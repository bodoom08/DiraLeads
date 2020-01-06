<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'third_party/vendor/autoload.php';

use PAGI\Client\Impl\ClientImpl as AgiClient;
use PAGI\Node\Node;

class Agi extends CI_Controller
{
	private $agiClient;
	private $logger;
	private $cdr;

	public function __construct()
	{
		if (!is_cli()) {
			show_404();
			exit();
		}
		parent::__construct();

		$this->agiClient = AgiClient::getInstance([]);
		$this->logger = $this->agiClient->getAsteriskLogger();
		$this->cdr = $this->agiClient->getCDR();

		$this->did = $this->agiClient->getVariable('CALLERID(dnid)');
		$this->src = $this->cdr->getSource();
	}

	public function index()
	{
		$this->logger->notice('Checking DID : ' . $this->did);

		if($this->did === CFG_CONTACT_NUMBER) {
			$this->_main_dialplan();
		} else {
			$this->_property_dialplan();
		}

		
		$this->agiClient->hangup();
	}

	private function _main_dialplan()
	{
		$this->agiClient->answer();
		$user = $this->db->where('mobile', $this->src)->get('users')->row();

		if($user) {
			$this->agiClient->streamFile($this->getIvrPath('welcome.wav'));
			$this->agiClient->streamFile($this->getIvrPath('menu.wav'));
		} else {
			$this->agiClient->streamFile($this->getIvrPath('sorry.wav'));
		}
	}
	
	private function _property_dialplan()
	{
		$propertyOwner = $this->db
			->select('b.*, c.mobile')
			->where('a.number', '+'.$this->did)
			->where('a.id = b.vn_id')
			->where('b.user_id = c.id')
			->get('virtual_numbers a, properties b, users c')
			->row();

		if (!$propertyOwner) {
			$this->logger->error('No property is belongs to '.$this->did);
			$this->agiClient->indicateProgress();
			$this->agiClient->exec('Playback', [$this->getIvrPath('propertyNotFound.wav'), 'noanswer']);
			$this->cdr->setCustom('hangup_cause', 'INVALID_PROPERTY');
		} else {
			$user = $this->db
				->select('a.*')
				->where('a.mobile', $this->src)
				->where('a.id = b.user_id')
				->where('b.start_date <=', date('Y-m-d'))
				->where('b.end_date >=', date('Y-m-d'))
				->where('b.for', $propertyOwner->for)
				->get('users a, user_packages b')
				->row();

			if (!$user) {
				$this->logger->error('Package expired or invalid / Caller is not valid');
				$this->agiClient->indicateProgress();
				$this->agiClient->exec('Playback', [$this->getIvrPath('noSubscription.wav'), 'noanswer']);
				$this->cdr->setCustom('hangup_cause', 'INVALID_PACKAGE');
			} else {
				$this->agiClient->dial('SIP/192.76.120.10/' . $propertyOwner->mobile, [60, 'g']);
			}
		}
	}

	public function hangup()
	{
		$this->db->insert('cdr', [
			'uniqueid' => $this->cdr->getUniqueId(),
			'clid' => $this->cdr->getCallerId(),
			'src' => $this->cdr->getSource(),
			'dst' => $this->cdr->getDestination(),
			'channel' => $this->cdr->getChannel(),
			'dstchannel' => $this->cdr->getDestinationChannel(),
			'duration' => $this->cdr->getTotalLength(),
			'billsec' => $this->cdr->getAnswerLength(),
			'disposition' => $this->cdr->getStatus(),
			'hangup_cause' => $this->cdr->getCustom('hangup_cause'),
			'start_time' => $this->cdr->getStartTime(),
			'answer_time' => $this->cdr->getAnswerTime(),
			'end_time' => $this->cdr->getEndTime()
		]);
	}

	private function getFilePath($filename)
	{
		return FCPATH . 'public/uploads/audios/' . substr($filename, 0, -4);
	}

	private function getIvrPath($filename)
	{
		return FCPATH . 'assets/ivr/' . substr($filename, 0, -4);
	}
}
