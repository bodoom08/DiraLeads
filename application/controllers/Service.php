<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Service extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_preferences');

    }
    
    function service_1() {
        echo '<pre>';
        ini_set('display_errors', 1);
        // Subscribed users
        $active_subscribed_users = $this->db
                                  ->select('DISTINCT(user_id), id as  user_package_ref_id, invoice_id, LOWER(package_name) as package_name')
                                  ->group_start()
                                  ->where('start_date <=', date('Y-m-d'))
                                  ->where('end_date >=', date('Y-m-d'))
                                  ->group_end()
                                  ->get('user_packages')
                                  ->result();
        $package_pref = [];
        // Subscribed user package pref
        foreach ($active_subscribed_users as $key => $row) {
            $subscribed_pref = $this->db
                                ->where('user_id', $row->user_id)
                                ->where('user_package_ref_id', $row->user_package_ref_id)
                                ->get('user_package_area_preferences')   
                                ->result();

            if($subscribed_pref) {
                foreach($subscribed_pref as $key => $pref) {
                    $subscribed_pref = (array) $pref;
                    $subscribed_pref['for'] = ($row->package_name && !empty($row->package_name)) ? strtolower($row->package_name): '';
                    $subscribed_pref['types'] = strtolower($subscribed_pref['types']);
                    
                    $subscribed_pref_attrs = $this->db->select('area_id, attribute_id, value')
                    ->where(
                        [
                            'user_package_ref_id' => $subscribed_pref['user_package_ref_id'],
                            'area_id' => $subscribed_pref['area_ids'],
                        ])
                    ->get('user_package_preference_attribute_values')
                    ->result();
                    $subscribed_pref['pref_attrs'] = (object) $subscribed_pref_attrs;
                    foreach ($subscribed_pref_attrs as $key => $item) {
                        $subscribed_pref['attr']['attr_'.$item->area_id.'_'.$item->attribute_id] = $item->value;
                    }
                    $package_pref [] = (object) $subscribed_pref;
                }
            
            }
        }        

        // Getting all properties whose staus false
        $properties = $this->db
                        ->where('flag', 'false')
                        ->get('properties')
                        
                        ->result_array();
        foreach ($properties as $key => $value) {
            $propertie_attrs = $this->db
                                ->select('attribute_id, value')
                                ->where('property_id', $value['id'])
                                ->get('property_attribute_values')
                                ->result_array();
            if($propertie_attrs) {
                foreach ($propertie_attrs as $k => $v) {
                    $properties[$key]['attr']['attr_'.$value['area_id'].'_'.$v['attribute_id']] = $v['value'];
                }
                $properties[$key]['propertie_attrs'] = (object)$propertie_attrs;
            }
        }

        $properties = (object) $properties;
        $package_pref = (object) $package_pref;

        // print_r('User Package Pref- '."\n");
        // print_r($package_pref);
        // print_r('Properties-'."\n");
        // print_r($properties);
        // die();

        // Abbreviation
        // [attr_2_2] = attr_[area_id]_[attribute_id]

        //  Loop through the properties
        foreach ($properties as $key => $record) {
            foreach ($package_pref as $index => $item) {
                $user_pref_attr = $item->attr;
                $prop_pref_attr = $record['attr'];

                $arr = explode(',', $item->area_ids);
                if(in_array($record['area_id'], $arr) && $record['status'] == 'active') {
                    $u_types = $item->types;
                    $u_for = $item->for;
                    $u_price_min = intval($item->price_min);
                    $u_price_max = intval($item->price_max);

                    $condition = false;
                    foreach ($user_pref_attr as $k => $v) {
                        if(array_key_exists($k, $prop_pref_attr)) {
                            if($v <= $prop_pref_attr[$k]) {
                                $condition = true;
                                break;
                            }
                        }                        
                    }

                    if(in_array($record['type'], explode(',', $u_types))
                        && ($record['for'] == $u_for) && ($record['price'] >= $u_price_min) && ($record['price'] <= $u_price_max)
                        && ($record['price'] >= $u_price_min) && ($record['price'] <= $u_price_max) 
                        && $condition
                        ) {
                            $this->db
                                    ->where('id', $record['id'])
                                    ->update('properties', ['flag' => 'true']);

                            $attribute_id = str_replace('attr_', '', $k);

                            $attributes = $this->db
                                            ->where('id', $attribute_id)
                                            ->get('property_attributes')
                                            ->row();

                            $users = $this->db
                                            ->where('id', $record['user_id'])
                                            ->get('users')
                                            ->row();
                            $areas = $this->db
                                            ->where('id', $record['area_id'])
                                            ->get('areas')
                                            ->row();
                            $arr = [
                                'mobile_no' => $users->mobile,
                                'property_id' => $record['id'],
                                'user_id' => $record['user_id'],
                                'message' => 'Property found in your area '.$areas->title." for ".$attributes->description." ".$v,
                                'location' => '',                                
                            ];
                            $this->db->insert('live_sms_table', $arr);
                            echo "\n";
                    }
                }
            }
            echo "-------------------------------------------"."\n";    
        }


    }

    function notify_service() {
        echo '<pre>';
        $rslt = $this->db
                ->where('flag', 'false')
                ->get('live_sms_table')
                ->result();

        foreach ($rslt as $key => $record) {
            if(!empty($record->mobile_no)) {
                $data_json = send_notify_sms($record->mobile_no, $record->message);                
                $data = json_decode($data_json);
                $arr = [
                    'request' => json_encode($data->msg),
                    'message' => $data->msg->body,
                    'location' => 'SMS - Notify',
                    'response' => $data_json,
                    'status' => $data->status,
                    'flag' =>  'true',
                    'sent_on' => date('Y-m-d H:i:s', strtotime($data->date_updated))
                 ];

                 $this->db->where('id', $record->id)
                         ->update('live_sms_table', $arr);
                // print_r($this->db->last_query());
            }
        }
        print_r($rslt);
    }

    /**
     * Service is used by Cronjob to push the data
     * into the push_notify_table
     */

    function service_add_notify() {
        echo '<pre>';
        ini_set('display_errors', 1);
        // Subscribed users
        $active_subscribed_users = $this->db
                                  ->select('DISTINCT(user_id), id as  user_package_ref_id, invoice_id, LOWER(package_name) as package_name')
                                  ->group_start()
                                  ->where('start_date <=', date('Y-m-d'))
                                  ->where('end_date >=', date('Y-m-d'))
                                  ->group_end()
                                  ->get('user_packages')
                                  ->result();
        $package_pref = [];
        // Subscribed user package pref
        foreach ($active_subscribed_users as $key => $row) {
            $subscribed_pref = $this->db
                                ->where('user_id', $row->user_id)
                                ->where('user_package_ref_id', $row->user_package_ref_id)
                                ->get('user_package_area_preferences')   
                                ->result();
            if($subscribed_pref) {
                foreach($subscribed_pref as $key => $pref) {
                    $subscribed_pref = (array) $pref;
                    $subscribed_pref['for'] = ($row->package_name && !empty($row->package_name)) ? strtolower($row->package_name): '';
                    $subscribed_pref['types'] = strtolower($subscribed_pref['types']);
                    
                    $subscribed_pref_attrs = $this->db->select('area_id, attribute_id, value')
                    ->where(
                        [
                            'user_package_ref_id' => $subscribed_pref['user_package_ref_id'],
                            'area_id' => $subscribed_pref['area_ids'],
                        ])
                    ->get('user_package_preference_attribute_values')
                    ->result();
                    $subscribed_pref['pref_attrs'] = (object) $subscribed_pref_attrs;
                    foreach ($subscribed_pref_attrs as $key => $item) {
                        $subscribed_pref['attr']['attr_'.$item->area_id.'_'.$item->attribute_id] = $item->value;
                    }
                    $package_pref [] = (object) $subscribed_pref;
                }
            
            }
        }        

        // Getting all properties whose staus false
        $properties = $this->db
                        ->where('flag', 'false')
                        ->get('properties')
                        
                        ->result_array();
        foreach ($properties as $key => $value) {
            $propertie_attrs = $this->db
                                ->select('attribute_id, value')
                                ->where('property_id', $value['id'])
                                ->get('property_attribute_values')
                                ->result_array();
            if($propertie_attrs) {
                foreach ($propertie_attrs as $k => $v) {
                    $properties[$key]['attr']['attr_'.$value['area_id'].'_'.$v['attribute_id']] = $v['value'];
                }
                $properties[$key]['propertie_attrs'] = (object)$propertie_attrs;
            }
        }

        $properties = (object) $properties;
        $package_pref = (object) $package_pref;

        // print_r('User Package Pref- '."\n");
        // print_r($package_pref);

        // print_r('Properties-'."\n");
        // print_r($properties);
        // die();

        // Abbreviation
        // [attr_2_2] = attr_[area_id]_[attribute_id]

        //  Loop through the properties
        foreach ($properties as $key => $record) {
            foreach ($package_pref as $index => $item) {
                $user_pref_attr = $item->attr;
                $prop_pref_attr = $record['attr'];

                $arr = explode(',', $item->area_ids);
                if(in_array($record['area_id'], $arr) && $record['status'] == 'active') {
                    $u_types = $item->types;
                    $u_for = $item->for;
                    $u_price_min = intval($item->price_min);
                    $u_price_max = intval($item->price_max);

                    $condition = false;
                    foreach ($user_pref_attr as $k => $v) {
                        if(array_key_exists($k, $prop_pref_attr)) {
                            if($v <= $prop_pref_attr[$k]) {
                                $condition = true;
                                break;
                            }
                        }                        
                    }

                    if(in_array($record['type'], explode(',', $u_types))
                        && ($record['for'] == $u_for) && ($record['price'] >= $u_price_min) && ($record['price'] <= $u_price_max) 
                        && $condition
                        ) {
                            $this->db
                                    ->where('id', $record['id'])
                                    ->update('properties', ['flag' => 'true']);

                            $attribute_id = str_replace('attr_', '', $k);

                            $attributes = $this->db
                                            ->where('id', $attribute_id)
                                            ->get('property_attributes')
                                            ->row();

                            $property_owner = $this->db
                                            ->where('id', $record['user_id'])
                                            ->get('users')
                                            ->row();
                            $subscriber = $this->db
                                            ->where('id', $item->user_id)
                                            ->get('users')
                                            ->row();
                            $areas = $this->db
                                            ->where('id', $record['area_id'])
                                            ->get('areas')
                                            ->row();
                            $arr = [
                                'country_code'  => $subscriber->country_code,
                                'mobile'        => $subscriber->mobile,
                                'email'         => $subscriber->email,
                                'property_id'   => $record['id'],
                                'user_id'       => $subscriber->id,
                                'created_at'    => date('Y-m-d H:i:s'),
                                'message'       => 'Property found in your area '.$areas->title." for ".$attributes->description." ".$v,
                                // 'location'      => '',
                            ];
                            // print_r($arr);
                            $this->db->insert('push_notify_table', $arr);
                            echo "\n";
                    }
                }
            }
            echo "-------------------------------------------"."\n";    
        }


    }

    /**
     * Service is used by cronjob to notify the user from
     * the push_notify_table
     */
    function service_send_notify() {
        $this->load->helper('email');
        echo '<pre>';
        $rslt = $this->db
                ->where('sent', 'false')
                ->limit(10)
                ->order_by('id', 'asc')
                ->get('push_notify_table')
                ->result();

        foreach ($rslt as $key => $record) {
            if(!empty($record->mobile)) {
                $mobile_no = $record->country_code.$record->mobile;
                // SMS Notify
                $data_json = send_notify_sms($mobile_no, $record->message);
                $data = json_decode($data_json);
                $arr = [
                    'country_code' => $record->country_code,
                    'mobile_no' => $record->mobile,
                    'request' => json_encode($data->msg),
                    'message' => $data->msg->body,
                    'location' => 'Property SMS Alert',
                    'response' => $data_json,
                    'status' => $data->status,
                    'created_at' => date('Y-m-d H:i:s', strtotime($data->date_updated))
                 ];
                 $this->db
                         ->insert('logs_sms', $arr);

                // Email Notify
                $body = '<table style="background:#f9f9f9; padding: 30px 20px;">
                    <tr>
                        <td class="h2-center" style="color:#000000; font-size:32px; line-height:36px; text-align:center; padding-bottom:20px;">Property Matched.</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td class="text-button-orange" style="background:#e85711; color:#ffffff; font-size:14px; line-height:18px; text-align:center; padding:10px 30px; border-radius:20px;">'.$record->message.'</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>';
                send_email($record->email, 'Diraleads Email Notify', $body);

                // Remove the Data from the push_notify_table
                $this->db->where('id', $record->id);
                $this->db->delete('push_notify_table');

                // print_r($this->db->last_query());
            }
        }
    }

    

    function gen_pdf() {
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('My Title');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('Author');
        $pdf->SetDisplayMode('real', 'default');

        $pdf->AddPage();

        $pdf->Write(5, 'Some sample text');
        $filename = "/var/www/diraleads-com/uploads/My-File-Name.pdf";
        $pdf->Output($filename, 'F');
    }

    function telnyx_vn_test() {
        echo '<pre>';
        $this->load->helper('sms');
        $response = get_vn();
        print_r($response);        
    } 

    function telnyx_vn_test_1() {
        echo '<pre>';
        $this->load->library('telnyx');
        $number_e164 = '+15162000187';
        $numberOrders = $this->telnyx->createNumberOrders($number_e164);
        // if (is_array($numberOrders)) {
        //     $this->db->insert('virtual_numbers', [
        //         'number' => $number_e164,
        //         'details' => json_encode($this->telnyx->myNumbers($number_e164))
        //     ]);
        //     print_r($number_e164);
        //     print_r($numberOrders);
        // }
        
        // $numberResult = $this->telnyx->searchNumbers(["country_iso" => 'us', 'state' => 'NY'], 1);
        // var_dump($numberResult);
        // die;
        // if (count($numberResult['result']) > 0) {
        //     $number_e164 = $numberResult['result'][0]['number_e164'];
            
        // }
        print_r($numberOrders);
    }

    function telnyx_vn_test_no() {
        // die('ssasasas');
        $this->load->library('telnyx');
        $numberResult = $this->telnyx->searchNumbers(["country_iso" => 'us', 'state' => 'NY'], 1);
        var_dump($numberResult);
        die;

        if (count($numberResult['result']) > 0) {
            $number_e164 = $numberResult['result'][0]['number_e164'];
            $numberOrders = $this->telnyx->createNumberOrders($number_e164);
            if (is_array($numberOrders)) {
                $this->db->insert('virtual_numbers', [
                    'number' => $number_e164,
                    'details' => json_encode($this->telnyx->myNumbers($number_e164))
                ]);
            } else {
                die(json_encode(['type' => 'warning', 'text' => 'Property submitted but can not be listed for number allocation error! Please contact admin']));
            }
        }
    }

    function telnyx_curl_get_numbers() {
        $curl = curl_init();
        $country_iso = "us";
        $state = "NY";


        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.telnyx.com/origination/number_searches",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS =>"{\r\n  \"search_descriptor\": {\r\n    \"country_iso\": \"$country_iso\",\r\n    \"state\": \"$state\"\r\n  }\r\n}",
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
        ),
      ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    function telnyx_number_fn() {
        $this->load->helper('telnyx_number');
        $numberResult = searchNumbersHelper('us', 'NY');
        if (count($numberResult['result']) > 0) {
            $number_e164 = $numberResult['result'][0]['number_e164'];
            $numberOrders = createNumberOrdersHelper($number_e164);
            if (is_array($numberOrders)) {
                $this->db->insert('virtual_numbers', [
                    'number' => $number_e164,
                    'details' => json_encode(myNumbersHelper($number_e164))
                ]);
            } else {
                die(json_encode(['type' => 'warning', 'text' => 'Property submitted but can not be listed for number allocation error! Please contact admin']));
            }
        }

        // echo $response;
    }

    
    function telnyx_sms_test() {
        $this->load->helper('sms');
        send_sms('8116035597', 'Test SMS Using Telnyx');
    }

    
}
