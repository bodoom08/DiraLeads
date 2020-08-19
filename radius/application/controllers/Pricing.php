<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'core/MOBO_User.php';
class Pricing extends MOBO_User
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_pricing');
        $this->load->model('M_preferences');
        $this->load->model('M_property');
        $this->load->model('M_subscription');
    }
    public function index()
    {
        if (!$_SESSION['id']) {
            $data['packages'] = $this->M_pricing->getAllPackages();
            $this->load->view('pricing_plans_view', $data);
        } else {
            $data['users_package'] = $this->M_pricing->getSubscribedPackage();
            $package_ids = array();
            foreach ($data['users_package'] as $key => $value) {
                $package_ids[$key] = $value['package_id'];
            }
            $data['package_ids'] = $package_ids;
            $packages = $this->M_pricing->getAllPackages();
            foreach($packages as $key => $package) {
                $subscribed_package = $this->M_pricing->getSubscribedPackageById($package['id']);
                if(!empty($subscribed_package->package_id))
                    $packages[$key]['subscribed_button_active'] = false;
                else
                    $packages[$key]['subscribed_button_active'] = true;
                
            }
            $data['packages'] = $packages;
            // echo '<pre>';
            // print_r($data);
            $this->load->view('pricing_plans', $data);
        }

    }

    public function subscribe()
    {
        if(empty($_POST))
            redirect(site_url('/pricing'));       

        $data['selected_pkg'] = $this->M_pricing->getSelectedPackage();
        $this->load->view('payment', $data);
    }
    
    public function pay()
    {
        $this->load->library('BevelPay');

        $package = $this->M_pricing->getSelectedPackage();
        
        if(is_null($package)) {
            show_404();
            die;
        }

        $description = $package->name . '($'.$package->price.') package subscription for '.$package->validity.' days';

        $invoiceId = $this->bevelpay->sale(
            $package,
            $this->input->post('cardNumber'),
            $this->input->post('mm') . $this->input->post('yy'),
            $this->input->post('cvv2'),
            $description,
            $this->input->post('name'),
            $this->input->post('street'),
            $this->input->post('zip')
        );

        if($invoiceId !== false) {
            $this->M_pricing->subscribe($invoiceId);
        } else {
            $data['selected_pkg'] = $this->M_pricing->getSelectedPackage();
            $data['last_errors'] = $this->bevelpay->getLastErrors();
            $this->load->view('payment', $data);
            // var_dump($this->bevelpay->getLastErrors());
        }
    }

    public function update_subscribe_flag()
    {
        exit(json_encode($this->M_pricing->update_subscribe_flag()));
    }
    
    public function test_email() {
        $ci=& get_instance();
        
        $ci->load->library('email');
        
        // $config['useragent'] = CFG_TITLE;
        // $config['mailtype'] = 'html';
        $from = 'noreply@diraleads.com';
        $to = 'aniruddha.roy12061990@gmail.com';
        $subject = 'Test Subject';
        $body = 'Test Body';
        
        $config = Array(
                        'protocol' => 'smtp',
                        'smtp_host' => 'smtp-relay.sendinblue.com',
                        'smtp_port' => 587,
                        'smtp_user' => '012yyh@gmail.com',
                        'smtp_pass' => '8vWUJOPZS2Gdt7mF',
                        'useragent' => CFG_TITLE,
                        'mailtype'  => 'html',
                        'charset'   => 'iso-8859-1'
                    );
        
        $ci->email->initialize($config);
        $ci->email->set_newline("\r\n");
        // $ci->email->from($from);
        $ci->email->from($from);
        $ci->email->to($to);
        $ci->email->subject($subject);
        $ci->email->message($body);
        
        $status = $ci->email->send();
        
        if(!$status)
        {
            $error = $ci->email->print_debugger();
            echo '<pre>';
            print_r($error);
        }
        else {
            print_r('success');
        }

    }

    /**
     * Page Update
     */

    public function check_subscribe_info() {
        exit(json_encode($this->M_pricing->getConfiguredPackage()));
    }

    public function pricing_pref() {
        ini_set('display_errors', 1);
        if(empty($_POST))
            redirect(site_url('/pricing/custom_pricing'));

        extract($_POST);
        $subscribe_record = json_decode($subscribe_info);
        $user_id = $subscribe_record->user_info->id;
        $data['subscribe_info']  = $subscribe_info;
        $data['user_pref'] = $this->db->select(
            'notification_phone, notification_phone_no, notification_email, notification_email_id, notification_fax, notification_fax_no, notification_frequence')->where('id', $user_id)->get('users')->row();
        $data['areas'] = $this->M_preferences->getAllAreas();
        $data['attributes'] = $this->M_property->getAllAttributes();
        if($subscribe_record->action == 'renew' || $subscribe_record->action == 'modify') {
            $whereArr = ['id' => $subscribe_record->record_id, 'user_id' => $user_id];
        }
        else {
            $whereArr = ['package_id' => $subscribe_record->package_selected_id, 'user_id' => $user_id];
        }
        $user_packages = $this->db
                                    ->select('no_of_area, short_term_available_date')
                                    ->where($whereArr)
                                    ->order_by('id', 'desc')
                                    ->limit(1)
                                    ->get('user_packages')
                                    ->row();
        
        $data['user_packages'] = $user_packages;
        $user_package_pref = $this->db
                                    ->select('id, area_ids, types, price_min, price_max')
                                    ->where(['user_package_ref_id' => $subscribe_record->record_id, 'user_id' => $user_id])
                                    ->order_by('id', 'asc')
                                    ->get('user_package_area_preferences')
                                    ->result();
        $data['user_package_pref'] = $user_package_pref;
        if(isset($user_package_pref[0]->id)) {
            foreach($user_package_pref as $row) {
                $data['user_package_pref_attrs'][] = $this->db
                                            ->select('area_id, attribute_id, value')
                                            ->where(['user_package_pref_id' => $row->id])
                                            ->get('user_package_preference_attribute_values')
                                            ->result_array();
            }
        }
        else {
            $data['user_package_pref_attrs'] = [];
        }
        $data['input_disable'] = (isset($subscribe_record->action) && ($subscribe_record->action == 'renew')) ? 'true' : 'false';
        $subscribe_info = json_decode($subscribe_info, true);
        if($subscribe_info['action'] == 'modify') {
            $subscribe_info['area_select_noof'] = $subscribe_info['area_select_noof'] + $user_packages->no_of_area;
        }
        else if($subscribe_info['action'] == 'renew') {
            $subscribe_info['area_select_noof'] = $user_packages->no_of_area;
        }

        // Get the package name
        $pack_name = $this->db
                    ->select('name')
                    ->where('id', $subscribe_info['package_selected_id'])
                    ->get('custom_package_names')
                    ->row();
        if(!isset($pack_name->name)) {
            die('Oops! we are unable to find the package name');
        } 
        $subscribe_info['pack_name'] = strtolower(trim($pack_name->name));
        $subscribe_info['short_term_available_date'] = $user_packages->short_term_available_date;
        $subscribe_info = json_encode($subscribe_info);
        $data['subscribe_info']  = $subscribe_info;

        // echo '<pre>';
        // print_r($user_packages);
        // print_r($subscribe_info);
        // die();

        $this->load->view('package-notification-pref', $data);
    }

    public function subscribe_custom() {
        if(empty($_POST))
            redirect(site_url('/pricing/custom_pricing'));
        ini_set('display_errors', 1);
            
        extract($_POST);
        // echo '<pre>';
        // print_r($_POST);
        // die();
        $subscribe_info = json_decode($subscribe_info);
        $user_id = $subscribe_info->user_info->id;
        // $dis_amnt = intval($subscribe_info->dis_amnt);
        $data['subscribe_info']  = $subscribe_info;
        $data['subscribe_pref_info'] = $subscribe_pref_info;
        $data['selected_pkg'] = $this->M_pricing->getConfiguredPackage();
        $data['subscribed_package'] = $this->M_subscription->getThisSubscribePackage($subscribe_info->package_selected_id, $user_id);
        if($subscribe_info->action == 'renew') {
            $data['subscribed_package'] = $this->M_subscription->getLastPackageById($subscribe_info->package_selected_id, $user_id);
            $record = $this->db
                        ->where('id', $subscribe_info->record_id)
                        ->get('user_packages')
                        ->row();
            $arr = [
                'name' => $record->package_name,
                'no_of_area' => $record->no_of_area,
                'no_of_days' => $record->no_of_days,
                'price' => $subscribe_info->total,
            ];
            $data['selected_pkg']['package_details'] = $arr;
        }
        $this->load->view('package-payment', $data);
    }

    public function custom_pricing() {
        $data['package_name'] = $this->db->where('status', 'active')->get('custom_package_names')->result_array();
        $data['users'] = $this->db->where('status', 'active')->order_by('name', 'asc')->get('users')->result_array();
        $this->load->view('pricing_plans_custom', $data);
    }

    public function custom_pricing_json_data() {
        ini_set('display_errors', 1);
        extract($_POST);
        $area_data = $this->db->where('custom_package_names_id', $package_id)->get('custom_package_areas')->result_array();
        $month_data = $this->db->where('custom_package_names_id', $package_id)->get('custom_package_months')->result_array();
        $package_data = $this->db->where('id', $package_id)->get('custom_package_names')->result_array();
        // $user_info = Data coming from $_POST format is
        // [user_info] => Array
        // (
        //     [id] => 20
        //     [name] => Amit
        //     [email] => aniruddha.roy12@gmail.com
        // )

        if(isset($record_id))
            $subscribed_package = $this->M_subscription->getTheUserPackage($record_id);
        else
            $subscribed_package = $this->M_subscription->getThisSubscribePackage($package_id, $user_info['id']);

        if(!empty($subscribed_package)) {
            $todate = DateTime::createFromFormat('Y-m-d', $subscribed_package->end_date)->format('jS M Y');
            $fromdate = DateTime::createFromFormat('Y-m-d', $subscribed_package->start_date)->format('jS M Y');
        }
        else {
            $fromdate = $todate = '';
        }
        $data = [
            'area_data' => $area_data,
            'month_data' => $month_data,
            'package_data' => $package_data,
            'subscribed_package' => $subscribed_package,
            'textdiv' => '<p>
                            You are already subscribed for this package
                        <br />
                        <button type="button" class="btn btn-link" onclick="window.location.href=\''.site_url('subscription/user').'\'">Renew</button>
                        <button type="button" class="btn btn-link" onclick="window.location.href=\''.site_url('subscription/user').'\'">Modify</button></p>',
            'renewtext' => '<p>You are already subscribed for this package, Validity of this package is from '.$fromdate." to ".$todate.', if you want to edit/modify this package click<button type="button" class="btn btn-link" onclick="packModify('.$package_id.')">Modify</button> </p>'
        ];
        if(empty($subscribed_package)) {
            unset($data['textdiv']);
            unset($data['renewtext']);
        }
        die(json_encode($data));
    }

    public function pay_package()
    {
        // echo '<pre>';
        ini_set('display_errors', 1);
        $this->load->library('BevelPay');
        $subscribe_info = json_decode($_POST['subscribe_info']);
        $user_id = $subscribe_info->user_info->id;
        // echo '<pre>';
        // print_r($_POST);
        // die();

        $package = $this->M_pricing->getConfiguredPackage();        
        if($subscribe_info->action == 'renew') {
            $renew_record = $this->db
                        ->where('id', $subscribe_info->record_id)
                        ->get('user_packages')
                        ->row();
            $arr = [
                'name' => $renew_record->package_name,
                'no_of_area' => $renew_record->no_of_area,
                'no_of_days' => $renew_record->no_of_days,
                'price' => $renew_record->price,
                'area_price' => $renew_record->area_price,
                'days_price' => $renew_record->days_price,
            ];
            // print_r($arr);

            $package['package_info'] = json_decode($package['package_info'], true);
            $package['package_info']['area_select_noof'] = $renew_record->no_of_area;
            $package['package_info']['days_select_noof'] = $renew_record->no_of_days;
            $package['package_info'] = json_encode($package['package_info']);  
            
            $package_details = [
                'package_selected_id' => $renew_record->package_id,
                'name' => $renew_record->package_name,
                'area_select_noof' => $renew_record->no_of_area,
                'no_of_area' => $renew_record->no_of_area,
                'area_price' => $renew_record->area_price,
                'days_select_noof' => $renew_record->no_of_days,
                'no_of_days' => $renew_record->no_of_days,
                'days_price' => $renew_record->days_price,
                'price' => $subscribe_info->total,
                'area_ids' => $renew_record->area_ids,
            ];
            $package['package_details'] = $package_details;
        }        

        $package_name = $package['package_details']['name'];
        $package_price = $package['package_details']['price'];
        $package_validity = $package['package_details']['no_of_days'];
        
        if(is_null($package)) {
            show_404();
            die;
        }       

        $description = $package_name . '($'.$package_price.') package subscription for '.$package_validity.' days';

        $subscribe_info = json_decode($this->input->post('subscribe_info'));
        if($subscribe_info->action == 'modify') {
            $description = $package_name . '($'.$package_price.') package Modify for '.$package_validity.' days';
        }
        else if($subscribe_info->action == 'renew') {
            $description = $package_name . '($'.$package_price.') package Renewed for '.$package_validity.' days';
        }
        else {
            $description = $package_name . '($'.$package_price.') package subscription for '.$package_validity.' days';
        }

        $subscribed_info = json_decode($_POST['subscribe_info']);
        
        if($subscribe_info->action == 'renew') {
            $package_id = $subscribe_info->package_selected_id;
        }
        // print_r($renew_record);
        // echo '<pre>';
        // print_r($_POST);
        // print_r($subscribe_info);
        // die();
        
        $invoiceId = $this->bevelpay->sale_package(
            $package,
            $this->input->post('cardNumber'),
            $this->input->post('mm') . $this->input->post('yy'),
            $this->input->post('cvv2'),
            $description,
            $this->input->post('name'),
            $this->input->post('street'),
            $this->input->post('zip')
        );
        // $invoiceId = 'db35e7164033e6bdd35ff771e8a7e3e46aca72';
        // echo '<pre>';
        // print_r($invoiceId);
        // die();
        if($invoiceId !== false) {
            if($subscribe_info->action == 'modify') {
                $current_pack_dtls = $this->db
                            ->select('no_of_area, area_price, no_of_days, days_price, price')
                            ->where('id', $subscribe_info->record_id)
                            ->get('user_packages')
                            ->row();
                
                $invoice_dtls  = $this->db
                            ->select('package')
                            ->where('id', $invoiceId)
                            ->get('invoices')
                            ->row();
                            
                $invoice_dtls = json_decode($invoice_dtls->package, true);
                $invoice_dtls['package_details']['area_price'] = $invoice_dtls['package_info']['total'] + $current_pack_dtls->area_price;
                $invoice_dtls['package_info']['total'] = $invoice_dtls['package_info']['total'] + $current_pack_dtls->price;
                $invoice_dtls['package_details']['price'] = $invoice_dtls['package_details']['area_price'] + $invoice_dtls['package_details']['days_price'];
                $_POST['package_dtls'] = json_encode($invoice_dtls);
            }
            $this->M_pricing->subscribe_package($invoiceId, $user_id);
            // print_r($_POST);
            // print_r($package);
            // print_r($invoiceId);
            // die();
        } else {
            $subscribe_info = json_decode($this->input->post('subscribe_info'));
            $data['subscribe_info']  = $subscribe_info;
            $data['subscribed_package'] = $this->M_subscription->getThisSubscribePackage($subscribe_info->package_selected_id, $user_id);
            if($subscribe_info->action == 'renew')
                $data['subscribed_package'] = $this->M_subscription->getTheUserPackage($subscribe_info->record_id);
            
            $data['selected_pkg'] = $this->M_pricing->getConfiguredPackage();
            if($subscribe_info->action == 'renew') {
                // start date and end date of the last package of the selected package id
                $last_package_info = $this->M_subscription->getLastPackageById($subscribe_info->package_selected_id, $user_id);
                $data['subscribed_package'] = (array)$data['subscribed_package'];
                if($last_package_info->end_date) {
                    $data['subscribed_package']['end_date'] = $last_package_info->end_date;
                    $data['subscribed_package']['start_date'] = $last_package_info->start_date;
                }
                $data['subscribed_package'] = (object)$data['subscribed_package'];
                $arr = [
                    'name' => $data['subscribed_package']->package_name,
                    'no_of_days' => $data['subscribed_package']->no_of_days,
                    'no_of_area' => $data['subscribed_package']->no_of_area,
                    'price' => $data['subscribed_package']->price,
                ];
                $data['selected_pkg']['package_details'] = $arr;
            }
            $data['last_errors'] = $this->bevelpay->getLastErrors();
            $data['subscribe_pref_info'] = $this->input->post('subscribe_pref_info');
            $this->load->view('package-payment', $data);
        }
    }

    public function manage_subscribed_package() {
        extract($_POST);
        ini_set('display_errors', 1);
        $user_packages = $this->db
                        ->select('no_of_area, area_price, no_of_days, days_price, price')
                        ->where(['package_id' => $package_id, 'user_id' => $_SESSION['id']])
                        ->get('user_packages')
                        ->row();

        if($user_packages) {
            $user_package_pref = $this->db
                                ->where(['user_package_id' => $package_id, 'user_id' => $_SESSION['id']])
                                ->get('user_package_preferences')
                                ->row();
            $user_package_pref_attr = $this->db
                                ->where(['user_package_pref_id' => $user_package_pref->id])
                                ->get('user_package_preference_attribute_values')
                                ->result();
            $data['package_name'] = $this->db
                                    ->where(['status' => 'active', 'id' => $package_id])
                                    ->get('custom_package_names')
                                    ->result_array();
            $data['user_packages'] = $user_packages;
            $data['package_pref'] = $user_package_pref;
            $data['package_pref_attr'] = $user_package_pref_attr;
            if($action == 'renew') {
                $this->load->view('pricing_plans_custom_readonly', $data);
            }
            else {
                $this->load->view('pricing_plans_custom_edit', $data);
            }

        }
    }

    public function manage_subscribed_package_custom() {
        extract($_POST);
        // [
        //     ...
        //     [userid] => 10
        // ]
        ini_set('display_errors', 1);
        $user_packages = $this->db
                        ->select('package_id, no_of_area, area_price, no_of_days, days_price, price')
                        ->where(['id' => $package_table_id, 'user_id' => $userid])
                        ->get('user_packages')
                        ->row();
        if($user_packages) {
            $package_id = $user_packages->package_id;
            $user_package_pref = $this->db
                                ->where(['user_package_id' => $package_id, 'user_id' => $userid])
                                ->get('user_package_preferences')
                                ->row();
            $user_package_pref_attr = $this->db
                                ->where(['user_package_pref_id' => $user_package_pref->id])
                                ->get('user_package_preference_attribute_values')
                                ->result();
            $data['package_name'] = $this->db
                                    ->where(['status' => 'active', 'id' => $package_id])
                                    ->get('custom_package_names')
                                    ->result_array();
            $data['users'] = $this->db
                                    ->where('status', 'active')
                                    ->where('id', $userid)
                                    ->order_by('name', 'asc')
                                    ->get('users')
                                    ->result_array();
            $data['user_packages'] = $user_packages;
            $data['package_pref'] = $user_package_pref;
            $data['package_pref_attr'] = $user_package_pref_attr;
            $data['record_id'] = $package_table_id;
            if($action == 'renew') {
                $this->load->view('pricing_plans_custom_readonly', $data);
            }
            else {
                $this->load->view('pricing_plans_custom_edit', $data);
            }

        }
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

            $this->load->helper('security');
            $_POST = array_map('xss_clean', $_POST);
			extract($_POST);
			$subscribe_info = json_decode($subscribe_info);
			$merge_attribute = array_combine($attribute_id, $value);
            ksort($merge_attribute);
            $user_id = $subscribe_info->user_info->id;

            


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
			$this->db->where('id', $user_id)
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
        // [userid] => 10

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
				'user_id' => $userid,
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
    

    public function subscribe_custom_no_pay() {
        if(empty($_POST))
            redirect(site_url('/pricing/custom_pricing'));
        ini_set('display_errors', 1);

        $this->load->library('BevelPay');
        $subscribe_info = json_decode($_POST['subscribe_info']);
        $user_id = $subscribe_info->user_info->id;

        $package = $this->M_pricing->getConfiguredPackage();        
        if($subscribe_info->action == 'renew') {
            $renew_record = $this->db
                        ->where('id', $subscribe_info->record_id)
                        ->get('user_packages')
                        ->row();
            $arr = [
                'name' => $renew_record->package_name,
                'no_of_area' => $renew_record->no_of_area,
                'no_of_days' => $renew_record->no_of_days,
                'price' => $renew_record->price,
                'area_price' => $renew_record->area_price,
                'days_price' => $renew_record->days_price,
            ];
            // print_r($arr);
            // die;

            $package['package_info'] = json_decode($package['package_info'], true);
            $package['package_info']['area_select_noof'] = $renew_record->no_of_area;
            $package['package_info']['days_select_noof'] = $renew_record->no_of_days;
            $package['package_info'] = json_encode($package['package_info']);  
            
            $package_details = [
                'package_selected_id' => $renew_record->package_id,
                'name' => $renew_record->package_name,
                'area_select_noof' => $renew_record->no_of_area,
                'no_of_area' => $renew_record->no_of_area,
                'area_price' => $renew_record->area_price,
                'days_select_noof' => $renew_record->no_of_days,
                'no_of_days' => $renew_record->no_of_days,
                'days_price' => $renew_record->days_price,
                'price' => $subscribe_info->total,
                'area_ids' => $renew_record->area_ids,
            ];
            $package['package_details'] = $package_details;
        }        

        $package_name = $package['package_details']['name'];
        $package_price = $package['package_details']['price'];
        $package_validity = $package['package_details']['no_of_days'];
        
        if(is_null($package)) {
            show_404();
            die;
        }       

        $description = $package_name . '($'.$package_price.') package subscription for '.$package_validity.' days';

        $subscribe_info = json_decode($this->input->post('subscribe_info'));
        if($subscribe_info->action == 'modify') {
            $description = $package_name . '($'.$package_price.') package Modify for '.$package_validity.' days';
        }
        else if($subscribe_info->action == 'renew') {
            $description = $package_name . '($'.$package_price.') package Renewed for '.$package_validity.' days';
        }
        else {
            $description = $package_name . '($'.$package_price.') package subscription for '.$package_validity.' days';
        }

        $subscribed_info = json_decode($_POST['subscribe_info']);
        
        if($subscribe_info->action == 'renew') {
            $package_id = $subscribe_info->package_selected_id;
        }
      
        $invoiceId = $this->bevelpay->sale_package_nopay(
            $package
        );
        $this->M_pricing->subscribe_package($invoiceId, $user_id);
    }
    
}
