<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_pricing extends CI_Model
{
    public function getAllPackages()
    {
        return $this->db->where('status', 'active')->get('packages')->result_array();
    }
    
    public function getSelectedPackage()
    {
        return $this->db
            ->where('id', $this->input->post('package_id'))
            ->get('packages')
            ->row();
    }

    public function subscribe($invoiceId)
    {
        $invoice = $this->db->where('id', $invoiceId)->get('invoices')->row();
        
        if ($invoice) {
            $package = json_decode($invoice->package);

            $lastPackage = $this->db
                ->where('package_id', 1)
                ->where('user_id', $_SESSION['id'])
                ->where('end_date >', date('Y-m-d'))
                ->order_by('end_date', 'desc')
                ->limit(1)
                ->get('user_packages')
                ->row();

            $start_date = is_null($lastPackage) ?
                date_create() :
                date_add(date_create($lastPackage->end_date), new DateInterval('P1D'))
            ;
            
            $users_packages_data = [
                'invoice_id' => $invoice->id,
                'user_id' => $_SESSION['id'],
                'package_id' => $package->id,
                'package_name' => $package->name,
                'validity' => $package->validity,
                'description' => $package->description,
                'price' => $package->price,
                'for' => $package->for,
                'created_by' => $_SESSION['id'],
                'start_date' => $start_date->format('Y-m-d'),
                'end_date' => $start_date->add(new DateInterval('P'.$package->validity.'D'))->format('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->db->insert('user_packages', $users_packages_data)) {
                $this->db->where('id', $_SESSION['id'])->update('users', ['subscribe_flag' => 'yes']);
                $this->session->set_userdata(['subscribe_flag' => 'yes']);
                
                redirect('invoices');
            }
        }
        echo "<script>alert('Invalid Invoice');</script>";
        redirect('pricing');
    }

    public function subscribe_package($invoiceId)
    {
        ini_set('display_errors', 1);
        $invoice = $this->db->where('id', $invoiceId)->get('invoices')->row();
        if ($invoice) {
            $package = json_decode($invoice->package);
            
            $subscribe_info = json_decode($this->input->post('subscribe_info'));
            if($subscribe_info->action == 'modify') {
                $package = json_decode($_POST['package_dtls']);
            }            
            $package_id = $package->package_details->package_selected_id;

            $lastPackage = $this->db
                ->where('package_id', $package_id)
                ->where('user_id', $_SESSION['id'])
                ->where('end_date >', date('Y-m-d'))
                ->order_by('end_date', 'desc')
                ->limit(1)
                ->get('user_packages')
                ->row();
               
            $start_date = is_null($lastPackage) ?
                date_create() :
                date_add(date_create($lastPackage->end_date), new DateInterval('P1D'))
            ;

            $users_packages_data = [
                'invoice_id' => $invoice->id,
                'user_id' => $_SESSION['id'],
                'package_id' => $package_id,
                'package_name' => $package->package_details->name,
                'validity' => $package->package_details->no_of_days,
                'description' => $package->package_details->name.' for '.$package->package_details->no_of_days.' day(s) for no of area '.$package->package_details->no_of_area,
                'price' => $package->package_details->price,
                'for' => $package->package_details->name,
                'created_by' => $_SESSION['id'],
                'start_date' => $start_date->format('Y-m-d'),
                'package' => $invoice->package,
                'no_of_area' => $package->package_details->no_of_area,
                'area_price' => $package->package_details->area_price,
                'no_of_days' => $package->package_details->no_of_days,
                'days_price' => $package->package_details->days_price,
                'end_date' => $start_date->add(new DateInterval('P'.$package->package_details->no_of_days.'D'))->format('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            if($subscribe_info->pack_name == 'short term rent') {
                $users_packages_data['short_term_available_date'] = $subscribe_info->short_term_available_date;
            }
            else {
                $users_packages_data['short_term_available_date'] = '';
            }

            if($subscribe_info->action == 'renew') {
                $record_id = $subscribe_info->record_id;
                $renew_package_info = $this->db
                ->select('start_date, end_date, short_term_available_date')
                ->group_start()
                ->where('package_id', $package_id)
                ->where('user_id', $_SESSION['id'])
                ->group_end()
                ->order_by('id', 'desc')
                ->limit(1)
                ->get('user_packages')
                ->row();

                if(strtotime($renew_package_info->end_date) >= strtotime(date('Y-m-d'))) {
                    $start_date = date_add(date_create($renew_package_info->end_date), new DateInterval('P1D'));
                    $end_date = date_add(date_create($start_date->format('Y-m-d')), new DateInterval('P'.$package->package_details->no_of_days.'D'));  
                }
                else {
                    $datetime = new DateTime(date('Y-m-d'));
                    $start_date = $datetime;
                    $end_date = date_add(date_create($start_date->format('Y-m-d')), new DateInterval('P'.$package->package_details->no_of_days.'D'));
                }

                               
                $users_packages_data['start_date'] = $start_date->format('Y-m-d');
                $users_packages_data['end_date'] = $end_date->format('Y-m-d');
                $users_packages_data['short_term_available_date'] = $renew_package_info->short_term_available_date;
            }

            $subscribe_info = json_decode($this->input->post('subscribe_info'));
            if($subscribe_info->action == 'modify') {
                $prev_total = $this->db->select('price')
                                        ->where('id', $subscribe_info->record_id)
                                        ->get('user_packages')
                                        ->row();

                $subscribe_pref_info = json_decode($this->input->post('subscribe_pref_info'));
                $attribute_id_arr = explode(',' ,$subscribe_pref_info->attribute_id);
                $attribute_value_arr = explode(',' ,$subscribe_pref_info->attribute_value);
                $record_id = $subscribe_info->record_id;
                $user_package_ref_id = $subscribe_info->record_id;
                $subscribe_pref_info = $subscribe_pref_info->pref_arr;

                unset($users_packages_data['start_date']);
                unset($users_packages_data['end_date']);
               
                $this->db->where('id', $user_package_ref_id);
                $this->db->update('user_packages', $users_packages_data);

                $this->db->delete('user_package_area_preferences', ['user_package_ref_id' => $user_package_ref_id]);
                $this->db->delete('user_package_preference_attribute_values', ['user_package_ref_id' => $user_package_ref_id]);
                $area_id_arr = [];
                foreach ($subscribe_pref_info as $row) {
                    $area_id_arr[] = $row->area_id;
                    $subscribe_pref_area_data = [
                        'user_id' => $_SESSION['id'],
                        'user_package_id' => $package_id,
                        'user_package_ref_id' => $user_package_ref_id,
                        'invoice_id' => $invoice->id,
                        'area_ids' => $row->area_id,
                        'types' => $row->types,
                        'price_min' => $row->price_min,
                        'price_max' => $row->price_max,
                    ];
                    $this->db->insert('user_package_area_preferences', $subscribe_pref_area_data);
                    $user_package_pref_id = $this->db->insert_id();

                    foreach($row->attribute as $key=> $value) {
                        $arr = [
                            'user_package_pref_id' => $user_package_pref_id,
                            'user_package_ref_id' => $user_package_ref_id,
                            'area_id' => $row->area_id,
                            'attribute_id' => $value,
                            'value' => $row->value[$key]
                        ];
                        $this->db->insert('user_package_preference_attribute_values', $arr);
                    }
                }
                $this->db
                ->where('id', $user_package_ref_id)
                ->update('user_packages', ['area_ids' => implode(',', $area_id_arr)]);

                $this->db
                        ->where('id', $invoice->id)
                        ->update('invoices', ['user_package_ref_id' => $user_package_ref_id]);

                $this->session->set_flashdata('payment_ref', $invoice->id);
                redirect('invoices/paymentsuccess');

            }
            else if ($this->db->insert('user_packages', $users_packages_data)) {
                $user_package_ref_id = $this->db->insert_id();
                $this->db->where('id', $_SESSION['id'])->update('users', ['subscribe_flag' => 'yes']);
                $this->session->set_userdata(['subscribe_flag' => 'yes']);

                // insert the user package pref
                $subscribe_pref_info = json_decode($_POST['subscribe_pref_info']);
                $subscribe_pref_info = $subscribe_pref_info->pref_arr;
                // $attribute_id_arr = explode(',' ,$subscribe_pref_info->attribute_id);
                // $attribute_value_arr = explode(',' ,$subscribe_pref_info->attribute_value);

                if($subscribe_info->action == 'renew') {
                    $record_id = $subscribe_info->record_id;
                    $subscribe_pref_record = $this->db
                                ->select('id, user_package_ref_id, area_ids, types, price_min, price_max')
                                ->where(['user_package_ref_id' => $record_id, 'user_id' => $_SESSION['id']])
                                ->get('user_package_area_preferences')
                                ->result();                                      
                }

                if($subscribe_info->action == 'renew') {
                    $subscribe_pref_data = [
                        'user_id' => $_SESSION['id'],
                        'user_package_id' => $package_id,
                        'user_package_ref_id' => $user_package_ref_id,
                        'invoice_id' => $invoice->id,
                        'area_ids' => $subscribe_pref_record->area_ids,
                        'types' => $subscribe_pref_record->types,
                        'price_min' => $subscribe_pref_record->price_min,
                        'price_max' => $subscribe_pref_record->price_max,
                    ];
                }

                if($subscribe_info->action == 'new') {
                    $area_id_arr = [];
                    foreach ($subscribe_pref_info as $row) {
                        $area_id_arr[] = $row->area_id;
                        $subscribe_pref_area_data = [
                            'user_id' => $_SESSION['id'],
                            'user_package_id' => $package_id,
                            'user_package_ref_id' => $user_package_ref_id,
                            'invoice_id' => $invoice->id,
                            'area_ids' => $row->area_id,
                            'types' => $row->types,
                            'price_min' => $row->price_min,
                            'price_max' => $row->price_max,
                        ];
                        $this->db->insert('user_package_area_preferences', $subscribe_pref_area_data);
                        $user_package_pref_id = $this->db->insert_id();

                        foreach($row->attribute as $key=> $value) {
                            $arr = [
                                'user_package_pref_id' => $user_package_pref_id,
                                'user_package_ref_id' => $user_package_ref_id,
                                'area_id' => $row->area_id,
                                'attribute_id' => $value,
                                'value' => $row->value[$key]
                            ];
                            $this->db->insert('user_package_preference_attribute_values', $arr);
                        }
                    }
                    $this->db
                    ->where('id', $user_package_ref_id)
                    ->update('user_packages', ['area_ids' => implode(',', $area_id_arr)]);
                }

                if($subscribe_info->action == 'renew') {
                    $area_id_arr = [];
                    foreach ($subscribe_pref_record as $key => $row ) {
                        $area_id_arr[] = $row->area_ids;
                        $subscribe_pref_area_data = [
                            'user_id' => $_SESSION['id'],
                            'user_package_id' => $package_id,
                            'user_package_ref_id' => $user_package_ref_id,
                            'invoice_id' => $invoice->id,
                            'area_ids' => $row->area_ids,
                            'types' => $row->types,
                            'price_min' => $row->price_min,
                            'price_max' => $row->price_max,
                        ];

                        $this->db->insert('user_package_area_preferences', $subscribe_pref_area_data);
                        $user_package_pref_id = $this->db->insert_id();

                        $subscribe_pref_attr_record = $this->db
                                ->select('area_id, attribute_id, value')
                                ->where(['user_package_ref_id' => $row->user_package_ref_id])
                                ->where(['user_package_pref_id' => $row->id])
                                ->get('user_package_preference_attribute_values')
                                ->result();
                    
                        foreach($subscribe_pref_attr_record as $k=> $v) {
                            $arr = [
                                'user_package_pref_id' => $user_package_pref_id,
                                'user_package_ref_id' => $user_package_ref_id,
                                'area_id' => $v->area_id,
                                'attribute_id' => $v->attribute_id,
                                'value' => $v->value
                            ];
                            $this->db->insert('user_package_preference_attribute_values', $arr);
                        }    

                    }

                    $this->db
                    ->where('id', $user_package_ref_id)
                    ->update('user_packages', ['area_ids' => implode(',', $area_id_arr)]);
                }
                
                $this->db
                        ->where('id', $invoice->id)
                        ->update('invoices', ['user_package_ref_id' => $user_package_ref_id]);

                $this->session->set_flashdata('payment_ref', $invoice->id);
                redirect('invoices/paymentsuccess');
            }
        }
        echo "<script>alert('Invalid Invoice');</script>";
        redirect('pricing/custom_pricing');
    }

    public function update_subscribe_flag()
    {
        $this->db->where('id', $_SESSION['id'])->update('users', ['subscribe_flag' => 'no']);
        $this->session->set_userdata(['subscribe_flag' => 'no']);
    }

    public function getSubscribedPackage()
    {
        return $this->db
            ->select('package_id')
            ->where('user_id', $_SESSION['id'])
            ->where('start_date<=', date('Y-m-d'))
            ->where('end_date>=', date('Y-m-d'))
            ->get('user_packages')->result_array();
    }
    public function getSubscribedPackageById($id)
    {
        return $this->db
            ->select('package_id')
            ->where('user_id', $_SESSION['id'])
            ->where('package_id', $id)
            ->where('start_date<=', date('Y-m-d'))
            ->where('end_date>=', date('Y-m-d'))
            ->limit(1)
            ->get('user_packages')->row();
    }

    public function getConfiguredPackage() {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());
        $subscribe_info = json_decode($_POST['subscribe_info'], true);
        extract($subscribe_info);
        $area_price = 0;
        $days_price = 0;
        $package_name = '';
        $no_of_area = '';
        $no_of_days = '';
        // check the package name exists
        $rslt = $this->db->where('id', $package_selected_id)->get('custom_package_names')->result_array();
        if(empty($rslt)) {
            return ['type'=> 'error', 'text' => 'No Package name exists'];
            exit;
        }
        else {
            $package_name .= $rslt[0]['name'];
        }

        $condition = true;
        if(isset($action) && $action == 'renew') {
            return ['type'=> 'success', 'text' => '', 'package_info' => $_POST['subscribe_info'], 'package_details' => ''];
        }
        else if(isset($action) && $action == 'modify') {
            $condition = false;

            if($package_name != '' && $total > 0) {
                $package_details = [
                    'name' => $package_name,
                    'price' => $total,
                    'no_of_area' => $area_select_noof,
                    'no_of_days' => $days_select_noof,
                    'action' => isset($action) ? $action: ''
                ];
            }
    
            return ['type'=> 'success', 'text' => '', 'package_info' => $_POST['subscribe_info'], 'package_details' => $package_details];
            exit();
        }
        
        // have any areas
        if(!empty($area_select_noof) && $condition == true) {
            $rslt = $this->db->where(['custom_package_names_id' => $package_selected_id, 'noof' => $area_select_noof])->get('custom_package_areas')->result_array();
            if(empty($rslt)) {
                return ['type'=> 'error', 'text' => 'No Configure Area Value found for the Selected Package'];
                exit;
            }
            else {
                $area_price = $rslt[0]['price'];
                $no_of_area = $rslt[0]['noof'];
            }
        }
        else {
            return ['type'=> 'error', 'text' => 'No Configure Area Value found for the Selected Package'];
            exit;
        }
        
        // have any days
        if(isset($action) && ($action == 'modify')) {
            $days_price = 0;
            $no_of_days = $days_select_noof;
        }
        else if(!empty($days_select_noof)) {
            $rslt = $this->db->where(['custom_package_names_id' => $package_selected_id, 'noof' => $days_select_noof])->get('custom_package_months')->result_array();
            if(empty($rslt)) {
                return ['type'=> 'error', 'text' => 'No Configure Days Value found for the Selected Package'];
                exit;
            }
            else {
                $days_price = $rslt[0]['price'];                
                $no_of_days = $rslt[0]['noof'];
            }
        }
        else {
            return [ 'type'=> 'error', 'text' => 'No Configure Days Value found for the Selected Package'];
            exit;
        }

        // total is same as submitted total amount
        $tot_price = $area_price + $days_price;
        if(intval($total) != intval($tot_price) && ($action == 'new')) {            
            return ['type'=> 'error', 'text' => 'Total Amount is not same'. $area_price.'/'.$days_price];
            exit;
        }

        $package_details = [];

        if($package_name != '' && $total > 0) {
            $package_details = [
                'name' => $package_name,
                'price' => $total,
                'no_of_area' => $no_of_area,
                'no_of_days' => $no_of_days,
                'action' => isset($action) ? $action: ''
            ];
        }

        return ['type'=> 'success', 'text' => '', 'package_info' => $_POST['subscribe_info'], 'package_details' => $package_details];

        // print_r($subscribe_info);
        // die();
        

    }
    
}
