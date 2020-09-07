<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Properties extends MOBO_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_properties');
        $this->load->model('M_page');
        $this->load->library('session');
    }

    //*
    public function index()
    {
        $data['title'] = 'Rentals';
        $this->load->view('maintenance', $data);
    }
    /**/

    /*
    public function index()
    {
        $data = $this->M_properties->getAllProducts();
        $data['areas'] = $this->M_page->get_areas();
        $this->load->view('properties', $data);
        // $this->load->view('properties');
    }
    /**/

    public function getAllImages()
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($this->M_properties->getAllImages()));
    }
    public function with_coords()
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($this->M_properties->getAll()));
    }

    public function with_coordsDevlop()
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($this->M_properties->getAllDevlopment()));
    }


    public function map()
    {
        $coords = $this->M_properties->getPropertyCoords();
        // var_dump($coords); die;

        $this->load->view('map_properties', compact('coords'));
    }

    public function paginate($total_properties)
    {
        $this->load->library('pagination');
        $config['base_url'] = base_url('properties');
        $config['total_rows'] = $total_properties;
        $config['per_page'] = 9;
        $config['query_string_segment'] = 'page';
        $config['num_links'] = 2;
        $config['use_page_numbers'] = true;
        $config['reuse_query_string'] = false;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['next_link'] = '<i class="fa fa-angle-right"></i>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '<i class="fa fa-angle-left"></i>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item">';
        $config['cur_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');
        $config['page_query_string'] = true;

        $this->pagination->initialize($config);
    }

    public function viewDetails()
    {
        if ($this->input->is_ajax_request()) {
            // die(json_encode($_POST));
            // die;
            exit(json_encode($this->M_properties->viewDetails()));
        }

        redirect('/properties');
    }

    public function property_detail()
    {
        $data['areas'] = $this->M_properties->getAllAreas();
        $properties = $this->M_properties->getPropertiesWithAttributes();
        $data['properties'] = $properties['properties'];
        echo json_encode($data);
        // $this->paginate($properties['all_properties_count']);
        // $this->load->view('property_detail',$data);
    }

    function lists()
    {
        $data = $this->M_properties->getPropertiesWithAttributes();
        $data['favorites'] = $this->M_properties->getFavorites();
        $data['no_to_paginate'] = ceil($data['all_properties_count'] / 9);
        extract($_GET);
        if (isset($bedroom) && (strtolower($bedroom) != 'any')) {
            $data['no_to_paginate'] = 1;
        } else if (isset($bedroom_min)) {
            $data['no_to_paginate'] = 1;
        }

        $query_string = $this->input->server('QUERY_STRING');
        if ($query_string != '') {
            $query_arr = explode('&', $query_string);
            foreach ($query_arr as $key => $value) {
                $val = explode('=', $value);
                if ($val[0] == 'page') {
                    unset($query_arr[$key]);
                }
            }
            $query_string = implode('&', $query_arr);
        }
        if (!isset($page)) { //ben
            $page = null;
        }
        if (($page == null) || ($page == 1)) {
            $data['prev_link'] = false;
        } else {
            $data['prev_link'] = "?page=" . ($page - 1) . ($query_string != '') ? '&' . $query_string : '';
        }

        if (($page == null) || ($page == $data['no_to_paginate'])) {
            $data['next_link'] = false;
        } else {
            $data['next_link'] = "?page=" . ($page + 1) . ($query_string != '') ? '&' . $query_string : '';
        }

        $data['page'] = ($page == null) ? 1 : $page;
        $data['query_string'] = $query_string;
        $data['token_name'] = $this->security->get_csrf_token_name();
        $data['token_hash'] = $this->security->get_csrf_hash();

        // echo '<pre>';
        // print_r($data);
        // die;
        $this->load->view('properties_list_view', $data);
    }

    function addToFavorites()
    {
        $response = $this->M_properties->addToFavorite($_POST['property_id']);
        die(json_encode(['response' => $response]));
        // redirect($_SERVER['HTTP_REFERER']);
    }

    function addToViews()
    {
        extract($_POST);
        if ($session_id && $property_id) {
            $rec = $this->db
                ->where('session_id', $session_id)
                ->where('property_id', $property_id)
                ->count_all_results('property_views');
            if ($rec == 0) {
                $this->db
                    ->insert('property_views', [
                        'session_id' => $session_id,
                        'property_id' => $property_id,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
            }
        }
    }

    function details()
    {
        echo json_encode($_POST);
    }

    function reportProperty()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('reason', 'Reason', 'required|trim');
        if ($this->form_validation->run()) {
            if ($this->input->post('reason') != null && ($_POST['reason'] == 'other')) {
                if (empty($_POST['other_reason'])) {
                    die(json_encode(['type' => 'error', 'text' => 'Other Reason is required, if you select choose reason is other']));
                }
            }
            if (!isset($_SESSION['id'])) {
                die(json_encode(['type' => 'error', 'text' => 'Oops! only registered user can report property.']));
            }

            $data = [
                'property_id' => $this->input->post('property_id'),
                'reason' => $this->input->post('reason'),
                'other_reason' => $this->input->post('other_reason') ?? '',
                'user_id' => $_SESSION['id'],
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('reported_property', $data);
            die(json_encode(['type' => 'success', 'text' => 'Property reported.']));
        } else {
            die(json_encode(['type' => 'error', 'text' => $this->form_validation->error_string()]));
        }
    }
}
