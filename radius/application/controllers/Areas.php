<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'core/MOBO_User.php';
class Areas extends MOBO_User
{
    public function __construct() {
        parent::__construct();       

        if(!isset($_SESSION['id']))
            redirect(site_url('/'));
        $this->only(['agent', 'admin']);
        $this->load->model('M_property');
        $this->load->model('M_area');
    }
    public function index()
    {
        $mainareas = $this->M_property->getMainAreas();
        $subareas = $this->M_property->getSubAreas();
        $allareas = $this->M_property->getAllAreas();
        
        $this->load->view('areas', compact('mainareas', 'subareas', 'allareas'));
    }

    
    public function json()
    {
        $data = $this->M_area->getdata();
        global $mainareas, $allareas;
        $mainareas = $this->M_property->getMainAreas();
        $allareas = $this->M_property->getAllAreas();

        $data['data'] = array_map(
            function ($row) {
                
                $mainarea = '';
                if($row['area_id'] != null) {
                    global $allareas;         
                    foreach($allareas as $value) {
                        if($value['id'] == $row['area_id']) {
                            $mainarea = $value['title'];
                            break;
                        }
                    }
                }
                

                $actions = '<div class="btn-group btn-group-sm" role="group">';

                $actions .= '<button type="button" class="btn btn-outline-primary" name="edit-btn" title="Edit Area" onclick="edit(\'' . $row['id'] . '\',\'' . htmlspecialchars(json_encode(["mainarea_id" => !empty($mainarea) ? $row['area_id'] : ""]), ENT_QUOTES, 'UTF-8') . '\')" data-info='.htmlspecialchars(json_encode(["mainarea_id" => !empty($mainarea) ? $row['area_id'] : ""]), ENT_QUOTES, 'UTF-8').'>Edit</button>';
                // if ($row['status'] == 'active') {
                //     $actions .= '<button type="button" class="btn btn-outline-danger" title="Active/Inactive" onclick="changeStatus(\'' . $row['id'] . '\')">Inactive</button>';
                // } else {
                //     $actions .= '<button type="button" class="btn btn-outline-success" title="Active/Inactive" onclick="changeStatus(\'' . $row['id'] . '\')">Active</button>';
                // }
                // $actions .= '<button type="button" class="btn btn-danger" title="Delete User" onclick="del(\'' . $row['id'] . '\')">Delete</button>
                $actions .= '</div>';

                $mainarea_label = !empty($mainarea) ? '<span class="badge badge-info" style="font-size: unset;">'.$mainarea.'</span>' : '';

                return [
                    $row['title'],
                    $mainarea_label,
                    $actions,
                ];
            },
            $data['data'],
            array_keys($data['data'])
        );

        exit(json_encode($data));
    }
    
    
    public function add_area()
    {
        exit(json_encode($this->M_area->save_area()));
    }
    
    public function update()
    {
        exit(json_encode($this->M_area->update()));
    }
    
    public function edit()
    {
        exit(json_encode($this->M_area->edit()));
    }

    public function changeStatus()
    {
        exit(json_encode($this->M_users->changeStatus()));
    }
}
