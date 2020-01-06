<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MOBO_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_login');
	}

	public function index()
	{
		if (isset($_SESSION['id'])) {
			extract($_GET);
            if(isset($continue))
              header('Location: '.$continue);
            else {
			  redirect('dashboard');
            }
		} else {
			$this->load->view('login');
		}
	}

	public function user()
	{
		if (isset($_SESSION['id'])) {
			extract($_GET);
            if(isset($continue))
              header('Location: '.$continue);
            else {
			  redirect('dashboard');
            }
		} else {
			$this->load->view('login-user');
		}
	}
	
	public function forgot()
	{
		if (isset($_SESSION['id'])) {
			redirect('dashboard');
		} else {
			if($this->input->is_ajax_request()) {
                exit(json_encode($this->M_login->forgot()));
			} else {
				$this->load->view('forgot_password');
			}
		}
	}

	function validate()
	{
		exit(json_encode($this->M_login->validate()));
	}
	
	function validate_user()
	{
		$data = $this->M_login->validate_user();
		if(array_key_exists('login_info', $data)) {
			$this->session->set_flashdata('login_info', json_encode($data));
		}
		exit(json_encode($this->M_login->validate_user()));
	}

	function otp_verify() {
		ini_set('display_errors', 1);
		if(empty($this->session->flashdata('login_info')))
			redirect('login/user');

		$encode_record_info = $this->session->flashdata('login_info');
		// $encode_record_info = '{"type":"success","text":"Welcome To DiraLeads!","login_info":"{\"id\":\"10\",\"name\":\"Aniruddha12061990\",\"email\":\"aniruddha.roy12061990@gmail.com\",\"mobile\":\"9046183568\",\"subscribe_flag\":\"yes\",\"contact_type\":null,\"day_of_the_weak\":\"monday,tuesday\",\"time_of_day\":\"24\",\"from_time\":\"\",\"to_time\":\"\",\"user_type\":\"user\"}","ref":"https:\/\/diraleads.com\/login\/otp_verify"}';
		$decode_record_info = json_decode($encode_record_info);
		$decode_record_info->login_info = json_decode($decode_record_info->login_info);
		send_otp($decode_record_info->login_info->mobile);
		$this->load->view('login-otp', compact('encode_record_info', 'decode_record_info'));
	}

	function resend_otp() {
		ini_set('display_errors', 1);
		extract($_POST);
		
		$decode_record_info = json_decode($encode_record_info);
		$decode_record_info->login_info = json_decode($decode_record_info->login_info);
		$response = send_otp($decode_record_info->login_info->mobile);
		// if($response->success == false) {
		// 	die(json_encode(['type' => 'error', 'text' => $response->message]));
		// }
		// else {
			die(json_encode(['type' => 'success', 'text' => 'Otp Sent to registerd mobile number, and valid for 3 minutes']));
		// }
	}

	function validate_otp() {
		extract($_POST);
		ini_set('display_errors', 1);

		$decode_record_info = json_decode($encode_record_info);
		$decode_record_info->login_info = json_decode($decode_record_info->login_info);
		$mobile = $decode_record_info->login_info->mobile;
		$result = $this->db->where('mobile', $mobile)
						->order_by('id', 'desc')
						->limit(1)
						->get('otp')
						->row();
		if($result->otp == $otp) {
			if($continue && $continue != '') {
				$ref = $continue;
			}
			else {
				$ref = site_url('/');
			}
			$decode_record_info = json_decode($encode_record_info, true);
			$decode_record_info['login_info'] = json_decode($decode_record_info['login_info'], true);
			$this->session->set_userdata($decode_record_info['login_info']);
			die(json_encode(['type' => 'success', 'text' => 'OTP validated.', 'ref' => $ref]));
		}
		else {
			die(json_encode(['type' => 'error', 'text' => 'OTP mismatched.']));
		}
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect('login', null);
	}

	function reset($token)
	{
		$this->session->sess_destroy();
		$this->M_login->reset($token);
	}
    
    function test() {
		$this->load->helper('url');
        $token = urlencode(base64_encode(strtotime('30 minutes') . ':' . bin2hex(random_bytes(16))));
        
		
		
		$this->load->helper('email');

            send_email(
                'subhojit.mobotics@gmail.com',
                'Diraleads Password Reset',
                $this->load->view(
                    'emails/reset_password',
                    ['href' => site_url('login/reset/' . $token)],
                    true
                )
			);
			
			
    }
}
