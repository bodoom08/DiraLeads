@extends('common.layout')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ site_url('assets/css/lightslider.css') }}" />
<link rel="stylesheet" type="text/css" href="assets/properties/css/bootstrap-select.min.css" />
<link rel="stylesheet" href="assets/properties/css/leaflet.css" type="text/css" />
<link rel="stylesheet" href="assets/properties/css/map.css" type="text/css" />
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.css' />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.Default.css' />
<link rel="stylesheet" type="text/css" href="assets/properties/css/jquery.mCustomScrollbar.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" integrity="sha256-ENFZrbVzylNbgnXx0n3I1g//2WeO47XxoPe0vkp3NC8=" crossorigin="anonymous" />
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPhDpAUyER52TsCsLFNOOxT_l5-y7e78A&callback=initMap">
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha256-siyOpF/pBWUPgIcQi17TLBkjvNgNQArcmwJB8YvkAgg=" crossorigin="anonymous" />
<style>
    .map-marker {
        background-color: transparent !important;
        bottom: -2px;
    }

    .marker-cluster-small {
        background-color: transparent !important;
    }

    .map-marker:before {
        display: none;
    }

    .map-marker .icon {
        border: none !important;
    }

    .map-marker:after {
        display: none
    }

    .map-marker .icon {
        background-color: transparent !important;
    }

    footer,
    .sub-footer {
        display: none;
    }

    #content,
    #content1,
    #content2,
    #content3,
    #content4 {
        display: none;
    }

    body {
        overflow: hidden;
    }

    .daterangepicker.show-calendar {
        width: 604px !important;
    }

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
?>
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

            <div class="filter-btn-mobo sortby">
                <button id="example4" type="button" class="btn btn-pophover" data-container="body" data-toggle="popover" data-placement="bottom" onclick="changeIcon(this);"> Sort By &nbsp;<i class="fa fa-angle-down"></i> </button>
                <div id="content4">
                    <h4>Sort By</h4>
                    <ul class="main-33">
                        <li class="active"><button class="btn {{ isset($_GET['sort_by']) && $_GET['sort_by'] == 'low-high' ? 'active' : '' }}" onclick="filter({name: 'sort_by', value: 'low-high'})">Low to High</button></li>
                        <li><button class="btn {{ isset($_GET['sort_by']) && $_GET['sort_by'] == 'high-low' ? 'active' : '' }}" onclick="filter({name: 'sort_by', value: 'high-low'})">High to Low</button></li>
                        <li class="active"><button class="btn {{ isset($_GET['sort_by']) && $_GET['sort_by'] == 'newest' ? 'active' : '' }}" onclick="filter({name: 'sort_by', value: 'newest'})">Newest</button></li>
                        <li class="active"><button class="btn {{ isset($_GET['sort_by']) && $_GET['sort_by'] == 'oldest' ? 'active' : '' }}" onclick="filter({name: 'sort_by', value: 'oldest'})">Oldest</button></li>
                        <div class="clearfix"></div>
                    </ul>
                </div>
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
        </div>
    </div>
</div>
@endsection