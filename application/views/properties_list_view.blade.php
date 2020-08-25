@extends('common.layout')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ site_url('assets/css/lightslider.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ site_url('assets/properties/css/bootstrap-select.min.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="{{ site_url('assets/properties/css/leaflet.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ site_url('assets/properties/css/map.css') }}" />
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.css' />
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.Default.css' />
<link rel="stylesheet" type="text/css" href="{{ site_url('assets/properties/css/jquery.mCustomScrollbar.css') }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<style>
    #content,
    #content1,
    #content2,
    #content3,
    #content4 {
        display: none;
    }

    .daterangepicker.show-calendar {
        width: 604px !important;
    }

    /* Search Not found */
    #norecord p i {
        font-size: 30px;
        padding: 7px 12px;
        color: #84b95c;
    }

    #norecord p.text-head {
        font-size: 30px;
        font-weight: 500;
    }

    #norecord p.text-details {
        margin: 0 auto;
        line-height: 25px;
        color: #928f8f;
    }
</style>

@endpush

@section('content')
<?php
if (!isset($_GET['for'])) { //ben
    $for = 'rent';
} else {
    $for = $_GET['for'];
}
if (strpos($for, 'short term rent') !== false) {
    $shortTermFor = true;

    $arrInput = explode('&', $for);
    $fromdate = explode('=', $arrInput[1]);
    if ($fromdate) {
        $fromdate = $fromdate[1];
    } else {
        $fromdate = '';
    }
    $todate = explode('=', $arrInput[2]);
    if ($todate) {
        $todate = $todate[1];
    } else {
        $todate = '';
    }
} else {
    $shortTermFor = false;
    $fromdate = '';
    $todate = '';
}

?>
<!--   <div class="explore-properity-banner">
      <div class="container">
         <div class="inner-explore-banner">
            <div class="heading-sec">
               <p>Find Your Properties In Your City</p>
               <h2>Explor Properties</h2>
            </div>
         </div>
      </div>
   </div> -->

