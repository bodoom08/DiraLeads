<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_profile extends CI_Model
{

	function update()
	{
		array_walk_recursive($_POST, 'trim');
        extract($_POST);

		if ($name) {
			if (strlen($password) < 6 || $password != $conf_password) {
				return ['type' => 'error', 'text' => 'Password & Confirm Password should be same and must be grater than six'];
            }
            
            $this->db->where('email', $_SESSION['email']);
            $this->db->where('password', sha1($current_pass));
            $user = $this->db->get('users')->row();

            if(!$user) {
                return ['type' => 'error', 'text' => 'Incorrect Password!'];
            }
            
            $data = [
				'name' => $name,
				'mobile' => $mobile,
				'email' => $email,
				'password' => sha1($password),
				'updated_at' => date('Y-m-d H:i:s')
			];
			if ($this->db->where('id', $user->id)->update('users', $data)) {
				return ['type' => 'success', 'text' => 'Updated Successfully!'];
				session_start();
				$_SESSION['name'] = $name;
				$_SESSION['mobile'] = $mobile;
				$_SESSION['email'] = $email;
			}
			return ['type' => 'error', 'text' => 'Update Failed!'];
		}
		return ['type' => 'error', 'text' => 'Name is are required!'];
	}
}
