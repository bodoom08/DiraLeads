<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_login');
	}

	public function index()
	{
		if (isset($_SESSION['id'])) {
			redirect('dashboard');
		} else {
			$this->load->view('login');
		}
	}
    
    public function agent_login() {
        if (isset($_SESSION['id'])) {
            redirect('dashboard');
        } else {
            $this->load->view('login_agent');
        }
    }

	function validate()
	{
		exit(json_encode($this->M_login->validate()));
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect('login', null);
	}
}