<div class="explore-search">
    <div class="container">
        <div class="inner-search">
            <div class="find-search-box">
                <input type="search" name="" id="street_search" placeholder="e.g- Brooklyn" value={{ isset($_GET['street']) ? $_GET['street'] : '' }}>
                <span><a href="javascript:void()" name="button_search"><img src="{{site_url()}}assets/images/search.png"></a></span>
            </div>
            <div class="filter-btn-mobo">
                <button id="example" type="button" class="btn btn-pophover" data-container="body" data-toggle="popover" data-placement="bottom" onclick="changeIcon(this);"> Rental Type
                    &nbsp;<i class="fa fa-angle-down"></i></button>
                <div id="content">
                    <h4>Rental Type</h4>
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
                        <li {{ isset($_GET['type']) && $_GET['type'] == 'duplex' ? 'class=active' : '' }}>
                            <button class="btn {{ isset($_GET['type']) && $_GET['type'] == 'duplex' ? 'active' : '' }}" onclick="filter({name: 'type', value: 'duplex'})">
                                <i class="fa fa-building-o"></i>
                                Duplex
                            </button>
                        </li>
                        <li {{ isset($_GET['type']) && $_GET['type'] == 'villa' ? 'class=active' : '' }}>
                            <button class="btn {{ isset($_GET['type']) && $_GET['type'] == 'villa' ? 'active' : '' }}" onclick="filter({name: 'type', value: 'villa'})">
                                <i class="fa fa-home"></i>
                                Villa
                            </button>
                        </li>
                        <li {{ isset($_GET['type']) && $_GET['type'] == 'basement' ? 'class=active' : '' }}>
                            <button class="btn {{ isset($_GET['type']) && $_GET['type'] == 'basement' ? 'active' : '' }}" onclick="filter({name: 'type', value: 'basement'})">
                                <i class="fa fa-home"></i>
                                Basement
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
                    <div class="main-35 input-box-mob">
                        <ul class="main-36">
                            <li {{ (isset($_GET['price_min']) && isset($_GET['price_max'])) && ($_GET['price_min'] == '' && $_GET['price_max'] == '') ? 'class=active' : '' }}>
                                <input type="hidden" id="price_min1" value=''>
                                <input type="hidden" id="price_max1" value=''>
                                <button class="btn propery_any {{ (isset($_GET['price_min']) && isset($_GET['price_max'])) && ($_GET['price_min'] == '' && $_GET['price_max'] == '') ? 'active' : '' }}" onclick="filter({name: 'price', value: '1'})">
                                    Any
                                </button>
                            </li>
                            <ul class="p-sec-n">
                                <li>
                                    <input type="number" class="form-control" placeholder="No Min" name="min" title="No Min" value="{{ isset($_GET['price_min']) && $_GET['price_min'] != '' ? $_GET['price_min'] : '' }}">
                                </li>
                                <li class="middle-s">
                                    to
                                </li>
                                <li>
                                    <input type="number" class="form-control" placeholder="No Max" name="max" title="No Max" value="{{ isset($_GET['price_max']) && $_GET['price_max'] != '' ? $_GET['price_max'] : '' }}">
                                </li>
                            </ul>
                        </ul>
                        <div class="row">
                            <div class="col-lg-12">
                                <button class="btn-md button-theme btn-block" name="pricefilter_button">Filter</button>
                            </div>
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
                            <button class="btn propery_any {{ isset($_GET['bedroom']) && $_GET['bedroom'] == 'any' ? 'active' : '' }}" onclick="filter({name: 'bedroom', value: 'any'})">
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
                        <li class="active"> <button class="btn {{ isset($_GET['sort_by']) && $_GET['sort_by'] == 'newest' ? 'active' : '' }}" onclick="filter({name: 'sort_by', value: 'newest'})">Newest</button></li>
                        <li class="active"> <button class="btn {{ isset($_GET['sort_by']) && $_GET['sort_by'] == 'oldest' ? 'active' : '' }}" onclick="filter({name: 'sort_by', value: 'oldest'})">Oldest</button></li>
                        <div class="clearfix"></div>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="filter-btn-mobo sortby">
                <button id="example5" type="button" class="btn btn-pophover" data-container="body" data-toggle="popover" data-placement="bottom" onclick="changeIcon(this);"> More &nbsp;<i class="fa fa-angle-down"></i> </button>
                <div id="content5">
                    <h4>More</h4>
                    <h5 style="text-align: center;">Bathroom</h5>
                    <ul class="main-36">
                        <li {{ isset($_GET['bathroom']) && $_GET['bathroom'] == 'any' ? 'class=active' : '' }}>
                            <button class="btn propery_any {{ isset($_GET['bathroom']) && $_GET['bathroom'] == 'any' ? 'active' : '' }}" onclick="filter({name: 'bathroom', value: 'any'})">
                                Any
                            </button>
                        </li>
                        <li {{ isset($_GET['bathroom']) && $_GET['bathroom'] == '1' ? 'class=active' : '' }}>
                            <button class="btn {{ isset($_GET['bathroom']) && $_GET['bathroom'] == '1' ? 'active' : '' }}" onclick="filter({name: 'bathroom', value: '1'})">
                                1+
                            </button>
                        </li>
                        <li {{ isset($_GET['bathroom']) && $_GET['bathroom'] == '2' ? 'class=active' : '' }}>
                            <button class="btn {{ isset($_GET['bathroom']) && $_GET['bathroom'] == '2' ? 'active' : '' }}" onclick="filter({name: 'bathroom', value: '2'})">
                                2+
                            </button>
                        </li>
                        <li {{ isset($_GET['bathroom']) && $_GET['bathroom'] == '3' ? 'class=active' : '' }}>
                            <button class="btn {{ isset($_GET['bathroom']) && $_GET['bathroom'] == '3' ? 'active' : '' }}" onclick="filter({name: 'bathroom', value: '3'})">
                                3+
                            </button>
                        </li>
                        <li {{ isset($_GET['bathroom']) && $_GET['bathroom'] == '4' ? 'class=active' : '' }}>
                            <button class="btn {{ isset($_GET['bathroom']) && $_GET['bathroom'] == '4' ? 'active' : '' }}" onclick="filter({name: 'bathroom', value: '4'})">
                                4+
                            </button>
                        </li>
                        <li {{ isset($_GET['bathroom']) && $_GET['bathroom'] == '5' ? 'class=active' : '' }}>
                            <button class="btn {{ isset($_GET['bathroom']) && $_GET['bathroom'] == '5' ? 'active' : '' }}" onclick="filter({name: 'bathroom', value: '5'})">
                                5+
                            </button>
                        </li>
                        <div class="clearfix"></div>
                    </ul>
                    <ul class="main-33 more-sec">

                        <li> <button class="btn {{ isset($_GET['more']) && $_GET['more'] == 'Floor' ? 'active' : '' }}" onclick="filter({name: 'more', value: 'Floor'})">Floor</button> </li>
                    </ul>
                </div>
            </div>

            <!--   <div class="filter-btn-mobo">
                        <button id="example5" type="button" class="btn btn-pophover" data-container="body"
                            data-toggle="popover" data-placement="bottom" onclick="changeIcon(this);"> More <i
                                class="fa fa-angle-down"></i> </button>
                        <div id="content5">
                            <!-- <h4>More</h4> -->
            <!--  <ul class="main-33">
                                <li class="active"> <button
                                        class="btn {{ isset($_GET['more']) && $_GET['more'] == 'Bedroom' ? 'active' : '' }}"
                                        onclick="filter({name: 'more', value: 'Bedroom'})">Bedroom</button></li>
                                <li> <button
                                        class="btn {{ isset($_GET['sort_by']) && $_GET['sort_by'] == 'Bathroom' ? 'active' : '' }}"
                                        onclick="filter({name: 'more', value: 'Bathroom'})">Bathroom</button></li>
                                        <li class="active"> <button
                                        class="btn {{ isset($_GET['sort_by']) && $_GET['sort_by'] == 'Floor' ? 'active' : '' }}"
                                        onclick="filter({name: 'more', value: 'Floor'})">Floor</button></li>
                                                                        <li class="active"> <button
                                        class="btn {{ isset($_GET['sort_by']) && $_GET['sort_by'] == 'Plot' ? 'active' : '' }}"
                                        onclick="filter({name: 'more', value: 'Plot'})">Plot</button></li>
                                <div class="clearfix"></div>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div> -->

        </div>
    </div>

