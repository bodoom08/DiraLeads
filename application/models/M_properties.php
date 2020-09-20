<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_properties extends CI_Model
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function getAllProducts()
    {
        $types      = isset($_POST['type']) ? $_POST['type'] : [];
        $bedroom    = isset($_POST['bed']) ? $_POST['bed'] : 'any';
        $bathroom   = isset($_POST['bath']) ? $_POST['bath'] : 'any';
        $floor      = isset($_POST['floor']) ? $_POST['floor'] : 'any';
        $sort_by    = isset($_POST['sort']) ? $_POST['sort'] : 'any';
        // $price      = isset($_POST['price']) ? $_POST['price'] : 'any';
        // $street     = isset($_POST['street']) ? $_POST['street'] : 'any';
        $location   = isset($_POST['location']) ? $_POST['location'] : [];
        $area       = isset($_POST['area']) ? $_POST['area'] : 'any';
        $has_pic    = isset($_POST['has_pic']) ? $_POST['has_pic'] : 'false';
        $amenities  = isset($_POST['amenities']) ? $_POST['amenities'] : [];
        $area       = isset($_POST['area']) ? $_POST['area'] : 'any';
        $languages  = isset($_POST['lang']) ? $_POST['lang'] : [];
        $bed_range  = isset($_POST['bed_range']) ? $_POST['bed_range'] : NULL;
        $floor_range = isset($_POST['floor_range']) ? $_POST['floor_range'] : NULL;

        $query = 'select properties.id, areas.title, properties.area_id, properties.area_other, properties.street, properties.price, properties.bedrooms, properties.bathrooms, properties.florbas, properties.area_other,properties.manual_booking, properties.blocked_date, properties.days_price, properties.weekend_price, properties.weekly_price, properties.monthly_price, properties.status, properties.coords, properties.area_other,users.language from properties LEFT JOIN `areas` ON `properties`.`area_id` = `areas`.`id` LEFT JOIN `users` ON `properties`.`user_id` = `users`.`id` where `properties`.`status` = "active" LIMIT 10';

        if (count($types) > 0) {
            $query .= ' AND (';
        }
        foreach ($types as $index =>  $type) {
            $query .= '`properties`.`type` = "' . strtolower($type) . '" ';
            if ($index + 1 == count($types)) {
                $query .= ')';
            } else {
                $query .= ' OR ';
            }
        }
        foreach ($amenities as $amenity) {
            $query .= ' AND `properties`.`amenities` like "%' . $amenity . '%"';
        }

        if (count($languages) > 0) {
            foreach ($languages as $language) {
                $query .= ' AND `users`.`language` LIKE "%' . $language . '%"';
            }
        }

        if ($bedroom != "any" && $bedroom != '0') {
            $query .= ' AND `properties`.`bedrooms` >= ' . $bedroom;
        }
        if ($bed_range) {
            $query .= ' AND `properties`.`bedrooms` >= ' . $bed_range['min'] . ' AND `properties`.`bedrooms` <= ' . $bed_range['max'];
        }
        if ($floor != "any" && $floor != '0') {
            $query .= ' AND `properties`.`florbas` = ' . $floor;
        }
        if ($floor_range) {
            $query .= ' AND `properties`.`florbas` >= ' . $floor_range['min'] . ' AND `properties`.`florbas` <= ' . $floor_range['max'];
        }
        if ($bathroom != "any") {
            $query .= ' AND `properties`.`bathrooms` >= ' . $bathroom;
        }
        // if ($price != "any" && $price != "0|0") {
        //     $price = explode("|", $price);
        //     $query .= ' AND `properties`.`price` >= ' . $price[0] . ' AND `properties`.`price` <= ' . $price[1];
        // }
        // if ($street != "any") {
        //     $query .= ' AND `properties`.`street` = "' . $street . '" OR `properties`.`coords` = "' . $location . '"';
        // }
        if ($area != "any") {
            $query .= ' AND `properties`.`area_id` = "' . $area . '"';
        }
        if (count($location) > 0) {
            $neighbor = strtolower($location[0]);
            $query .= ' AND lower(`areas`.`title`) LIKE "%' . $neighbor . '%"';
        }
        if ($sort_by != "any") {
            switch ($sort_by) {
                case 'latest':
                    $query .= ' ORDER BY `properties`.`created_at` DESC';
                    break;
                case 'oldest':
                    $query .= ' ORDER BY `properties`.`created_at` ASC';
                    break;
                case 'updated':
                    $query .= ' ORDER BY `properties`.`updated_at` DESC';
                    break;
                case 'bedroom-down':
                    $query .= ' ORDER BY `properties`.`bedrooms` DESC';
                    break;
                case 'bedroom-up':
                    $query .= ' ORDER BY `properties`.`bedrooms` ASC';
                    break;
                case 'area':
                    $query .= ' ORDER BY `properties`.`area_id` DESC';
                    break;
                default:
                    break;
            }
        }

        $query_get = $this->db->query($query);
        $properties = array();
        if ($query_get !== FALSE && $query_get->num_rows() > 0) {
            foreach ($query_get->result_array() as $row) {
                $properties[] = $row;
            }
        }

        $streets = array();
        $filteredProperties = array();
        foreach ($properties as $index => $property) {
            if ($property['area_id'] == 0) $property['title'] = $property['area_other'];

            $images = $this->db->select("path")->where("property_id", $property["id"])->from('property_images')->get()->result_array();
            if ($has_pic == 'false' || count($images) > 0) {
                $property['images'] = $images;

                if (isset($property['coords']) && $property['coords'] != '[""]' && $property['coords'] != '[]') {
                    $coord = json_decode($property['coords']);
                    if (is_array($coord)) {
                        $coord = [
                            "lat" => round(doubleval($coord[0]), 5),
                            "lng" => round(doubleval($coord[1]), 5)
                        ];
                    } else if (is_object($coord)) {
                        $coord = [
                            "lat" => round(doubleval($coord->lat), 5),
                            "lng" => round(doubleval($coord->lng), 5)
                        ];
                    }
                    $property['coords'] = $coord;
                    $property['images'] = $images;
                    $property['blocked_date'] = json_decode($property['blocked_date']);
                    $property['manual_booking'] = json_decode($property['manual_booking']);
                    array_push($streets, [
                        "location" => $coord,
                        "property" => $property
                    ]);
                } else {
                    $property['coords'] = [
                        "lat" => 31.0461,
                        "lng" => 34.08516
                    ];
                    $property['blocked_date'] = json_decode($property['blocked_date']);
                    $property['manual_booking'] = json_decode($property['manual_booking']);
                }
                
                $filteredProperties[] = $property;
            }
        }

        return [
            "properties" => $filteredProperties,
            "streets"   => json_encode($streets)
        ];
    }

    public function getProductDetail($id)
    {
        $query = 'select users.name, properties.id, areas.title, properties.area_id, properties.area_other, properties.street, properties.type, properties.amenities, properties.description, properties.price, properties.bedrooms, properties.bathrooms, properties.florbas, properties.area_other, properties.days_price, properties.weekend_price, properties.weekly_price, properties.monthly_price, properties.weekend_from, properties.weekend_to, properties.only_weekend, properties.status, properties.coords, properties.is_annual, properties.seasonal_price, properties.blocked_date, properties.manual_booking, properties.private_note , virtual_numbers.number from properties LEFT JOIN `areas` on `areas`.`id` = `properties`.`area_id` LEFT JOIN `virtual_numbers` ON `properties`.`vn_id` = `virtual_numbers`.`id` LEFT JOIN `users` ON `properties`.`user_id` = `users`.`id` where `properties`.`status` = "active" AND `properties`.`id` = ' . $id;
        $property_query = $this->db->query($query);
        $property = [];
        if ($property_query !== FALSE && $property_query->num_rows() > 0) {
            $property = $this->db->query($query)->row();
            $images_query = $this->db->select('path')->where('property_id', $id)->from('property_images')->get();

            $property->images = array();
            if ($images_query !== FALSE && $images_query->num_rows() > 0) {
                foreach ($images_query->result_array() as $row) {
                    $property->images[] = $row;
                }
            }
            $property->amenities = explode(',', $property->amenities);
            if ($property->area_id == 0)
                $property->title = $property->area_other;
        }

        return ["property" => $property];
    }

    public function getAll()
    {
        extract($this->input->get());

        $data = $this->db
            ->select("a.id, a.type, a.description title, a.for listing_for, b.name author, a.created_at created, a.updated_at updated, CAST(TRIM(BOTH '\"' FROM JSON_EXTRACT(a.coords, '$[0]')) AS DOUBLE) latitude, CAST(TRIM(BOTH '\"' FROM JSON_EXTRACT(a.coords, '$[1]')) AS DOUBLE) longitude, a.street address, CONCAT('uploads/', (SELECT path FROM property_images WHERE property_id = a.id LIMIT 1)) image, a.price, a.sold")
            ->where('b.id = a.created_by')
            ->where('a.vn_id !=', NULL)
            ->where('a.status = "active"')
            ->where('a.sold = "false"');

        if ($street && $street != "") {
            $this->db->like('a.street', $street);
        }

        if ($for && $for != "any") {
            $this->db->where('a.for', $for);
            if ($for == 'short term rent') {
                if ($fromdate && $todate) {
                    $fromdate = new DateTime($fromdate);
                    $todate = new DateTime($todate);
                    $count = 1;
                    $query = '';
                    for ($i = $fromdate; $i <= $todate; $i->modify('+1 days')) {
                        if ($count == 1) {
                            $query .= "(FIND_IN_SET('" . $i->format("Y-m-d") . "', `a`.`short_term_available_date`)";
                        } else {
                            $query .= " OR FIND_IN_SET('" . $i->format("Y-m-d") . "', `a`.`short_term_available_date`)";
                        }
                        $count++;
                    }
                    $query .= ")";
                    $this->db->where($query);
                }
            }
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
        $this->db->query("set session sql_mode=''");
        $data = $this->db->get('properties a,users b')->result_array();
        // echo $this->db->last_query();
        // die;

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
            $bedroom_id = $this->db->select('id')->get_where('property_attributes', ['text' => 'Bedroom'], 1)->row_array()['id'];
            foreach ($data as $key => $value) {
                $bedroom_attr_val = $this->db->select('`value`')->where('property_id', $value['id'])->where('attribute_id', $bedroom_id)->where('value >=', intval($bedroom))->get('property_attribute_values')->row_array()['value'];
                if (!is_null($bedroom_attr_val)) {
                    continue;
                } else {
                    unset($data[$key]);
                }
            }
            $data = array_values($data);
        } else if ($bedroom_min && $bedroom_max != 0 && $bedroom_max != '') {
            $bedroom_id = $this->db->select('id')->get_where('property_attributes', ['text' => 'Bedroom'], 1)->row_array()['id'];
            foreach ($data as $key => $value) {
                $bedroom_attr_val = $this->db->select('`value`')->where('property_id', $value['id'])->where('attribute_id', $bedroom_id)->where('value >=', intval($bedroom_min))->where('value <=', intval($bedroom_max))->get('property_attribute_values')->row_array()['value'];
                if (!is_null($bedroom_attr_val)) {
                    continue;
                } else {
                    unset($data[$key]);
                }
            }
            $data = array_values($data);
            // echo '<pre>';
            // print_r($data);
            // die();
        }
        if (sizeof($data) < 1) {
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




        array_walk($data, function (&$row) use ($attributes, $attributes_icon, $favourites) {
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

    public function getAllDevlopment()
    {
        extract($this->input->get());

        $data = $this->db
            ->select("a.id, a.type, a.description title, a.for listing_for, b.name author, a.created_at created, a.updated_at updated, CAST(TRIM(BOTH '\"' FROM JSON_EXTRACT(a.coords, '$[0]')) AS DOUBLE) latitude, CAST(TRIM(BOTH '\"' FROM JSON_EXTRACT(a.coords, '$[1]')) AS DOUBLE) longitude, a.street address,CONCAT('uploads/', (SELECT path FROM property_images WHERE property_id = a.id LIMIT 1)) image,a.price, a.sold")
            ->where('b.id = a.created_by')
            ->where('a.vn_id !=', NULL)
            ->where('a.status = "active"')
            ->where('a.sold = "false"');

        if ($street && $street != "") {
            $this->db->like('a.street', $street);
        }

        if ($for && $for != "any") {
            $this->db->where('a.for', $for);
            if ($for == 'short term rent') {
                if ($fromdate && $todate) {
                    $fromdate = new DateTime($fromdate);
                    $todate = new DateTime($todate);
                    $count = 1;
                    $query = '';
                    for ($i = $fromdate; $i <= $todate; $i->modify('+1 days')) {
                        if ($count == 1) {
                            $query .= "(FIND_IN_SET('" . $i->format("Y-m-d") . "', `a`.`short_term_available_date`)";
                        } else {
                            $query .= " OR FIND_IN_SET('" . $i->format("Y-m-d") . "', `a`.`short_term_available_date`)";
                        }
                        $count++;
                    }
                    $query .= ")";
                    $this->db->where($query);
                }
            }
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
        // die;

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
            $bedroom_id = $this->db->select('id')->get_where('property_attributes', ['text' => 'Bedroom'], 1)->row_array()['id'];
            foreach ($data as $key => $value) {
                $bedroom_attr_val = $this->db->select('`value`')->where('property_id', $value['id'])->where('attribute_id', $bedroom_id)->where('value >=', intval($bedroom))->get('property_attribute_values')->row_array()['value'];
                if (!is_null($bedroom_attr_val)) {
                    continue;
                } else {
                    unset($data[$key]);
                }
            }
            $data = array_values($data);
        } else if ($bedroom_min && $bedroom_max != 0 && $bedroom_max != '') {
            $bedroom_id = $this->db->select('id')->get_where('property_attributes', ['text' => 'Bedroom'], 1)->row_array()['id'];
            foreach ($data as $key => $value) {
                $bedroom_attr_val = $this->db->select('`value`')->where('property_id', $value['id'])->where('attribute_id', $bedroom_id)->where('value >=', intval($bedroom_min))->where('value <=', intval($bedroom_max))->get('property_attribute_values')->row_array()['value'];
                if (!is_null($bedroom_attr_val)) {
                    continue;
                } else {
                    unset($data[$key]);
                }
            }
            $data = array_values($data);
            // echo '<pre>';
            // print_r($data);
            // die();
        }
        if (sizeof($data) < 1) {
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




        array_walk($data, function (&$row) use ($attributes, $attributes_icon, $favourites) {
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
        $image = $this->db
            ->select('property_id, path')
            ->get('property_images')
            ->result_array();
        return compact('data', 'image');
    }

    public function getPropertiesWithAttributes()
    {
        $page = $this->input->get('page');
        $page = $page > 0 ? $page - 1 : 0;

        $for = 'short term rent';
        $type = $this->input->get('type');
        $bedroom = $this->input->get('bedroom');
        $street = $this->input->get('street');
        $toDate = $this->input->get('toDate');
        $fromDate = $this->input->get('fromDate');
        $area = $this->input->get('area');
        $more = $this->input->get('more');
        $bathroom = $this->input->get('bathroom');
        $favourite = $this->input->get('favourite');
        $areasData = $this->db
            ->select('id')
            ->where('title', $area)
            ->get('areas');
        $res =  $areasData->row();
        if (isset($res->id)) { //Ben
            $area_id = $res->id;
        } else {
            $area_id = null;
        }

        $max_price = $this->input->get('price_max');
        $min_price = $this->input->get('price_min');
        $available = $this->input->get('available');
        $sort_by = $this->input->get('sort_by');
        $bedroom_min = $this->input->get('bedroom_min');
        $bedroom_max = $this->input->get('bedroom_max');
        $fromdate = '';
        $todate = '';



        $this->db->select('a.*');
        $this->db->start_cache();
        $this->db->where('a.status', 'active');
        $this->db->where('a.sold', 'false');
        if ($toDate) {
            // $this->db->where('a.available_date BETWEEN "'.$fromDate. '" and "'.$toDate.'"');
            $this->db->where("available_date BETWEEN '$fromDate' AND '$toDate'");
            // $this->db->where('available_date <=', $fromDate);
        }

        // die($for); 
        $paramsArr = '';
        $for_get = isset($_GET['for']) ? $_GET['for'] : 'rent';
        if (strpos($for_get, 'short term rent') !== false) {
            $for = 'short term rent';
            $arrInput = explode('&', $for_get);
            $fromdate = explode('=', $arrInput[1]);
            if ($fromdate) {
                $fromdate = $fromdate[1];
            }
            $todate = explode('=', $arrInput[2]);
            if ($todate) {
                $todate = $todate[1];
            }
        }

        if ($for && $for != "any") {
            $this->db->where('a.for', $for);
            if ($for == 'short term rent') {
                if ($fromdate && $todate) {
                    $fromdate = new DateTime($fromdate);
                    $todate = new DateTime($todate);
                    $count = 1;
                    $query = '';
                    for ($i = $fromdate; $i <= $todate; $i->modify('+1 days')) {
                        if ($count == 1) {
                            $query .= "(FIND_IN_SET('" . $i->format("Y-m-d") . "', `a`.`short_term_available_date`)";
                        } else {
                            $query .= " OR FIND_IN_SET('" . $i->format("Y-m-d") . "', `a`.`short_term_available_date`)";
                        }
                        $count++;
                    }
                    $query .= ")";
                    $this->db->where($query);
                }
            }

            // die($query);
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

        if (isset($bedroom)) {
        } else if (isset($bedroom_min)) {
        } else
            $this->db->limit(9, $page * 9);


        $properties = $this->db->get()->result_array(); //die($this->db->last_query());
        $all_properties_count = $this->db->count_all_results();
        $this->db->flush_cache();

        if (count($properties) == 0) {
            return [];
        }

        if ($favourite) {
            $fav_propry_ids = $this->db->select('property_id')->where('user_id', $_SESSION['id'])->get('favorites')->result_array();
            // print_r($properties);
            // die();
            foreach ($fav_propry_ids as $k => $y) {
                foreach ($properties as $key => $property) {
                    if ($k == $key) {
                        echo   $y['property_id'];

                        $bedroom_attr_val = $this->db->select('id')->where('id', $y['property_id'])->get('properties')->row_array();

                        if (!is_null($bedroom_attr_val)) {
                            continue;
                        } else {
                            unset($properties[$key]);
                        }
                    }
                }
            }
        }

        if ($more) {
            $bedroom_id = $this->db->select('id')->get_where('property_attributes', ['text' => $more], 1)->row_array()['id'];

            foreach ($properties as $key => $property) {

                $bedroom_attr_val = $this->db->select('`value`')->where('property_id', $property['id'])->where('attribute_id', $bedroom_id)->get('property_attribute_values')->row_array()['value'];

                // if($bedroom_attr_val > $bedroom){
                //     continue;
                // } else {
                //     unset($properties[$key]);
                // }

                if (!is_null($bedroom_attr_val)) {
                    continue;
                } else {
                    unset($properties[$key]);
                }
            }
        }
        if ($bedroom) {
            $bedroom_id = $this->db->select('id')->get_where('property_attributes', ['text' => 'Bedroom'], 1)->row_array()['id'];

            foreach ($properties as $key => $property) {

                $bedroom_attr_val = $this->db->select('`value`')->where('property_id', $property['id'])->where('attribute_id', $bedroom_id)->where('value >=', intval($bedroom))->get('property_attribute_values')->row_array()['value'];

                // if($bedroom_attr_val > $bedroom){
                //     continue;
                // } else {
                //     unset($properties[$key]);
                // }

                if (!is_null($bedroom_attr_val)) {
                    continue;
                } else {
                    unset($properties[$key]);
                }
            }
        }
        if ($bathroom) {
            $bathroom_id = $this->db->select('id')->get_where('property_attributes', ['text' => 'Bathroom'], 1)->row_array()['id'];

            foreach ($properties as $key => $property) {

                $bedroom_attr_val = $this->db->select('`value`')->where('property_id', $property['id'])->where('attribute_id', $bathroom_id)->where('value >=', intval($bathroom))->get('property_attribute_values')->row_array()['value'];
                if (!is_null($bedroom_attr_val)) {
                    continue;
                } else {
                    unset($properties[$key]);
                }
            }
        } else if ($bedroom_min && $bedroom_max != 0 && $bedroom_max != '') {
            $bedroom_id = $this->db->select('id')->get_where('property_attributes', ['text' => 'Bedroom'], 1)->row_array()['id'];
            foreach ($properties as $key => $property) {
                $bedroom_attr_val = $this->db->select('`value`')->where('property_id', $property['id'])->where('attribute_id', $bedroom_id)->where('value >=', intval($bedroom_min))->where('value <=', intval($bedroom_max))->get('property_attribute_values')->row_array()['value'];
                if (!is_null($bedroom_attr_val)) {
                    continue;
                } else {
                    unset($properties[$key]);
                }
            }
            $properties = array_values($properties);
            // echo '<pre>';
            // print_r($data);
            // die();
        }
        // $bedroom_attr_val = $this->db->get('property_attribute_values');

        if (count($properties) > 0) {
            $attributes =  $this->db
                ->select('a.text,a.icon,b.property_id,b.attribute_id,b.value ')
                ->where('a.id = b.attribute_id')
                ->where_in('b.property_id', array_column($properties, 'id'))
                ->get('property_attribute_values b,property_attributes a')
                ->result_array();
        } else {
            $attributes = [];
        }

        $images = $this->db
            ->select('property_id, path')
            // ->group_by('property_id')
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
        $images = $this->db
            ->select('property_id, path')
            // ->group_by('property_id')
            ->get('property_images')
            ->result_array();
        return compact('properties', 'all_properties_count', 'images');
    }

    public function getAllImages()
    {
        return $this->db
            ->select('property_id, path')
            ->get('property_images')
            ->result_array();
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

        array_walk($propertyCoords, function (&$str) {
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
        if (count($this->db->select('id')->where('user_id', $_SESSION['id'])->where('property_id', $id)->get('favorites')->result_array()) > 0) {
            if ($this->db->where('user_id', $_SESSION['id'])->where('property_id', $id)->delete('favorites')) {
                return 'remove';
            }
            return false;
        }
        $data = [
            'user_id' => $_SESSION['id'],
            'property_id' => $id
        ];
        if ($this->db->insert('favorites', $data)) {
            return 'insert';
        }
        return false;
    }

    function getFavorites()
    {
        if (isset($_SESSION['id'])) {
            return $this->db->select('property_id')->where('user_id', $_SESSION['id'])->get('favorites')->result_array();
        } else {
            return null;
        }
    }

    public function property_count() 
    {
        $this->db->where('status', 'active');
        $this->db->from('properties');
        return $this->db->count_all_results();
    }

    function generate_query() 
    {
        $types          = isset($_POST['type']) ? $_POST['type'] : [];
        $bedroom        = isset($_POST['bed']) ? $_POST['bed'] : 'any';
        $bathroom       = isset($_POST['bath']) ? $_POST['bath'] : 'any';
        $floor          = isset($_POST['floor']) ? $_POST['floor'] : 'any';
        $sort_by        = isset($_POST['sort']) ? $_POST['sort'] : 'any';
        $location       = isset($_POST['location']) ? $_POST['location'] : [];
        $area           = isset($_POST['area']) ? $_POST['area'] : 'any';
        $amenities      = isset($_POST['amenities']) ? $_POST['amenities'] : [];
        $area           = isset($_POST['area']) ? $_POST['area'] : 'any';
        $languages      = isset($_POST['lang']) ? $_POST['lang'] : [];
        $bed_range      = isset($_POST['bed_range']) ? $_POST['bed_range'] : NULL;
        $floor_range    = isset($_POST['floor_range']) ? $_POST['floor_range'] : NULL;

        $query = '';

        if (count($types) > 0) {
            $query .= ' AND (';
        }
        foreach ($types as $index =>  $type) {
            $query .= '`properties`.`type` = "' . strtolower($type) . '" ';
            if ($index + 1 == count($types)) {
                $query .= ')';
            } else {
                $query .= ' OR ';
            }
        }
        foreach ($amenities as $amenity) {
            $query .= ' AND `properties`.`amenities` like "%' . $amenity . '%"';
        }
        if (count($languages) > 0) {
            foreach ($languages as $language) {
                $query .= ' AND `users`.`language` LIKE "%' . $language . '%"';
            }
        }
        if ($bedroom != "any" && $bedroom != '0') {
            $query .= ' AND `properties`.`bedrooms` >= ' . $bedroom;
        }
        if ($bed_range) {
            $query .= ' AND `properties`.`bedrooms` >= ' . $bed_range['min'] . ' AND `properties`.`bedrooms` <= ' . $bed_range['max'];
        }
        if ($floor != "any" && $floor != '0') {
            $query .= ' AND `properties`.`florbas` = ' . $floor;
        }
        if ($floor_range) {
            $query .= ' AND `properties`.`florbas` >= ' . $floor_range['min'] . ' AND `properties`.`florbas` <= ' . $floor_range['max'];
        }
        if ($bathroom != "any") {
            $query .= ' AND `properties`.`bathrooms` >= ' . $bathroom;
        }
        if ($area != "any") {
            $query .= ' AND `properties`.`area_id` = "' . $area . '"';
        }
        if (count($location) > 0) {
            $neighbor = strtolower($location[0]);
            $query .= ' AND lower(`areas`.`title`) LIKE "%' . $neighbor . '%"';
        }
        if ($sort_by != "any") {
            switch ($sort_by) {
                case 'latest':
                    $query .= ' ORDER BY `properties`.`created_at` DESC';
                    break;
                case 'oldest':
                    $query .= ' ORDER BY `properties`.`created_at` ASC';
                    break;
                case 'updated':
                    $query .= ' ORDER BY `properties`.`updated_at` DESC';
                    break;
                case 'bedroom-down':
                    $query .= ' ORDER BY `properties`.`bedrooms` DESC';
                    break;
                case 'bedroom-up':
                    $query .= ' ORDER BY `properties`.`bedrooms` ASC';
                    break;
                case 'area':
                    $query .= ' ORDER BY `properties`.`area_id` DESC';
                    break;
                default:
                    break;
            }
        }

        return $query;
    }

    public function property_count_by_conditions()
    {
        $sql_query = 'select properties.id from properties LEFT JOIN `areas` ON `properties`.`area_id` = `areas`.`id` LEFT JOIN `users` ON `properties`.`user_id` = `users`.`id` where `properties`.`status` = "active" ' . $this->generate_query();
        $query = $this->db->query($sql_query);

        return $query->num_rows();
    }

    public function fetch_properties($limit, $start) 
    {
        $has_pic        = isset($_POST['has_pic']) ? $_POST['has_pic'] : 'false';

        $query = 'select properties.id, areas.title, properties.area_id, properties.area_other, properties.street, properties.price, properties.bedrooms, properties.bathrooms, properties.florbas, properties.area_other,properties.manual_booking, properties.blocked_date, properties.days_price, properties.weekend_price, properties.weekly_price, properties.monthly_price, properties.status, properties.coords, properties.area_other,users.language from properties LEFT JOIN `areas` ON `properties`.`area_id` = `areas`.`id` LEFT JOIN `users` ON `properties`.`user_id` = `users`.`id` where `properties`.`status` = "active" ' . $this->generate_query();


        $query .= ' LIMIT ' . $start . ', ' . $limit;

        $query = $this->db->query($query);

        $properties = array();
        if ($query !== FALSE && $query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $properties[] = $row;
            }
        }

        $streets = array();
        $filteredProperties = array();
        foreach ($properties as $index => $property) {
            if ($property['area_id'] == 0) $property['title'] = $property['area_other'];

            $images = $this->db->select("path")->where("property_id", $property["id"])->from('property_images')->get()->result_array();
            if ($has_pic == 'false' || count($images) > 0) {
                $property['images'] = $images;

                if (isset($property['coords']) && $property['coords'] != '[""]' && $property['coords'] != '[]') {
                    $coord = json_decode($property['coords']);
                    if (is_array($coord)) {
                        $coord = [
                            "lat" => round(doubleval($coord[0]), 5),
                            "lng" => round(doubleval($coord[1]), 5)
                        ];
                    } else if (is_object($coord)) {
                        $coord = [
                            "lat" => round(doubleval($coord->lat), 5),
                            "lng" => round(doubleval($coord->lng), 5)
                        ];
                    }
                    $property['coords'] = $coord;
                    $property['images'] = $images;
                    $property['blocked_date'] = json_decode($property['blocked_date']);
                    $property['manual_booking'] = json_decode($property['manual_booking']);
                    array_push($streets, [
                        "location" => $coord,
                        "property" => $property
                    ]);
                } else {
                    $property['coords'] = [
                        "lat" => 31.0461,
                        "lng" => 34.08516
                    ];
                    $property['blocked_date'] = json_decode($property['blocked_date']);
                    $property['manual_booking'] = json_decode($property['manual_booking']);
                }
                
                $filteredProperties[] = $property;
            }
        }

        return [
            "properties" => $filteredProperties,
            "streets"   => json_encode($streets)
        ];
    }

}
