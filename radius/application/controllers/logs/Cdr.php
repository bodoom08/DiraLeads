<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'core/MOBO_User.php';
class Cdr extends MOBO_User
{
    public function __construct()
    {
        parent::__construct();
        if(!isset($_SESSION['id']))
            redirect(site_url('/'));
            
        $this->load->model('logs/M_cdr', 'M_cdr');
    }
    public function index()
    {
        $this->load->view('logs/cdr');
    }

    public function json()
    {
        $data = $this->M_cdr->getdata();

        $data['data'] = array_map(
            function ($row) {
                switch ($row['disposition']) {
                    case 'FAILED':
                        if($row['hangup_cause']) {
                            $disposition = '<span class="badge badge-danger">Failed <small>('. ucfirst(str_replace('_', ' ', strtolower($row['hangup_cause']))) .')</small></span>';
                        } else {
                            $disposition = '<span class="badge badge-danger">Failed</span>';
                        }
                        break;

                    case 'ANSWERED':
                        $disposition = '<span class="badge badge-success">Answered</span>';
                        break;

                    case 'NO ANSWER':
                        $disposition = '<span class="badge badge-warning" style="color: white;">No Answer</span>';
                        break;

                    default:
                        $disposition = '<span class="badge badge-info">' . ucfirst(strtolower($row['disposition'])) . '</span>';
                        break;
                }

                return [
                    $row['start_time'],
                    $row['src'],
                    $row['dst'],
                    gmdate('H:i:s', $row['billsec']),
                    $disposition,
                ];
            },
            $data['data'],
            array_keys($data['data'])
        );

        exit(json_encode($data));
    }
}
