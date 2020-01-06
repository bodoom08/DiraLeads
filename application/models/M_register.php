<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_register extends CI_Model
{

	function user_register()
	{
		array_walk_recursive($_POST, 'trim');
		extract($_POST);

		if ($name && $email && $mobile && $password && $confirm_Password && $country) {
			if ($password != $confirm_Password) {
				return ['type' => 'error', 'text' => 'Password & Confirm Password should be same!'];
			}
			if (!is_numeric($mobile) || strlen($mobile) < 10) {
				return ['type' => 'error', 'text' => 'Mobile Number should be 10 digit numeric!'];
			}
			$verified = $this->db->where('email', $email)->where('subscribe_verify', 'inactive')->count_all_results('users');
			if($verified > 0) {
				return ['type' => 'warning', 'text' => 'It seems you already registerd but not verified, Please <a href="'.site_url('/').'register/verify/?email='.$email.'">Verify</a>!', 'small' => 'It seems you already registerd but not verified, Please <a href="'.site_url('/').'register/verify/?email='.$email.'">Verify</a>!'];
			}
			$exist = $this->db->where('email', $email)->get('users')->row_array();
			if ($exist) {
				return ['type' => 'error', 'text' => 'This Email already taken!'];
			}
			$exist1 = $this->db->where('mobile', $mobile)->get('users')->row_array();
			if ($exist1) {
				return ['type' => 'error', 'text' => 'This Mobile Number already taken!'];
			}

			// Generate 6 digit OTP
			$otp = mt_rand(111111, 999999);

			$register_data = [
				'name' => $name,
				'email' => $email,
				'mobile' => $mobile,
				'country_code' => $country,
				'password' => sha1($password),
				'subscribe_verify' => 'inactive',
				'otp' => $otp,
				'created_at' => date('Y-m-d H:i:s'),
			];

			if ($this->db->insert('users', $register_data)) {
				$this->reg_email_otp($email, $otp);
				$user_id = $this->db->insert_id();
				$this->db->where('id', $user_id)->update('users', ['created_by' => $user_id]);
				return ['type' => 'info', 'text' => 'Please enter the OTP to complete registration process!'];
			}
			return ['type' => 'error', 'text' => 'Registration Failed!'];
		}
		return ['type' => 'error', 'text' => 'All fields are required!'];
	}

	function verify_otp() {
		array_walk_recursive($_POST, 'trim');
		array_walk_recursive($_POST, 'xss_clean');
		extract($_POST);
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return ['type' => 'error', 'text' => 'Opps! Problem with email id'];
		}

		$record_info = $this->db
												->select('otp')
												->where('email', $email)
												->get('users')
												->row();
		if($record_info->otp != $reg_verify_otp) {
			return ['type' => 'error', 'text' => 'OTP mismatched!'];
		}

		$register_data = [
			'subscribe_verify' => 'active',
			'otp' => '',
			'updated_at' => date('Y-m-d H:i:s'),
		];
		$this->db->where('email', $email);
		if($this->db->update('users', $register_data)) {
			return ['type' => 'success', 'text' => 'Otp verification complete, Please Wait we are going to redirect you login page.'];
		}
		return ['type' => 'error', 'text' => 'Opps! Server Error Occured'];		
	}
	function resend_verify_otp() {
		array_walk_recursive($_POST, 'trim');
		array_walk_recursive($_POST, 'xss_clean');
		extract($_POST);
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return ['type' => 'error', 'text' => 'Opps! Problem with email id'];
		}

		// Generate 6 digit OTP
		$otp = mt_rand(111111, 999999);

		$register_data = [
			'subscribe_verify' => 'inactive',
			'otp' => $otp,
			'updated_at' => date('Y-m-d H:i:s'),
		];
		$this->db->where('email', $email);
		if($this->db->update('users', $register_data)) {
			$this->reg_email_otp($email, $otp);
			return ['type' => 'info', 'text' => 'Otp resend sent to your email id'];
		}
		return ['type' => 'error', 'text' => 'Opps! Server Error Occured'];		
	}

	function reg_email_otp($email, $otp) {
		$this->load->helper('email');
		// Sending Register Email OTP
		$href = site_url('register/verify/?email=' . $email);
		$body = '<table style="background:#f9f9f9; padding: 30px 20px;">
				<tr>
					<td class="h2-center" style="color:#000000; font-size:32px; line-height:36px; text-align:center; padding-bottom:20px;">Register OTP Verification</td>
				</tr>
				<tr>
					<td style="color:#5d5c5c; font-size:14px; line-height:22px; text-align:center; padding-bottom:22px;">Hi <b>'.$email.'</b>, To complete registration Click on the verify button and put this OTP <b>'.$otp.'.</b> If you unable to click, manually go to this url <a href='.$href.'>'.$href.'</a></td>
				</tr>
				<tr>
					<td align="center">
						<table>
							<tr>
								<td class="text-button-orange" style="background:#e85711; color:#ffffff; font-size:14px; line-height:18px; text-align:center; padding:10px 30px; border-radius:20px;"><a href='.$href.' target="_blank" style="color:#fff; text-decoration: none;">Verfiy</a></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>';



		send_email(
			$email,
			'Diraleads Register Email Verify',
			$body
		);
	}
}
