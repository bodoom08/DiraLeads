<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_preferences extends CI_Model
{

    function getAllAreas()
    {
        return $this->db->get('areas')->result_array();
    }
}
