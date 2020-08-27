<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Rental extends MOBO_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->userOnly();
		$this->load->model('M_property');
	}

	public function index()
	{
		$areas = $this->M_property->getAllAreas();
		usort($areas, function ($a, $b) {
			return strcmp($a['title'], $b['title']);
		});
		$data['areas'] = $areas;


		$data['attributes'] = $this->M_property->getAllAttributes();
		$data['packagenames'] = $this->M_property->getCustomPackageNames();
		$this->load->view('submit-property', $data);
	}

	public function property_listing()
	{
		exit(json_encode($this->M_property->property_listing()));
	}

	public function short_term_date_range_search()
	{
		$from = new DateTime('2020-03-01');
		$to = new DateTime('2020-03-14');
		$count = 1;
		$query = 'SELECT * FROM properties WHERE ';
		for ($i = $from; $i <= $to; $i->modify('+1 days')) {
			if ($count == 1) {
				$query .= "FIND_IN_SET('" . $i->format("Y-m-d") . "', short_term_available_date)";
			} else {
				$query .= " OR FIND_IN_SET('" . $i->format("Y-m-d") . "', short_term_available_date)";
			}
			$count++;
		}

		echo '<pre>';

		$result = $this->db->query($query)->result();
		print_r($result);
	}
}
