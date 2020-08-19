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
		$this->load->view('my-profile');
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


			$areaName = [];
			for($i=0; $i<$subscribe_info->area_select_noof; $i++) {
				// Check the types
				if(!isset($_POST['types_'.$i])) {
					die(json_encode(['type' => 'error', 'text' => 'Please select the property types for area '.($i+1)]));
				}

				// Check the area
				if(!isset($_POST['area_'.$i])) {
					die(json_encode(['type' => 'error', 'text' => 'Please select area name for area '.($i+1)]));
				}

				// Check the minprice
				if(!isset($_POST['price_min_'.$i])) {
					die(json_encode(['type' => 'error', 'text' => 'Please add minimum price for area '.($i+1)]));
				}

				// Check the minprice
				if(!isset($_POST['price_max_'.$i])) {
					die(json_encode(['type' => 'error', 'text' => 'Please add maximum price for area '.($i+1)]));
				}
				$areaName[] = $_POST['area_'.$i][0];
			}

			// // Duplicate Area Name
			if(count(array_unique($areaName)) < sizeof($areaName)) {
				die(json_encode(['type' => 'error', 'text' => 'Duplicate area name found']));
			}

			die(json_encode(['type' => 'error', 'text' => 'JAKAKAKA']));

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
			if(!isset($area)) {
				die(json_encode(['type' => 'error', 'text' => 'Please select the area.']));				
			}
			else if(count($area) != $subscribe_info->area_select_noof) {
				die(json_encode(['type' => 'error', 'text' => 'You should select a maximum of '.$subscribe_info->area_select_noof.' area(s)']));				
			}

			/**
			 * Other Validations
			 */
			if(!isset($types)) {
				die(json_encode(['type' => 'error', 'text' => 'Please select at least one property types']));
			}
		
			if(isset($email) && empty($email_checked)) {
				die(json_encode(['type' => 'error', 'text' => 'Email ID is required']));
			}
			else if(isset($email) && !empty($email_checked) && !filter_var($email_checked, FILTER_VALIDATE_EMAIL)) {
				die(json_encode(['type' => 'error', 'text' => 'Email ID is not valid']));
			}

			if(isset($phone) && empty($phone_no_checked)) {
				die(json_encode(['type' => 'error', 'text' => 'Phone No is required']));
			}

			if(isset($fax) && empty($fax_checked)) {
				die(json_encode(['type' => 'error', 'text' => 'Fax No is required']));
			}
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

			$notify_package_pref = [
				'price_min' => $price_min,
				'price_max' => $price_max,
				'types' => implode(',', $types),
				'area' => implode(',', $area),
				'attribute_id' => implode(',', array_keys($merge_attribute)),
				'attribute_value' => implode(',', array_values($merge_attribute)),
			];

			die(json_encode(['type' => 'success', 'text' => 'Notification preference successfully saved.', 'notify_package_pref' => $notify_package_pref]));
		}
		else {
			die(json_encode(['type' => 'error', 'text' => $this->form_validation->error_string()]));
		}
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

