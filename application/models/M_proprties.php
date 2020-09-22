<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_proprties extends CI_Model
{
    public function getAll()
    {
        return ['Hello', 'World'];
    }

    public function getPropertiesWithAttributes()
    {
        $page = $this->input->get('page');
        $page = $page > 0 ? $page - 1 : 0;

        $for = $this->input->get('for');
        $type = $this->input->get('type');
        $area_id = $this->input->get('area_id');
        $max_price = $this->input->get('max_price');
        $min_price = $this->input->get('min_price');
        $available = $this->input->get('available');
        $sort_by = $this->input->get('sort_by');

        $this->db->select('a.*');
        $this->db->start_cache();
        $this->db->where('a.status', 'active');
        if ($for) {
            $this->db->where('a.for', $for);
        }
        if ($type) {
            $this->db->where('a.type', $type);
        }
        if ($area_id) {
            $this->db->where('area_id', $area_id);
        }
        if ($max_price) {
            $this->db->where('price <=', $max_price);
        }
        if ($min_price) {
            $this->db->where('price >=', $min_price);
        }
        if ($available) {
            if ($available == 'yes') {
                $this->db->where('available_date', date('Y-m-d'));
            } elseif ($available == 'no') {
                $this->db->where('available_date !=', date('Y-m-d'));
            } else {
                $this->db->where('available_date', date('Y-m-d'));
                $this->db->where('available_date !=', date('Y-m-d'));
            }
        }

        switch ($sort_by) {
            case 'lo-hi':
                $this->db->order_by('a.price', 'asc');
                break;
            case 'hi-lo':
                $this->db->order_by('a.price', 'desc');
                break;
            case 'newest':
                $this->db->order_by('a.created_at', 'desc');
                break;
            case 'oldest':
                $this->db->order_by('a.created_at', 'asc');
                break;
            
            default:
                # code...
                break;
        }

        $this->db->from('properties a');
        $this->db->join('virtual_numbers b', 'a.vn_id = b.id', 'right');
        $this->db->stop_cache();

        $this->db->limit(10, $page * 10);

        $properties = $this->db->get()->result_array(); //die($this->db->last_query());
        $all_properties_count = $this->db->count_all_results();
        $this->db->flush_cache();

        if (count($properties) == 0) {
            return [];
        }

        $attributes =  $this->db
            ->select('a.text,a.icon,b.property_id,b.attribute_id,b.value ')
            ->where('a.id = b.attribute_id')
            ->where_in('b.property_id', array_column($properties, 'id'))
            ->get('property_attribute_values b,property_attributes a')
            ->result_array();
        $images = $this->db
            ->select('property_id, path')
            ->group_by('property_id')
            ->get('property_images')
            ->result_array();
        $images = array_column($images, 'path', 'property_id');
        array_walk($properties, function (&$property) use ($attributes, $images) {
            $property['images'] = $images[$property['id']] ?? '';
            $keys = array_keys(array_column($attributes, 'property_id'), $property['id']);
            $property['attributes'] = array_map(function ($key) use ($attributes) {
                return $attributes[$key];
            }, $keys);
        });

        return compact('properties', 'all_properties_count');
    }
    
    public function getPropertyCoords()
    {
        $for = $this->input->get('for');
        $type = $this->input->get('type');
        $area_id = $this->input->get('area_id');
        $max_price = $this->input->get('max_price');
        $min_price = $this->input->get('min_price');
        $available = $this->input->get('available');

        $this->db->select('a.*');
        $this->db->where('a.status', 'active');
        if ($for) {
            $this->db->where('a.for', $for);
        }
        if ($type) {
            $this->db->where('a.type', $type);
        }
        if ($area_id) {
            $this->db->where('area_id', $area_id);
        }
        if ($max_price) {
            $this->db->where('price <=', $max_price);
        }
        if ($min_price) {
            $this->db->where('price >=', $min_price);
        }
        if ($available) {
            if ($available == 'yes') {
                $this->db->where('available_date', date('Y-m-d'));
            } elseif ($available == 'no') {
                $this->db->where('available_date !=', date('Y-m-d'));
            } else {
                $this->db->where('available_date', date('Y-m-d'));
                $this->db->where('available_date !=', date('Y-m-d'));
            }
        }

        $this->db->from('properties a');
        $this->db->join('virtual_numbers b', 'a.vn_id = b.id', 'right');

        $properties = $this->db->get()->result_array();
        $propertyCoords = array_filter(array_column($properties, 'coords', 'id'));
        
        array_walk($propertyCoords, function(&$str) {
            $str = json_decode($str);
        });

        return $propertyCoords;
    }

    function viewDetails()
    {
        extract($_POST);
        $data['property'] = $this->db
            ->select('a.*, b.mobile, b.email, vn.number as contact_number')
            ->where('a.id', $property_id)
            ->where('a.user_id = b.id')
            ->join('virtual_numbers vn', 'vn.id = a.vn_id', 'left')
            ->get('properties a, users b')
            ->row();
        $data['property_attributes'] = $this->db
            ->select('a.text,a.icon,b.property_id,b.attribute_id,b.value')
            ->where('a.id = b.attribute_id')
            ->where('b.property_id', $property_id)
            ->get('property_attribute_values b,property_attributes a')
            ->result_array();
        $data['property_images'] = $this->db
            ->select('property_id,path')
            ->where('property_id', $property_id)
            ->get('property_images')
            ->result_array();
        return $data;
    }

    function getAllAreas()
    {
        return $this->db->get('areas')->result_array();
    }
}