</div>
</div>

</div>
</div>

</div>
</div>
<script>
    //   var initMap = (latLng = [40.71427, -74.00597]) => {
    //     try {
    //      window.mapPicker = L.map('map', {
    //         center: latLng,
    //             zoom: 15
    //         });

    //         $('#lat_lng').val(`${latLng[0]}|${latLng[1]}`);

    //         L.tileLayer('https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}.png?lang=en', {
    //         attribution: 'Map Data &copy; <a href="https://wikimediafoundation.org/wiki/Maps_Terms_of_Use">Wikimedia</a>'
    //         }).addTo(mapPicker);

    //         window.marker = L.marker(latLng, {
    //             autoPan: true
    //         }).addTo(mapPicker);

    //         setTimeout(function(){  window.mapPicker.invalidateSize();  window.mapPicker.setView(latLng, 15);},1000);
    //     } catch (err) {
    //         window.mapPicker.panTo(latLng);
    //         window.marker.setLatLng(latLng);
    //         setTimeout(function(){  window.mapPicker.invalidateSize();  window.mapPicker.setView(latLng, 15);},1000);

    //     }
    // };

    function showDetails(id) {
        $.ajax({
            type: "post",
            url: "{{ site_url('properties/viewDetails') }}",
            dataType: "json",
            data: {
                property_id: id,
            },
            success: function(res) {


                if (res.property.coords) {
                    var a = JSON.parse(res.property.coords);
                    var coords = a.map(function(x) {
                        return parseFloat(x);
                    });
                    // initMap(JSON.parse(res.property.coords));
                } else {
                    // initMap();
                }
                $(".contentText").html("");
                $(".contectDetail").html("");
                $(".carousel-indicators").html("");
                $(".carousel-inner").html("");
                $.each(res.property_images, function(key, value) {
                    if (key == 0) {
                        var active = 'active';
                    } else {
                        var active = '';
                    }
                    $(".carousel-indicators").append("<li data-target='#demo' data-slide-to='" + key + "' class='" + active + "'></li>");
                    var base_path = '{{ site_url("uploads/") }}';
                    $(".carousel-inner").append("<div class='carousel-item " + active + "'><img src='" + base_path + value.path + "' /></li>");
                });

                $(".prepends").remove();
                $(".contectDetail").append("<span>Property ID:" + res.property.id + "</span>" + "<span>Property Price:$" + res.property.price + "</span><span>Property status: For " + res.property.for+"</span><span>Property Type: " + res.property.type + "</span><p class='moreDetails'>");
                $.each(res.property_attributes, function(key, value) {
                    var icon_path = '{{ site_url("") }}';
                    $(".moreDetails").prepend("<span>" + value.text + ': ' + value.value + " " + value.text + " </span>");
                });
                if (res.property.description != '') {
                    $(".contentText").append("<h5>Discription</h5><p>" + res.property.description + "</p>");
                }
                $("#propertyDetailStreet").html(res.property.street);

                $("#Properties-popup").modal('show');
            }
        });
    }
