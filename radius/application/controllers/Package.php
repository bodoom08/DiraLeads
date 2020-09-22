<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'core/MOBO_User.php';
class Package extends MOBO_User
{

    function __construct()
    {
        parent::__construct();
        if(!isset($_SESSION['id']))
            redirect(site_url('/'));

        $this->load->model('M_package');
        $this->load->model('M_users');
    }

    public function index()
    {
        // $this->load->view('packages');
        $data['users'] = $this->M_users->getAllUserIds();
        $data['areas'] = $this->M_users->getAllAreas();
        $this->load->view('packages-custom', $data);
    }

    public function json()
    {
        $data = $this->M_package->getdata();

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
                // $actions .= '<button type="button" class="btn btn-danger" title="Delete User" onclick="del(\'' . $row['id'] . '\')">Delete</button>
                '</div>';

                return [$row['name'], ucfirst($row['for']), $row['price'] . '$', $row['validity'] . ' Days', $row['description'], $row['no_of_location_select'], $status, $actions];
            },
            $data['data'],
            array_keys($data['data'])
        );

        exit(json_encode($data));
    }

    public function json_custom_package()
    {
        $data = $this->M_package->getdata_custom_package_json();

        $data['data'] = array_map(
            function ($row) {
                if(strtotime($row['end_date']) >= strtotime(date('Y-m-d'))) {
                    $status = '<div class="btn-group btn-group-sm"><button type="button" class="btn btn-success btn-xs" disabled>Active</button></div>';
                }
                else {
                    $status = '<div class="btn-group btn-group-sm"><button type="button" class="btn btn-danger btn-xs" disabled>Expired</button></div>';
                }

                $validity = date_diff(date_create($row['start_date']), date_create($row['end_date']));
                $validity = $validity->format('%R%a');
                $actions = '<div class="btn-group btn-group-sm" role="group">';                
                $actions .="";
                '</div>';

                $details = "<ul>";
                    $details .= '<li> Invoice ID- '. $row['invoice_id'].'</li>';
                    $details .= '<li> Start Date- <em><strong>'. $row['start_date'].'</strong></em> </li>';
                    $details .= '<li> End Date- <em><strong>'.$row['end_date'].'</strong></em></li>';
                    $details .= '<li> No of area- '.$row['no_of_area'].'</li>';
                    $details .= '<li> Price- '.$row['area_price'].'</li>';
                    $details .= '<li> No of days- '.$row['no_of_days'].'</li>';
                    $details .= '<li> Price- '.$row['days_price'].'</li>';
                    $details .= '<li> Total- '.$row['price'].'</li>';
                $details .= "</ul>";

                return [$row['name'], $row['user_name'], $details, $row['price'] . '$', $validity . ' Day(s)', $row['description'], $row['no_of_area'], $row['no_of_days'], $status];
            },
            $data['data'],
            array_keys($data['data'])
        );

        exit(json_encode($data));
    }

    public function changeStatus()
    {
        exit(json_encode($this->M_package->changeStatus()));
    }

    public function edit()
    {
        exit(json_encode($this->M_package->edit()));
    }

    public function update()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');
        $this->form_validation->set_rules('validity', 'Validity', 'trim|required|numeric');
        $this->form_validation->set_rules('no_of_location_select', 'No Of Location Select', 'trim|required|numeric');

        if($this->form_validation->run()) {
            exit(json_encode($this->M_package->update()));
        }
        else
            die(json_encode(['type' => 'error', 'text' => $this->form_validation->error_string()]));
    }

    public function insert()
    {
        exit(json_encode($this->M_users->addSubscriber()));
    }

    public function getSubscribers() 
    {
        $data = $this->M_users->getAllSubScribers();
        
        $data['data'] = array_map(
            function ($row, $index) {
                $actions = '<a href="javascript:onEditSubscriber('.$row['id'].');" class="btn btn-outline-success">Edit</a>&nbsp;&nbsp;';
                $actions .= '<a href="javascript:onRemoveSubscriber('.$row['id'].');" class="btn btn-outline-danger">Delete</a>';
                
                return [
                    $index + 1,
                    $row['user_id'],
                    $row['email_id'],
                    $row['title'],
                    $row['date_from'],
                    $row['date_to'],
                    $row['bedroom'],
                    $actions
                ];
            },
            $data['data'],
            array_keys($data['data'])
        );
        exit(json_encode($data));
    }

    public function getSubscriberDetail()
    {
        if (!isset($_GET['id'])) 
            exit(json_encode([
                "type"      => "error",
                "text"       => "id is missing"
            ]));

        $subscriber_id = $_GET['id'];
        exit(json_encode([
            "type"      => "success",
            "text"      => $this->M_users->getSubscriberDetail($subscriber_id)
        ]));
    }

    public function removeSubscriber()
    {
        if (!isset($_GET['id']))
            exit(json_encode([
                "type"      => "error",
                "text"      => "Id is missing"
            ]));

        $subscriber_id = $_GET['id'];
        $this->M_users->removeSubscriber($subscriber_id);

        exit(json_encode([
            "type"  => "success",
            "text"  => "Successfully removed"
        ]));
    }

    public function updateSubscriber()
    {
        exit(json_encode($this->M_users->updateSubscriber()));
    }

    // public function del()
    // {
    //     exit(json_encode($this->M_package->del()));
    // }
}
