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
        // $this->load->view('user-favourites');
        $this->load->view('user-favourites-list');
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

    function json_data() {
        $favorites = $this->db
        ->select('property_id')
        ->where('user_id', $_SESSION['id'])
        ->get('favorites')
        ->result_array();
           if(count($favorites) == 0){
            $res = '<div class="col-lg-12 text-center mt-5 dashboard_fav">
                      <p><i class="fa fa-search" aria-hidden="true"></i></p>
                      <h5 class="text-head">No rentals marked as "Favorites"</h5>
                      <p>Add any property to your list of “Favorites” by clicking on the rental’s ♡ icon</p>
                      </p>
                  </div>';
            die($res);
        }
        $proprty_id = array_column($favorites, 'property_id');
        $properties = $this->db->where_in('id', $proprty_id)->get('properties')->result_array();


        $attributes =  $this->db
                ->select('a.text,a.icon,b.property_id,b.attribute_id,b.value ')
                ->where('a.id = b.attribute_id')
                ->where_in('b.property_id', $proprty_id)
                ->get('property_attribute_values b,property_attributes a')
                ->result_array();

        $images = $this->db
            ->select('property_id, path')
            ->group_by('property_id')
            ->get('property_images')
            ->result_array();
        $images = array_column($images, 'path', 'property_id');
        array_walk($properties, function (&$property) use ($attributes, $images) {
            $property['images'] = $images[$property['id']] ?? '';
            $keys = array_keys(array_column($attributes, 'property_id'), $property['id']);
            $property['attributes'] = array_map(function ($key) use ($attributes) {
                return $attributes[$key];
            }, $keys);
        });

        $res = '';


        if(intval(count($properties)) < 1)
            $res = '<div class="col-lg-12 text-center mt-5" id="norecord">
                <p><i class="fa fa-search" aria-hidden="true"></i></p>
                <p class="text-head">No matching property</p>
                <p class="text-details">There were not any sources matching your search, Please try to modify the search.</p>
            </div>';
        else {
            foreach ($properties as $property) {
                $area_key = array_search('Area', array_column($property['attributes'], 'text'));
                $room_key = array_search('Bedroom', array_column($property['attributes'], 'text'));
                $bathroom_key = array_search('Bathroom', array_column($property['attributes'], 'text'));
                $garrage_key = array_search('Garrage', array_column($property['attributes'], 'text'));
                $sold = $property['sold'];
    
                $res .= '<div class="col-md-4 col-lg-4">
                            <div class="item">
                             <div class="feat_property">
                                <div class="thumb" data-toggle="modal" data-target="#Properties-popup" onclick="showDetails('.$property['id'].')">
                                    <img class="img-whp" src="'.site_url('/').'uploads/'.$property['images'].'" alt="properties">
                                    <div class="thmb_cntnt">
                                        <a class="fp_price" href="#">$'.$property['price'].'<small>/month</small></a>
                                    </div>
                                </div>
                    <div class="details">
                    <div class="tc_content">
                        <p class="text-thm">Apartment for '.$property['for'].'</p>
                        <p><span class="flaticon-placeholder"></span> '.$property['street'].'</p>
            <ul class="prop_details mb0">';
            if(is_numeric($room_key)){
            $res .='<li class="list-inline-item"><a href="#">Beds: '.$property['attributes'][$room_key]['value'].'</a></li>';
            } 
            if(is_numeric($bathroom_key)){
            $res .='<li class="list-inline-item"><a href="#">Baths: '.$property['attributes'][$bathroom_key]['value'].'</a></li>';
            }
            if(is_numeric($area_key)){
            $res .='<li class="list-inline-item"><a href="#">Sq Ft: '.$property['attributes'][$area_key]['value'].'</a></li>';
            }
            $res .='<li>
            <form action="'.site_url('properties/addToFavorites').'" id="favForm" method="post">
               <input type="hidden" name="property_id" value="'.$property['id'].'">
                <input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'">
               <button type="button" class="favLinkButton favrite_remove" style="background-color: #F7F7F7;border:none;">';
               $match = false;
               foreach ($favorites as $item){
               if ($item['property_id'] == $property['id']){
               $match = true;
              }}
               if ($match){
               $res .='<i class="fa fa-heart fa-lg" style="color:red;"></i>';
               }else{
               $res .= '<i class="fa fa-heart-o fa-lg"></i>';
              }
              $res .= '</button>
            </form> 
         </li>';
            $res .='</ul>
                    </div>
                </div>
             </div>
        </div>
    </div>';
            }
            
        }
        die($res);
    }

    function json_dashboard_data() {
        $favorites = $this->db
        ->select('property_id')
        ->where('user_id', $_SESSION['id'])
        ->get('favorites')
        ->result_array();
              if(count($favorites) == 0){
            $res = '<div class="col-lg-12 text-center mt-5 dashboard_fav">
                      <p><i class="fa fa-search" aria-hidden="true"></i></p>
                      <h5 class="text-head">No rentals marked as Favorite</h5>
                      <p>Add rentals to Your Favorites by clicking on</p> <p>the rentals Favorite icon.</p>
                      </p>
                  </div>';
            die($res);
        }
        $proprty_id = array_column($favorites, 'property_id');
        $properties = $this->db->where_in('id', $proprty_id)->get('properties')->result_array();


        $attributes =  $this->db
                ->select('a.text,a.icon,b.property_id,b.attribute_id,b.value ')
                ->where('a.id = b.attribute_id')
                ->where_in('b.property_id', $proprty_id)
                ->get('property_attribute_values b,property_attributes a')
                ->result_array();

        $images = $this->db
            ->select('property_id, path')
            ->group_by('property_id')
            ->get('property_images')
            ->result_array();
        $images = array_column($images, 'path', 'property_id');
        array_walk($properties, function (&$property) use ($attributes, $images) {
            $property['images'] = $images[$property['id']] ?? '';
            $keys = array_keys(array_column($attributes, 'property_id'), $property['id']);
            $property['attributes'] = array_map(function ($key) use ($attributes) {
                return $attributes[$key];
            }, $keys);
        });

        $res = '';


        if(intval(count($properties)) < 1)
            $res = '<div class="col-lg-12 text-center mt-5" id="norecord">
                <p><i class="fa fa-search" aria-hidden="true"></i></p>
                <p class="text-head">No matching property</p>
                <p class="text-details">There were not any sources matching your search, Please try to modify the search.</p>
            </div>';
        else {
            foreach ($properties as $key=>$property) {
                if($key < 3 ){
                $area_key = array_search('Area', array_column($property['attributes'], 'text'));
                $room_key = array_search('Bedroom', array_column($property['attributes'], 'text'));
                $bathroom_key = array_search('Bathroom', array_column($property['attributes'], 'text'));
                $garrage_key = array_search('Garrage', array_column($property['attributes'], 'text'));
                $sold = $property['sold'];
    
                $res .= '<div class="col-md-3 col-lg-3">
                            <div class="item">
                             <div class="feat_property">
                                <div class="thumb" data-toggle="modal" data-target="#Properties-popup" onclick="showDetails('.$property['id'].')">
                                    <img class="img-whp" src="'.site_url('/').'uploads/'.$property['images'].'" alt="properties">
                                    <div class="thmb_cntnt">
                                        <a class="fp_price" href="#">$'.$property['price'].'<small>/month</small></a>
                                    </div>
                                </div>
                    <div class="details">
                    <div class="tc_content">
                        <p class="text-thm">Apartment for '.$property['for'].'</p>
                        <p><span class="flaticon-placeholder"></span> '.$property['street'].'</p>
            <ul class="prop_details mb0">';
            if(is_numeric($room_key)){
            $res .='<li class="list-inline-item"><a href="#">Beds: '.$property['attributes'][$room_key]['value'].'</a></li>';
            } 
            if(is_numeric($bathroom_key)){
            $res .='<li class="list-inline-item"><a href="#">Baths: '.$property['attributes'][$bathroom_key]['value'].'</a></li>';
            }
            if(is_numeric($area_key)){
            $res .='<li class="list-inline-item"><a href="#">Sq Ft: '.$property['attributes'][$area_key]['value'].'</a></li>';
            } $res .='<li>
            <form action="'.site_url('properties/addToFavorites').'" id="favForm" method="post">
               <input type="hidden" name="property_id" value="'.$property['id'].'">
                <input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'">
               <button type="button" class="favLinkButton favrite_remove" style="background-color: #F7F7F7;border:none;">';
               $match = false;
               foreach ($favorites as $item){
               if ($item['property_id'] == $property['id']){
               $match = true;
              }}
               if ($match){
               $res .='<i class="fa fa-heart fa-lg" style="color:red;"></i>';
               }else{
               $res .= '<i class="fa fa-heart-o fa-lg"></i>';
              }
              $res .= '</button>
            </form>
         </li>';
            $res .='</ul>
                    </div>
                </div>
             </div>
        </div>
    </div>'
    ;
            }
        }

            
$res .= '<div class="col-md-3 col-lg-3">
        <a href="favourites"><div class="item all-sec">
            <div class="feat_property">
                <div class="details">
                    <div class="tc_content">
                        <h4>View All</h4>
                    </div>
                </div>
            </div>
        </div></a>
    </div>';
        }
        die($res);
    }
}