</script>



<div class="explore-content-box">
    <div class="container-fluid">
        <div class="inner-content-box">
            <div class="row">
                <div class="col-md-12">
                    <div class="btns-area">
                        <a href="{{site_url('properties/lists')}}" class="change-view-btn active-view-btn">List View</a>
                        <a href="{{site_url('properties')}}" class="change-view-btn ">Map View</i></a>
                    </div>
                </div>
                @if(intval(count($properties)) < 1) <div class="row" id="norecord">
                    <div class="col-lg-12 text-center mt-5">
                        <p><i class="fa fa-search" aria-hidden="true"></i></p>
                        <p class="text-head">No matching rental</p>
                        <p class="text-details">Please try to modify the search.
                        </p>
                    </div>
            </div>
            @else
            <!--  @php print_r($images) @endphp -->
            @php $j = 0 @endphp
            @foreach ($properties as $property)
            @php $j++ @endphp
            @php
            $area_key = array_search('Area', array_column($property['attributes'], 'text'));
            $room_key = array_search('Bedroom', array_column($property['attributes'], 'text'));
            $bathroom_key = array_search('Bathroom', array_column($property['attributes'], 'text'));
            $garrage_key = array_search('Garrage', array_column($property['attributes'], 'text'));
            $sold = $property['sold'];
            @endphp
            <div class="col-md-4 col-lg-4">
                <div class="item">
                    <div class="feat_property slider_property">
                        <div class="thumb">

                            @if (array_key_exists('images', $property) && !empty($property['images']))
                            <div id="carouselExampleControls{{$j}}" class="carousel slide" data-interval="false">
                                <div class="" onclick="showDetails({{$property['id']}})">
                                    @php $i = 0 @endphp
                                    @foreach($images as $k=>$image)
                                    @if($image['property_id'] == $property['id'])
                                    @php $i++ @endphp
                                    @if($i == 1)
                                    @php $class = 'active'@endphp
                                    @else
                                    @php $class= ''@endphp
                                    @endif
                                    <div class="carousel-item {{ $class }}">
                                        <img class="img-whp" src="<?php echo site_url('/'); ?>uploads/{{$image['path']}}" alt="properties" />
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                @if($i != 1)

                                <a class="carousel-control-prev" href="#carouselExampleControls{{$j}}" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls{{$j}}" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                                @endif
                            </div>
                            @else
                            <img class="img-whp" src="<?php echo site_url('/'); ?>uploads/diraleads-logo.svg" alt="properties" />
                            @endif
                            <div class="thmb_cntnt">
                                <a class="fp_price" href="#">${{$property['price']}}<small>/Month</small></a>
                            </div>
                        </div>
                        <div class="details">
                            <div class="tc_content">
                                <p class="text-thm">Apartment for {{$property['for']}}</p>
                                <p><span class="flaticon-placeholder"></span> {{$property['street']}}</p>
                                <ul class="prop_details mb0">
                                    @if(is_numeric($room_key))
                                    <li class="list-inline-item"><a href="#">Beds: {{$property['attributes'][$room_key]['value']}}</a></li>
                                    @endif
                                    @if(is_numeric($bathroom_key))
                                    <li class="list-inline-item"><a href="#">Baths: {{$property['attributes'][$bathroom_key]['value']}}</a></li>
                                    @endif
                                    @if(is_numeric($area_key))
                                    <li class="list-inline-item"><a href="#">Sq Ft: {{$property['attributes'][$area_key]['value']}}</a></li>
                                    @endif
                                    @if (isset($_SESSION['id']))
                                    <li>
                                        <form action="{{site_url('properties/addToFavorites')}}" method="post">
                                            <input type="hidden" name="property_id" value="{{$property['id']}}">
                                            <input type="hidden" name="<?php echo $token_name; ?>" value="<?php echo $token_hash; ?>">

                                            @php
                                            $match = false;
                                            @endphp
                                            @foreach ($favorites as $item)
                                            @if ($item['property_id'] == $property['id'])
                                            @php
                                            $match = true;
                                            @endphp
                                            @endif
                                            @endforeach
                                            @if ($match)
                                            <button type="button" class="favLinkButton favrite_remove" style="background-color: #F7F7F7;border:none;">
                                                <i class="fa fa-heart fa-lg" style="color:red;"></i>
                                                @else
                                                <button type="button" class="favLinkButton favrite_add" style="background-color: #F7F7F7;border:none;">
                                                    <i class="fa fa-heart-o fa-lg"></i>
                                                    @endif
                                                </button>
                                        </form>
                                    </li>
                                    @endif
                                </ul>
                                @if($property['description'] !='')
                                <p>{{substr($property['description'],0,40)}}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
            @endif
            <div class="clearfix"></div>
        </div>
    </div>
