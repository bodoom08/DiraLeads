<?php
defined('BASEPATH') or exit('No direct script access allowed');
require(APPPATH . 'third_party/usaepay-master/usaepay.php');

class BevelPay extends umTransaction
{
    /* Possible command values are: cc:sale (Default),
    cc:authonly, cc:capture, cc:credit,
    cc:postauth, check:sale, check:credit,
    void, void:release, refund, creditvoid, cc:save */

    private $db;
    private $lastErrors;

    public function __construct()
    {
        parent::__construct();
        $CI =& get_instance();

        $this->db = $CI->load->database('default', true);
        $this->lastErrors = [];

        // $this->gatewayurl = "https://www.bevelpay.com/gate";
        // $this->software = 'BevelPay using ' . $this->software;
        // $this->key = 'nLT5ii3Bz18Y5aIzXPV5JQ1W34Kc43Xm';
        // $this->pin = '1111';

        $this->gatewayurl = "https://www.bevelpay.com/gate";
        // $this->software = 'BevelPay using ' . $this->software;
        $this->key = 'Q0vJ5RQ30KUhWMe3QW5kOALKA7r434s1';
        $this->pin = '1111';
        $this->testmode = 1; // Change this to 0 for the transaction to process
    }

    public function sale($package, $card, $exp, $cvv2, $description, $name, $street, $zip)
    {
        $this->command = "cc:sale";

        $this->card = $card;
        $this->exp = $exp;
        $this->amount = number_format($package->price, 2, '.', '');
        $this->orderid = bin2hex(random_bytes(19));
        $this->cardholder = $name;
        $this->street = $street;
        $this->zip = $zip;
        $this->description = $description;
        $this->cvv2 = $cvv2;


        if($this->Process()) {
            if($this->db) {
                $this->db->insert('invoices', [
                    'id' => $this->orderid,
                    'name' => $this->cardholder,
                    'street' => $this->street,
                    'zip' => $this->zip,
                    'description' => $this->description,
                    'result' => $this->result,
                    'refnum' => $this->refnum,
                    'avs_result' => $this->avs_result,
                    'error' => $this->error,
                    'package' => json_encode($package),
                ]);
            }
            
            return $this->orderid;
        } else {
            $this->lastErrors = [
                'refnum' => $this->refnum,
                'result' => $this->result,
                'error' => $this->error,
                'errorcode' => $this->errorcode,
                'avs_result' => $this->avs_result,
                'cvv2_result' => $this->cvv2_result
            ];
        }
        
        return false;
    }

    public function sale_package($package, $card, $exp, $cvv2, $description, $name, $street, $zip)
    {
        ini_set('display_errors', 1);

        $this->command = "cc:sale";
        $package_price = $package['package_details']['price'];

        $this->card = $card;
        $this->exp = $exp;
        $this->amount = number_format($package_price, 2, '.', '');
        $this->orderid = bin2hex(random_bytes(19));
        $this->cardholder = $name;
        $this->street = $street;
        $this->zip = $zip;
        $this->description = '';
        $this->cvv2 = $cvv2;


        if($this->Process()) {
            if($this->db) {
                $package['package_info'] = json_decode($package['package_info'], true);
                $custom_package_areas =  $this->db->where(['custom_package_names_id' => $package['package_info']['package_selected_id'],'noof' => $package['package_info']['area_select_noof']])->get('custom_package_areas')->row();
                $custom_package_days =  $this->db->where(['custom_package_names_id' => $package['package_info']['package_selected_id'],'noof' => $package['package_info']['days_select_noof']])->get('custom_package_months')->row();
                if($package['package_info']['action'] == 'new') {
                    $area_price = $custom_package_areas->price;
                }
                else if($package['package_info']['action'] == 'renew') {
                    $area_price = $package['package_details']['area_price'];
                }
                else {
                    $area_price = $package['package_info']['total'];
                }

                $details_arr = [
                    "package_selected_id" => $package['package_info']['package_selected_id'],
                    "name" => $package['package_details']['name'],
                    "area_select_noof" => $package['package_details']['no_of_area'],
                    "no_of_area" => $package['package_details']['no_of_area'],
                    'area_price' => intval($area_price),
                    "days_select_noof" => $package['package_info']['days_select_noof'],
                    "no_of_days" => $package['package_details']['no_of_days'],
                    'days_price' => intval($custom_package_days->price),
                    "price" => $package['package_details']['price'],

                ];
                $package['package_details'] = $details_arr;
                                
                $this->db->insert('invoices', [
                    'id' => $this->orderid,
                    'name' => $this->cardholder,
                    'street' => $this->street,
                    'zip' => $this->zip,
                    'description' => $this->description,
                    'result' => $this->result,
                    'refnum' => $this->refnum,
                    'avs_result' => $this->avs_result,
                    'error' => $this->error,
                    'package' => json_encode($package),
                ]);
            }
            
            return $this->orderid;
        } else {
            $this->lastErrors = [
                'refnum' => $this->refnum,
                'result' => $this->result,
                'error' => $this->error,
                'errorcode' => $this->errorcode,
                'avs_result' => $this->avs_result,
                'cvv2_result' => $this->cvv2_result
            ];
        }
        
        return false;
    }

    public function sale_package_nopay($package, $card='', $exp='', $cvv2='', $description='', $name='', $street='', $zip='')
    {
        ini_set('display_errors', 1);

        $this->command = "cc:sale";
        $package_price = $package['package_details']['price'];

        $this->card = $card;
        $this->exp = $exp;
        $this->amount = number_format($package_price, 2, '.', '');
        $this->orderid = bin2hex(random_bytes(19));
        $this->cardholder = $name;
        $this->street = $street;
        $this->zip = $zip;
        $this->description = '';
        $this->cvv2 = $cvv2;


        $package['package_info'] = json_decode($package['package_info'], true);
        $custom_package_areas =  $this->db->where(['custom_package_names_id' => $package['package_info']['package_selected_id'],'noof' => $package['package_info']['area_select_noof']])->get('custom_package_areas')->row();
        $custom_package_days =  $this->db->where(['custom_package_names_id' => $package['package_info']['package_selected_id'],'noof' => $package['package_info']['days_select_noof']])->get('custom_package_months')->row();
        if($package['package_info']['action'] == 'new') {
            $area_price = $custom_package_areas->price;
        }
        else if($package['package_info']['action'] == 'renew') {
            $area_price = $package['package_details']['area_price'];
        }
        else {
            $area_price = $package['package_info']['total'];
        }

        $details_arr = [
            "package_selected_id" => $package['package_info']['package_selected_id'],
            "name" => $package['package_details']['name'],
            "area_select_noof" => $package['package_details']['no_of_area'],
            "no_of_area" => $package['package_details']['no_of_area'],
            'area_price' => intval($area_price),
            "days_select_noof" => $package['package_info']['days_select_noof'],
            "no_of_days" => $package['package_details']['no_of_days'],
            'days_price' => intval($custom_package_days->price),
            "price" => $package['package_details']['price'],

        ];
        $package['package_details'] = $details_arr;
                        
        $this->db->insert('invoices', [
            'id' => $this->orderid,
            'name' => $this->cardholder,
            'street' => $this->street,
            'zip' => $this->zip,
            'description' => $this->description,
            'result' => 'Approved',
            'refnum' => 0,
            'avs_result' => 'NO PAY',
            'error' => '',
            'pay' => 'false',
            'package' => json_encode($package),
        ]);
    
        return $this->orderid;
    }

    public function getLastErrors()
    {
        return $this->lastErrors;
    }
}
