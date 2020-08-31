<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class M_page extends CI_Model
{
    function getPageData($slug = 'home')
    {
        return $this->db
            ->where('slug', $slug)
            ->where('status', 'active')
            ->get('pages')
            ->row_array();
    }

    function getWidgetData($names)
    {
        if (is_array($names) && $names !== []) {
            $widgets = $this->db->where_in('name', $names)->get('widgets')->result_array();
            return array_map(function ($htmlentites) {
                return html_entity_decode($htmlentites);
            }, array_column($widgets, 'html', 'name'));
        }

        return [];
    }

    function contact()
    {
        extract($this->input->post());

        if ($name && ($email || $phone)) {
            $this->db->insert('contact_requests', [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'message' => $message
            ]);

            return ['type' => 'success', 'text' => 'Contact request generated!'];
        }

        return ['type' => 'warning', 'text' => 'Name and Email/Phone is required!'];
    }
    function get_areas()
    {
        return $this->db
            ->get('areas')
            ->result_array();
    }
    function propertiesCount()
    {
        $this->db->select('areas.id,title');
        $this->db->from('areas');
        $this->db->join('properties', 'properties.area_id = areas.id');
        // $this->db->where('vn_id is  NOT NULL');
        $this->db->where('for', 'short term rent');
        $query = $this->db->get();
        $data = $query->result_array();
        foreach ($data as $key => $d) {
            $data[$key] = $d['title'];
        }
        return $data;
    }
    function home_page_livedata()
    {
        $no_of_sale = sizeof($this->db
            ->where('for', 'sale')
            ->get('properties')
            ->result_array());

        $no_of_rent = sizeof($this->db
            ->where('for', 'rent')
            ->get('properties')
            ->result_array());

        $no_of_short_term_rent = sizeof($this->db
            ->where('for', 'short term rent')
            ->get('properties')
            ->result_array());

        $no_of_agent = sizeof($this->db
            ->get('agents')
            ->result_array());

        $no_of_users = sizeof($this->db
            ->get('users')
            ->result_array());
        return [
            'no_of_sale' => $no_of_sale,
            'no_of_rent' => $no_of_rent,
            'no_of_short_term_rent' => $no_of_short_term_rent,
            'no_of_agent' => $no_of_agent,
            'no_of_users' => $no_of_users
        ];
    }
}