</div>
</div>
<div class="clearfix"></div>

@if(intval(count($properties)) > 0)
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center" style="margin: 0 auto; display: flex; margin-bottom:30px;">

        <?php if ($prev_link != false) : ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $prev_link; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php else : ?>
            <li class="page-item disabled">
                <a class="page-link" href="" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $no_to_paginate; $i++) : ?>
            <?php if ($page == $i) :  ?>
                <li class="page-item active">
                    <span class="page-link" style="background-color: #a27007; border-color: #a27007;">
                        <?php echo $i; ?>
                        <span class="sr-only">(current)</span>
                    </span>
                </li>
            <?php else : ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $i; ?><?php echo ($query_string != '') ? '&' . $query_string : ''; ?>"><?php echo $i; ?></a>
                </li>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($next_link != false) : ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $next_link; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php else : ?>
            <li class="page-item disabled">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
@endif

</div>



<!-- The Modal -->
<div class="modal" id="Properties-popup">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="slider-popup">
                <div id="demo" class="carousel slide" data-interval="false">
                    <!-- Indicators -->
                    <ul class="carousel-indicators">
                    </ul>
                    <!-- The slideshow -->
                    <div class="carousel-inner">
                    </div>
                </div>
                <div class="popup-slider-text">
                    <div class="inner-slider-text">
                        <div class="content-text contentText">

                        </div>


                        <div class="content-text">
                            <h5>Property Details</h5>
                            <div class="list-content contectDetail">
                            </div>
                            <div class="submit-box">
                                <button>Submit Request</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div id="map"></div> -->
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
{{-- <script src="{{ site_url('assets/properties/js/rangeslider.js') }}"></script> --}}
<script src="{{ site_url('assets/properties/js/bootstrap-select.min.js') }}"></script>
<script src="{{ site_url('assets/properties/js/jquery.easing.1.3.js') }}"></script>
<script src="{{ site_url('assets/properties/js/jquery.scrollUp.js') }}"></script>
<script src="{{ site_url('assets/properties/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ site_url('assets/properties/js/leaflet.js') }}"></script>
<script src="{{ site_url('assets/properties/js/leaflet-providers.js') }}"></script>
<script src="{{ site_url('assets/properties/js/leaflet.markercluster.js')}}"></script>
<script src="{{ site_url('assets/properties/js/dropzone.js') }}"></script>
<script src="{{ site_url('assets/properties/js/slick.min.js') }}"></script>
<script src="{{ site_url('assets/properties/js/jquery.filterizr.js') }}"></script>
<script src="{{ site_url('assets/properties/js/jquery.magnific-popup.min.js') }}"></script>
<!-- <script src="{{ site_url('assets/properties/js/maps.js') }}"></script> -->
<script src="{{ site_url('assets/js/lightslider.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js">
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">
    $(function() {
        $('.daterangePicker').daterangepicker();
        $(".range-slider-ui-x").slider({
            range: true,
            min: 0,
            max: 500,
            values: [100, 300],
            slide: function(event, ui) {
                $("#amount").html("$" + ui.values[0] + " - $" + ui.values[1]);
                $("#amount1").val(ui.values[0]);
                $("#amount2").val(ui.values[1]);
            }
        });
        $("#amount").html("$" + $(".range-slider-ui-x").slider("values", 0) +
            " - $" + $(".range-slider-ui-x").slider("values", 1));
    });
