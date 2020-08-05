<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Verify extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        session_destroy();
    }

    function index()
    {
        $this->load->view('emails/agent_verification');
    }

    public function email($token)
    {
        $token = explode(':', base64_decode(urldecode($token)));

        $this->db->where('token', $token[1]);
        
        switch ($token[0]) {
            case 'agent':
                $this->db->from('agents');
                break;
            default:
                $this->db->from('users');
                break;
        }

        $user = $this->db
            ->select('id, name, email, mobile')
            ->get()
            ->row_array();
        
        if(is_null($user)) {
            show_404();
        } else {
            if(
                $this->input->method() == 'post'
                && (
                    $this->input->post('password')
                    === $this->input->post('cnf_password')
                )
            ) {
                $this->db->where('token', $token[1]);
                $this->db->set('token', null);
                $this->db->set('password', sha1($this->input->post('password')));
                $this->db->update('users');
                redirect('login');
            } else {
                if(($this->input->method() == 'post') && ( $this->input->post('password')
                != $this->input->post('cnf_password')))
                    $error = "Password Not matched";
                else if(($this->input->method() == 'post') && ($this->input->post('password') == '' || $this->input->post('cnf_password') == ''))
                    $error = "Password Required";
                $this->load->view('new_password', compact('error'));
            }
        }
    }
}
