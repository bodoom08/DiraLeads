<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'core/MOBO_User.php';
class Widgets extends MOBO_User
{
    public function __construct()
    {
        parent::__construct();
        if(!isset($_SESSION['id']))
            redirect(site_url('/'));
            
        $this->only('admin');
        $this->load->model('website/M_widgets');
    }
    public function index()
    {
        $widgets = $this->M_widgets->getWidgets();
        
        $this->load->view('website/widgets', compact('widgets'));
    }

    public function json()
    {
        $data = $this->M_widgets->getdata();

        $data['data'] = array_map(
            function ($row) {
                if ($row['status'] == 'active') {
                    $status = '<div class="btn-group btn-group-sm"><button type="button" class="btn btn-success btn-xs" disabled>Active</button></div>';
                } else {
                    $status = '<div class="btn-group btn-group-sm"><button type="button" class="btn btn-warning btn-xs" disabled>Inactive</button></div>';
                }
                $actions = '<div class="btn-group btn-group-sm" role="group">';

                $actions .= '<button type="button" class="btn btn-info" title="Edit User" onclick="edit(\'' . $row['id'] . '\')">Edit</button>';
                if ($row['status'] == 'active') {
                    $actions .= '<button type="button" class="btn btn-warning" title="Active/Inactive" onclick="changeStatus(\'' . $row['id'] . '\')">Inactive</button>';
                } else {
                    $actions .= '<button type="button" class="btn btn-success" title="Active/Inactive" onclick="changeStatus(\'' . $row['id'] . '\')">Active</button>';
                }
                $actions .= '<button type="button" class="btn btn-danger" title="Delete Page" onclick="del(\'' . $row['id'] . '\')">Delete</button></div>';

                return [$row['title'], $row['slug'] . ' <a target="_blank" href="/' . $row['slug'] . '"><i class="fa fa-external-link"></i></a>', $status, $actions];
            },
            $data['data'],
            array_keys($data['data'])
        );

        exit(json_encode($data));
    }

    public function edit($name = '')
    {
        if ($this->input->method() == 'put') {
            exit(json_encode($this->M_widgets->update($name)));
        } else {
            $data = $this->M_widgets->edit($name);

            $this->load->view('website/widget_edit', $data);
        }
    }

    public function new()
    {
        if ($this->input->method() == 'post') {
            exit(json_encode($this->M_widgets->add()));
        } else {
            $this->load->view('website/page_new');
        }
    }

    public function update()
    {
        exit(json_encode($this->M_package->update()));
    }
}
