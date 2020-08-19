<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_package extends CI_Model
{
    public function getdata() // not used
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

    public function getdata_custom_package_json()
    {
        extract($this->input->get());

        $search = array_map('trim', $search);
        $search['value'] = strtolower($search['value']);

        $this->db->start_cache();

        $query['select'] = ['a.package_name', 'a.invoice_id', 'a.price', 'a.description', 'a.no_of_area', 'a.no_of_days', 'a.status', 'b.name'];
        $this->db->select('a.id, a.package_name as name, a.invoice_id, a.price, a.description, a.no_of_area, a.no_of_days, a.area_price, a.days_price, a.status, a.start_date, a.end_date, a.user_id, b.name as user_name');
        $this->db->from('user_packages a');
        $this->db->join('users b', 'a.user_id = b.id', 'inner');


        $query['recordsTotal'] = $this->db->count_all_results();

        if (isset($search['value'])) {
            $this->db->group_start();
            foreach ($query['select'] as $s) {
                $this->db->or_like('LOWER(' . $s . ')', $search['value']);
            }
            $this->db->group_end();
        }

        $this->db->stop_cache();

        $this->db->order_by('a.id', 'desc');

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

    public function save_package()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());
        
        // if($this->db->where('email', $email)->or_where('mobile', $mobile)->count_all_results('users') > 0) {
        //     return ['type' => 'warning', 'text' => 'Email or mobile no already exist!'];
        // }
        if(empty($name))
            return ['type' => 'warning', 'text' => 'Package Name is required!'];
        
        if (!empty($name)) {

            foreach($days_no as $key => $value) {
                if((empty($value) && $key == 0) || intval($value) == 0) {                
                    return ['type' => 'warning', 'text' => 'Please add the no of days for row '.($key+1).'!'];
                    exit;
                }
                else if((empty($days_price[$key]) && $key == 0) || intval($value) == 0) {                
                    return ['type' => 'warning', 'text' => 'Please add the price for the days for row '.($key+1).'!'];
                    exit;
                }
                else if((empty($value)) || intval($value) == 0) {
                    return ['type' => 'warning', 'text' => 'Please add the no of days for row '.($key+1).'!'];
                    exit;
                }
                else if((empty($days_price[$key])) || intval($value) == 0) {
                    return ['type' => 'warning', 'text' => 'Please add the price for the days for row '.($key+1).'!'];
                    exit;
                }
            }
            
            foreach($area_no as $key => $value) {
                if((empty($value) && $key == 0) || intval($value) == 0) {
                    return ['type' => 'warning', 'text' => 'Please add the no of area for row '.($key+1).'!'];
                    exit;
                }
                else if((empty($area_price[$key]) && $key == 0) || intval($value) == 0) {
                    return ['type' => 'warning', 'text' => 'Please add the price for the area for row '.($key+1).'!'];
                    exit;
                }
                else if((empty($value)) || intval($value) == 0) {
                    return ['type' => 'warning', 'text' => 'Please add the no of area for row '.($key+1).'!'];
                    exit;
                }
                else if((empty($area_price[$key])) || intval($value) == 0) {
                    return ['type' => 'warning', 'text' => 'Please add the price for the area for row '.($key+1).'!'];
                    exit;
                }
            }

            if(!empty($package_id)) { // edit package
                $this->db->where('id', $package_id)->update('custom_package_names', ['name' => $name]);
                $this->db->where('custom_package_names_id', $package_id)->delete('custom_package_months');
                $this->db->where('custom_package_names_id', $package_id)->delete('custom_package_areas');

                foreach ($days_no as $key => $value) {
                    $this->db->insert('custom_package_months', ['noof' => $value, 'price' => $days_price[$key], 'custom_package_names_id' => $package_id]);                
                }

                foreach ($area_no as $key => $value) {
                    $this->db->insert('custom_package_areas', ['noof' => $value, 'price' => $area_price[$key], 'custom_package_names_id' => $package_id]);                
                }
                return ['type' => 'success', 'text' => 'Package Successfully edited'];
            }
            else { //  insert
                $this->db->insert('custom_package_names', ['name' => $name]);
                $last_insert_id = $this->db->insert_id();
                
                foreach ($days_no as $key => $value) {
                    $this->db->insert('custom_package_months', ['noof' => $value, 'price' => $days_price[$key], 'custom_package_names_id' => $last_insert_id]);                
                }

                foreach ($area_no as $key => $value) {
                    $this->db->insert('custom_package_areas', ['noof' => $value, 'price' => $area_price[$key], 'custom_package_names_id' => $last_insert_id]);                
                }
                return ['type' => 'success', 'text' => 'Package Successfully added'];
            }            
        }
    }

    public function get_package_json() {
        extract($this->input->get());

        $search = array_map('trim', $search);
        $search['value'] = strtolower($search['value']);

        $this->db->start_cache();

        $query['select'] = ['a.name'];
        $this->db->select('a.id,a.name,a.status');
        $this->db->from('custom_package_names a');

        $query['recordsTotal'] = $this->db->count_all_results();

        if (isset($search['value'])) {
            $this->db->group_start();
            foreach ($query['select'] as $s) {
                $this->db->or_like('LOWER(' . $s . ')', $search['value']);
            }
            $this->db->group_end();
        }

        $this->db->stop_cache();

        $this->db->order_by('a.name', 'asc');

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

    public function edit_package()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());
        if ($id) {
            $custom_package_names = $this->db
                ->select('id, name')
                ->where('id', $id)
                ->get('custom_package_names')
                ->row_array();

            $custom_package_days = $this->db
                ->select('id, noof, price')
                ->where('custom_package_names_id', $id)
                ->get('custom_package_months')
                ->result_array();
      
            $custom_package_areas = $this->db
                ->select('id, noof, price')
                ->where('custom_package_names_id', $id)
                ->get('custom_package_areas')
                ->result_array();
            return [
                'custom_package_names' => $custom_package_names,
                'custom_package_days' => $custom_package_days,
                'custom_package_areas' => $custom_package_areas,
            ];
        } else {
            return [];
        }
    }
 
    public function changeStatus()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());
        if (isset($id)) {
            if ($this->db->set('status', 'IF(status = "active" , "inactive" , "active")', FALSE)->where('id', $id)->update('custom_package_names')) {
                return ['type' => 'success', 'text' => 'Package status changed successfully!'];
            }
        }
        return ['type' => 'error', 'text' => 'Error Occured!'];
    }

}
