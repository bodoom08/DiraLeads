<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pricing extends CI_Controller
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
            // redirect(site_url('/pricing/custom_pricing'));
        
        extract($_POST); 
        $subscribe_info = '{"package_selected_id":"14","days_select_noof":"1","area_select_noof":"1","total":62,"action":"new","pack_name":"short term rent","short_term_available_date":null}';
        $data['subscribe_info']  = $subscribe_info;
        $data['user_pref'] = $this->db->select(
            'notification_phone, notification_phone_no, notification_email, notification_email_id, notification_fax, notification_fax_no, notification_frequence')->where('id', $_SESSION['id'])->get('users')->row();
        $data['areas'] = $this->M_preferences->getAllAreas();
        $data['attributes'] = $this->M_property->getAllAttributes();
        $subscribe_record = json_decode($subscribe_info);
        if($subscribe_record->action == 'renew' || $subscribe_record->action == 'modify') {
            $whereArr = ['id' => $subscribe_record->record_id, 'user_id' => $_SESSION['id']];
        }
        else {
            $whereArr = ['package_id' => $subscribe_record->package_selected_id, 'user_id' => $_SESSION['id']];
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
                                    ->where(['user_package_ref_id' => $subscribe_record->record_id, 'user_id' => $_SESSION['id']])
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
            
        extract($_POST);        
        $subscribe_info = json_decode($subscribe_info);
        $data['subscribe_info']  = $subscribe_info;
        $data['subscribe_pref_info'] = $subscribe_pref_info;
        $data['selected_pkg'] = $this->M_pricing->getConfiguredPackage();
        $data['subscribed_package'] = $this->M_subscription->getThisSSubscribePackage($subscribe_info->package_selected_id);
        if($subscribe_info->action == 'renew') {
            $data['subscribed_package'] = $this->M_subscription->getLastPackageById($subscribe_info->package_selected_id);
            $record = $this->db
                        ->where('id', $subscribe_info->record_id)
                        ->get('user_packages')
                        ->row();
            $arr = [
                'name' => $record->package_name,
                'no_of_area' => $record->no_of_area,
                'no_of_days' => $record->no_of_days,
                'price' => $record->price,
            ];
            $data['selected_pkg']['package_details'] = $arr;
        }
        $this->load->view('package-payment', $data);
    }

    public function custom_pricing() {
        $data['package_name'] = $this->db->where('status', 'active')->get('custom_package_names')->result_array();        
        $this->load->view('pricing_plans_custom', $data);
    }

    public function custom_pricing_json_data() {
        ini_set('display_errors', 1);
        extract($_POST);
        $area_data = $this->db->where('custom_package_names_id', $package_id)->get('custom_package_areas')->result_array();
        $month_data = $this->db->where('custom_package_names_id', $package_id)->get('custom_package_months')->result_array();
        $package_data = $this->db->where('id', $package_id)->get('custom_package_names')->result_array();
        if(isset($record_id))
            $subscribed_package = $this->M_subscription->getTheUserPackage($record_id);
        else
            $subscribed_package = $this->M_subscription->getThisSSubscribePackage($package_id);

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
                'price' => $renew_record->price,
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
        // $invoiceId = 'c414ea0610007da4b61f46d8af3a5c0aa60ba0';
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
            $this->M_pricing->subscribe_package($invoiceId);
            // print_r($_POST);
            // print_r($package);
            // print_r($invoiceId);
            // die();
        } else {
            $subscribe_info = json_decode($this->input->post('subscribe_info'));
            $data['subscribe_info']  = $subscribe_info;
            $data['subscribed_package'] = $this->M_subscription->getThisSSubscribePackage($subscribe_info->package_selected_id);
            if($subscribe_info->action == 'renew')
                $data['subscribed_package'] = $this->M_subscription->getTheUserPackage($subscribe_info->record_id);
            
            $data['selected_pkg'] = $this->M_pricing->getConfiguredPackage();
            if($subscribe_info->action == 'renew') {
                // start date and end date of the last package of the selected package id
                $last_package_info = $this->M_subscription->getLastPackageById($subscribe_info->package_selected_id);
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
        ini_set('display_errors', 1);
        $user_packages = $this->db
                        ->select('package_id, no_of_area, area_price, no_of_days, days_price, price')
                        ->where(['id' => $package_table_id, 'user_id' => $_SESSION['id']])
                        ->get('user_packages')
                        ->row();
        if($user_packages) {
            $package_id = $user_packages->package_id;
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
            $data['record_id'] = $package_table_id;
            if($action == 'renew') {
                redirect(site_url('/pricing/pricing_pref'));
                // $this->load->view('pricing_plans_custom_readonly', $data);
            }
            else {
                 redirect(site_url('/pricing/pricing_pref'));
                // $this->load->view('pricing_plans_custom_edit', $data);
            }

        }
    }
    
}
