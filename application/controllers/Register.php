<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		$this->load->model('M_register');
	}
	function index()
	{
		$data['register_error'] = $this->session->flashdata('message');
		$data['countries'] = $this->db->get('country')->result();
		$this->load->view('signup', $data);
	}

	function user_register()
	{
		exit(json_encode($this->M_register->user_register()));
	}

	function verify()
	{
		// print_r($_GET);
		extract($_GET);
		if (!$email) {
			redirect('login');
		}
		// Check if the email id is still now not verified
		$rslts = $this->db
			->where('email', $email)
			->where('subscribe_verify', 'inactive')
			->count_all_results('users');
		if ($rslts == 0) {
			redirect('login');
		}
		$this->load->view('reg_otp_verify');
	}

	function verify_otp()
	{
		extract($_POST);
		if ($email) {
			exit(json_encode($this->M_register->verify_otp()));
		}
		exit(json_encode(['type' => 'error', 'text' => 'Oops! Server error occured.']));
	}

	function resend_verify_otp()
	{
		extract($_POST);
		if ($email) {
			exit(json_encode($this->M_register->resend_verify_otp()));
		}
		exit(json_encode(['type' => 'error', 'text' => 'Oops! Server error occured.']));
	}

	function country_json()
	{
		// $email = 'mobotics.aniruddha@gmail.com';
		// $userinfo = $this->db->where('email', $email)->get('users')->row();
		// die(json_encode($userinfo));
		// Fecth the county code
		$priory_countries = ['US', 'GB', 'IL', 'BE'];
		$pr_country =  $this->db
			->select('nicename as  countryName, iso as code, phonecode as phoneCode')
			// ->where('is_active', 1)
			->where_in('iso', $priory_countries)
			->order_by('countryName', 'DESC')
			->get('country')
			->result_array();

		$country =  $this->db
			->select('nicename as  countryName, iso as code, phonecode as phoneCode')
			// ->where('is_active', 1)
			->where_not_in('iso', $priory_countries)
			// ->order_by('countryName', 'DESC')
			->get('country')
			->result_array();

		$result = array_merge($pr_country, $country);
		// $result = json_encode($country, true);
		// $select = [
		// 	'countryName' => 'Select',
		// 	'code' => '--',
		// 	'phoneCode' => '',
		// ];
		// $country = array_merge([$select], $country);
		// print_r($country);
		die(json_encode($result));
	}
}
