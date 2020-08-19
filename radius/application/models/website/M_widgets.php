<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_widgets extends CI_Model
{
    public function getWidgets()
    {
        return $this->db->get('widgets')->result();
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

    public function edit($name)
    {
        $widget = $this->db->where('name', $name)->get('widgets')->row_array();
        
        if ($widget) {
            return $widget;
        } else {
            redirect('website/widgets');
        }
    }

    public function update($name)
    {
        $html = $this->input->input_stream('html');

        $html = htmlentities($html);
        $this->db
            ->where('name', $name)
            ->update('widgets', compact('html'));

        return ['type' => 'success', 'text' => 'Widget ' . $name . ' updated!'];
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
