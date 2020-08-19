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
                                  ->select('DISTINCT(user_id), invoice_id, LOWER(package_name) as package_name')
                                  ->group_start()
                                  ->where('start_date <=', date('Y-m-d'))
                                  ->or_where('end_date >=', date('Y-m-d'))
                                  ->group_end()
                                  ->get('user_packages')
                                  ->result();
        $package_pref = [];
        // Subscribed user package pref
        foreach ($active_subscribed_users as $key => $row) {
            $subscribed_pref = $this->db
                                ->where('user_id', $row->user_id)
                                ->where('invoice_id', $row->invoice_id)
                                ->get('user_package_preferences')   
                                ->result();
            if($subscribed_pref) {
                $subscribed_pref = (array) $subscribed_pref[0];                
                $subscribed_pref['for'] = ($row->package_name && !empty($row->package_name)) ? strtolower($row->package_name): '';
                $subscribed_pref['types'] = strtolower($subscribed_pref['types']);
                
                $subscribed_pref_attrs = $this->db->select('attribute_id, value')
                ->where('user_package_pref_id', $subscribed_pref['id'])
                ->get('user_package_preference_attribute_values')
                ->result();
                $arr = [];
                $subscribed_pref['pref_attrs'] = (object) $subscribed_pref_attrs;
                foreach ($subscribed_pref_attrs as $key => $item) {
                    $subscribed_pref['attr_'.$item->attribute_id] = $item->value;
                }
                $package_pref [] = (object) $subscribed_pref;
            
            }
        }
        print_r($package_pref);

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
            $no_of_bedroom = $no_of_bathroom = $no_of_area = $no_of_plot = $no_of_year = $no_of_floor = $no_of_garrage = 0;
            if($propertie_attrs) {
                $properties[$key]['propertie_attrs'] = (object)$propertie_attrs;
                foreach($properties[$key]['propertie_attrs'] as $index => $row) {
                    $row = (object)$row;
                    if($row->attribute_id == 1) {
                        $no_of_bedroom = intval($row->value);
                    }
                    if($row->attribute_id == 2) {
                        $no_of_bathroom = intval($row->value);
                    }
                    if($row->attribute_id == 3) {
                        $no_of_area = intval($row->value);
                    }
                    if($row->attribute_id == 4) {
                        $no_of_plot = intval($row->value);
                    }
                    if($row->attribute_id == 5) {
                        $no_of_year = intval($row->value);
                    }
                    if($row->attribute_id == 6) {
                        $no_of_floor = intval($row->value);
                    }
                    if($row->attribute_id == 7) {
                        $no_of_garrage = intval($row->value);
                    }

                }
            }            

            $properties[$key]['no_of_bedroom']  = $no_of_bedroom;
            $properties[$key]['no_of_bathroom'] = $no_of_bathroom;
            $properties[$key]['no_of_area']     = $no_of_area;
            $properties[$key]['no_of_plot']     = $no_of_plot;
            $properties[$key]['no_of_year']     = $no_of_year;
            $properties[$key]['no_of_floor']    = $no_of_floor;
            $properties[$key]['no_of_garrage']  = $no_of_garrage;
        }

        $properties = (object) $properties;
        $package_pref = (object) $package_pref;

        //  Loop through the properties
        foreach ($properties as $key => $record) {
            foreach ($package_pref as $index => $item) {
                $arr = explode(',', $item->area_ids);
                if(in_array($record['area_id'], $arr) && $record['status'] == 'active') {
                    $u_types = $item->types;
                    $u_for = $item->for;
                    $u_price_min = intval($item->price_min);
                    $u_price_max = intval($item->price_max);

                    $u_no_of_bedroom = intval($item->no_of_bedroom);
                    $u_no_of_bathroom = intval($item->no_of_bathroom);
                    $u_no_of_area = intval($item->no_of_area);
                    $u_no_of_plot = intval($item->no_of_plot);
                    $u_no_of_year = intval($item->no_of_year);
                    $u_no_of_floor = intval($item->no_of_floor);
                    $u_no_of_garrage = intval($item->no_of_garrage);

                    $temp_arr = [
                        "no_of_bedroom" => intval($item->no_of_bedroom),
                        "no_of_bathroom" => intval($item->no_of_bathroom),
                        "no_of_area" => intval($item->no_of_area),
                        "no_of_plot" => intval($item->no_of_plot),
                        "no_of_year" => intval($item->no_of_year),
                        "no_of_floor" => intval($item->no_of_floor),
                        "no_of_garrage" => intval($item->no_of_garrage)
                    ];

                    foreach ($temp_arr as $k => $v) {
                        if($v < 1){
                            unset($temp_arr[$k]);
                        }
                    }
                    // $condition = true;
                    // foreach ($temp_arr as $k => $v) {
                    //     $condition = $condition || $v <= $record[$k];
                    // }

                    $condition = false;
                    foreach ($temp_arr as $k => $v) {
                        if($v <= $record[$k]) {
                            $condition = true;
                            break;
                        }
                    }

                    if(in_array($record['type'], explode(',', $u_types))
                        && ($record['for'] == $u_for) && ($record['price'] >= $u_price_min) && ($record['price'] <= $u_price_max)
                        && ($record['price'] >= $u_price_min) && ($record['price'] <= $u_price_max) 
                        && $condition
                        ) {
                            print_r($item);
                            print_r($record);   
                            echo "\n";
                    }

                    // if(($u_types == $record['type'])
                }
            }
            echo "-------------------------------------------"."\n";    
        }


    }
}
