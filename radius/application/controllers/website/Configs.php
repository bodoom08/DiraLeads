<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'core/MOBO_User.php';
class Configs extends MOBO_User
{
    public function __construct(Type $var = null)
    {
        parent::__construct();
        if(!isset($_SESSION['id']))
            redirect(site_url('/'));
        $this->load->model('website/M_configs');
    }

    public function index($id = null)
    {
        if ($id && $this->input->method() == 'delete') {
            exit(json_encode($this->M_menus->delete($id)));
        }

        $data = $this->M_configs->getAll();

        $this->load->view('website/configs', $data);
    }

    public function update()
    {
        exit(json_encode($this->M_configs->update()));
    }
}