</script>
<script>
    var ops = {
        'html': true,
        sanitize: false,
        content: function() {
            return $('#content').html();
        }
    };

    $(function() {
        $('#example').popover(ops)
    });

    var ops1 = {
        'html': true,
        sanitize: false,
        content: function() {
            return $('#content1').html();
        }
    };

    $(function() {
        $('#example1').popover(ops1);
    });
    var ops2 = {
        'html': true,
        sanitize: false,
        content: function() {
            return $('#content2').html();
        }
    };

    $(function() {
        $('#example2').popover(ops2);

    });

    var ops3 = {
        'html': true,
        sanitize: false,
        content: function() {
            return $('#content3').html();
        }
    };

    $(function() {
        $('#example3').popover(ops3)
    });
    var ops4 = {
        'html': true,
        sanitize: false,
        content: function() {
            return $('#content4').html();
        }
    };

    $(function() {
        $('#example4').popover(ops4)
    });
    var ops5 = {
        'html': true,
        sanitize: false,
        content: function() {
            return $('#content5').html();
        }
    };
    $(function() {
        $('#example5').popover(ops5)
    });

    function changeIcon(el) {
        if ($(el).children().hasClass("fa-angle-down")) {
            $(el).children().removeClass("fa-angle-down");
            $(el).children().addClass("fa-angle-up");
            $(".popover-active").click();
            $(el).removeClass("popover-inactive");
            $(el).addClass("popover-active");
        } else if ($(el).children().hasClass("fa-angle-up")) {
            $(el).children().removeClass("fa-angle-up");
            $(el).children().addClass("fa-angle-down");
            $(el).removeClass("popover-active");
            $(el).addClass("popover-inactive");
        }
    }


    function filter(type) {
        var form = document.createElement("form");
        var element1 = document.createElement("input");
        var element2 = document.createElement("input");
        var element3 = document.createElement("input");
        var element4 = document.createElement("input");
        form.method = "get";
        form.action = "";
        var price = false;
        if (type.value == "") {
            return false;
        }
        var custom_bedroom_filter = false;
        // if(type.value == ''){
        // return false;
        // }
        if (type.name == 'street') {

            element1.name = type.name;
            element1.value = $('#street_search').val();

        } else if (type.name == 'price') {

            element1.name = 'price_min';
            element1.value = $('#price_min' + type.value).val();
            element2.name = 'price_max';
            element2.value = $('#price_max' + type.value).val();
            price = true;

        } else if (type.name == 'custom_filter_price') {
            type.name = 'price';
            element1.name = 'price_min';
            element1.value = !isNaN(type.value.min) ? type.value.min : '';
            element2.name = 'price_max';
            element2.value = !isNaN(type.value.max) ? type.value.max : '';
            price = true;

        } else if (type.name == 'custom_filter_bedroom') {

            element1.name = 'bedroom_min';
            element1.value = !isNaN(type.value.min) ? type.value.min : '';
            element2.name = 'bedroom_max';
            element2.value = !isNaN(type.value.max) ? type.value.max : '';
            custom_bedroom_filter = true;

        } else {

            element1.name = type.name;
            if (type.value == 'short term rent') {
                element1.value = type.value + `&fromdate=${type.from}&todate=${type.to}`;
                //   element3.name = 'fromdate';
                //   element3.value = type.from;

                //   element4.name = 'todate';
                //   element4.value = type.to;
            } else {
                element1.value = type.value;
            }
        }


        form.appendChild(element1);
        form.appendChild(element2);
        // if(type.value == 'short term rent') {
        //    form.appendChild(element3);
        //    form.appendChild(element4);
        // }
        var getParams = <?php echo json_encode($_GET) ?>;

        if (type.name == 'bedroom') {
            delete getParams.bedroom_min;
            delete getParams.bedroom_max;
        }

        if (type.name == 'custom_filter_bedroom') {
            delete getParams.bedroom;
        }

        if (price == true) {
            delete getParams.price_max;
        }
        if (price == true) {
            delete getParams.price_min;
        }
        if (custom_bedroom_filter == true) {
            delete getParams.bedroom_min;
            delete getParams.bedroom_max;
        }

        $.each(getParams, function(name, value) {
            // if(name != type.name && name != 'price_min' && name != 'price_max'  && name != 'bedroom_min' && name != 'bedroom_max') {
            if (name != type.name) {
                var element = document.createElement("input");
                element.value = value;
                element.name = name;
                form.appendChild(element);
            }
        });
        document.body.appendChild(form);
        form.submit();
    }

    $('[name="button_search"').click(function() {
        var e = $.Event("keydown", {
            keyCode: 13
        });
        $('#street_search').trigger(e);
    });
    $('#street_search').keydown(function(event) {
        if (event.which == 13 || event.keyCode == 13) {
            val = $(this).val();
            filter({
                name: 'street',
                value: val
            });
        }
    });

    //  Custom Bedroom Filter Button
    $('body').on('click', 'button[name="bedfilter_button"]', function() {
        input_box_momb = $(this).closest('.input-box-mob');
        min = parseInt($(input_box_momb).find('input[name="min"]').val());
        max = parseInt($(input_box_momb).find('input[name="max"]').val());
        if (isNaN(min) && isNaN(max)) {
            alert('Min & Max Value Required');
            return false;
        } else if (min > max) {
            alert('Min Value should not be greater than Max Value');
            return false;
        }
        val = {
            min,
            max
        };

        filter({
            name: 'custom_filter_bedroom',
            value: val
        });
    });
    //  Custom Price Filter Button
    $('body').on('click', 'button[name="pricefilter_button"]', function() {
        input_box_momb = $(this).closest('.input-box-mob');
        min = parseInt($(input_box_momb).find('input[name="min"]').val());
        max = parseInt($(input_box_momb).find('input[name="max"]').val());
        if (isNaN(min) && isNaN(max)) {
            alert('Min & Max Value Required');
            return false;
        } else if (min > max) {
            alert('Min Value should not be greater than Max Value');
            return false;
        }
        val = {
            min,
            max
        };

        filter({
            name: 'custom_filter_price',
            value: val
        });
    });

    $(function() {
        $('body').on('click', '.favLinkButton', function() {
            // $.LoadingOverlay("show", {
            //     image       : "",
            //     fontawesome : "fa fa-cog fa-spin"
            // });
            var form = $(this).closest('form');
            property_id = $(form).find('[name="property_id"]').val();
            csrf_token = $(form).find('[name="csrf_token"]').val();
            var formData = new FormData($(form)[0]);
            $.ajax({
                url: '<?php echo site_url("properties/addToFavorites"); ?>',
                type: 'POST',
                data: formData,
                cache: false,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function(data) {
                    // $.LoadingOverlay("hide");
                    if (data.response == 'insert') {
                        $(form).find('.fa').removeClass('fa-heart-o').addClass('fa-heart').css('color', 'red');
                        $(form).find('.favLinkButton').addClass('favrite_remove');
                        $(form).find('.favLinkButton').removeClass('favrite_add');
                        toastr.success('Rental added to favorites');
                    } else if (data.response == 'remove') {
                        $(form).find('.favLinkButton').addClass('favrite_add');
                        $(form).find('.favLinkButton').removeClass('favrite_remove');
                        $(form).find('.fa').removeClass('fa-heart').addClass('fa-heart-o').css('color', 'inherit');
                        toastr.success('Rental removed from favorites');
                    }
                },
                error: function(data) {
                    console.log();
                    $.LoadingOverlay("hide");
                },
                complete: function(data) {
                    $.LoadingOverlay("hide");
                    console.log(data)
                }
            })


        })
    })

    function shortTermCustomDateRange(elem) {
        dateRange = $('.daterangePicker').val().split('-');
        // console.log(dateRange);
        filter({
            name: 'for',
            value: 'short term rent',
            from: dateRange[0],
            to: dateRange[1]
        })
    }
    $('body').on('click', function(e) {
        $('[data-toggle="popover"]').each(function() {
            //the 'is' for buttons that trigger popups
            //the 'has' for icons within a button that triggers a popup
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });
</script>
@endpush