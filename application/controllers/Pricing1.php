<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pricing extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_pricing');
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
            $data['packages'] = $this->M_pricing->getAllPackages();
            $this->load->view('pricing_plans', $data);
        }

    }

    public function subscribe()
    {
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
            var_dump($this->bevelpay->getLastErrors());
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
}
