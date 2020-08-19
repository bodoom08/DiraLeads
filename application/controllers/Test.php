<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_property');
    }

    function index()
    {
        if (!isset($_SESSION['id'])) {
            redirect('login');
        }
        $data['areas'] = $this->M_property->getAllAreas();
        $properties = $this->M_property->getUserProperties();
        $data['my_properties'] = $properties['properties'];
        $this->paginate($properties['all_properties_count']);

        $this->load->view('test', $data);
    }

    public function paginate($total_properties)
    {
        $this->load->library('pagination');
        $config['base_url'] = base_url('my_properties');
        $config['total_rows'] = $total_properties;
        $config['per_page'] = 10;
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

    public function edit()
    {
        if (!$_POST) {
            redirect('my_properties');
        }
        if($_POST['forDate']){
           $_SESSION['forDate'] = $_POST['forDate'];
        }else{
             $_SESSION['forDate'] = '';
        }
        // echo $_SESSION['forDate'];die();
        $data['attributes'] = $this->M_property->getAllAttributes();
        $data['areas'] = $this->M_property->getAllAreas();
        $data['property'] = $this->M_property->edit();
		$data['packagenames'] = $this->M_property->getCustomPackageNames();
        // echo '<pre>';
        // print_r($data);die;
        $this->load->view('property_edit', $data);
    }

    public function update()
    {
        exit(json_encode($this->M_property->update()));
    }

    public function change_status()
    {
        exit(json_encode($this->M_property->change_status()));
    }

    public function del()
    {
        exit(json_encode($this->M_property->delete()));
    }
    
    public function mark_sold() {
        exit(json_encode($this->M_property->mark_sold()));
    }
}
