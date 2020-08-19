<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_area extends CI_Model
{
    public function getdata()
    {
        extract($this->input->get());

        $search = array_map('trim', $search);
        $search['value'] = strtolower($search['value']);

        $this->db->start_cache();

        $query['select'] = ['a.id', 'a.title', 'a.area'];
        $this->db->select('a.id,a.title,a.area as area_id');
        $this->db->from('areas a');

        $query['recordsTotal'] = $this->db->count_all_results();

        if (isset($search['value'])) {
            $this->db->group_start();
            foreach ($query['select'] as $s) {
                $this->db->or_like('LOWER(' . $s . ')', $search['value']);
            }
            $this->db->group_end();
        }

        $this->db->stop_cache();

        $this->db->order_by('a.title', 'asc');

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

    public function save_area()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());
        
        // if($this->db->where('email', $email)->or_where('mobile', $mobile)->count_all_results('users') > 0) {
        //     return ['type' => 'warning', 'text' => 'Email or mobile no already exist!'];
        // }
        if(empty($name))
            return ['type' => 'warning', 'text' => 'Area Name is required!'];
            
        
        if ($name) {
            if(empty($area_type))
                $arr = ['title' => $name, 'area' => NULL];
            else
                $arr = ['title' => $name, 'area' => $area_type];
            
            $this->db->insert('areas', $arr);
            return ['type' => 'success', 'text' => 'Area Added Successfully'];
        }
    }

    public function edit()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());
        if ($id) {
            return $this->db
                ->select('id, title, area')
                ->where('id', $id)
                ->get('areas')
                ->row_array();
        } else {
            return [];
        }
    }

    public function update()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());

        // print_r($this->input->post());
        // die();

        if(empty($name))
            return ['type' => 'warning', 'text' => 'Area Name is required!'];
        if($area_type == $id)
            return ['type' => 'warning', 'text' => 'Area title and Parent Area title can not be identical!'];

        if ($name) {
            if(empty($area_type))
                $arr = ['title' => $name, 'area' => NULL];
            else
                $arr = ['title' => $name, 'area' => $area_type];
            
            $this->db->where('id', $id);
            $this->db->update('areas', $arr);
            return ['type' => 'success', 'text' => 'Area Updated Successfully'];
        }
        
    }

}
