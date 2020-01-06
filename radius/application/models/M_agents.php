<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_agents extends CI_Model
{
    public function getdata()
    {
        extract($this->input->get());

        $search = array_map('trim', $search);
        $search['value'] = strtolower($search['value']);

        $this->db->start_cache();

        $query['select'] = ['0', '0', '0', 'name', 'email', 'mobile', 'status', 'id'];
        $this->db->select('0 approval, 0 entries, 0 resolved, name, email, mobile, status, id, password');
        $this->db->from('agents');

        $query['recordsTotal'] = $this->db->count_all_results();

        if (isset($search['value'])) {
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
        $query['recordsFiltered'] = $this->db->count_all_results();
        $this->db->flush_cache();
        unset($query['select']);
        return $query;
    }

    public function save()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());

        if($this->db->where('email', $email)->or_where('mobile', $mobile)->count_all_results('agents') > 0) {
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

    public function changeStatus()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());
        if (isset($id)) {
            if ($this->db->set('status', 'IF(status = "active" , "inactive" , "active")', FALSE)->where('id', $id)->update('agents')) {
                return ['type' => 'success', 'text' => 'Representative\'s status changed successfully!'];
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
                ->select('name, email, mobile')
                ->where('id', $id)
                ->get('agents')
                ->row_array();
        } else {
            return [];
        }
    }

    public function update()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());
        if ($id && $name && $email && $mobile) {
            $this->db->where('id', $id)->update('agents', [
                'name' => $name,
                'email' => $email,
                'mobile' => $mobile,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            return ['type' => 'success', 'text' => 'Representative\'s info successfully updated!'];
        }
        return ['type' => 'error', 'text' => 'Please Filled Out all mandatory field!'];
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
}
