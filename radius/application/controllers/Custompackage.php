<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'core/MOBO_User.php';
class Custompackage extends MOBO_User
{
    public function __construct() {
        parent::__construct();       

        if(!isset($_SESSION['id']))
            redirect(site_url('/'));
            
        $this->only(['agent', 'admin']);
        $this->load->model('M_package');
    }
    public function index()
    {
        $configure_package_names = $this->db->get('custom_package_names')->result_array();    
        $configure_package_areas = $this->db->get('custom_package_areas')->result_array();    
        $configure_package_days = $this->db->get('custom_package_months')->result_array();    
        $this->load->view('custom_packages', compact('configure_package_names', 'configure_package_areas', 'configure_package_days'));
    }

    
    public function json()
    {
        $data = $this->M_package->get_package_json();
        global $i;
        $i = 0;

        $data['data'] = array_map(
            function ($row) {

                $actions = '<div class="btn-group btn-group-sm" role="group">';

                $actions .= '<button type="button" class="btn btn-outline-primary" name="edit-btn" title="Edit Package" onclick="edit(\'' . $row['id'] . '\')" data-info='.$row['id'].'>Edit</button>';
                if ($row['status'] == 'active') {
                    $actions .= '<button type="button" class="btn btn-outline-danger" title="Active/Inactive" onclick="changeStatus(\'' . $row['id'] . '\')">Inactive</button>';
                } else {
                    $actions .= '<button type="button" class="btn btn-outline-success" title="Active/Inactive" onclick="changeStatus(\'' . $row['id'] . '\')">Active</button>';
                }
                // $actions .= '<button type="button" class="btn btn-danger" title="Delete User" onclick="del(\'' . $row['id'] . '\')">Delete</button>
                $actions .= '</div>';
                global $i;              
                $i++;
                return [
                    $i,
                    $row['name'],
                    $actions,
                ];
            },
            $data['data'],
            array_keys($data['data'])
        );

        exit(json_encode($data));
    }    
    
    public function add_edit_custom_packages()
    {
        exit(json_encode($this->M_package->save_package()));
    }
    
    public function edit()
    {
        exit(json_encode($this->M_package->edit_package()));
    }

    public function changeStatus()
    {
        exit(json_encode($this->M_package->changeStatus()));
    }

    public function test() {
        $str  = $this->db->where('id', '17')->get('user_packages')->row();
        echo '<pre>';
        print_r(json_decode($str->package));
    }

}
