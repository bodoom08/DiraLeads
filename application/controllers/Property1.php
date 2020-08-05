<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Property extends MOBO_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->userOnly();
		$this->load->model('M_property');
	}

	public function index()
	{
		$data['areas'] = $this->M_property->getAllAreas();
		$data['attributes'] = $this->M_property->getAllAttributes();
		$this->load->view('submit-property', $data);
	}

	public function property_listing()
	{
		exit(json_encode($this->M_property->property_listing()));
	}
}
