<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
	public function __construct() {
		parent::__construct();
        if(!$_SESSION['id']) {
            redirect('login');
        }
        $this->load->model('M_profile');
	}
	public function index()
	{
		$countries = $this->db->get('country')->result();
		$userinfo  = $this->db->where('id', $_SESSION['id'])->get('users')->row();
		$this->load->view('my-profile', compact('countries', 'userinfo'));
	}

	public function update()
	{
		exit(json_encode($this->M_profile->update()));
	}

	public function update_userprofile() {
			exit(json_encode($this->M_profile->update_userprofile()));
	}

	public function update_timepref() {
		exit(json_encode($this->M_profile->update_usertime_pref()));
	}

	public function update_package_notification_pref() {
		$this->load->library('form_validation');

		$this->form_validation->set_rules('email_checked', 'Email ID', 'trim|valid_emails');
		$this->form_validation->set_rules('phone_no_checked', 'Phone No', 'trim|numeric');
		$this->form_validation->set_rules('fax_checked', 'Fax No', 'trim|numeric');
		$this->form_validation->set_rules('price_min', 'Min Price', 'trim|numeric');
		$this->form_validation->set_rules('price_max', 'Max Price', 'trim|numeric');
		$this->form_validation->set_rules('frequence', 'Frequence', 'trim');
		if($this->form_validation->run() == true) {
			foreach($_POST as $key => $value) {
				if(!is_array($_POST[$key])) {
					$_POST[$key] = trim($value);
				}
			}

			$_POST = array_map('xss_clean', $_POST);
			extract($_POST);
			$subscribe_info = json_decode($subscribe_info);
			$merge_attribute = array_combine($attribute_id, $value);
			ksort($merge_attribute);


			if($subscribe_info->action == 'renew') {
				die(json_encode(['type' => 'success', 'text' => 'Please Wait....']));
			}

			$area = [];
			$pref_arr = [];
			for($i=0; $i<$subscribe_info->area_select_noof; $i++) {
				// Check the types
				if(!isset($_POST['types_'.$i])) {
					die(json_encode(['type' => 'error', 'text' => 'Please select the property types for section area '.($i+1)]));
				}

				// Check the area
				if(!isset($_POST['area_'.$i])) {
					die(json_encode(['type' => 'error', 'text' => 'Please select area name for section area '.($i+1)]));
				}

				// Check the minprice
				if(!isset($_POST['price_min_'.$i])) {
					die(json_encode(['type' => 'error', 'text' => 'Please add minimum price for section area '.($i+1)]));
				}

				// Check the minprice
				if(!isset($_POST['price_max_'.$i])) {
					die(json_encode(['type' => 'error', 'text' => 'Please add maximum price for section area '.($i+1)]));
				}
				
				for($k=0; $k<sizeof($_POST['value_'.$i]); $k++) {
					if(empty($_POST['value_'.$i][$k]) || (intval($_POST['value_'.$i][$k]) < 1)) {
						die(json_encode(['type' => 'error', 'text' => 'Please add property attribute value for section area '.($i+1)]));
					}
				}

				$area[] = $_POST['area_'.$i];
				$arr = [
					'types' => implode(',', $_POST['types_'.$i]),
					'area_id' => $_POST['area_'.$i],
					'price_min' => $_POST['price_min_'.$i],
					'price_max' => $_POST['price_max_'.$i],
					'attribute' => $_POST['attribute_id_'.$i],
					'value' => $_POST['value_'.$i],
				];
				$pref_arr[] = $arr;
			}

			// Duplicate Area Name
			if(count(array_unique($area)) < sizeof($area)) {				
				die(json_encode(['type' => 'error', 'text' => 'Duplicate area name found']));
			}

			/**
			 * Checking the same property attribute 
			 */
			for($i=0; $i<sizeof($attribute_id); $i++) {
				$found=0;
				for($j=0; $j<sizeof($attribute_id); $j++) {
					if($attribute_id[$i] == $attribute_id[$j]) {
						$found++;
					}
				}
				if($found > 1) {
					die(json_encode(['type' => 'error', 'text' => 'Duplicate Property attribute.']));
				}
			}

			/**
			 * Checking the no of area is equal to the selected area
			 * nos
			 */
			// if(count($area) != $subscribe_info->area_select_noof) {
			// 	die(json_encode(['type' => 'error', 'text' => 'You should select a maximum of '.$subscribe_info->area_select_noof.' area(s)']));				
			// }

			/**
			 * Other Validations
			 */
			// if(!isset($types)) {
			// 	die(json_encode(['type' => 'error', 'text' => 'Please select at least one property types']));
			// }
			// echo '<pre>';
			// print_r($pref_arr);
			// die();
		
			// if(isset($email) && empty($email_checked)) {
			// 	die(json_encode(['type' => 'error', 'text' => 'Email ID is required']));
			// }
			// else if(isset($email) && !empty($email_checked) && !filter_var($email_checked, FILTER_VALIDATE_EMAIL)) {
			// 	die(json_encode(['type' => 'error', 'text' => 'Email ID is not valid']));
			// }

			// if(isset($phone) && empty($phone_no_checked)) {
			// 	die(json_encode(['type' => 'error', 'text' => 'Phone No is required']));
			// }

			// if(isset($fax) && empty($fax_checked)) {
			// 	die(json_encode(['type' => 'error', 'text' => 'Fax No is required']));
			// }
			$arr = [];
			if(isset($phone) && !empty($phone_no_checked)) {
				$arr['notification_phone'] = 'active';
				$arr['notification_phone_no'] = $phone_no_checked;
			}
			else {
				$arr['notification_phone'] = 'inactive';
				$arr['notification_phone_no'] = '';
			}

			if(isset($email) && !empty($email_checked)) {
				$arr['notification_email'] = 'active';
				$arr['notification_email_id'] = $email_checked;
			}
			else {
				$arr['notification_email'] = 'inactive';
				$arr['notification_email_id'] = '';
			}

			if(isset($fax) && !empty($fax_checked)) {
				$arr['notification_fax'] = 'active';
				$arr['notification_fax_no'] = $fax_checked;
			}
			else {
				$arr['notification_fax'] = 'inactive';
				$arr['notification_fax_no'] = '';
			}

			if(!empty($price_min) && !empty($price_max)) {
				if($price_min > $price_max) {
					die(json_encode(['type' => 'error', 'text' => 'Min Price should not be greater than Max Price']));
				}
			}

			$arr['notification_frequence'] = $frequence;
			$this->db->where('id', $_SESSION['id'])
					->update('users', $arr);

			//  Get the short term available date if date is selected
			if($subscribe_info->pack_name == 'short term rent') {
				if(empty($short_term_available_date)) {
					die(json_encode(['type' => 'error', 'text' => 'Please select atleast one available date for the short term rent.']));
				}
			}
			if(!isset($short_term_available_date))
				$short_term_available_date  = '';

			$notify_package_pref = [
				'pref_arr' => $pref_arr	
				// 'price_min' => $price_min,
				// 'price_max' => $price_max,
				// 'types' => implode(',', $types),
				// 'area' => implode(',', $area),
				// 'attribute_id' => implode(',', array_keys($merge_attribute)),
				// 'attribute_value' => implode(',', array_values($merge_attribute)),

			];

			die(json_encode(['type' => 'success', 'text' => 'Notification preference successfully saved.', 'notify_package_pref' => $notify_package_pref, 'short_term_available_date' => $short_term_available_date]));
		}
		else {
			die(json_encode(['type' => 'error', 'text' => $this->form_validation->error_string()]));
		}
	}
	public function update_package_area_pref() {		
		foreach($_POST as $key => $value) {
			if(!is_array($_POST[$key])) {
				$_POST[$key] = trim($value);
			}
		}

		$_POST = array_map('xss_clean', $_POST);
		extract($_POST);
		$subscribe_info = json_decode($subscribe_info);	

		$area = [];
		$pref_arr = [];
		for($i=0; $i<$subscribe_info->area_select_noof; $i++) {
			// Check the types
			if(!isset($_POST['types_'.$i])) {
				die(json_encode(['type' => 'error', 'text' => 'Please select the property types for section area '.($i+1)]));
			}

			// Check the area
			if(!isset($_POST['area_'.$i])) {
				die(json_encode(['type' => 'error', 'text' => 'Please select area name for section area '.($i+1)]));
			}

			// Check the minprice
			if(!isset($_POST['price_min_'.$i])) {
				die(json_encode(['type' => 'error', 'text' => 'Please add minimum price for section area '.($i+1)]));
			}

			// Check the minprice
			if(!isset($_POST['price_max_'.$i])) {
				die(json_encode(['type' => 'error', 'text' => 'Please add maximum price for section area '.($i+1)]));
			}
			
			for($k=0; $k<sizeof($_POST['value_'.$i]); $k++) {
				if(empty($_POST['value_'.$i][$k]) || (intval($_POST['value_'.$i][$k]) < 1)) {
					die(json_encode(['type' => 'error', 'text' => 'Please add property attribute value for section area '.($i+1)]));
				}
			}

			$area[] = $_POST['area_'.$i];
			$arr = [
				'types' => implode(',', $_POST['types_'.$i]),
				'area_id' => $_POST['area_'.$i],
				'price_min' => $_POST['price_min_'.$i],
				'price_max' => $_POST['price_max_'.$i],
				'attribute' => $_POST['attribute_id_'.$i],
				'value' => $_POST['value_'.$i],
			];
			$pref_arr[] = $arr;
		}

		// // Duplicate Area Name
		if(count(array_unique($area)) < sizeof($area)) {
			die(json_encode(['type' => 'error', 'text' => 'Duplicate area name found']));
		}

		/**
		 * Checking the same property attribute 
		 */
		for($i=0; $i<sizeof($attribute_id); $i++) {
			$found=0;
			for($j=0; $j<sizeof($attribute_id); $j++) {
				if($attribute_id[$i] == $attribute_id[$j]) {
					$found++;
				}
			}
			if($found > 1) {
				die(json_encode(['type' => 'error', 'text' => 'Duplicate Property attribute.']));
			}
		}

		// fetch user_package_id, invoice_id
		$user_package_details = $this->db
										->select('package_id, invoice_id')
										->where('id', $subscribe_info->ref_id)
										->get('user_packages')
										->row();

		// delete user_package_area_preferences
		$this->db
				->where('user_package_ref_id', $subscribe_info->ref_id)
				->delete('user_package_area_preferences');

		// delete user_package_preference_attribute_values
		$this->db
				->where('user_package_ref_id', $subscribe_info->ref_id)
				->delete('user_package_preference_attribute_values');

		// update user package short_term_available_date
		if($subscribe_info->pack_name == 'short term rent' && !empty($short_term_available_date)) {
			$this->db
				->where('id', $subscribe_info->ref_id)
				->update('user_packages', ['short_term_available_date' => $short_term_available_date]);
		}

		// user package area pref
		$area_id_arr = [];
		foreach($pref_arr as $row) {
			$area_id_arr[] = $row['area_id'];
			$arr = [
				'user_id' => $_SESSION['id'],
				'user_package_id' => $user_package_details->package_id,
				'user_package_ref_id' => $subscribe_info->ref_id,
				'invoice_id' => $user_package_details->invoice_id,
				'area_ids' => $row['area_id'],
				'types' => $row['types'],
				'price_min' => $row['price_min'],
				'price_max' => $row['price_max'],
			];
			$this->db->insert('user_package_area_preferences', $arr);
			$user_package_pref_id = $this->db->insert_id();


			foreach($row['attribute'] as $key=> $value) {
				$arr = [
						'user_package_pref_id' => $user_package_pref_id,
						'user_package_ref_id' => $subscribe_info->ref_id,
						'area_id' => $row['area_id'],
						'attribute_id' => $value,
						'value' => $row['value'][$key]
				];
				$this->db->insert('user_package_preference_attribute_values', $arr);
			}
		}
		// user package pref attr values
		$this->db
						->where('id', $subscribe_info->ref_id)
						->update('user_packages', ['area_ids' => implode(',', $area_id_arr)]);

		die(json_encode(['type' => 'success', 'text' => 'Area preference successfully updated.']));
	}

	public function notification_pref_status_update() {
		$this->db->where('id', $_SESSION['id'])->update('users', ['notification_pref_alert' => 'inactive']);
		exit(json_encode(['type' => 'success', 'text' => 'Updated']));
	}

	public function test() {
		$allSubs = $this->db
            ->where('user_id', $_SESSION['id'])
            ->group_start()
            ->where('start_date<=', date('Y-m-d'))
            ->or_where('end_date>=', date('Y-m-d'))
            ->group_end()
            ->get('user_packages')
			->result_array();
		die($this->db->last_query());
	}
}

