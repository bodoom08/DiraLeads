<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_pages extends CI_Model
{
    public function getdata()
    {
        extract($this->input->get());

        $search = array_map('trim', $search);
        $search['value'] = strtolower($search['value']);

        $this->db->start_cache();

        $query['select'] = ['a.title', 'a.slug', 'a.status', 'a.id'];
        $this->db->select('a.*');
        $this->db->from('pages a');

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

    public function changeStatus()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());
        if (isset($package_id)) {
            if ($this->db->set('status', 'IF(status = "active" , "inactive" , "active")', FALSE)->where('id', $package_id)->update('pages')) {
                return ['type' => 'success', 'text' => 'Page Status changed successfully!'];
            }
        }
        return ['type' => 'error', 'text' => 'Error Occured! Please checked it manualy!'];
    }

    public function edit($id)
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());

        if ($id) {
            return $this->db->where('id', $id)->get('pages')->row_array();
        } else {
            return [];
        }
    }

    public function update($id)
    {
        $title = $this->input->input_stream('title');
        $slug = $this->input->input_stream('slug');
        $banner_type = $this->input->input_stream('banner_type');
        $content = $this->input->input_stream('content');

        if ($id && $title && $slug && $content) {
            $content = htmlentities($content);
            $this->db
                ->where('id', $id)
                ->update('pages', compact('title', 'slug', 'banner_type', 'content'));

            return ['type' => 'success', 'text' => 'Page updated!'];
        }
        return ['type' => 'error', 'text' => 'Please Filled Out all mandatory field!'];
    }

    public function add()
    {
        $title = $this->input->post('title');
        $slug = url_title($this->input->post('slug'), '-', true);
        $banner_type = $this->input->post('banner_type');
        $content = $this->input->post('content');

        if ($this->db->where('slug', $slug)->count_all_results('pages') > 0) {
            return ['type' => 'error', 'text' => 'Slug already exists!'];
        }

        if ($title && $slug && $content) {
            $content = htmlentities($content);
            $this->db
                ->insert('pages', compact('title', 'slug', 'banner_type', 'content'));

            return ['type' => 'success', 'text' => 'Page updated!'];
        }
        return ['type' => 'error', 'text' => 'Please all fields are  mandatory!'];
    }

    public function delete($id)
    {
        if ($this->db->where('id', $id)->get('pages')->row()->slug == 'home') {
            return ['type' => 'warning', 'text' => 'Sorry!! Home page can not be deleted'];
        }
        if ($id) {
            if ($this->db->where('id', $id)->delete('pages')) {
                return ['type' => 'success', 'text' => 'Page Deleted successfully!'];
            }
        }
        return ['type' => 'error', 'text' => 'Error Occured! Please checked it manualy!'];
    }
}
