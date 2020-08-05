<?php defined('BASEPATH') or exit('No direct script access allowed');

class Page extends MOBO_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->slug = $this->router->fetch_class();
		$this->slug = $this->slug == 'page' ? 'home' : $this->slug;
		$this->load->model('M_page');
	}

	public function index()
	{
		$data = $this->M_page->getPageData($this->slug);

		if (is_null($data)) {
			show_404();
			exit;
		}

		$this->load->view('page', $data);
	}

	function appendHTML(DOMNode &$parent, $source) {
		$tmpDoc = new DOMDocument();
		$tmpDoc->loadHTML($source);
		foreach ($tmpDoc->getElementsByTagName('body')->item(0)->childNodes as $node) {
			$node = $parent->ownerDocument->importNode($node, true);
			$parent->appendChild($node);
		}
	}

	public function widgets()
	{
		$names = json_decode($this->security->xss_clean($this->input->raw_input_stream));
		exit(json_encode($this->M_page->getWidgetData($names)));
	}

	public function contact()
	{
		if($this->input->method() != 'post' || !$this->input->is_ajax_request() ) {
			redirect('/');
		}

		exit(json_encode($this->M_page->contact()));
	}

	public function send_contact_email() {
		echo json_encode($_POST);
	}
}
