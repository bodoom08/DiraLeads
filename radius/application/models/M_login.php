<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_login extends CI_Model
{
    function validate()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());

        $this->db->where('email', $email);
        $this->db->where('password', sha1($password));
        $this->db->where('status', 'active');
        $query = $this->db->get('admin');

        if ($query->num_rows() == 1) {
            $this->session->set_userdata($query->row_array() + ['user_type' => 'admin']);
            return ['type' => 'success', 'text' => 'Welcome To DiraLeads Admin Panel!'];
        } else {
            $this->db->where('email', $email);
            $this->db->where('password', sha1($password));
            $this->db->where('token', null);
            $this->db->where('status', 'active');
            $query = $this->db->get('agents');

            if ($query->num_rows() == 1) {
                $this->session->set_userdata($query->row_array() + ['user_type' => 'agent']);
                return ['type' => 'success', 'text' => 'Welcome To DiraLeads Agent Panel!'];
            }
        }
        return ['type' => 'error', 'text' => 'Sorry!! Invalid Username or Password'];
    }
}
