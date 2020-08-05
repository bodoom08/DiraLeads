<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function index()
    {
        $this->load->model('M_property');
        if (isset($_SESSION['id'])) {
            // if ($_SESSION['subscribe_flag'] == null) {
            //     redirect('pricing');
            // } else {
                // Active Listing
                $no_of_listed_property = $this->db->select('count(*) as nos')
                                            ->where(['user_id' => $_SESSION['id'], 'status' => 'active', 'sold' => 'false'])
                                            ->get('properties')
                                            ->row();

                // Subscribed for no of Packages
                $subscribed_for_packages = $this->db->select('count(*) as nos')
                                            ->where(['user_id' => $_SESSION['id']])
                                            ->group_start()
                                            ->where('start_date <=', date('Y-m-d'))
                                            ->where('end_date >=', date('Y-m-d'))
                                            ->group_end()
                                            ->get('user_packages')
                                            ->row();

                // die($this->db->last_query());

                // No of sold property
                $no_of_sold_property = $this->db->select('count(*) as nos')
                                            ->where(['user_id' => $_SESSION['id'], 'flag' => 'true'])
                                            ->get('properties')
                                            ->row();


                // Bookmarked | wishlisted
                $bookmarked = $this->db->select('count(*) as nos')
                                            ->where(['user_id' => $_SESSION['id']])
                                            ->get('favorites')
                                            ->row();

                // No of Views of the listed property
                $listedPropertyUser = $this->db
                                            ->select('id')
                                            ->where(['user_id' => $_SESSION['id']])
                                            ->get('properties')
                                            ->result();
                $no_of_views = 0;
                foreach ($listedPropertyUser as $property) {
                    $no_of_views += $this->db
                                    ->where('property_id', $property->id)
                                    ->count_all_results('property_views');

                }
                $properties = $this->M_property->getUserProperties();
                $my_properties = $properties['properties'];
                // $this->paginate($properties['all_properties_count']);
                $active_listing             = $no_of_listed_property->nos;
                $subscribed_for_packages    = $subscribed_for_packages->nos;
                $no_of_sold_property        = $no_of_sold_property->nos;
                $bookmarked                 = $bookmarked->nos;
                $no_of_views                = $no_of_views;
                $this->load->view('dashboard', compact('active_listing', 'subscribed_for_packages', 'no_of_sold_property', 'bookmarked', 'no_of_views','my_properties'));
            // }
        } else {
            redirect('login');
        }
    }
}

