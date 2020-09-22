<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_users extends CI_Model
{
    public function getUser($email)
    {
        return $this->db
            ->select('a.id, a.name, a.email, a.mobile, a.status, a.created_at, GROUP_CONCAT(b.package_name) packages')
            ->where('a.email', $email)
            ->join('user_packages b', 'b.user_id = a.id and now() between b.start_date and b.end_date', 'left')
            ->get('users a')
            ->row();
    }

    function property_add()
    {
        array_walk_recursive($_POST, 'trim');
        extract($_POST);
        if ($property && $house_no && $street && $area_id && $property_type && $price && $available_date && $lat_lng) {
            if (empty($attribute_id) || empty($value)) {
                return ['type' => 'error', 'text' => 'Atleast one property attribute is mandatory!'];
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
                'created_at' => date('Y-m-d H:i:s')
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
                    $this->load->library('upload');
                    $files = $_FILES;
                    $cpt = count($_FILES['userfile']['name']);
                    $path = FCPATH . "../uploads";
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

                                allocate_did($property_id, $this->db->insert_id(), 'Agent Resolve', 'DID allocation resolved by agent ' . $_SESSION['name']);
                            } else {
                                return ['type' => 'warning', 'text' => 'Property submitted but can not be listed for number allocation error! Please contact admin'];
                            }
                        }

                        return ['type' => 'success', 'text' => 'Property listing done successfully!'];
                    }
                    return ['type' => 'error', 'text' => 'Image upload is not done successfully!'];
                }
            }
            return ['type' => 'error', 'text' => 'Error Occured! Please checked it manualy!'];
        }
        return ['type' => 'error', 'text' => 'Please filled out all mandatory field!'];
    }

    function getAllAreas()
    {
        return $this->db->get('areas')->result_array();
    }

    function getAllAttributes()
    {
        return $this->db->get('property_attributes')->result_array();
    }

    public function getUserProperties($email)
    {
        $images = $this->db
            ->select('property_id, path')
            ->group_by('property_id')
            ->get('property_images')
            ->result_array();
        $this->db->select('a.*, b.number, (select path from property_images where property_id = a.id limit 1) AS image');
        $this->db->from('properties a');
        $this->db->join('virtual_numbers b', 'b.id = a.vn_id', 'left');
        $this->db->join('users c', 'c.id = a.user_id');
        $this->db->where('c.email', $email);

        $properties = $this->db->get()->result_array();

        return $properties;
    }

    public function getdata()
    {
        extract($this->input->get());

        $search = array_map('trim', $search);
        $search['value'] = strtolower($search['value']);

        $this->db->start_cache();

        $query['select'] = ['a.name', 'a.email', 'a.mobile', 'a.status', 'a.id'];
        $having = ['packages'];
        $this->db->select('GROUP_CONCAT(DISTINCT b.for) packages, 0 entries, COUNT(distinct c.id) posts, a.name, a.email, a.mobile, a.status, a.id, a.password');
        $this->db->from('users a');
        $this->db->join('user_packages b', 'b.user_id = a.id', 'left');
        $this->db->join('properties c', 'c.user_id = a.id', 'left');
        $this->db->group_by('a.id');

        $query['recordsTotal'] = $this->db->query('SELECT count(*) as total FROM (' . $this->db->get_compiled_select() . ') as tbl')->row()->total;

        if ($search['value']) {
            $this->db->group_start();
            foreach ($query['select'] as $s) {
                $this->db->or_like('LOWER(' . $s . ')', $search['value']);
            }
            $this->db->group_end();
        }

        $this->db->stop_cache();

        $this->db->order_by('id', 'desc');

        if ($length > 0) {
            $this->db->limit($length, $start);
        }
        $query['data'] = $this->db->get()->result_array();
        $query['draw'] = $draw;
        $query['recordsFiltered'] = $this->db->query('SELECT count(*) as total FROM (' . $this->db->get_compiled_select() . ') as tbl')->row()->total;
        $this->db->flush_cache();
        unset($query['select']);
        return $query;
    }

    public function save()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());

        $email = isset($email) ? $email : '';

        if ($this->db->where('email', $email)->or_where('mobile', $mobile)->count_all_results('agents') > 0) {
            return ['type' => 'warning', 'text' => 'Email or mobile no already exist!'];
        }

        if ($name && $email && $mobile) {
            $token = bin2hex(random_bytes(16));

            $this->db->insert('agents', [
                'name' => $name,
                'email' => $email,
                'mobile' => $mobile,
                'created_by' => $_SESSION['id'],
                'token' => $token
            ]);

            $token = urlencode(base64_encode('agent:' . $token));

            $this->load->helper('email');

            send_email(
                $email,
                'Diraleads Agent Verification',
                $this->load->view(
                    'emails/agent_verification',
                    ['href' => site_url('verify/email/' . $token)],
                    true
                )
            );

            return ['type' => 'success', 'text' => 'Email sent for verification!'];
        }
        return ['type' => 'error', 'text' => 'Please Filled Out all mandatory fields!'];
    }


    public function save_user()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());

        $email = isset($email) ? $email : '';

        if (($email && $this->db->where('email', $email)->count_all_results('agents') > 0) || (!$email && $this->db->where('email', $email)->or_where('mobile', $mobile)->count_all_results('agents') > 0)) {
            return ['type' => 'warning', 'text' => 'Email or mobile no already exist!'];
        }
        if (empty($mobile) || empty($name) || empty($country)) {
            return ['type' => 'warning', 'text' => 'All fields are mandatory.'];
        }
        // if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //     return ['type' => 'warning', 'text' => 'Invalid Email ID!'];
        // }
        if (!preg_match('/^[0-9]+$/', $mobile)) {
            return ['type' => 'warning', 'text' => 'Invalid Mobile Number!'];
        } else if (strlen($mobile) < 10) {
            return ['type' => 'warning', 'text' => 'Mobile number should be 10 digits minimum!'];
        }

        if ($name && $mobile && $country) {
            $token = bin2hex(random_bytes(16));

            $this->db->insert('users', [
                'name' => $name,
                'email' => $email,
                'country_code' => $country,
                'mobile' => $mobile,
                'created_by' => $_SESSION['id'],
                'token' => $token
            ]);

            $token = urlencode(base64_encode('users:' . $token));

            $this->load->helper('email');

            // send_email(
            //            $email,
            //            'Diraleads User Verification',
            //            $this->load->view(
            //                              'emails/user_verification',
            //                              ['href' => site_url('verify/email/' . $token)],
            //                              true
            //                              )
            //            );
            user_reg_email($email, 'Diraleads User Verification', 'https://diraleads.com/verify/email/' . $token);

            return ['type' => 'success', 'text' => 'Email sent for verification!'];
        }
        return ['type' => 'error', 'text' => 'Please Filled Out all mandatory fields!'];
    }


    public function changeStatus()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());
        if (isset($id)) {
            if ($this->db->set('status', 'IF(status = "active" , "inactive" , "active")', FALSE)->where('id', $id)->update('users')) {
                return ['type' => 'success', 'text' => 'User status changed successfully!'];
            }
        }
        return ['type' => 'error', 'text' => 'Error Occured!'];
    }

    public function edit()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());
        if ($id) {
            return $this->db
                ->select('name, email, country_code, mobile')
                ->where('id', $id)
                ->get('users')
                ->row_array();
        } else {
            return [];
        }
    }

    public function update()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());

        $email = isset($email) ? $email : '';
        if ($id && $name && $mobile && $country_ed) {
            if (($_SESSION['user_type'] == 'admin') || ($_SESSION['user_type'] == 'agent')) {
                // Check the duplicate entry for the email
                $unique_email = $this->db
                    ->where('email', $email)
                    ->where('id !=', $id)
                    ->count_all_results('users');
                if ($unique_email > 0) {
                    return ['type' => 'error', 'text' => 'Email id already taken'];
                }
                $this->db->where('id', $id)->update('users', [
                    'name' => $name,
                    'email' => $email,
                    'mobile' => $mobile,
                    'country_code' => $country_ed,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                $this->db->where('id', $id)->update('users', [
                    'name' => $name,
                    // 'email' => $email,
                    // 'mobile' => $mobile,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            return ['type' => 'success', 'text' => 'User info successfully updated!'];
        }
        return ['type' => 'error', 'text' => 'Please Filled Out all mandatory field!'];
    }

    public function verifyUser()
    {
        extract($_POST);
        if ($userid && $password && $cnf_password) {
            if ($password !== $cnf_password) {
                die(json_encode(['type' => 'error', 'text' => 'Password Mismatched!']));
            }
            $this->db->set('password', sha1($password));
            $this->db->where('id', $userid);
            $this->db->update('users');
            die(json_encode(['type' => 'success', 'text' => 'User Verified!']));
        } else {
            die(json_encode(['type' => 'error', 'text' => 'All fileds are mandatory!']));
        }
    }

    public function resendVerifyEmail()
    {
        extract($_POST);
        $token = bin2hex(random_bytes(16));

        $this->db->where('id', $users_id);
        $this->db->update('users', [
            'token' => $token
        ]);

        // Get the user details
        $user_info = $this->db
            ->where('id', $users_id)
            ->get('users')
            ->row();
        $token = urlencode(base64_encode('users:' . $token));
        $this->load->helper('email');

        // send_email(
        //            $email,
        //            'Diraleads User Verification',
        //            $this->load->view(
        //                              'emails/user_verification',
        //                              ['href' => site_url('verify/email/' . $token)],
        //                              true
        //                              )
        //            );
        user_reg_email($user_info->email, 'Diraleads User Verification', 'https://diraleads.com/verify/email/' . $token);

        return ['type' => 'success', 'text' => 'Email sent for verification!'];
    }

    // public function del()
    // {
    //     array_walk_recursive($_POST, 'trim');
    //     extract($this->input->post());
    //     if ($package_id) {
    //         if ($this->db->where('id', $package_id)->delete('packages')) {
    //             return ['type' => 'success', 'text' => 'Package Deleted successfully!'];
    //         }
    //     }
    //     return ['type' => 'error', 'text' => 'Error Occured! Please checked it manualy!'];
    // }

    public function getAllUserIds()
    {
        return $this->db->select('id, name, email')->get('users')->result_array();
    }

    public function addSubscriber()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());

        if ($subscriber && $area && $date_from && $date_to && $bedroom) {
            // [0] => users.id , [1] => users.email
            $subscriber = explode("|", $subscriber);
            
            $this->db->insert('subscribers', [
                "user_id"   => $subscriber[0],
                "email_id"  => $subscriber[1],
                "area_id"   => $area,
                "date_from" => $date_from,
                "date_to"   => $date_to,
                "bedroom"   => $bedroom,
            ]);

            return [
                'type' => 'success',
                'text' => 'Successfully Added.'
            ];
        }
        return [
            'type'  => 'error',
            'text'  => 'Field is missing'
        ];
    }

    public function getAllSubScribers()
    {
        extract($this->input->get());

        $search = array_map('trim', $search);
        $search['value'] = strtolower($search['value']);

        $this->db->start_cache();

        $query['select'] = ['a.*', 'b.title'];
        $having = ['packages'];
        $this->db->select('a.*, b.title');
        $this->db->from('subscribers a');
        $this->db->join('areas b', 'b.id = a.area_id', 'left');
        $this->db->group_by('a.id');

        $query['recordsTotal'] = $this->db->query('SELECT count(*) as total FROM (' . $this->db->get_compiled_select() . ') as tbl')->row()->total;

        if ($search['value']) {
            $this->db->group_start();
            foreach ($query['select'] as $s) {
                $this->db->or_like('LOWER(' . $s . ')', $search['value']);
            }
            $this->db->group_end();
        }

        $this->db->stop_cache();

        $this->db->order_by('id', 'desc');

        if ($length > 0) {
            $this->db->limit($length, $start);
        }
        $query['data'] = $this->db->get()->result_array();
        $query['draw'] = $draw;
        $query['recordsFiltered'] = $this->db->query('SELECT count(*) as total FROM (' . $this->db->get_compiled_select() . ') as tbl')->row()->total;
        $this->db->flush_cache();
        unset($query['select']);
        return $query;
    }
}
