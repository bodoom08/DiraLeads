<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_menus extends CI_Model
{
    public function getAll()
    {
        $menus = $this->db->order_by('position_menu', 'ASC')->get('menus')->result_array();
        $data = [];

        foreach ($menus as $menu) {
            $data[$menu['menu_position_id']][] = $menu;
        }

        $menuPositions = $this->db->get('menupositions')->result_array();

        array_walk($menuPositions, function (&$row) use ($data) {
            if (isset($data[$row['id']])) {
                $row['menus'] = $data[$row['id']];
            }
        });

        return $menuPositions;
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
        if ($id) {
            return $this->db->where('id', $id)->get('menus')->row_array();
        } else {
            return [];
        }
    }

    public function update($id)
    {
        $menu_position = $this->input->input_stream('menu_position');
        $title = $this->input->input_stream('title');
        $url = $this->input->input_stream('url');
        $opens_in = $this->input->input_stream('opens_in');

        if ($menu_position && $title && $url && $opens_in) {
            $this->db
                ->where('id', $id)
                ->update('menus', [
                    'menu_position_id' => $menu_position,
                    'title' => $title,
                    'url' => $url,
                    'tab_option' => $opens_in,
                    'created_by' => $_SESSION['id']
                ]);

            return ['type' => 'success', 'text' => 'Menu updated!'];
        }
        return ['type' => 'error', 'text' => 'Please Filled Out all mandatory field!'];
    }

    public function add()
    {
        $menu_position = $this->input->post('menu_position');
        $title = $this->input->post('title');
        $url = $this->input->post('url');
        $opens_in = $this->input->post('opens_in');

        if ($menu_position && $title && $url && $opens_in) {
            $position_menu = 1 + $this->db
                ->where('menu_position_id', $menu_position)
                ->count_all_results('menus');

            $this->db
                ->insert('menus', [
                    'menu_position_id' => $menu_position,
                    'title' => $title,
                    'url' => $url,
                    'tab_option' => $opens_in,
                    'position_menu' => $position_menu,
                    'created_by' => $_SESSION['id']
                ]);

            return ['type' => 'success', 'text' => 'Menu added!'];
        }
        return ['type' => 'error', 'text' => 'Please all fields are  mandatory!'];
    }

    public function delete($id)
    {
        if ($id) {
            if ($this->db->where('id', $id)->delete('menus')) {
                return ['type' => 'success', 'text' => 'Menu Deleted successfully!'];
            }
        }
        return ['type' => 'error', 'text' => 'Error Occured! Please checked it manualy!'];
    }

    public function update_pos($id)
    {
        $menuIds = $this->input->input_stream('menuIds');

        foreach ($menuIds as $i => $menuId) {
            $this->db
                ->where('menu_position_id', $id)
                ->where('id', $menuId)
                ->update('menus', [
                    'position_menu' => ($i + 1)
                ]);
        }

        return ['type' => 'success', 'text' => 'Menu position updated'];
    }

    public function getPositions()
    {
        return $this->db->get('menupositions')
            ->result();
    }
}
