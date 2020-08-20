<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_availability extends CI_Model {
    public function insert($data) {
        // Request Validation
        if (!isset($data['user_id']) || !$data['user_id'])
            return [
                'type' => 'error',
                'text' => 'User ID is missing',
            ];
        
        if (!isset($data['property_id']) || !$data['property_id'])
            return [
                'type' => 'error',
                'text'  => 'Property ID is missing',
            ];

        if (!isset($data['from']) || !$data['from'] || !isset($data['to']) || !$data['to'])
            return [
                'type'  => 'error',
                'text'  => 'Availabilities are missing'
            ];

        // Insert Data into DB
        if ($this->db->insert('user_availabilities', $data)) {
            return [
                'type'  => 'success',
                'text'  => 'Successfully Inserted'
            ];
        } else {
            return [
                'type'  => 'error',
                'text'  => 'Not able to add user availabilities'
            ];
        }
    }

    public function get($id) {
        return $this->db->get('user_availabilities', $id);
    }
}