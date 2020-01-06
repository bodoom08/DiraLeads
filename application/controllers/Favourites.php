<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Favourites extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$_SESSION['id']) {
            redirect('login');
        }
        $this->load->model('M_favourites');
    }
    function index()
    {
        $this->load->view('user-favourites');
    }

    function json()
    {
        $data = $this->M_favourites->getdata();

        $data['data'] = array_map(
            function ($row) {
                $list = '<ul>';
                $list .= '<li><b>For:</b> '.$row['for'].'</li>';
                $list .= '<li><b>Type:</b> '.$row['type'].'</li>';
                $list .= '<li><b>Street:</b> '.$row['street'].'</li>';
                $list .= '<li><b>House Number:</b> '.$row['house_number'].'</li>';
                $list .= '<li><b>Price:</b> '.$row['price'].'</li>';
                $list .= '<li><b>Description:</b> '.$row['description'].'</li>';
                $list .= '</ul>';
                return [
                    $row['title'],
                    $list,
                    $row['created_at'],
                ];
            },
            $data['data'],
            array_keys($data['data'])
        );

        exit(json_encode($data));
    }

}
