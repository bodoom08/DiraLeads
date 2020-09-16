<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'core/MOBO_User.php';
class Property extends MOBO_User
{
    function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['id']))
            redirect(site_url('/'));

        $this->load->model('M_property');
    }

    public function index()
    {
        $this->load->view('properties');
    }

    public function add_property()
    {
        $data['areas'] = $this->M_property->getAllAreas();
        $data['attributes'] = $this->M_property->getAllAttributes();
        $data['users'] = $this->M_property->getAllUsers();
        $this->load->view('submit-property', $data);
    }

    public function property_listing()
    {
        exit(json_encode($this->M_property->property_listing()));
    }

    public function get_virtual_number()
    {
        exit(json_encode($this->M_property->get_virtual_number()));
    }

    public function json()
    {
        $data = $this->M_property->getdata();

        $data['data'] = array_map(
            function ($row) {
                $row['area'] = $row['area'] ?? $row['area_other'];

                if ($row['vn_id']) {
                    if ($row['status'] == 'active') {
                        $status = '<span class="badge badge-success">Active</span>';
                    } else {
                        $status = '<span class="badge badge-secondary">Inactive</span>';
                    }

                    $actions = '<div class="btn-group btn-group-sm" role="group">';
                    // $actions .= '<a href="javascript:void(0)" class="btn btn-info btn-sm" title="Edit User" data-toggle="modal" data-target="#editModal" onclick="edit(\'' . $row['id'] . '\')">Edit</a>';
                    if ($row['status'] == 'active') {
                        $actions .= '<button type="button" class="btn btn-warning" title="Active/Inactive" onclick="changeStatus(\'' . $row['id'] . '\')">Inactive</button><button type="button" class="btn btn-primary" title="Edit Property" onclick="editProperty(' . $row['id'] . ')">Edit</button>';
                    } else {
                        $actions .= '<button type="button" class="btn btn-success" title="Active/Inactive" onclick="changeStatus(\'' . $row['id'] . '\')">Active</button><button type="button" class="btn btn-primary" title="Edit Property" onclick="editProperty(' . $row['id'] . ')">Edit</button>';
                    }
                    // $actions .= '<a href="javascript:void(0)" class="btn btn-danger btn-sm" title="Delete User" onclick="del(\'' . $row['id'] . '\')">Delete</a>
                    '</div> ';
                } else {
                    $status = '<span class="badge badge-warning">Missing DID</span>';
                    $actions = '<button type="button" class="btn btn-success btn-sm" title="Resolve DID" onclick="resolveDID(\'' . $row['id'] . '\')">Resolve</button><button type="button" class="btn btn-primary" title="Edit Property" onclick="editProperty(' . $row['id'] . ')">Edit</button>';
                }
                /*
                 * Created by flag
                 */
                $user_role = ['agent', 'admin'];
                if (in_array($row['user_role'], $user_role))
                    $created_by = '<span class="badge badge-info">' . strtoupper($row['user_role']) . '</span>';
                else
                    $created_by = '';

                $user_info = '<a style="color:blue; text-decoration:underline;" href="users?email=' . $row['user_email'] . '">' . $row['user_id'] . '</a>';

                return [$user_info, $row['user_name'], $row['for'], $row['id'], $row['type'], $row['area'], $row['price'], $row['available_date'], $status, $created_by, $actions];
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

    public function edit()
    {
        if (!$_POST) {
            redirect('property');
        }
        $data['attributes'] = $this->M_property->getAllAttributes();
        $data['areas'] = $this->M_property->getAllAreas();
        $data['property'] = $this->M_property->edit();
        $data['users'] = $this->M_property->getAllUsers();
        $this->load->view('property_edit', $data);
    }

    public function update()
    {
        exit(json_encode($this->M_property->update()));
    }

    public function test()
    {
        $virtualNumber = $this->db
            ->where_not_in('id', "SELECT vn_id FROM properties where vn_id is not null")
            ->get('virtual_numbers')
            ->row();
        echo '<pre>';
        print_r($virtualNumber);
    }

    public function reported()
    {
        $this->load->view('reported_property');
    }

    public function reported_json()
    {
        $data = $this->M_property->getreported();

        $data['data'] = array_map(
            function ($row) {
                $user_info = '<a style="color:blue; text-decoration:underline;" href="users?email=' . $row['user_email'] . '">' . $row['user_name'] . '(' . $row['user_email'] . ')' . '</a>';

                return [$row['id'], $user_info, ucwords($row['reason']), ucwords($row['other_reason'])];
            },
            $data['data'],
            array_keys($data['data'])
        );

        exit(json_encode($data));
    }
}
