<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_properties extends CI_Model
{
    public function getAll()
    {
        extract($this->input->get());

        $data = $this->db
            ->select("a.id, a.type, a.description title, a.for listing_for, b.name author, a.created_at created, a.updated_at updated, CAST(TRIM(BOTH '\"' FROM JSON_EXTRACT(a.coords, '$[0]')) AS DOUBLE) latitude, CAST(TRIM(BOTH '\"' FROM JSON_EXTRACT(a.coords, '$[1]')) AS DOUBLE) longitude, a.street address, CONCAT('uploads/', (SELECT path FROM property_images WHERE property_id = a.id LIMIT 1)) image, a.price, a.sold")
            ->where('b.id = a.created_by')
            ->where('a.vn_id !=', NULL)
            ->where('a.status = "active"')
            ->where('a.sold = "false"');

            if($street && $street != "") {
                $this->db->like('a.street', $street);
            }

            if ($for && $for != "any") {
                $this->db->where('a.for', $for);
            }
            if ($type && $type != "any") {
                $this->db->where('a.type', $type);
            }

            if ($price_max && $price_max != 0 && $price_max != '') {
                $this->db->where('a.price <=', $price_max);
            }
            if ($price_min && $price_min != '') {
                $this->db->where('a.price >=', $price_min);
            }
            

            switch ($sort_by) {
                case 'low-high':
                    $this->db->order_by('a.price', 'asc');
                    break;
                case 'high-low':
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

            $data = $this->db->get('properties a,users b')->result_array();
            // echo $this->db->last_query();
            
            // if($bedroom && $bedroom != 'any'){
            //     $bedroom_id = $this->db->select('id')->get_where('property_attributes', ['text' => 'Bedroom'],1)->row_array()['id'];
                
            //     foreach($data as $key => $value){
                    
            //         $bedroom_attr_val = $this->db->select('`value`')->where('property_id', $value['id'])->where('attribute_id',$bedroom_id)->get('property_attribute_values')->row_array()['value'];
                    
            //         if($bedroom_attr_val > $bedroom){
            //             continue;
            //         } else {
            //             unset($data[$key]);
            //         }
                    
            //     }
            // }

            // echo '<pre>';
            // print_r($data);

        if ($bedroom && $bedroom != 0) {
            $bedroom_id = $this->db->select('id')->get_where('property_attributes', ['text' => 'Bedroom'],1)->row_array()['id'];
            foreach($data as $key => $value){                 
                $bedroom_attr_val = $this->db->select('`value`')->where('property_id', $value['id'])->where('attribute_id',$bedroom_id)->where('value >=',intval($bedroom))->get('property_attribute_values')->row_array()['value'];
                if(!is_null($bedroom_attr_val)) {
                    continue;
                }
                else {
                    unset($data[$key]);
                }
            }
            $data = array_values($data);
        }
        else if ($bedroom_min && $bedroom_max != 0 && $bedroom_max != '') {
            $bedroom_id = $this->db->select('id')->get_where('property_attributes', ['text' => 'Bedroom'],1)->row_array()['id'];
            foreach($data as $key => $value){                    
                $bedroom_attr_val = $this->db->select('`value`')->where('property_id', $value['id'])->where('attribute_id',$bedroom_id)->where('value >=',intval($bedroom_min))->where('value <=',intval($bedroom_max))->get('property_attribute_values')->row_array()['value'];
                if(!is_null($bedroom_attr_val)) {
                    continue;
                }
                else {
                    unset($data[$key]);
                }
                
            }
            $data = array_values($data);
            // echo '<pre>';
            // print_r($data);
            // die();
        }
        if(sizeof($data) < 1) {
            die(json_encode(['result_empty' => true]));
        }

        $attributes = $this->db
            ->select('b.property_id, GROUP_CONCAT(JSON_OBJECT("text", a.text, "value", b.value)) attrs')
            ->where('b.attribute_id = a.id')
            ->where_in('b.property_id', array_column($data, 'id'))
            ->group_by('b.property_id')
            ->get('property_attributes a, property_attribute_values b')
            ->result_array();

        $attributes = array_column($attributes, 'attrs', 'property_id');

        $attributes_icon = $this->db
                    ->select('b.property_id, GROUP_CONCAT(JSON_OBJECT("text", a.text, "value", a.icon)) attrs_icon')
                    ->where('b.attribute_id = a.id')
                    ->where_in('b.property_id', array_column($data, 'id'))
                    ->group_by('b.property_id')
                    ->get('property_attributes a, property_attribute_values b')
                    ->result_array();

        $attributes_icon = array_column($attributes_icon, 'attrs_icon', 'property_id');
        

        $favourites = $this->db
                    ->select('b.user_id, b.property_id')
                    ->where('a.id = b.property_id')
                    ->where('b.user_id', $_SESSION['id'])
                    ->get('properties a, favorites b')
                    ->result_array(); 
                
        

            
        array_walk($data, function(&$row) use ($attributes, $attributes_icon, $favourites) {
            $dateInterval = (new DateTime())->diff(new DateTime($row['date']));
            $row['date'] = $dateInterval->format('%d days ago');
            $row['created'] = (new DateTime($row['created']))->format('d M y');
            $row['updated'] = (new DateTime($row['updated']))->format('d M y');
            $row['attrs'] = '[' . $attributes[$row['id']] . ']';
            $row['attrs_icon'] = '[' . $attributes_icon[$row['id']] . ']';
            $row['session'] = isset($_SESSION['id']) ? $_SESSION['id'] : 'null';
            $row['favourites'] = json_encode($favourites);
            $row = array_filter($row);
        });
        
        // print_r($data);
        // die();
        return compact('data');
    }

    public function getPropertiesWithAttributes()
    {
        $page = $this->input->get('page');
        $page = $page > 0 ? $page - 1 : 0;

        $for = $this->input->get('for');
        $type = $this->input->get('type');
        $bedroom = $this->input->get('bedroom');
        $street = $this->input->get('street');
        $area_id = $this->input->get('area_id');
        $max_price = $this->input->get('price_max');
        $min_price = $this->input->get('price_min');
        $available = $this->input->get('available');
        $sort_by = $this->input->get('sort_by');
        $bedroom_min = $this->input->get('bedroom_min');
        $bedroom_max = $this->input->get('bedroom_max');

       

        $this->db->select('a.*');
        $this->db->start_cache();
        $this->db->where('a.status', 'active');
        $this->db->where('a.sold', 'false');
        
        

        if ($for && $for != "any") {
            $this->db->where('a.for', $for);
        }
        if ($type && $type != "any") {
            $this->db->where('a.type', $type);
        }
        if ($area_id) {
            $this->db->where('area_id', $area_id);
        }
        if ($max_price && $max_price != 0 && $max_price != '') {
            $this->db->where('price <=', $max_price);
        }
        if ($min_price && $min_price != '') {
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

        if ($street) {
            $this->db->like('street', $street);
        }

        switch ($sort_by) {
            case 'low-high':
                $this->db->order_by('a.price', 'asc');
                break;
            case 'high-low':
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

        if(isset($bedroom)) {
        }
        else if(isset($bedroom_min)) {
        }
        else
            $this->db->limit(9, $page * 9);


        $properties = $this->db->get()->result_array(); //die($this->db->last_query());
        $all_properties_count = $this->db->count_all_results();
        $this->db->flush_cache();
        
        if (count($properties) == 0) {
            return [];
        }

        if($bedroom){
            $bedroom_id = $this->db->select('id')->get_where('property_attributes', ['text' => 'Bedroom'],1)->row_array()['id'];
            
            foreach($properties as $key => $property){
                
                $bedroom_attr_val = $this->db->select('`value`')->where('property_id', $property['id'])->where('attribute_id',$bedroom_id)->where('value >=',intval($bedroom))->get('property_attribute_values')->row_array()['value'];
                
                // if($bedroom_attr_val > $bedroom){
                //     continue;
                // } else {
                //     unset($properties[$key]);
                // }

                if(!is_null($bedroom_attr_val)) {
                    continue;
                }
                else {
                    unset($properties[$key]);
                }
                
            }
        }
        else if ($bedroom_min && $bedroom_max != 0 && $bedroom_max != '') {
            $bedroom_id = $this->db->select('id')->get_where('property_attributes', ['text' => 'Bedroom'],1)->row_array()['id'];
            foreach($properties as $key => $property){
                $bedroom_attr_val = $this->db->select('`value`')->where('property_id', $property['id'])->where('attribute_id',$bedroom_id)->where('value >=',intval($bedroom_min))->where('value <=',intval($bedroom_max))->get('property_attribute_values')->row_array()['value'];
                if(!is_null($bedroom_attr_val)) {
                    continue;
                }
                else {
                    unset($properties[$key]);
                }
                
            }
            $properties = array_values($properties);
            // echo '<pre>';
            // print_r($data);
            // die();
        }
        // $bedroom_attr_val = $this->db->get('property_attribute_values');
         
        if(count($properties) > 0) {
            $attributes =  $this->db
                ->select('a.text,a.icon,b.property_id,b.attribute_id,b.value ')
                ->where('a.id = b.attribute_id')
                ->where_in('b.property_id', array_column($properties, 'id'))
                ->get('property_attribute_values b,property_attributes a')
                ->result_array();
        }
        else {
            $attributes = [];
        }

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

    function getAllProperties()
    {
        return true;
    }

    function addToFavorite($id)
    {
        if(count($this->db->select('id')->where('user_id', $_SESSION['id'])->where('property_id', $id)->get('favorites')->result_array()) > 0){
            if($this->db->where('user_id', $_SESSION['id'])->where('property_id', $id)->delete('favorites')){
                return true;
            }
            return false;
        }
        $data = [
            'user_id' => $_SESSION['id'],
            'property_id' => $id
        ];
        if($this->db->insert('favorites', $data)){
            return true;
        }
        return false;
    }

    function getFavorites(){
        return $this->db->select('property_id')->where('user_id', $_SESSION['id'])->get('favorites')->result_array();
    }
}
