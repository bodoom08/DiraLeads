<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoices extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        if(!$_SESSION['id']) {
            redirect('login');
        }
        $this->load->model('M_invoices');
    }
    function index()
    {
        $this->load->view('invoices');
    }

    function json()
    {
        ini_set('display_errors', 1);
        $data = $this->M_invoices->getdata();

        $data['data'] = array_map(
            function ($row) {
                if ($row['result'] == 'Approved') {
                    $status = '<span class="badge badge-success">Approved</span>';
                } else {
                    $status = '<span class="badge badge-danger">'.$row['status'].'</span>';
                }

                $actions = '<div class="btn-group btn-group-sm" role="group">';

                $actions .= '<button type="button" class="btn btn-outline-primary" title="Edit User" onclick="edit(\'' . $row['id'] . '\')">Edit</button>';
                if ($row['status'] == 'active') {
                    $actions .= '<button type="button" class="btn btn-outline-danger" title="Active/Inactive" onclick="changeStatus(\'' . $row['id'] . '\')">Inactive</button>';
                } else {
                    $actions .= '<button type="button" class="btn btn-success" title="Active/Inactive" onclick="changeStatus(\'' . $row['id'] . '\')">Active</button>';
                }
                // $actions .= '<button type="button" class="btn btn-danger" title="Delete User" onclick="del(\'' . $row['id'] . '\')">Delete</button>
                '</div>';

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
                    $link .= '<li> <a href="'.site_url('invoice/'.$invoice->id).'" target="_blank"><i class="fa fa-external-link"></i></a> </li>';
                }
                $link .= '</ul>';

                return [
                    $row['created_at'] . $link,
                    $row['description'],
                    '<b>'.money_format('%n', trim($row['package_price'], '"')).'</b>',
                    '<span class="badge badge-primary">'.trim($row['package_name'], '"').'</span>',
                    $status
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

    function paymentsuccess() {
        $invoice_id = $this->session->flashdata('payment_ref');
        // $invoice_id = '9ce82822c1698ef6279986b126d5ebae36c91f';
        if(empty($invoice_id))
            show_404();

        $invoice_dtls = $this->db->where(['invoice_id' => $invoice_id])->get('user_packages')->row();
        if(empty($invoice_dtls))
            show_404();
        else {
            $invoice = $this->M_invoices->getById($invoice_dtls->invoice_id);
            $package = json_decode($invoice->package);
            $price = $package->package_details->price;
            $user_info = $this->db->where('id', $_SESSION['id'])->get('users')->row();
            $this->load->view('emails/invoice', compact('invoice', 'user_info', 'price'));
            
        }
    }
}
