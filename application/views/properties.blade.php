@extends('common.layout')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ site_url('assets/css/lightslider.css') }}" />
<link rel="stylesheet" type="text/css" href="assets/properties/css/bootstrap-select.min.css" />
<link rel="stylesheet" href="assets/properties/css/leaflet.css" type="text/css" />
<link rel="stylesheet" href="assets/properties/css/map.css" type="text/css" />
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.css' />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<link rel='stylesheet'
    href='https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.Default.css' />
<link rel="stylesheet" type="text/css" href="assets/properties/css/jquery.mCustomScrollbar.css" />
<style>
footer, .sub-footer{
    display:none;
}
#content, #content1, #content2, #content3, #content4{
    display:none;
    }
    body{
        overflow: hidden;
    }
    .daterangepicker.show-calendar {
        width: 604px !important;
    }
    #norecord p i {
        font-size: 30px;
        background: #ededed;
        padding: 7px 12px;
        color: #84b95c;
        box-shadow: 1px 1px 1px 0px #d6d6d6;
    } 
    #norecord p.text-head {
        font-size: 30px;
        font-weight: 500;
    }
    #norecord p.text-details {
        width: 28%;
        margin: 0 auto;
        line-height: 25px;
        color: #928f8f;
    }
</style>

@endpush

@section('content')
<div class="map-content content-area container-fluid">
<div class="container-fluid" style="padding:0px 15px;">
    <div class="row">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group search-prop">
                        <input type="search" class="form-control" placeholder="India" name="search_name" id="street_search" value="{{ isset($_GET['street']) && $_GET['street'] != '' ? $_GET['street'] : '' }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" name="button_search">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="filter-btn-mobo">
                    <button id="example1" type="button" class="btn btn-pophover" data-container="body" data-toggle="popover" data-placement="bottom" onclick="changeIcon(this);"> Listing Type  &nbsp;<i class="fa fa-angle-down"></i></button>
                    <div id="content1">
                        <h4>Listing Type</h4>
                        <ul class="main-33">
                            <li class="active">
                               <button class="btn {{ isset($_GET['for']) && $_GET['for'] == 'any' ? 'active' : '' }}" onclick="filter({name: 'for', value: 'any'})">Any</button>
                            </li>
                            <li>
                               <button class="btn {{ isset($_GET['for']) && $_GET['for'] == 'rent' ? 'active' : '' }}" onclick="filter({name: 'for', value: 'rent'})">For Rent</button>
                            </li>
                            <li>
                               <button class="btn {{ isset($_GET['for']) && $_GET['for'] == 'sale' ? 'active' : '' }}" onclick="filter({name: 'for', value: 'sale'})">For Sale</button>
                            </li>
                            <li>
                               <button class="btn {{ isset($_GET['for']) && $_GET['for'] == 'short term rent' ? 'active' : '' }}" onclick="filter({name: 'for', value: 'short term rent'})">For Short Term Rent</button>
                            </li>
                            <div class="clearfix"></div>
                         </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="filter-btn-mobo">
                    <button id="example" type="button" class="btn btn-pophover" data-container="body" data-toggle="popover" data-placement="bottom" onclick="changeIcon(this);"> Property Type  &nbsp;<i class="fa fa-angle-down"></i></button>
                    <div id="content">
                        <h4>Property Type</h4>
                        <ul class="main-34">
                            <li {{ isset($_GET['type']) && $_GET['type'] == 'any' ? 'class=active' : '' }}>
                               <button class="btn {{ isset($_GET['type']) && $_GET['type'] == 'any' ? 'active' : '' }}" onclick="filter({name: 'type', value: 'any'})">
                                  <i class="fa fa-building-o"></i> 
                                  Any
                               </button>
                            </li>
                            <li {{ isset($_GET['type']) && $_GET['type'] == 'house' ? 'class=active' : '' }}>
                               <button class="btn {{ isset($_GET['type']) && $_GET['type'] == 'house' ? 'active' : '' }}" onclick="filter({name: 'type', value: 'house'})">
                                  <i class="fa fa-home"></i> 
                                  House
                               </button>
                            </li>
                            <li {{ isset($_GET['type']) && $_GET['type'] == 'apartment' ? 'class=active' : '' }}>
                                <button class="btn {{ isset($_GET['type']) && $_GET['type'] == 'apartment' ? 'active' : '' }}" onclick="filter({name: 'type', value: 'apartment'})">
                                  <i class="fa fa-building-o"></i>                   
                                  Apartments
                               </button>
                            </li>
                            <li {{ isset($_GET['type']) && $_GET['type'] == 'office' ? 'class=active' : '' }}>
                               <button class="btn {{ isset($_GET['type']) && $_GET['type'] == 'office' ? 'active' : '' }}" onclick="filter({name: 'type', value: 'office'})">
                                  <i class="fa fa-building-o"></i>                   
                                  Office
                               </button>
                            </li>
                            <li {{ isset($_GET['type']) && $_GET['type'] == 'other' ? 'class=active' : '' }}>
                                <button class="btn {{ isset($_GET['type']) && $_GET['type'] == 'other' ? 'active' : '' }}" onclick="filter({name: 'type', value: 'other'})">
                                  <i class="fa fa-home"></i>                   
                                  Other
                               </button>
                            </li>
                               <div class="clearfix"></div>
                            </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="filter-btn-mobo">
                    <button id="example2" type="button" class="btn btn-pophover" data-container="body" data-toggle="popover" data-placement="bottom" onclick="changeIcon(this);"> Price &nbsp;<i class="fa fa-angle-down"></i></button>
                    <div id="content2">

                        <h4>Price</h4>
                        <div class="main-35">
                            <ul class="main-36">
                                <li {{ (isset($_GET['price_min']) && isset($_GET['price_max'])) && ($_GET['price_min'] == '' && $_GET['price_max'] == '') ? 'class=active' : '' }}>
                                   <input type="hidden" id="price_min1" value=''>
                                   <input type="hidden" id="price_max1" value=''>
                                   <button class="btn {{ (isset($_GET['price_min']) && isset($_GET['price_max'])) && ($_GET['price_min'] == '' && $_GET['price_max'] == '') ? 'active' : '' }}" onclick="filter({name: 'price', value: '1'})">
                                   Any
                                   </button>
                                </li>
                                <li {{ (isset($_GET['price_min']) && isset($_GET['price_max'])) && ($_GET['price_min'] == '0' && $_GET['price_max'] == '1000') ? 'class=active' : '' }}>
                                   <input type="hidden" id="price_min2" value='0'>
                                   <input type="hidden" id="price_max2" value='1000'>
                                   <button class="btn {{ (isset($_GET['price_min']) && isset($_GET['price_max'])) && ($_GET['price_min'] == '0' && $_GET['price_max'] == '1000') ? 'active' : '' }}" onclick="filter({name: 'price', value: '2'})">
                                   0 - 1000
                                   </button>
                                </li>
                                <li {{ (isset($_GET['price_min']) && isset($_GET['price_max'])) && ($_GET['price_min'] == '1000' && $_GET['price_max'] == '5000') ? 'class=active' : '' }}>
                                   <input type="hidden" id="price_min3" value='1000'>
                                   <input type="hidden" id="price_max3" value='5000'>
                                   <button class="btn {{ (isset($_GET['price_min']) && isset($_GET['price_max'])) && ($_GET['price_min'] == '1000' && $_GET['price_max'] == '5000') ? 'active' : '' }}" onclick="filter({name: 'price', value: '3'})">
                                   1000 - 5000
                                   </button>
                                </li>
                                <li {{ (isset($_GET['price_min']) && isset($_GET['price_max'])) && ($_GET['price_min'] == '5000' && $_GET['price_max'] == '10000') ? 'class=active' : '' }}>
                                   <input type="hidden" id="price_min4" value='5000'>
                                   <input type="hidden" id="price_max4" value='10000'>
                                   <button class="btn {{ (isset($_GET['price_min']) && isset($_GET['price_max'])) && ($_GET['price_min'] == '5000' && $_GET['price_max'] == '10000') ? 'active' : '' }}" onclick="filter({name: 'price', value: '4'})">
                                   5000 - 10000
                                   </button>
                                </li>
                                <li {{ (isset($_GET['price_min']) && isset($_GET['price_max'])) && ($_GET['price_min'] == '10000' && $_GET['price_max'] == '0') ? 'class=active' : '' }}>
                                   <input type="hidden" id="price_min5" value='10000'>
                                   <input type="hidden" id="price_max5" value='0'>
                                   <button class="btn {{ (isset($_GET['price_min']) && isset($_GET['price_max'])) && ($_GET['price_min'] == '10000' && $_GET['price_max'] == '0') ? 'active' : '' }}" onclick="filter({name: 'price', value: '5'})">
                                   > 10000
                                   </button>
                                </li>
                             </ul>
                            <div class="clearfix"></div>
                            <p class="text-center" style="margin-top: 20px;">Or Select Price Range</p>
                            <div class="input-box-mob" style="margin-left:0px; margin-right:0px;">
                                <div class="row mb-2 align-items-center">
                                    <div class="col-md-5">
                                        <input type="number" class="form-control" placeholder="No Min" name="min" title="No Min"
                                        value="{{ isset($_GET['price_min']) && $_GET['price_min'] != '' ? $_GET['price_min'] : '' }}">
                                    </div>
                                    <div class="col-md-2">to</div>
                                    <div class="col-md-5">
                                        <input type="number" class="form-control" placeholder="No Max" name="max" title="No Max"
                                        value="{{ isset($_GET['price_max']) && $_GET['price_max'] != '' ? $_GET['price_max'] : '' }}">
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button class="btn-md button-theme btn-block" name="pricefilter_button">Filter</button>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter-btn-mobo">
                    <button id="example3" type="button" class="btn btn-pophover" data-container="body" data-toggle="popover" data-placement="bottom" onclick="changeIcon(this);"> Bedrooms &nbsp;<i class="fa fa-angle-down"></i></button>
                    <div id="content3">
                        <h4>Bedrooms</h4>
                        <ul class="main-36">
                            <li {{ isset($_GET['bedroom']) && $_GET['bedroom'] == 'any' ? 'class=active' : '' }}> 
                               <button class="btn {{ isset($_GET['bedroom']) && $_GET['bedroom'] == 'any' ? 'active' : '' }}" onclick="filter({name: 'bedroom', value: 'any'})">
                               Any
                               </button>
                            </li>
                            <li {{ isset($_GET['bedroom']) && $_GET['bedroom'] == '1' ? 'class=active' : '' }}>
                               <button class="btn {{ isset($_GET['bedroom']) && $_GET['bedroom'] == '1' ? 'active' : '' }}" onclick="filter({name: 'bedroom', value: '1'})">
                               1+
                               </button>
                            </li>
                            <li {{ isset($_GET['bedroom']) && $_GET['bedroom'] == '2' ? 'class=active' : '' }}>
                               <button class="btn {{ isset($_GET['bedroom']) && $_GET['bedroom'] == '2' ? 'active' : '' }}" onclick="filter({name: 'bedroom', value: '2'})">
                               2+ 
                               </button>
                            </li>
                            <li {{ isset($_GET['bedroom']) && $_GET['bedroom'] == '3' ? 'class=active' : '' }}>
                               <button class="btn {{ isset($_GET['bedroom']) && $_GET['bedroom'] == '3' ? 'active' : '' }}" onclick="filter({name: 'bedroom', value: '3'})">
                               3+
                               </button>
                            </li>
                            <li {{ isset($_GET['bedroom']) && $_GET['bedroom'] == '4' ? 'class=active' : '' }}>
                               <button class="btn {{ isset($_GET['bedroom']) && $_GET['bedroom'] == '4' ? 'active' : '' }}" onclick="filter({name: 'bedroom', value: '4'})">
                               4+
                               </button>
                            </li>
                            <li {{ isset($_GET['bedroom']) && $_GET['bedroom'] == '5' ? 'class=active' : '' }}>
                               <button class="btn {{ isset($_GET['bedroom']) && $_GET['bedroom'] == '5' ? 'active' : '' }}" onclick="filter({name: 'bedroom', value: '5'})">
                               5+
                               </button>
                            </li>
                            <div class="clearfix"></div>
                         </ul>
                        <div class="clearfix"></div>
                        <p class="text-center">Or Select Bedrooms Range</p>
                        <div class="input-box-mob" style="margin-left:15px; margin-right:15px;">
                            <div class="row mb-2 align-items-center">
                                <div class="col-md-5">
                                    <input type="number" class="form-control" placeholder="No Min" name="min" title="No Min"
                                    value="{{ isset($_GET['bedroom_min']) && $_GET['bedroom_min'] != '' ? $_GET['bedroom_min'] : '' }}">
                                </div>
                                <div class="col-md-2">to</div>
                                <div class="col-md-5">
                                    <input type="number" class="form-control" placeholder="No Max" name="max" title="No Max"
                                    value="{{ isset($_GET['bedroom_max']) && $_GET['bedroom_max'] != '' ? $_GET['bedroom_max'] : '' }}">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button class="btn-md button-theme btn-block" name="bedfilter_button">Filter</button>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="filter-btn-mobo">
                    <button id="example4" type="button" class="btn btn-pophover" data-container="body" data-toggle="popover" data-placement="bottom" onclick="changeIcon(this);"> Sort By &nbsp;<i class="fa fa-angle-down"></i> </button>
                    <div id="content4">
                        <h4>Sort By</h4>
                        <ul class="main-33">
                            <li class="active"> <button class="btn {{ isset($_GET['sort_by']) && $_GET['sort_by'] == 'low-high' ? 'active' : '' }}" onclick="filter({name: 'sort_by', value: 'low-high'})">Low to High</button></li>
                        <li> <button class="btn {{ isset($_GET['sort_by']) && $_GET['sort_by'] == 'high-low' ? 'active' : '' }}" onclick="filter({name: 'sort_by', value: 'high-low'})">High to Low</button></li>
                            <div class="clearfix"></div>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-3 d-none">
                    <div class="input-group search-prop">
                        <input type="text" readonly class="form-control daterangePicker" placeholder="Select Date Range">
                    </div>
                </div>
                <div class="filter-btn-mobo d-none">
                    <button type="button" class="btn btn-pophover" onclick="changeIcon(this);"> More Filter &nbsp;<i class="fa fa-angle-down"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="pull-right btns-area">
                <a href="{{site_url('properties/lists')}}" class="change-view-btn ">List View</a>
                <a href="{{site_url('properties')}}" class="change-view-btn active-view-btn">Map View</i></a>
            </div>
        </div>
    </div>
