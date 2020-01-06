<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_profile extends CI_Model
{

	function update()
	{
		array_walk_recursive($_POST, 'trim');
        extract($_POST);

		// if ($name) {
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
				// 'name' => $name,
				// 'mobile' => $mobile,
				// 'email' => $email,
				'password' => sha1($password),
				'updated_at' => date('Y-m-d H:i:s')
			];
			if ($this->db->where('id', $_SESSION['id'])->update('users', $data)) {
				return ['type' => 'success', 'text' => 'Updated Successfully!'];
                // session_start();
				// $_SESSION['name'] = $name;
				// $_SESSION['mobile'] = $mobile;
				// $_SESSION['email'] = $email;
			}
			return ['type' => 'error', 'text' => 'Update Failed!'];
		//}
		// return ['type' => 'error', 'text' => 'Name is are required!'];
	}
    
    
    function update_userprofile()
    {
        array_walk_recursive($_POST, 'trim');
        extract($_POST);
        if(!is_numeric($mobile)) {
               return ['type' => 'error', 'text' => 'Mobile no should be numeric!'];
        }
        
        if ($name) {
            //            if (strlen($password) < 6 || $password != $conf_password) {
            //                return ['type' => 'error', 'text' => 'Password & Confirm Password should be same and must be grater than six'];
            //            }
            
//            $this->db->where('email', $_SESSION['email']);
//            $this->db->where('password', sha1($current_pass));
//            $user = $this->db->get('users')->row();
//
//            if(!$user) {
//                return ['type' => 'error', 'text' => 'Incorrect Password!'];
//            }

            // Check the same mobile no is not already taken for the other user
            $rslt = $this->db->where('mobile', $mobile)->get('users')->row();
            if($rslt->id != $_SESSION['id']) {
                return ['type' => 'error', 'text' => 'Mobile no already taken!'];
            }
            
            $data = [
            'name' => $name,
            'country_code' => $country,
            'mobile' => $mobile,
            //'email' => $email,
            'updated_at' => date('Y-m-d H:i:s')
            ];
            if ($this->db->where('id', $_SESSION['id'])->update('users', $data)) {
                
                session_start();
                $_SESSION['name'] = $name;
                $_SESSION['mobile'] = $mobile;
                $_SESSION['email'] = $email;
                
                return ['type' => 'success', 'text' => 'Updated Successfully!'];
            }
            return ['type' => 'error', 'text' => 'Update Failed!'];
        }
        return ['type' => 'error', 'text' => 'Name is are required!'];
    }

    function update_usertime_pref() {

        array_walk_recursive($_POST, 'trim');
        extract($_POST);

        if(empty($phone) || empty($email))
                return ['type' => 'error', 'text' => 'Phone and Email both are required!'];
        
        if(!empty($fax))
            $contact_through = ['phone', 'email', 'fax'];
        else
            $contact_through = ['phone', 'email'];
        $contact_type = implode(',', $contact_through);
        if(!empty($sunday))
            $day_arr[] = 'sunday';
        if(!empty($monday))
            $day_arr[] = 'monday';
        if(!empty($tuesday))
            $day_arr[] = 'tuesday';
        if(!empty($wednesday))
            $day_arr[] = 'wednesday';
        if(!empty($thursday))
            $day_arr[] = 'thursday';
        if(!empty($friday))
            $day_arr[] = 'friday';
        if(!empty($saturday))
            $day_arr[] = 'saturday';
        
        if(empty($day_arr))
            return ['type' => 'error', 'text' => 'Please selct at least one day!'];
        
        $day_arr = implode(',', $day_arr);
        
        if(!empty($time) && ($time == 'custom')) {
            if(empty($start_time) && empty($end_time))
                return ['type' => 'error', 'text' => 'Start Time and End Time both required for custom time.'];
            else if(strtotime($start_time) >= strtotime($end_time))
                return ['type' => 'error', 'text' => 'Start Time should not greater than or equal to End Time.'];
            
            if(!empty($start_time))
                $start_time = date("H:i", strtotime($start_time));
            else
                $start_time = '';
            if(!empty($end_time))
                $end_time = date("H:i", strtotime($end_time));
            else
                $end_time = '';
        }

        $data = [
            'contact_type' => $contact_type,
            'day_of_the_weak' => $day_arr,
            'time_of_day' => $time,
            'from_time' => $start_time,
            'to_time' => $end_time,
            'updated_at' => date('Y-m-d H:i:s'),
            'notification_pref_alert' => 'active'
        ];
        if ($this->db->where('id', $_SESSION['id'])->update('users', $data)) {

            session_start();
            
            $_SESSION['contact_type'] = $contact_type;
            $_SESSION['day_of_the_weak'] = $day_arr;
            $_SESSION['time_of_day'] = $time;
            $_SESSION['from_time'] = $start_time;
            $_SESSION['to_time'] = $end_time;
            
            return ['type' => 'success', 'text' => 'Updated Successfully!'];
        }
        return ['type' => 'error', 'text' => 'Update Failed!'];



    }
}
