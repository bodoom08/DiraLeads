<?php

require APPPATH . 'core/MOBO_Api.php';

class Properties extends MOBO_Api
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        $this->_checkAuth();
    }

    function index()
    {
        $properties = $this->db->where('status', 'active')
            ->get('properties')
            ->result_array();

        $properties = array_column($properties, null, 'id');

        $attributes = $this->db
            ->select('a.text, a.icon, a.description, b.value, b.property_id')
            ->where('a.id = b.attribute_id')
            ->get('property_attributes a, property_attribute_values b')
            ->result();

        foreach ($attributes as $attribute) {
            if ($properties[$attribute->property_id]) {
                $properties[$attribute->property_id]['attributes'][] = $attribute;
            }
        }

        $this->_json(array_values($properties));
    }
}
