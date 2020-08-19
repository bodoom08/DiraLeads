<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class M_login extends CI_Model {
	public function validate() {
		array_walk_recursive($_POST, 'trim');
		extract($this->input->post());

		$this->db->select('id,name,email,mobile,subscribe_flag,contact_type,day_of_the_weak,time_of_day,from_time,to_time,subscribe_verify');
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->where('password', sha1($password));
		$this->db->where('status', 'active');
		$query = $this->db->get();


		if($query->row()->subscribe_verify == 'inactive') {
			return ['type' => 'warning', 'text' => 'It seems you already registerd but not verified, Please <a href="'.site_url('/').'register/verify/?email='.$email.'">Verify</a>!'];
		}	else if ($query->num_rows() == 1) {
			$this->session->set_userdata($query->row_array() + ['user_type' => 'user']);
			return ['type' => 'success', 'text' => 'Welcome To DiraLeads!', 'ref' => isset($ref) ? $ref : site_url('dashboard')];
		}
		return ['type' => 'error', 'text' => 'Sorry!! Invalid Username or Password'];
	}

	public function validate_user() {
		array_walk_recursive($_POST, 'trim');
		extract($this->input->post());

		$this->db->select('id,name,email,mobile,subscribe_flag,contact_type,day_of_the_weak,time_of_day,from_time,to_time');
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->where('password', sha1($password));
		$this->db->where('status', 'active');
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			// $this->session->set_userdata($query->row_array() + ['user_type' => 'user']);
			return ['type' => 'success', 'text' => 'Welcome To DiraLeads!', 'login_info' => json_encode($query->row_array() + ['user_type' => 'user']),'ref' => (isset($ref) && !empty($ref)) ? site_url('login/otp_verify').'?ref='.urlencode($ref) : site_url('login/otp_verify').'?ref=' ];
		}
		return ['type' => 'error', 'text' => 'Sorry!! Invalid Username or Password'];
	}

	// public function initiate_login() {

	// }

	public function forgot() {
		$email = $this->input->post('email');
		$user = $this->db
			->where('email', $email)
			->where('status', 'active')
			->get('users')
			->row();

		if($user) {
			$token = urlencode(base64_encode(strtotime('30 minutes') . ':' . bin2hex(random_bytes(16))));

			$this->db->where('email', $email);
			$this->db->update('users', [
				'token' => $token
			]);
            
            			
			$this->load->helper('email');

			$href = site_url('login/reset/' . $token);

			// Password template
			$body = '<table style="background:#f9f9f9; padding: 30px 20px;">
						<tr>
							<td class="h2-center" style="color:#000000; font-size:32px; line-height:36px; text-align:center; padding-bottom:20px;">Reset Password</td>
						</tr>
						<tr>
							<td style="color:#5d5c5c; font-size:14px; line-height:22px; text-align:center; padding-bottom:22px;">To set a new password Click on the reset button. If you unable to click, manually go to this url <a href='.$href.'>'.$href.'</a></td>
						</tr>
						<tr>
							<td align="center">
								<table>
									<tr>
										<td class="text-button-orange" style="background:#e85711; color:#ffffff; font-size:14px; line-height:18px; text-align:center; padding:10px 30px; border-radius:20px;"><a href='.$href.' target="_blank" style="color:#fff; text-decoration: none;">Reset</a></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>';

			
			
			send_email(
                $email,
				'Diraleads Password Reset',
				$body
                // $this->load->view(
                //     'emails/reset_password',
                //     ['href' => site_url('login/reset/' . $token)],
                //     true
                // )
            );

            
            return ['type' => 'success', 'text' => 'Reset link sent and will valid for 30 mins. Please check inbox.'];
		}

		return ['type' => 'error', 'text' => 'Sorry!! your email is not registered with us'];
	}

	function reset($token)
	{
		$user = $this->db
				->where('token', $token)
				->get('users')
				->row();
		$token = explode(':', base64_decode(urldecode($token)));

		if(time() <= $token[0] && $user) {
			if($this->input->method() == 'get') {
				$this->load->view('new_password');
			} elseif(($this->input->post('password') == $this->input->post('cnf_password')) && (trim($this->input->post('password')) != '') && (trim($this->input->post('cnf_password')) != '')) {
				$this->db
					->where('id', $user->id)
					->set('token', null)
					->set('password', sha1($this->input->post('password')))
					->update('users');					

				redirect('login');
			} else {
				if(empty(trim($this->input->post('password'))) || empty(trim($this->input->post('cnf_password'))))
					$error = 'Passsword Or Confirm Password Should not be empty.';
				else if($this->input->post('password') != $this->input->post('cnf_password'))
					$error = 'Passsword and Confirm Password Should be same.';

				$this->load->view('new_password', ['error' => $error]);
			}
		} else {
			show_404();
		}

	}
}
