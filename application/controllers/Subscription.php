<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subscription extends MOBO_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->userOnly();
        $this->load->model('M_subscription');
        $this->load->model('M_preferences');
        $this->load->model('M_property');
    }
    public function index()
    {
        $data['current'] = $this->M_subscription->getThisSubscription();
        $this->load->view('my_subscription', $data);
    }

    public function user() {
        $data['areas'] = $this->M_preferences->getAllAreas();
        $this->load->view('user_subscriptions', $data);
    }

    function json()
    {
        $data = $this->M_subscription->getdata();

        $data['data'] = array_map(
            function ($row) {

                $actions = '<div class="btn-group btn-group-sm" role="group">';
                
                if(strtotime(date('Y-m-d')) > strtotime($row['end_date'])) { // only enable renew button if package expired
                    $actions .= '<button type="button" class="btn btn-outline-success" name="edit-btn" title="Renew Package" onclick="renew(\'' . $row['id'] . '\')" data-info='.htmlspecialchars(json_encode(["ref_id" => $row['id'] ]), ENT_QUOTES, 'UTF-8').'>Renew</button>';
                }
                else {
                    $actions .= '<button type="button" class="btn btn-outline-info" name="edit-btn" title="Edit Area Info" onclick="editarea(\'' . $row['id'] . '\')" data-info='.htmlspecialchars(json_encode(["ref_id" => $row['id'] ]), ENT_QUOTES, 'UTF-8').'>Edit Area Info</button><button type="button" class="btn btn-outline-success" name="edit-btn" title="Renew Package" onclick="renew(\'' . $row['id'] . '\')" data-info='.htmlspecialchars(json_encode(["ref_id" => $row['id'] ]), ENT_QUOTES, 'UTF-8').'>Renew</button><button type="button" class="btn btn-outline-primary" name="edit-btn" title="Modify Package" onclick="edit(\'' . $row['id'] . '\')" data-info='.htmlspecialchars(json_encode(["ref_id" => $row['id'] ]), ENT_QUOTES, 'UTF-8').'>Modify</button>';
                    
                }
                $actions .= '</div>';
                
                if(strtotime(date('Y-m-d')) < strtotime($row['start_date']))
                    $actions = '';
                
                $row['start_date'] = date('j<\s\u\p>S</\s\u\p> M Y', strtotime($row['start_date']));
                $row['end_date'] = date('j<\s\u\p>S</\s\u\p> M Y', strtotime($row['end_date']));

                return [
                    // $row['id'],
                    // $row['package_id'],
                    $row['package_name'],
                    $row['validity'],
                    $row['no_of_area'],
                    $row['price'],
                    $row['start_date'],
                    $row['end_date'],
                    $actions,
                ];
            },
            $data['data'],
            array_keys($data['data'])
        );

        exit(json_encode($data));
    }

    function manage_package_area_info() {        
        ini_set('display_errors', 1);
        extract($_POST);
        $data['user_pref'] = $this->db->select(
            'notification_phone, notification_phone_no, notification_email, notification_email_id, notification_fax, notification_fax_no, notification_frequence')->where('id', $_SESSION['id'])->get('users')->row();
        $data['areas'] = $this->M_preferences->getAllAreas();
        $data['attributes'] = $this->M_property->getAllAttributes();
        $subscribe_record = json_decode($subscribe_info);
        $user_packages = $this->db
                                    ->select('no_of_area, for, short_term_available_date')
                                    ->where(['id' => $package_table_id, 'user_id' => $_SESSION['id']])
                                    ->get('user_packages')
                                    ->row();
        $data['user_packages'] = $user_packages;
        $user_package_pref = $this->db
                                    ->select('id, area_ids, types, price_min, price_max')
                                    ->where(['user_package_ref_id' => $package_table_id, 'user_id' => $_SESSION['id']])
                                    ->order_by('id', 'asc')
                                    ->get('user_package_area_preferences')
                                    ->result();
        $data['user_package_pref'] = $user_package_pref;
        if(isset($user_package_pref[0]->id)) {
            foreach($user_package_pref as $row) {
                $data['user_package_pref_attrs'][] = $this->db
                                            ->select('area_id, attribute_id, value')
                                            ->where(['user_package_pref_id' => $row->id])
                                            ->get('user_package_preference_attribute_values')
                                            ->result_array();
            }
        }
        else {
            $data['user_package_pref_attrs'] = [];
        }
        $data['input_disable'] = 'false';
        $subscribe_info = [];
        $subscribe_info['ref_id'] = $package_table_id;
        $subscribe_info['area_select_noof'] = $user_packages->no_of_area;
        $subscribe_info['pack_name'] = $user_packages->for;
        $subscribe_info['short_term_available_date'] = $user_packages->short_term_available_date;
        $subscribe_info = json_encode($subscribe_info);
        $data['subscribe_info']  = $subscribe_info;
        // echo '<pre>';
        // print_r($data);
        $this->load->view('package_area_pref_edit', $data);
    }

    // public function more_package_subscription()
    // {
    //     if (!$_POST) {
    //         redirect('subscription');
    //     }
    //     array_walk_recursive($_POST, 'trim');
    //     extract($this->input->post());
    //     $data['package_ids'] = explode(',', $package_ids);
    //     $data['packages'] = $this->M_subscription->getAllPackages();
    //     $this->load->view('pricing_plans', $data);
    // }
}
