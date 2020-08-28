@extends('common.layout')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="{{ site_url('assets/css/lightslider.css') }}" />
<link rel="stylesheet" type="text/css" href="assets/properties/css/bootstrap-select.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" integrity="sha256-ENFZrbVzylNbgnXx0n3I1g//2WeO47XxoPe0vkp3NC8=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha256-siyOpF/pBWUPgIcQi17TLBkjvNgNQArcmwJB8YvkAgg=" crossorigin="anonymous" />
<style>
    .filter-btn-mobo {
        margin: 0 !important;
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
    .search-page {
        margin: 0 !important;
        height: calc(100vh - 300px);
    }

    .search-page #map {
        height: 100% !important;
    }

    .view-product {
        max-height: 100%;
        overflow: hidden;
    }

    .item-list {
        max-height: 100%;
        overflow-x: hidden;
        overflow-y: scroll;

        display: grid;
        grid-template-columns: 33% 33% 33%;
        column-gap: 0.5%;

        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .item-card {
        flex: 0 0 32%;
        margin-bottom: 0.5rem;
        padding: 0.5rem;
        cursor: pointer;
        border-radius: 5px;
        background: white;
    }
    .item-card:nth-child(3n) {
        /*  */
    }

    .item-card:hover {
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transform: scale(1.05);
        transition: all 0.5s ease;

        z-index: 10;
    }

    .item-card .item-desc {
        width: 100%;
        padding-left: 20px;
    }

    .item-image {
        width: 100%;
        height: 200px;
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;

        border-radius: 10px;
        border: 2px solid #82828247;

        display: flex;
        justify-content: space-between;

        padding-top: 0.1rem;
        padding-right: 0.5rem;
    }
    .item-image a {
        color: red !important;
        font-size: 22px;
    }
    .item-image .item-badge {
        display: inline-block;
        font-size: 12px;
        padding: 0.1rem;
    }
    .item-image .item-badge span {
        border-radius: 5px;
        color: white;
        background: pink;
        margin: 0.1rem;
        padding: 0.1rem;
    }
</style>

@endpush

@section('content')
<?php
?>
<div class="explore-search">
    <div class="inner-search px-4">
        <div class="find-search-box">
            <input type="search" name="" id="street_search" placeholder="e.g- Brooklyn" value={{ isset($_GET['street']) ? $_GET['street'] : '' }}>
            <span><a href="javascript:void()" name="button_search"><img src="{{site_url()}}assets/images/search.png" /></a></span>
        </div>

        <div class="filter-btn-mobo">
            <button id="example" type="button" class="btn btn-pophover" data-container="body" data-toggle="popover" data-placement="bottom" onclick="changeIcon(this);"> Rental Type
                &nbsp;<i class="fa fa-angle-down"></i></button>
            <div id="content">
                <h4>Rental Type</h4>
                <ul class="main-34">
                    <li {{ (isset($_GET['type']) && $_GET['type'] == 'any') || (!isset($_GET['type'])) ? 'class=active' : '' }}>
                        <button class="btn {{ isset($_GET['type']) && $_GET['type'] == 'any' || (!isset($_GET['type'])) ? 'active' : '' }}" onclick="filter({name: 'type', value: 'any'})">
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
                        <li {{ (isset($_GET['price_min']) && isset($_GET['price_max'])) && ($_GET['price_min'] == '' && $_GET['price_max'] == '')  ? 'class=active' : '' }}>
                            <input type="hidden" id="price_min1" value=''>
                            <input type="hidden" id="price_max1" value=''>
                            <button class="btn propery_any {{ (isset($_GET['price_min']) && isset($_GET['price_max'])) && ($_GET['price_min'] == '' && $_GET['price_max'] == '') || (!isset($_GET['price_min']) && !isset($_GET['price_max'])) ? 'active' : '' }}" onclick="filter({name: 'price', value: '1'})">
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
                    <li {{ (isset($_GET['bedroom']) && $_GET['bedroom'] == 'any') || !isset($_GET['bedroom']) ? 'class=active' : '' }}>
                        <button class="btn propery_any {{ isset($_GET['bedroom']) && $_GET['bedroom'] == 'any' || !isset($_GET['bedroom']) ? 'active' : '' }}" onclick="filter({name: 'bedroom', value: 'any'})">
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
            <button id="example5" type="button" class="btn btn-pophover" data-container="body" data-toggle="popover" data-placement="bottom" onclick="changeIcon(this);"> More &nbsp;<i class="fa fa-angle-down"></i> </button>
            <div id="content5">
                <h4>More</h4>
                <h5 style="text-align: center;">Bathroom</h5>
                <ul class="main-36">
                    <li {{ (isset($_GET['bathroom']) && $_GET['bathroom'] == 'any') || !isset($_GET['bathroom']) ? 'class=active' : '' }}>
                        <button class="btn propery_any {{ isset($_GET['bathroom']) && $_GET['bathroom'] == 'any' || !isset($_GET['bathroom']) ? 'active' : '' }}" onclick="filter({name: 'bathroom', value: 'any'})">
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
                    <li><button class="btn {{ isset($_GET['more']) && $_GET['more'] == 'Floor' ? 'active' : '' }}" onclick="filter({name: 'more', value: 'Floor'})">Floor</button> </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="w-50 d-flex justify-content-between">
    <div class="pl-4">
        <h5>San Francisco, CA Apartments & Homes For Rent</h5>
        <small>3,3008 rentals available on DiraLeads</small>
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
</div>

<div class="row search-page">
    <div class="col-lg-6 h-100">
        <div class="w-100 item-list">
            <div class="item-card">
                <div class="item-image" style="background-image: url(<?php echo site_url('assets/images/fp2.jpg');?>)">
                    <div class="item-badge">
                        <span>Sale</span>
                        <span>Rent</span>
                        <span>Short term rent</span>
                    </div>
                    <a href="javascript:;" >❤</a>
                </div>
                <div class="item-desc">
                    <h5>$5,900/mo</h5>
                    <p>🏠 4bd 🎉 2ba ✨ 1,600 sqft</p>
                    <p>1703 Powell St</p>
                    <p>Russian Hill, San Francisco, CA</p>
                </div>
            </div>

            <div class="item-card">
                <div class="item-image" style="background-image: url(<?php echo site_url('assets/images/fp2.jpg');?>)">
                    <div class="item-badge">
                        <span>Sale</span>
                        <span>Rent</span>
                        <span>Short term rent</span>
                    </div>
                    <a href="javascript:;" >❤</a>
                </div>
                <div class="item-desc">
                    <h5>$5,900/mo</h5>
                    <p>🏠 4bd 🎉 2ba ✨ 1,600 sqft</p>
                    <p>1703 Powell St</p>
                    <p>Russian Hill, San Francisco, CA</p>
                </div>
            </div>

            <div class="item-card">
                <div class="item-image" style="background-image: url(<?php echo site_url('assets/images/fp2.jpg');?>)">
                    <div class="item-badge">
                        <span>Sale</span>
                        <span>Rent</span>
                        <span>Short term rent</span>
                    </div>
                    <a href="javascript:;" >❤</a>
                </div>
                <div class="item-desc">
                    <h5>$5,900/mo</h5>
                    <p>🏠 4bd 🎉 2ba ✨ 1,600 sqft</p>
                    <p>1703 Powell St</p>
                    <p>Russian Hill, San Francisco, CA</p>
                </div>
            </div>

            <div class="item-card">
                <div class="item-image" style="background-image: url(<?php echo site_url('assets/images/fp2.jpg');?>)">
                    <div class="item-badge">
                        <span>Sale</span>
                        <span>Rent</span>
                        <span>Short term rent</span>
                    </div>
                    <a href="javascript:;" >❤</a>
                </div>
                <div class="item-desc">
                    <h5>$5,900/mo</h5>
                    <p>🏠 4bd 🎉 2ba ✨ 1,600 sqft</p>
                    <p>1703 Powell St</p>
                    <p>Russian Hill, San Francisco, CA</p>
                </div>
            </div>

            <div class="item-card">
                <div class="item-image" style="background-image: url(<?php echo site_url('assets/images/fp2.jpg');?>)">
                    <div class="item-badge">
                        <span>Sale</span>
                        <span>Rent</span>
                        <span>Short term rent</span>
                    </div>
                    <a href="javascript:;" >❤</a>
                </div>
                <div class="item-desc">
                    <h5>$5,900/mo</h5>
                    <p>🏠 4bd 🎉 2ba ✨ 1,600 sqft</p>
                    <p>1703 Powell St</p>
                    <p>Russian Hill, San Francisco, CA</p>
                </div>
            </div>

        </div>
    </div>
    <div class="col-lg-6">
        <div id="map"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPhDpAUyER52TsCsLFNOOxT_l5-y7e78A&callback=initMap">
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
        // $('.daterangePicker').daterangepicker();
        $('#example').popover(ops);
    });

    var ops1 = {
        'html': true,
        sanitize: false,
        content: function() {
            return $('#content1').html();
        }
    };
    $(function() {
        $('#example1').popover(ops1)
    });

    var ops2 = {
        'html': true,
        sanitize: false,
        content: function() {
            return $('#content2').html();
        }
    };
    $(function() {
        $('#example2').popover(ops2)
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
</script>

<script>
    function initMap() {
        const uluru = { lat: -25.344, lng: 131.036 };
        const map = new google.maps.Map(
            document.getElementById('map'), { zoom: 4, center: uluru }
        );
        marker = new google.maps.Marker({ position: uluru, map });
    }
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
</script>
@endpush