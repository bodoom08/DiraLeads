<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Preferences extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$_SESSION['id']) {
            redirect('login');
        }
        $this->load->model('M_preferences');
    }
    function index()
    {
        // $data['areas'] = $this->M_preferences->getAllAreas();
        // $this->load->view('preferences', $data);
        $data['user_pref'] = $this->db->select(
            'notification_phone, notification_phone_no, notification_email, notification_email_id, notification_fax, notification_fax_no, notification_frequence')->where('id', $_SESSION['id'])->get('users')->row();
        $this->load->view('user-preferences', $data);
    }

    function json()
    {
        $data = $this->M_preferences->getdata();

        $data['data'] = array_map(
            function ($row) {
                return [
                    $row['title'],
                    $row['for'],
                    $row['price_range'],
                    $row['types'],
                    $row['created_at'],
                ];
            },
            $data['data'],
            array_keys($data['data'])
        );

        exit(json_encode($data));
    }

    function byId($id)
    {
        $invoice = $this->M_preferences->getById($id);

        if ($invoice) {
            $this->load->view('emails/invoice', compact('invoice'));
            echo '<script>window.print()</script>';
        } else {
            show_404();
        }
    }
    function add()
    {
        exit(json_encode($this->M_preferences->save()));
    }
}
