<?php
header('Access-Control-Allow-Origin: *');

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'core/MOBO_User.php';
class Users extends MOBO_User
{
    public function __construct()
    {
        parent::__construct();

        if (!isset($_SESSION['id']))
            redirect(site_url('/'));

        $this->only(['agent', 'admin']);
        $this->load->model('M_users');
    }
    public function index()
    {
        if (isset($_GET['email'])) {
            $user = $this->M_users->getUser($_GET['email']);
            $properties = $this->M_users->getUserProperties($_GET['email']);

            if (!$user) {
                redirect('users');
            }

            $this->load->view('user_with_properties', compact('user', 'properties'));
        } else {
            $countries = $this->db->get('country')->result();
            $this->load->view('users', compact('countries'));
        }
    }

    public function property_add()
    {
        if ($this->input->is_ajax_request()) {
            exit(json_encode($this->M_users->property_add()));
        }
        if (isset($_GET['email'])) {
            $data['user'] = $this->M_users->getUser($_GET['email']);
        }

        if (!$data['user']) {
            redirect('users');
        }

        $data['areas'] = $this->M_users->getAllAreas();
        $data['attributes'] = $this->M_users->getAllAttributes();

        $this->load->view('user_add_property', $data);
    }

    public function json()
    {
        $data = $this->M_users->getdata();

        $data['data'] = array_map(
            function ($row) {
                if ($row['status'] == 'active') {
                    $status = '<span class="badge badge-success" style="font-size: unset;">Active</span>';
                } else {
                    $status = '<span class="badge badge-danger" style="font-size: unset;">Inactive</span>';
                }

                if (is_null($row['password'])) {
                    $status = '<span class="badge badge-warning" style="font-size: unset;"><i class="fa fa-envelope-o"></i> Not Verified!</span>';
                }

                $actions = '<div class="btn-group btn-group-sm" role="group">';

                $actions .= '<button type="button" class="btn btn-outline-primary" title="Edit User" onclick="edit(\'' . $row['id'] . '\')">Edit</button>';
                if ($row['status'] == 'active') {
                    $actions .= '<button type="button" class="btn btn-outline-danger" title="Active/Inactive" onclick="changeStatus(\'' . $row['id'] . '\')">Inactive</button>';
                } else {
                    $actions .= '<button type="button" class="btn btn-outline-success" title="Active/Inactive" onclick="changeStatus(\'' . $row['id'] . '\')">Active</button>';
                }

                if (is_null($row['password'])) {
                    $actions .= '<button type="button" class="btn btn-outline-info" title="Verify User" onclick="verifyUser(\'' . $row['id'] . '\')">Verify</button>';
                    $actions .= '<button type="button" class="btn btn-outline-info" title="Resend Verify Email" onclick="resendVerify(\'' . $row['id'] . '\')">Resend Verify Email</button>';
                }
                // $actions .= '<button type="button" class="btn btn-danger" title="Delete User" onclick="del(\'' . $row['id'] . '\')">Delete</button>
                $actions .= '</div>';

                $packages = $row['packages'] ? '<span class="badge badge-info" style="font-size: unset;">' . implode('</span> <span class="badge badge-info" style="font-size: unset;">', array_map('ucfirst', explode(',', $row['packages']))) . '</span>' : 'N/A';

                return [
                    $row['id'],
                    $packages,
                    $row['entries'],
                    $row['posts'],
                    '<a style="color: blue; text-decoration: underline;" href="users?email=' . $row['email'] . '">' . $row['name'] . '</a>',
                    '<a style="color: blue; text-decoration: underline;" href="users?email=' . $row['email'] . '">' . $row['email'] . '</a>',
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
        exit(json_encode($this->M_users->save()));
    }

    public function add_user()
    {
        exit(json_encode($this->M_users->save_user()));
    }

    public function update()
    {
        exit(json_encode($this->M_users->update()));
    }

    public function edit()
    {
        exit(json_encode($this->M_users->edit()));
    }

    public function changeStatus()
    {
        exit(json_encode($this->M_users->changeStatus()));
    }

    function verify()
    {
        exit(json_encode($this->M_users->verifyUser()));
    }

    function resendVerifyEmail()
    {
        exit(json_encode($this->M_users->resendVerifyEmail()));
    }
}
