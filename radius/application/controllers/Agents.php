<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'core/MOBO_User.php';
class Agents extends MOBO_User
{
    public function __construct() {
        parent::__construct();

        if(!isset($_SESSION['id']))
            redirect(site_url('/'));
            
        $this->load->model('M_agents');
    }
    public function index()
    {
        if (!$_SESSION['id']) {
            redirect('login');
        }
        $this->load->view('agents');
    }
    
    public function json()
    {
        $data = $this->M_agents->getdata();

        $data['data'] = array_map(
            function ($row) {
                if ($row['status'] == 'active') {
                    $status = '<span class="badge badge-success" style="font-size: unset;">Active</span>';
                } else {
                    $status = '<span class="badge badge-danger" style="font-size: unset;">Inactive</span>';
                }
                
                if(is_null($row['password'])) {
                    $status = '<span class="badge badge-warning" style="font-size: unset;"><i class="fa fa-envelope-o"></i> Not Verified!</span>';
                }

                $actions = '<div class="btn-group btn-group-sm" role="group">';

                $actions .= '<button type="button" class="btn btn-outline-primary" title="Edit User" onclick="edit(\'' . $row['id'] . '\')">Edit</button>';
                if ($row['status'] == 'active') {
                    $actions .= '<button type="button" class="btn btn-outline-danger" title="Active/Inactive" onclick="changeStatus(\'' . $row['id'] . '\')">Inactive</button>';
                } else {
                    $actions .= '<button type="button" class="btn btn-success" title="Active/Inactive" onclick="changeStatus(\'' . $row['id'] . '\')">Active</button>';
                }
                // $actions .= '<button type="button" class="btn btn-danger" title="Delete User" onclick="del(\'' . $row['id'] . '\')">Delete</button>
                '</div>';

                return [
                    $row['approval'],
                    $row['entries'],
                    $row['resolved'],
                    $row['name'],
                    $row['email'],
                    $row['mobile'],
                    $status,
                    $actions,
                ];
            },
            $data['data'],
            array_keys($data['data'])
        );

        exit(json_encode($data));
    }
    
    public function add()
    {
        exit(json_encode($this->M_agents->save()));
    }
    
    public function update()
    {
        exit(json_encode($this->M_agents->update()));
    }
    
    public function edit()
    {
        exit(json_encode($this->M_agents->edit()));
    }

    public function changeStatus()
    {
        exit(json_encode($this->M_agents->changeStatus()));
    }
}