</div>
    <div class="row d-none" id="norecord">
        <div class="col-lg-12 text-center mt-5">
            <p><i class="fa fa-search" aria-hidden="true"></i></p>
            <p class="text-head">No matching property</p>
            <p class="text-details">There were not any sources matching your search, Please try to modify the search.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7 map-content-sidebar">
            <div class="properties-map-search properties-pad2">              
                <div class="fetching-properties hidden-sm hidden-xs"></div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="row">
                <div id="map"></div>
            </div>
        </div>
    </div>    
</div>



<!-- The Modal -->
<div class="modal custom-modal" id="propertyDetail">
   <div class="modal-dialog">
      <div class="modal-content">
         <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
      
         <!-- Modal body -->
         <div class="modal-body">
         
            <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
            
            </ul>
            <div class="row">
               <div class="col-md-6">
                  <div class="properties-amenities">
                    <h3 class="heading-2">
                        Property ID (<span id="listing_property_id"></span>)
                    </h3>
                     <h3 class="heading-2">
                     Condition
                     </h3>
                     <div class="clearfix"></div>
                     <ul class="amenities" id="propertyDetailAttr">
                        <li>
                           <span style="color: #ff214f" id="propertyDetailPrice" >  </span>
                        </li>
                        <div class="clearfix"></div>
                     </ul>
                     <p><img src="https://diraleads.com/assets/img/c-4.png" alt=""> <span id="propertyDetailStreet"></span> </p>
               
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="properties-amenities">
                     <h3 class="heading-2">
                     Contact
                     </h3>
                     <p><a href="tel:+18475555555"> <i class="fa fa-phone"></i> <span id="propertyDetailMobile"></span></a></p>
                     <p><a href="mailto:info@demo.com"> <i  class="fa fa-envelope"></i> <span id="propertyDetailEmail"></span></a></p>
                  </div>
               </div>
            </div>
            <!-- Properties description start -->
            <div class="properties-description mb-40">
            <h3 class="heading-2 mt-20">
               Description
            </h3>
            <p id="propertyDetailDescription"></p>
            <div id="mapmd" style="height:300px;"></div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@push('scripts')
