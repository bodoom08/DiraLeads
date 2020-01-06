<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'core/MOBO_User.php';
class Dashboard extends MOBO_User
{
    public function index()
    {
        if (!$_SESSION['id']) {
            redirect('login');
        }
        
        $users = $this->db->get('users')->result_array();
        $no_of_subscribers = $this->db->get('subscribers')->result_array();
        $no_of_properties = $this->db->get('properties')->result_array();
        $no_of_agents = $this->db->get('agents')->result_array();
        $no_of_bookmarked = $this->db->query('SELECT DISTINCT SUM(COUNT(property_id)) over() AS total_count FROM favorites GROUP BY user_id')->row();
        $this->load->view('dashboard', compact('users', 'no_of_subscribers', 'no_of_properties', 'no_of_agents', 'no_of_bookmarked'));
    }
}
