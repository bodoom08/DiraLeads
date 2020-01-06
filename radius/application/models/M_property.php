<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_property extends CI_Model
{
    public function getdata()
    {
        extract($this->input->get());

        $search = array_map('trim', $search);
        $search['value'] = strtolower($search['value']);

        $this->db->start_cache();

        $query['select'] = ['a.for', 'a.type', 'c.title', 'a.house_number', 'b.name', 'a.available_date', 'a.user_role'];
        $this->db->select('a.*,b.name as user_name,c.title as area, b.id as user_id, b.email as user_email');
        $this->db->where('a.user_id = b.id');
        $this->db->where('a.area_id = c.id');
        if(isset($property_id) && !empty($property_id)) {
            $this->db->where('a.id = '.$property_id);
        }
        $this->db->from('properties a, users b, areas c');

        if(constant('IS_AGENT')) {
            $this->db->where('a.vn_id', null);
        }

        $query['recordsTotal'] = $this->db->count_all_results();

        if (isset($search['value'])) {
            $this->db->group_start();
            foreach ($query['select'] as $s) {
                $this->db->or_like('LOWER(' . $s . ')', $search['value']);
            }
            $this->db->group_end();
        }

        $this->db->stop_cache();

        $this->db->order_by('a.id', 'desc');

        if ($length > 0) {
            $this->db->limit($length, $start);
        }
        $query['data'] = $this->db->get()->result_array();
        $query['draw'] = $draw;
        $query['recordsFiltered'] = $this->db->count_all_results();
        $this->db->flush_cache();
        unset($query['select']);
        return $query;
    }

    public function changeStatus()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());
        if ($property_id) {
            if ($this->db->set('status', 'IF(status = "active" , "inactive" , "active")', FALSE)->where('id', $property_id)->update('properties')) {
                return ['type' => 'success', 'text' => 'Property Status changed successfully!'];
            }
        }
        return ['type' => 'error', 'text' => 'Error Occured! Please checked it manualy!'];
    }
    
    public function resolveDID()
    {
        $id = $this->input->post('id');

        $property = $this->db->where('id', $id)->get('properties')->row();
        $number = $this->db->where('id', $property->vn_id)->get('virtual_numbers')->row();
        
        if ($number) {
            return ['type' => 'info', 'text' => 'Already resolved!!'];
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
        
                    allocate_did($property->id, $this->db->insert_id(), 'Agent Resolve', 'DID allocation resolved by agent '. $_SESSION['name']);
                } else {
                    return ['type' => 'warning', 'text' => 'Sorry!! DID can not be reesolved! Please contact admin'];
                }
            }


            return ['type' => 'success', 'text' => 'DID resolved. Property listing done successfully!'];
        }
        return ['type' => 'error', 'text' => 'Error Occured!'];
    }
    
    function getAllUsers() {
        return $this->db->get('users')->result_array();
    }
    
    function getAllAreas()
    {
        return $this->db->get('areas')->result_array();
    }
    
    function getAllAttributes()
    {
        return $this->db->get('property_attributes')->result_array();
    }
    
    function property_listing()
    {
        array_walk_recursive($_POST, 'trim');
        extract($_POST);
        
        
        $available_date = date('Y-m-d');
        if ($property && $street && $area_id && $property_type && $price && $available_date && $lat_lng) {
            if($property == 'short term rent') {
                $_POST['short_term_available_date'] = '';
            }
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
            
            $property_data = [
                'user_id' => $_POST['user_id'],
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
                'user_role' =>  isset($_SESSION['user_type']) ? ($_SESSION['user_type']) : 'user',
                'contact_type' => $contact_type,
                'day_of_the_weak' => $day_arr,
                'time_of_day' => $time,
                'from_time' => $start_time,
                'to_time' => $end_time            
            ];

            // $user_pref= [
            //     'contact_type' => $contact_type,
            //     'day_of_the_weak' => $day_arr,
            //     'time_of_day' => $time,
            //     'from_time' => $start_time,
            //     'to_time' => $end_time
            // ];

            if ($_FILES) {
                $this->load->library('upload');
                $files = $_FILES;
                $cpt = count($_FILES['userfile']['name']);
                // $path = FCPATH . "/uploads";
                $path = "../tmp_uploads";
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

            
            if ($this->db->insert('properties', $property_data)) {

                $property_id = $this->db->insert_id();

                // $this->db->where('id', $_POST['user_id']);
                // $this->db->update('users', $user_pref);

                
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
                    if ($_FILES) {
                        $this->load->library('upload');
                        // $files = $_FILES;
                        $cpt = count($files['userfile']['name']);
                        // $path = FCPATH . "/uploads";
                        $path = "../uploads";
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
                        if(!$this->db->insert_batch('property_images', $image_data)) {
                            return ['type' => 'error', 'text' => 'Image upload is not done successfully!'];
                        }
                    }

                        // $virtualNumber = $this->db
                        // ->where_not_in('id', "SELECT vn_id FROM properties")
                        // ->get('virtual_numbers')
                        // ->row();
                        
                        // $virtualNumber = false;

                        $result = $this->db->select('vn_id')->where('vn_id is Not NULL')->get('properties')->result_array();
                        $vn_id_arr = array_column($result, 'vn_id');

                        $virtualNumber = $this->db->select('id')
                            ->where_not_in('id', $vn_id_arr)
                            ->get('virtual_numbers')
                            ->row();
                            
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

    public function edit()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());

        $data['property_details'] = $this->db
            ->select('a.*, b.mobile, b.email')
            ->where('a.id', $property_id)
            ->where('a.user_id = b.id')
            ->get('properties a,users b')->row_array();
        $data['property_attributes'] = $this->db
            ->select('a.text,a.icon,b.property_id,b.attribute_id,b.value')
            ->where('a.id = b.attribute_id')
            ->where('b.property_id', $property_id)
            ->get('property_attribute_values b,property_attributes a')->result_array();
        $data['property_images'] = $this->db
            ->where('property_id', $property_id)
            ->get('property_images')->result_array();
        $data['property_user_details'] = $this->db
            ->where('id', $data['property_details']['user_id'])
            ->select('name, email, contact_type, day_of_the_weak, time_of_day, from_time, to_time')
            ->get('users')->row_array();
        return $data;
    }

    function update()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());

        $available_date = date('Y-m-d');
        if ($property && $street && $area_id && $property_type && $price && $available_date) {
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

            
            if ($_FILES) {
                $this->load->library('upload');
                $files = $_FILES;
                $cpt = count($_FILES['userfile']['name']);
                // $path = FCPATH . "/uploads";
                $path = "../tmp_uploads";
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
                'created_by' => $_SESSION['id'],
                'user_role' =>  isset($_SESSION['user_type']) ? ($_SESSION['user_type']) : 'user',
                'contact_type' => $contact_type,
                'day_of_the_weak' => $day_arr,
                'time_of_day' => $time,
                'from_time' => $start_time,
                'to_time' => $end_time
            ];

            // $this->db->where('id', $property_id);
            // $property_info = $this->db->get('properties')->result_array();

            // $user_pref= [
            //     'contact_type' => $contact_type,
            //     'day_of_the_weak' => $day_arr,
            //     'time_of_day' => $time,
            //     'from_time' => $start_time,
            //     'to_time' => $end_time
            // ];
            // $this->db->where('id', $property_info[0]['user_id']);
            // $this->db->update('users', $user_pref);

            if ($this->db->where('id', $property_id)->update('properties', $property_data)) {
                foreach ($attribute_id as $key => $attribute) {
                    $i = array_search($attribute, $attribute_id);
                    if (!$value[$i]) {
                        return ['type' => 'error', 'text' => 'You did not submit any blank value attribute!'];
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
                        // $path = FCPATH . "/uploads";
                        $path = "../uploads";
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

    function getMainAreas()
    {
        return $this->db->where('area is NULL')->get('areas')->result_array();
    }

    function getSubAreas()
    {
        return $this->db->where('area IS NOT NULL')->get('areas')->result_array();
    }


}
