<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'core/MOBO_User.php';
class Property extends MOBO_User
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_property');
    }

    public function index()
    {
        $this->load->view('properties');
    }

    public function json()
    {
        $data = $this->M_property->getdata();

        $data['data'] = array_map(
            function ($row) {

                if($row['vn_id']) {
                    if ($row['status'] == 'active') {
                        $status = '<span class="badge badge-success">Active</span>';
                    } else {
                        $status = '<span class="badge badge-secondary">Inactive</span>';
                    }

                    $actions = '<div class="btn-group btn-group-sm" role="group">';
                    // $actions .= '<a href="javascript:void(0)" class="btn btn-info btn-sm" title="Edit User" data-toggle="modal" data-target="#editModal" onclick="edit(\'' . $row['id'] . '\')">Edit</a>';
                    if ($row['status'] == 'active') {
                        $actions .= '<button type="button" class="btn btn-warning" title="Active/Inactive" onclick="changeStatus(\'' . $row['id'] . '\')">Inactive</button>';
                    } else {
                        $actions .= '<button type="button" class="btn btn-success" title="Active/Inactive" onclick="changeStatus(\'' . $row['id'] . '\')">Active</button>';
                    }
                    // $actions .= '<a href="javascript:void(0)" class="btn btn-danger btn-sm" title="Delete User" onclick="del(\'' . $row['id'] . '\')">Delete</a>
                    '</div> ';
                } else {
                    $status = '<span class="badge badge-warning">Missing DID</span>';
                    $actions = '<button type="button" class="btn btn-success btn-sm" title="Resolve DID" onclick="resolveDID(\'' . $row['id'] . '\')">Resolve</button>';
                }

                return [$row['user_name'], $row['for'], $row['type'], $row['area'], $row['price'], $row['available_date'], $status, $actions];
            },
            $data['data'],
            array_keys($data['data'])
        );

        exit(json_encode($data));
    }

    public function changeStatus()
    {
        exit(json_encode($this->M_property->changeStatus()));
    }

    public function resolve_did()
    {
        exit(json_encode($this->M_property->resolveDID()));
    }
}
