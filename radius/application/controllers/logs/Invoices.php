<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'core/MOBO_User.php';
class Invoices extends MOBO_User
{
    public function __construct() {

        parent::__construct();
        if(!isset($_SESSION['id']))
            redirect(site_url('/'));

        $this->load->model('logs/M_invoices', 'M_invoices');
    }
    function index()
    {
        $this->load->view('logs/invoices');
    }

    function json()
    {
        ini_set('display_errors', 1);
        setlocale(LC_MONETARY, 'en_US');
        $data = $this->M_invoices->getdata();

        $data['data'] = array_map(
            function ($row) {
                $status = '';
                $actions = '<div class="btn-group btn-group-sm" role="group">';                
                // $actions .= '<button type="button" class="btn btn-danger" title="Delete User" onclick="del(\'' . $row['id'] . '\')">Delete</button>
                '</div>';
                if ((date('Y-m-d') <= $row['start_date']) || (date('Y-m-d') >= $row['end_date'])) {
                    $status = '<span class="badge badge-success">Subscribed</span>';
                } else {
                    $status = '<span class="badge badge-danger">Expired</span>';
                }

                if(!empty($row['user_package'])) {
                    $row['package_name'] = $row['user_package_name'];
                    $row['description'] = $row['desc'];
                    $row['package_price'] = $row['price'];
                }

                $invoices = $this->db
                                ->select('id')
                                ->where('user_package_ref_id', $row['pack_id'])
                                ->get('invoices')
                                ->result();
                $link = '<br/><ul><li>Invoices</li>';
                foreach($invoices as $invoice) {
                    $link .= '<li> <a href="'.site_url('logs/invoice/'.$invoice->id).'" target="_blank"><i class="fa fa-external-link"></i></a> </li>';
                }
                $link .= '</ul>';

                return [
                    $row['created_at'] . $link,
                    $row['description'],
                    $row['user_name'],
                    $row['user_email'],
                    $row['user_mobile'],
                    '<b>'.money_format('%n', trim($row['package_price'], '"')).'</b>',
                    '<span class="badge badge-primary">'.trim($row['package_name'], '"').'</span>',
                    $status,
                    

                ];
            },
            $data['data'],
            array_keys($data['data'])
        );

        exit(json_encode($data));
    }

    function byId($id) {
        $invoice = $this->M_invoices->getInvoiceById($id);
        if($invoice) {
            $package = json_decode($invoice->package);
            $price = $package->package_details->price;
            $description = $this->db
                            ->select('description')
                            ->where('id', $invoice->user_package_ref_id)
                            ->order_by('id', 'desc')
                            ->limit(1)
                            ->get('user_packages')
                            ->row();            
            $description = $description->description;            
            $this->load->view('emails/invoice', compact('invoice', 'price', 'description'));
            echo '<script>window.print()</script>';
        } else {
            show_404();
        }
    }
}
