<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_property extends CI_Model
{
    function getAllAreas()
    {
        return $this->db->get('areas')->result_array();
    }

    function getAllAttributes()
    {
        return $this->db->get('property_attributes')->result_array();
    }

    function getCustomPackageNames()
    {
        return $this->db
                    ->select('id, name')
                    ->where('status =', 'active')
                    ->get('custom_package_names')
                    ->result();
    }


    function property_listing()
    {
        array_walk_recursive($_POST, 'trim');
        extract($_POST);
        // $lat_lng = "31.7927312|35.212823"; // hardcode for test
        // print_r($_POST);
        // die();
        $available_date = date('Y-m-d');
        if(empty($lat_lng)) {
            return ['type' => 'error', 'text' => 'Please select area on Map or Search for Area'];
        }
        if ($property && $street && $area_id && $property_type && $price && $available_date && $lat_lng) {
            if (empty($attribute_id) || empty($value)) {
                return ['type' => 'error', 'text' => 'Atleast one property attribute is mandatory!'];
            }
            // else if(empty($_FILES)) {
            //     return ['type' => 'error', 'text' => 'Please Upload photo!'];
            // }            
            
            if(empty($phone) || empty($email))
                return ['type' => 'error', 'text' => 'Phone and Email both are required!'];
            
            $contact_type = implode(',', ['phone', 'email']);
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

            // check for available date if property type is short term rent
            if(($property == 'short term rent') && empty($short_term_available_date)) {
                return ['type' => 'error', 'text' => 'Please select at least one available date for short term rent!'];
            }
            else if($property != 'short term rent'){
                $short_term_available_date = '';
            }

            

            // Check the property Image before upload
            if(!empty($_FILES)) {
                $this->load->library('upload');
                $files = $_FILES;
                $cpt = count($_FILES['userfile']['name']);
                $path = FCPATH . "/tmp_uploads";
                $config = array();
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = '0';
                $config['overwrite'] = false;
                for ($i = 0; $i < $cpt; $i++) {
                    $_FILES['userfile']['name'] = $files['userfile']['name'][$i];
                    $_FILES['userfile']['type'] = $files['userfile']['type'][$i];
                    $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
                    $_FILES['userfile']['error'] = $files['userfile']['error'][$i];
                    $_FILES['userfile']['size'] = $files['userfile']['size'][$i];

                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload()) {
                        $errors = $this->upload->display_errors();
                        return ['type' => 'error', 'text' => $errors];
                    }
                }    
            }            
            
            $property_data = [
                'user_id' => $_SESSION['id'],
                'for' => $property,
                'house_number' => $house_no,
                'street' => $street,
                'area_id' => $area_id,
                'type' => $property_type,
                'price' => $price,
                'available_date' => date('Y-m-d', strtotime($available_date)),
                'description' => $property_desc,
                'coords' => json_encode(explode('|', $lat_lng)),
                'created_by' => $_SESSION['id'],
                'created_at' => date('Y-m-d H:i:s'),
                'contact_type' => $contact_type,
                'day_of_the_weak' => $day_arr,
                'time_of_day' => $time,
                'from_time' => $start_time,
                'to_time' => $end_time,
                'short_term_available_date' => $short_term_available_date
            ];            

            if ($this->db->insert('properties', $property_data)) {
                $property_id = $this->db->insert_id();
                foreach ($attribute_id as $key => $attribute) {
                    $i = array_search($attribute, $attribute_id);
                    $attribute_data[] = [
                        'property_id' => $property_id,
                        'attribute_id' => $attribute,
                        'value' => $value[$i],
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }
                if ($this->db->insert_batch('property_attribute_values', $attribute_data)) {
                    
                    if(!empty($_FILES)) {
                        $this->load->library('upload');
                        // $files = $_FILES;
                        // print_r($files);
                        // die;
                        $cpt = count($files['userfile']['name']);
                        $path = FCPATH . "/uploads";
                        $config = array();
                        $config['upload_path'] = $path;
                        $config['allowed_types'] = 'jpg|jpeg|png';
                        $config['max_size'] = '0';
                        $config['overwrite'] = false;
                        for ($i = 0; $i < $cpt; $i++) {
                            $_FILES['userfile']['name'] = $files['userfile']['name'][$i];
                            $_FILES['userfile']['type'] = $files['userfile']['type'][$i];
                            $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
                            $_FILES['userfile']['error'] = $files['userfile']['error'][$i];
                            $_FILES['userfile']['size'] = $files['userfile']['size'][$i];
    
                            $this->upload->initialize($config);
    
                            if (!$this->upload->do_upload()) {
                                $errors = $this->upload->display_errors();
                                return ['type' => 'error', 'text' => $errors];
                            } else {
                                $dataupload = array('upload_data' => $this->upload->data());
                                $image_data[] = array(
                                    'property_id' => $property_id,
                                    'path' => $dataupload['upload_data']['file_name'],
                                    'created_at' => date('Y-m-d H:i:s')
                                );
                            }
                        }
                        if (!$this->db->insert_batch('property_images', $image_data)) {
                            return ['type' => 'error', 'text' => 'Image upload is not done successfully!'];
                        }
                        
                    }
                    $result = $this->db->select('vn_id')->where('vn_id is Not NULL')->get('properties')->result_array();
                    $vn_id_arr = array_column($result, 'vn_id');

                    $virtualNumber = $this->db->select('id')
                        ->where_not_in('id', $vn_id_arr)
                        ->get('virtual_numbers')
                        ->row();
                    
                    // $virtualNumber = false;
                    if($virtualNumber) {
                        $this->load->helper('did');
                        allocate_did($property_id, $virtualNumber->id, 'Auto Re-assign', 'DID re-allocation');
                    } else {
                        $this->load->library('telnyx');

                        $numberResult = $this->telnyx->searchNumbers(["country_iso" => 'us', 'state' => 'NY'], 1);

                        if (count($numberResult['result']) > 0) {
                            $number_e164 = $numberResult['result'][0]['number_e164'];

                            $numberOrders = $this->telnyx->createNumberOrders($number_e164);

                            if (is_array($numberOrders)) {
                                $this->db->insert('virtual_numbers', [
                                    'number' => $number_e164,
                                    'details' => json_encode($this->telnyx->myNumbers($number_e164))
                                ]);

                                $this->load->helper('did');
                        
                                allocate_did($property_id, $this->db->insert_id(), 'Auto Assign', 'Auto DID allocation');
                            } else {
                                return ['type' => 'warning', 'text' => 'Property submitted but can not be listed for number allocation error! Please contact admin'];
                            }
                        }
                    }

                    return ['type' => 'success', 'text' => 'Property listing done successfully!'];
                        
                    
                }
            }
            return ['type' => 'error', 'text' => 'Error Occured! Please checked it manualy!'];
        }
        return ['type' => 'error', 'text' => 'Please filled out all mandatory field!'];
    }

    public function getUserProperties()
    {
        $page = $this->input->get('page');
        $page = $page > 0 ? $page - 1 : 0;

        $this->db->start_cache();
        $this->db->select('a.*, b.number');
        $this->db->where('a.user_id', $_SESSION['id']);
        $this->db->from('properties a');
        $this->db->join('virtual_numbers b', 'b.id = a.vn_id', 'left');
        $this->db->stop_cache();
        $this->db->limit(10, $page * 10);

        $properties = $this->db->get()->result_array();
        $all_properties_count = $this->db->count_all_results();
        $this->db->flush_cache();

        if (count($properties) == 0) {
            return [];
        }
        $attributes =  $this->db
            ->select('a.text,a.icon,b.property_id,b.attribute_id,b.value ')
            ->where('a.id = b.attribute_id')
            ->where_in('b.property_id', array_column($properties, 'id'))
            ->get('property_attribute_values b,property_attributes a')
            ->result_array();
        $images = $this->db
            ->select('property_id, path')
            ->group_by('property_id')
            ->get('property_images')
            ->result_array();
        $images = array_column($images, 'path', 'property_id');
        array_walk($properties, function (&$property) use ($attributes, $images) {
            $property['images'] = (!empty($images[$property['id']])) ? $images[$property['id']] : '';
            $keys = array_keys(array_column($attributes, 'property_id'), $property['id']);
            $property['attributes'] = array_map(function ($key) use ($attributes) {
                return $attributes[$key];
            }, $keys);
        });
        return compact('properties', 'all_properties_count');
    }

    public function edit()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());

        $data['property_details'] = $this->db
            ->select('a.*, b.mobile, b.email')
            ->where('a.id', $user_property_id)
            ->where('a.user_id = b.id')
            ->get('properties a,users b')->row_array();
        $data['property_attributes'] = $this->db
            ->select('a.text,a.icon,b.property_id,b.attribute_id,b.value')
            ->where('a.id = b.attribute_id')
            ->where('b.property_id', $user_property_id)
            ->get('property_attribute_values b,property_attributes a')->result_array();
        $data['property_images'] = $this->db
            ->where('property_id', $user_property_id)
            ->get('property_images')->result_array();
        return $data;
    }

    function update()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());


        $available_date = date('Y-m-d');
        if ($property  && $street && $area_id && $property_type && $price && $available_date) {
            if (empty($attribute_id) || empty($value)) {
                return ['type' => 'error', 'text' => 'Atleast one property attribute is mandatory!'];
            }
            
            if(empty($phone) || empty($email))
                return ['type' => 'error', 'text' => 'Phone and Email both are required!'];
            
            $contact_type = implode(',', ['phone', 'email']);
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
            else if($time != 'custom')
                $end_time = $start_time = '';

            // check for available date if property type is short term rent
            if(($property == 'short term rent') && empty($short_term_available_date)) {
                return ['type' => 'error', 'text' => 'Please selct at least one available date for short term rent!'];
            }
            else if($property != 'short term rent'){
                $short_term_available_date = '';
            }

            // remove the existing files
            $removeFileNameArr = json_decode($removeFileName, true);
            for ($i=0; $i < sizeof($removeFileNameArr); $i++) { 
                $delete_where = [
                    'property_id' => $property_id,
                    'path' => $removeFileNameArr[$i]
                ];
                $this->db->delete('property_images', $delete_where);
            }


            if ($_FILES) {
                $this->load->library('upload');
                $files = $_FILES;
                $cpt = count($_FILES['userfile']['name']);
                $path = FCPATH . "/tmp_uploads";
                $config = array();
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = '0';
                $config['overwrite'] = false;
                for ($i = 0; $i < $cpt; $i++) {
                    $_FILES['userfile']['name'] = $files['userfile']['name'][$i];
                    $_FILES['userfile']['type'] = $files['userfile']['type'][$i];
                    $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
                    $_FILES['userfile']['error'] = $files['userfile']['error'][$i];
                    $_FILES['userfile']['size'] = $files['userfile']['size'][$i];

                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload()) {
                        $errors = $this->upload->display_errors();
                        return ['type' => 'error', 'text' => $errors];
                    }
                }
            }
            
            
            $property_data = [
                'for' => $property,
                'house_number' => $house_no,
                'street' => $street,
                'area_id' => $area_id,
                'type' => $property_type,
                'price' => $price,
                'available_date' => date('Y-m-d', strtotime($available_date)),
                'description' => $property_desc,
                'updated_at' => date('Y-m-d H:i:s'),
                'contact_type' => $contact_type,
                'day_of_the_weak' => $day_arr,
                'time_of_day' => $time,
                'from_time' => $start_time,
                'to_time' => $end_time,                
                'short_term_available_date' => $short_term_available_date
            ];
            if ($this->db->where('id', $property_id)->update('properties', $property_data)) {
                foreach ($attribute_id as $key => $attribute) {
                    $i = array_search($attribute, $attribute_id);
                    if (!$value[$i]) {
                        return ['type' => 'error', 'text' => 'You did not submit any value for property attribute!'];
                    }
                    $attribute_data[] = [
                        'property_id' => $property_id,
                        'attribute_id' => $attribute,
                        'value' => $value[$i],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }
                $this->db->where('property_id', $property_id)->delete('property_attribute_values');
                if ($this->db->insert_batch('property_attribute_values', $attribute_data)) {
                    if ($_FILES) {
                        $this->load->library('upload');
                        // $files = $_FILES;
                        $cpt = count($files['userfile']['name']);
                        $path = FCPATH . "/uploads";
                        $config = array();
                        $config['upload_path'] = $path;
                        $config['allowed_types'] = 'jpg|jpeg|png';
                        $config['max_size'] = '0';
                        $config['overwrite'] = false;
                        for ($i = 0; $i < $cpt; $i++) {
                            $_FILES['userfile']['name'] = $files['userfile']['name'][$i];
                            $_FILES['userfile']['type'] = $files['userfile']['type'][$i];
                            $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
                            $_FILES['userfile']['error'] = $files['userfile']['error'][$i];
                            $_FILES['userfile']['size'] = $files['userfile']['size'][$i];

                            $this->upload->initialize($config);

                            if (!$this->upload->do_upload()) {
                                $errors = $this->upload->display_errors();
                                return ['type' => 'error', 'text' => $errors];
                            } else {
                                $dataupload = array('upload_data' => $this->upload->data());
                                $image_data[] = array(
                                    'property_id' => $property_id,
                                    'path' => $dataupload['upload_data']['file_name'],
                                    'created_at' => date('Y-m-d H:i:s')
                                );
                            }
                        }
                        if ($this->db->insert_batch('property_images', $image_data)) {
                            return ['type' => 'success', 'text' => 'Property Updated successfully!'];
                        }
                        return ['type' => 'error', 'text' => 'Image upload is not done successfully!'];
                    } else {
                        return ['type' => 'success', 'text' => 'Property Updated successfully!'];
                    }
                }
            }
            return ['type' => 'error', 'text' => 'Error Occured! Please checked it manualy!'];
        }
        return ['type' => 'error', 'text' => 'Please filled out all mandatory field!'];
    }

    public function change_status()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());
        if ($this->db->set('status', 'IF(status = "active" , "inactive" , "active")', FALSE)->where('id', $property_id)->update('properties')) {
            return ['type' => 'success', 'text' => 'Property Status changed successfully!'];
        }
        return ['type' => 'error', 'text' => 'Error Occured! Please checked it manualy!'];
    }

    public function delete()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());
        if ($property_id) {
            $this->db->where('id', $property_id)->delete('properties');
            $this->db->where('property_id', $property_id)->delete('property_attribute_values');
            $this->db->where('property_id', $property_id)->delete('property_images');
            return ['type' => 'success', 'text' => 'Your Property Deleted successfully!'];
        }
        return ['type' => 'error', 'text' => 'Error Occured! Please checked it manualy!'];
    }

    public function mark_sold()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());
        if ($property_id) {
            $this->db->where('id', $property_id)->update('properties', ['vn_id' => NULL, 'flag' => 'true', 'sold' => 'true']);
            return ['type' => 'success', 'text' => 'Your Property Marked Sold successfully!'];
        }
        return ['type' => 'error', 'text' => 'Error Occured! Please checked it manualy!'];
    }
}
