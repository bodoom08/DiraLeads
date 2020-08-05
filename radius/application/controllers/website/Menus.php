<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'core/MOBO_User.php';
class Menus extends MOBO_User
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        if(!isset($_SESSION['id']))
            redirect(site_url('/'));
            
        $this->load->model('website/M_menus');
    }

    public function index($id = null)
    {
        if ($id && $this->input->method() == 'delete') {
            exit(json_encode($this->M_menus->delete($id)));
        }

        $data = $this->M_menus->getAll();

        $this->load->view('website/menus', compact('data'));
    }

    public function changeStatus()
    {
        exit(json_encode($this->M_pages->changeStatus()));
    }

    public function edit($id)
    {
        if ($this->input->method() == 'put') {
            exit(json_encode($this->M_menus->update($id)));
        } else {
            $data = $this->M_menus->edit($id);

            $data['positions'] = $this->M_menus->getPositions();

            $this->load->view('website/menu_edit', $data);
        }
    }

    public function new()
    {
        if ($this->input->method() == 'post') {
            exit(json_encode($this->M_menus->add()));
        } else {
            $positions = $this->M_menus->getPositions();
            $this->load->view('website/menu_new', compact('positions'));
        }
    }

    public function update_pos($posId)
    {
        exit(json_encode($this->M_menus->update_pos($posId)));
    }
}