<script>var csrf_name='<?php $CI= & get_instance(); echo $CI->security->get_csrf_token_name(); ?>';var csrf_hash='<?php echo $CI->security->get_csrf_hash(); ?>';</script>
<script src="assets/properties/js/rangeslider.js"></script>
<script src="assets/properties/js/bootstrap-select.min.js"></script>
<script src="assets/properties/js/jquery.easing.1.3.js"></script>
<script src="assets/properties/js/jquery.scrollUp.js"></script>
<script src="assets/properties/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="assets/properties/js/leaflet.js"></script>
{{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.5.1/leaflet.js'></script> --}}
<script src="assets/properties/js/leaflet-providers.js"></script>
<script src="assets/properties/js/leaflet.markercluster.js"></script>
{{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/leaflet.markercluster.js'></script> --}}
<script src="assets/properties/js/dropzone.js"></script>
<script src="assets/properties/js/slick.min.js"></script>
<script src="assets/properties/js/jquery.filterizr.js"></script>
<script src="assets/properties/js/jquery.magnific-popup.min.js"></script>
<script src="assets/properties/js/maps.js?ref={{ mt_rand(100, 999) }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="assets/properties/js/app.js"></script>
<script  src="{{ site_url('assets/js/lightslider.js') }}"></script>
<script>
var ops = {
    'html':true,    
    sanitize: false,  
    content: function(){
        return $('#content').html();
    }
};

$(function(){
    $('.daterangePicker').daterangepicker();
    $('#example').popover(ops);
});
var ops1 = {
    'html':true, 
    sanitize: false,     
    content: function(){
        return $('#content1').html();
    }
};

$(function(){
    $('#example1').popover(ops1)
});
var ops2 = {
    'html':true,   
    sanitize: false,  
    content: function(){
        return $('#content2').html();
    }
};

$(function(){
    $('#example2').popover(ops2)
});

var ops3 = {
    'html':true, 
    sanitize: false,   
    content: function(){
        return $('#content3').html();
    }
};

$(function(){
    $('#example3').popover(ops3)
});
var ops4 = {
    'html':true, 
    sanitize: false,   
    content: function(){
        return $('#content4').html();
    }
};

$(function(){
    $('#example4').popover(ops4)
});

function changeIcon(el){
   if($(el).children().hasClass("fa-angle-down")){
      $(el).children().removeClass("fa-angle-down");
      $(el).children().addClass("fa-angle-up");
      $(".popover-active").click();
      $(el).removeClass("popover-inactive");
      $(el).addClass("popover-active");
   }else if($(el).children().hasClass("fa-angle-up")){
      $(el).children().removeClass("fa-angle-up");
      $(el).children().addClass("fa-angle-down");
      $(el).removeClass("popover-active");
      $(el).addClass("popover-inactive");
   }
}

function filter(type){
   var form = document.createElement("form");
   var element1 = document.createElement("input");
   var element2 = document.createElement("input");
   form.method = "get";
   form.action = "";
   var price = false;
   var custom_bedroom_filter = false;
   if(type.name == 'street'){

      element1.name = type.name;
      element1.value = $('#street_search').val();

   }else if(type.name == 'price'){
      element1.name = 'price_min';
      element1.value = $('#price_min'+type.value).val();
      element2.name = 'price_max';
      element2.value = $('#price_max'+type.value).val();
      price = true;
      
    }else if(type.name == 'custom_filter_price'){
        type.name = 'price';
        element1.name = 'price_min';
        element1.value = !isNaN(type.value.min) ? type.value.min : '';
        element2.name = 'price_max';
        element2.value = !isNaN(type.value.max) ? type.value.max : '';
        price = true;


   }else if(type.name == 'custom_filter_bedroom'){
      
      element1.name = 'bedroom_min';
      element1.value = !isNaN(type.value.min) ? type.value.min : '';
      element2.name = 'bedroom_max';
      element2.value = !isNaN(type.value.max) ? type.value.max : '';
      custom_bedroom_filter = true;

   }else{

      element1.name = type.name;
      element1.value = type.value;
   }
   
   
   form.appendChild(element1);
   form.appendChild(element2);
   var getParams = <?php echo json_encode($_GET) ?>;
   if(type.name == 'bedroom') {
       delete getParams.bedroom_min;
       delete getParams.bedroom_max;
    }
    
    if(type.name == 'custom_filter_bedroom') {
        delete getParams.bedroom;
    }
    console.log(price);
    console.log(getParams);
    if(price == true) {
        delete getParams.price_max;
    }
    if(price == true) {
        delete getParams.price_min;
    }
    if(custom_bedroom_filter == true) {
        delete getParams.bedroom_min;
        delete getParams.bedroom_max;
    }
    
   $.each( getParams, function( name, value ) {
      if(name != type.name){
         var element = document.createElement("input");
         element.value = value;
         element.name = name;
         form.appendChild(element);
      }
   });
   document.body.appendChild(form);
   form.submit();
}


$(function() {
    var $request;
    var clickPropertyId = '';

    $('body').on('click', '.property-thumbnail', function() {
        // console.log($(this).data('propid'));
        // showDetails(78);
        propid = $(this).data('propid');
        showDetails(propid);
    });

    var initMap = (latLng = [40.71427, -74.00597]) => {
        try {
            map = $('body').find('#mapmd');

            window.mapPicker = L.map('mapmd').setView(latLng, 13);
            L.tileLayer('https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}.png?lang=en', {
                attribution: 'Map Data &copy; <a href="https://wikimediafoundation.org/wiki/Maps_Terms_of_Use">Wikimedia</a>'
            }).addTo(mapPicker);

            window.marker = L.marker(latLng).addTo(mapPicker);
            setTimeout(function(){  window.mapPicker.invalidateSize();  window.mapPicker.setView(latLng, 15);},1000);
            // console.log('if');
        } catch (err) {
            // console.log('else');
            window.mapPicker.panTo(latLng);
            window.marker.setLatLng(latLng);
            setTimeout(function(){  window.mapPicker.invalidateSize();  window.mapPicker.setView(latLng, 15);},1000);
        }
    };
   
   function showDetails(id){
    // if ($request != null) { 
    //     $request.abort();
    //     $request = null;
    // }
    clickPropertyId = id;
    $request = $.ajax({
        type: "post",
        url: "{{ site_url('properties/viewDetails') }}",
        dataType: "json",
        data: {
            property_id: id,
            <?php 
            $CI = & get_instance();
             echo $CI->security->get_csrf_token_name(); ?>: '<?php echo $CI->security->get_csrf_hash(); ?>'
        },
        success: function (res) {
            

            if (res.property.coords) {
                var a = JSON.parse(res.property.coords);
                var coords = a.map(function (x) { 
                return parseFloat(x); 
                });
                initMap(JSON.parse(res.property.coords));
            } else {
                initMap();
            }

            $("#image-gallery").html("");
            $.each( res.property_images, function( key, value ) {
                var base_path = '{{ site_url("uploads/") }}';
                $("#image-gallery").append("<li data-thumb='"+base_path+value.path+"'><img src='"+base_path+value.path+"' /></li>");
            });

            $(".prepends").remove();
            $.each( res.property_attributes, function( key, value ) {
                var icon_path = '{{ site_url("") }}';
                $("#propertyDetailAttr").prepend("<li class='prepends'><img src='"+icon_path+value.icon+"' /> "+value.value+" "+value.text+" </li>");
            });

            $("#propertyDetailPrice").html("$ "+res.property.price);
            $("#propertyDetailMobile").html(res.property.contact_number);
            $("#propertyDetailEmail").html(res.property.email);
            $("#propertyDetailDescription").html(res.property.description);
            $("#propertyDetailStreet").html(res.property.street);

            $('#listing_property_id').html(res.property.id);

            $("#propertyDetail").modal('show');
        }
    });
   }

   $('#propertyDetail').on('shown.bs.modal', function() {
       var session_id = '<?php echo session_id(); ?>';
       console.log(session_id, clickPropertyId);

       $.ajax({
        type: "post",
        url: "{{ site_url('properties/addToViews') }}",
        dataType: "json",
        data: {
            property_id: clickPropertyId,
            session_id,
            <?php 
                $CI = & get_instance();
                echo $CI->security->get_csrf_token_name(); ?>: '<?php echo $CI->security->get_csrf_hash(); ?>'
            },
            success: function (res) {
                

                if (res.property.coords) {
                    var a = JSON.parse(res.property.coords);
                    var coords = a.map(function (x) { 
                    return parseFloat(x); 
                    });
                    initMap(JSON.parse(res.property.coords));
                } else {
                    initMap();
                }

                $("#image-gallery").html("");
                $.each( res.property_images, function( key, value ) {
                    var base_path = '{{ site_url("uploads/") }}';
                    $("#image-gallery").append("<li data-thumb='"+base_path+value.path+"'><img src='"+base_path+value.path+"' /></li>");
                });

                $(".prepends").remove();
                $.each( res.property_attributes, function( key, value ) {
                    var icon_path = '{{ site_url("") }}';
                    $("#propertyDetailAttr").prepend("<li class='prepends'><img src='"+icon_path+value.icon+"' /> "+value.value+" "+value.text+" </li>");
                });

                $("#propertyDetailPrice").html("$ "+res.property.price);
                $("#propertyDetailMobile").html(res.property.contact_number);
                $("#propertyDetailEmail").html(res.property.email);
                $("#propertyDetailDescription").html(res.property.description);
                $("#propertyDetailStreet").html(res.property.street);

                $('#listing_property_id').html(res.property.id);

                $("#propertyDetail").modal('show');
            }
        });
   })

   
   $('button[name="button_search"]').click(function() {
        var e = $.Event("keydown", { keyCode: 13 });
        $('#street_search').trigger(e);
   });
   $('#street_search').keydown(function(event) {
        if (event.which == 13 || event.keyCode == 13) {
            val = $(this).val();            
            filter({name: 'street', value: val});
        }
   });

   //  Custom Bedroom Filter Button
   $('body').on('click', 'button[name="bedfilter_button"]', function() {
    input_box_momb =  $(this).closest('.input-box-mob');
    min = parseInt($(input_box_momb).find('input[name="min"]').val());
    max = parseInt($(input_box_momb).find('input[name="max"]').val());
    if(isNaN(min) || isNaN(max)) {
        alert('Min & Max Value Required');
        return false;
    }
    else if(min > max) {
        alert('Min Value should not be greater than Max Value');
        return false;
    }
    val = {
        min,
        max
    };

    filter({name: 'custom_filter_bedroom', value: val});
   });
   //  Custom Price Filter Button
   $('body').on('click', 'button[name="pricefilter_button"]', function() {
    input_box_momb =  $(this).closest('.input-box-mob');
    min = parseInt($(input_box_momb).find('input[name="min"]').val());
    max = parseInt($(input_box_momb).find('input[name="max"]').val());
    if(isNaN(min) || isNaN(max)) {
        alert('Min & Max Value Required');
        return false;
    }
    else if(min > max) {
        alert('Min Value should not be greater than Max Value');
        return false;
    }
    val = {
        min,
        max
    };

    filter({name: 'custom_filter_price', value: val});
   });
});
   

</script>
@endpush
