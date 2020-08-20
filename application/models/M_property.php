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

        // echo json_encode($_POST);
        // exit;

        extract($_POST);
        $available_date = $date;

        // if ($street && $area_id && $property_type && $price && $available_date && $property_desc) {
        if (empty($attribute_id) || empty($value)) {
            return ['type' => 'error', 'text' => 'Atleast one property attribute is mandatory!'];
        }

        if (strlen($property_desc) < 60) {
            return ['type' => 'error', 'text' => 'Description should have a minimum of 60 letters'];
        }

        // Check the property Image before upload
        if (!empty($_FILES)) {
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
        if ($amenities) {
            $amenitie = implode(',', $amenities);
        } else {
            $amenitie = "";
        }
        $property_data = [
            'user_id' => $_SESSION['id'],
            'for' => 'short term rent',
            // 'house_number' => $house_no,
            'amenities' => $amenitie,
            'street' => $street,
            'area_id' => $area_id,
            'type' => $property_type,
            'price' => $price,
            'date_price' => $date_price,
            'available_date' => date('Y-m-d', strtotime($available_date)),
            'description' => $property_desc,
            // 'coords' => json_encode(explode('|', $lat_lng)),
            'coords'    => '[""]',
            'created_by' => $_SESSION['id'],
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->db->insert('properties', $property_data)) {
            $property_id = $this->db->insert_id();
            foreach ($attribute_id as $key => $attribute) {
                $i = array_search($attribute, $attribute_id);
                if (!$value[$i]) {
                    return ['type' => 'error', 'text' => 'You did not submit any value for property attribute!'];
                }
                $attribute_data[] = [
                    'property_id' => $property_id,
                    'attribute_id' => $attribute,
                    'value' => $value[$i],
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }

            /*store seasonal price*/

            // if (empty($date_price)) { 

            //     $sessional = explode('&', $rule_data);
            //     foreach ($sessional as $key => $valu) {
            //         $signle = explode('|', $valu);
            //         $session_data[] = [
            //             'name' => $signle[0],
            //             'start_date' => $signle[1],
            //             'end_date' => $signle[2],
            //             'days' => $signle[3],
            //             'price' => $signle[4],
            //             'property_id' => $property_id
            //         ];
            //     }
            //     $this->db->insert_batch('properties_sessional', $session_data);
            // }


            if ($this->db->insert_batch('property_attribute_values', $attribute_data)) {

                if (!empty($_FILES)) {
                    $this->load->library('upload');
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

                // Just for Testing
                
                // return [
                //     'type' => 'success',
                //     'text' => 'Property listing done successfully!',
                //     'virtual_number' => "+1 123123123"
                // ];

                $virtualNumber = $this->db->select('id')
                    ->where_not_in('id', $vn_id_arr)
                    ->get('virtual_numbers')
                    ->row();

                $virtualNumber = false;
                $this->load->helper('telnyx_number');
                if ($virtualNumber) { // Check if there is non-allocated Telnyx number in the table
                    $this->load->helper('did');
                    allocate_did($property_id, $virtualNumber->id, 'Auto Re-assign', 'DID re-allocation');
                    $response['virutal_number'] = $virtualNumber;
                } else { // Buy a new Telnyx number
                    // $this->load->library('telnyx');

                    $numberResult = searchNumbersHelper('us', 'NY');

                    if (count($numberResult['result']) > 0) {
                        $number_e164 = $numberResult['result'][0]['number_e164'];

                        $numberOrders = createNumberOrdersHelper($number_e164);

                        if (is_array($numberOrders)) {
                            $this->db->insert('virtual_numbers', [
                                'number' => $number_e164,
                                'details' => json_encode(myNumbersHelper($number_e164))
                            ]);

                            $this->load->helper('did');

                            allocate_did($property_id, $this->db->insert_id(), 'Auto Assign', 'Auto DID allocation');
                            $response['virtual_number'] = $number_e164;
                        } else {
                            return ['type' => 'warning', 'text' => 'Property submitted but can not be listed for number allocation error! Please contact admin'];
                        }
                    }
                }

                return [
                    'type' => 'success',
                    'text' => 'Property listing done successfully!',
                    'virtual_number' => $response['virtual_number']
                ];
            }
        }
        return ['type' => 'error', 'text' => 'Error Occured! Please checked it manualy!'];
        // }
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


        $available_date = $date;
        $property = 'short term rent';
        if ($property  && $street && $area_id && $property_type && $price && $available_date && $property_desc) {
            if (empty($attribute_id) || empty($value)) {
                return ['type' => 'error', 'text' => 'Atleast one property attribute is mandatory!'];
            }
            if (strlen($property_desc) < 60) {
                return ['type' => 'error', 'text' => 'Description should have a minimum of 60 letters'];
            }
            // check for available date if property type is short term rent
            if (($property == 'short term rent') && empty($short_term_available_date)) {
                return ['type' => 'error', 'text' => 'Please selct at least one available date for short term rent!'];
            } else if ($property != 'short term rent') {
                $short_term_available_date = '';
            }

            if (($property == 'short term rent') && !empty($short_term_available_date)) {
                $arr = explode(',', $short_term_available_date);
                $trimmed_array = array_map('trim', $arr);
                $short_term_available_date = implode(',', $trimmed_array);
            }

            // remove the existing files
            $removeFileNameArr = json_decode($removeFileName, true);
            for ($i = 0; $i < sizeof($removeFileNameArr); $i++) {
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
            if ($amenities) {
                $amenitie = implode(',', $amenities);
            } else {
                $amenitie = "";
            }
            $property_data = [
                'for' => $property,
                // 'house_number' => $house_no,
                'street' => $street,
                'area_id' => $area_id,
                'type' => $property_type,
                'price' => $price,
                'available_date' => date('Y-m-d', strtotime($available_date)),
                'description' => $property_desc,
                'amenities' => $amenitie,
                'updated_at' => date('Y-m-d H:i:s'),
                // 'contact_type' => $contact_type,
                // 'day_of_the_weak' => $day_arr,
                // 'time_of_day' => $time,
                // 'from_time' => $start_time,
                // 'to_time' => $end_time,                
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
