@extends('common.layout')

@push('styles')
<link rel="stylesheet" type="text/css" href="assets/properties/css/bootstrap-select.min.css" />
<link rel="stylesheet" href="assets/properties/css/leaflet.css" type="text/css" />
<link rel="stylesheet" href="assets/properties/css/map.css" type="text/css" />
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.css' />
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
                        <input type="search" class="form-control" placeholder="India">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="filter-btn-mobo">
                    <button id="example1" type="button" class="btn btn-pophover" data-container="body" data-toggle="popover" data-placement="bottom"> Listing Type </button>
                    <div id="content1">
                        <h4>Listing Type</h4>
                        <ul class="main-33">
                            <li class="active">Any</li>
                            <li> For Rent </li>
                            <li> For Sell </li>
                            <li>For Short Term Rent</li>
                            <div class="clearfix"></div>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="filter-btn-mobo">
                    <button id="example" type="button" class="btn btn-pophover" data-container="body" data-toggle="popover" data-placement="bottom"> Property Type </button>
                    <div id="content">
                        <h4>Property Type</h4>
                        <ul class="main-34">
                            <li><i class="fa fa-building-o"></i> Any</li>
                            <li class="active"><i class="fa fa-home"></i> House</li>
                            <li><i class="fa fa-building-o"></i> Apartments </li>
                            <li><i class="fa fa-building-o"></i> Office </li>
                            <li><i class="fa fa-home"></i> Other</li>
                            <div class="clearfix"></div>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="filter-btn-mobo">
                    <button id="example2" type="button" class="btn btn-pophover" data-container="body" data-toggle="popover" data-placement="bottom"> Price</button>
                    <div id="content2">

                        <h4>Price</h4>
                        <div class="main-35">
                            <div class="range-slider">
                                <label>Price</label>
                                <div data-min="0" data-max="150000" data-unit="USD" data-min-name="min_price" data-max-name="max_price" class="range-slider-ui ui-slider" aria-disabled="false"></div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="filter-btn-mobo">
                    <button id="example3" type="button" class="btn btn-pophover" data-container="body" data-toggle="popover" data-placement="bottom"> Badrooms</button>
                    <div id="content3">
                        <h4>Badrooms</h4>
                        <ul class="main-36">
                            <li class="active"> Any</li>
                            <li>1+</li>
                            <li>2+ </li>
                            <li>3+</li>
                            <li>4+</li>
                            <li>5+</li>
                            <div class="clearfix"></div>
                        </ul>
                        <div class="clearfix"></div>
                        <p class="text-center">Or select badrooms Range</p>
                        <div class="input-box-mob">
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" class="form-control" placeholder="No Min">
                                </div>
                                <div class="col-md-2">to</div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" placeholder="No Max">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="filter-btn-mobo">
                    <button id="example4" type="button" class="btn btn-pophover" data-container="body" data-toggle="popover" data-placement="bottom"> Sort By </button>
                    <div id="content4">
                        <h4>Sort By</h4>
                        <ul class="main-33">
                            <li class="active"> Low to High</li>
                            <li> Hight to low</li>
                            <div class="clearfix"></div>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="filter-btn-mobo">
                    <button type="button" class="btn btn-pophover"> More Filter</button>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="pull-right btns-area">
                <a href="#" class="change-view-btn ">List View</a>
                <a href="#" class="change-view-btn active-view-btn">Map View</i></a>
            </div>
        </div>
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
@endsection

@push('scripts')
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
<script src="assets/properties/js/maps.js"></script>
<script src="assets/properties/js/app.js"></script>
<script>
var ops = {
    'html':true,    
    content: function(){
        return $('#content').html();
    }
};

$(function(){
    $('#example').popover(ops)
});
var ops1 = {
    'html':true,    
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


</script>
@endpush