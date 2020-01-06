<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'core/MOBO_User.php';
class Pages extends MOBO_User
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        if(!isset($_SESSION['id']))
            redirect(site_url('/'));
        $this->load->model('website/M_pages');
    }
    public function index($id = null)
    {
        if ($id && $this->input->method() == 'delete') {
            exit(json_encode($this->M_pages->delete($id)));
        }
        $this->load->view('website/pages');
    }

    public function json()
    {
        $data = $this->M_pages->getdata();

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

    public function make_slug()
    {
        exit(json_encode(['slug' => url_title($this->input->get('title'), '-', true)]));
    }

    public function changeStatus()
    {
        exit(json_encode($this->M_pages->changeStatus()));
    }

    public function edit($id)
    {
        if ($this->input->method() == 'put') {
            exit(json_encode($this->M_pages->update($id)));
        } else {
            $data = $this->M_pages->edit($id);

            $this->load->view('website/page_edit', $data);
        }
    }

    public function new()
    {
        if ($this->input->method() == 'post') {
            exit(json_encode($this->M_pages->add()));
        } else {
            $this->load->view('website/page_new');
        }
    }

    public function update()
    {
        exit(json_encode($this->M_package->update()));
    }
}
