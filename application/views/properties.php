<?php
defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/layout/top', [
    'title' => 'Properties'
]);
?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"> -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/lightslider.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/properties/css/bootstrap-select.min.css'); ?>" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha256-siyOpF/pBWUPgIcQi17TLBkjvNgNQArcmwJB8YvkAgg=" crossorigin="anonymous" />
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPhDpAUyER52TsCsLFNOOxT_l5-y7e78A&libraries=places&callback=initMap">
</script>
<style>
    .my-header {
        position: fixed;
        left: 0;
        right: 0;
        top: 0;
        z-index: 100;
        height: 80px;
        background: white;
    }

    .explore-search {
        position: fixed;
        left: 0;
        right: 0;
        top: 80px;
        z-index: 100;
        background: white;
        margin: 0 !important;
        padding: 20px 0;
    }

    .title-bar {
        position: fixed;
        left: 0;
        right: 0;
        top: 180px;
        z-index: 100;
        background: white;
        height: 100px;
    }

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
    #content4,
    #content5,
    #content6
     {
        display: none;
    }

    .search-page {
        margin: 0 !important;
        min-height: calc(100vh - 260px);

        margin: 0 !important;
        min-height: calc(100vh - 300px);
        z-index: 10;
        left: 0;
        right: 0;
        top: 270px;
        position: absolute;
    }

    .search-page .map-region {
        position: fixed;
        height: calc(100vh - 300px);
        right: 0;
    }
    .map-region #map {
        height: 100%;
    }

    .view-product {
        max-height: 100%;
        overflow: hidden;
    }

    .item-list {

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
        background-size: inherit;

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

    #item-detail-dialog {
        position: fixed;
        z-index: 100;
        width: 290px;
        height: 320px;
        display: none;
    }
</style>

<div class="explore-search">
    <div class="inner-search px-4">
        <div class="find-search-box">
            <input type="search" name="" id="street_search" placeholder="e.g- Brooklyn" value="<?php echo isset($_GET['street']) ? $_GET['street'] : '' ;?>">
            <span><a href="javascript:void()" name="button_search"><img src="<?php echo site_url('assets/images/search.png'); ?>" /></a></span>
        </div>

        <div class="filter-btn-mobo">
            <button id="example" type="button" class="btn btn-pophover" data-container="body" data-toggle="popover" data-placement="bottom" onclick="changeIcon(this);"> Rental Type
                &nbsp;<i class="fa fa-angle-down"></i></button>
            <div id="content">
                <h4>Rental Type</h4>
                <ul class="main-34">
                    <li <?php echo (isset($_GET['type']) && $_GET['type'] == 'any') || (!isset($_GET['type'])) ? 'class=active' : '' ;?>>
                        <button class="btn <?php echo isset($_GET['type']) && $_GET['type'] == 'any' || (!isset($_GET['type'])) ? 'active' : ''; ?>" onclick="filter({name: 'type', value: 'any'})">
                            <i class="fa fa-building-o"></i>
                            Any
                        </button>
                    </li>
                    <li <?php echo isset($_GET['type']) && $_GET['type'] == 'house' ? 'class=active' : '' ;?>>
                        <button class="btn <?php echo isset($_GET['type']) && $_GET['type'] == 'house' ? 'active' : '' ;?>" onclick="filter({name: 'type', value: 'house'})">
                            <i class="fa fa-home"></i>
                            House
                        </button>
                    </li>
                    <li <?php echo isset($_GET['type']) && $_GET['type'] == 'apartment' ? 'class=active' : '' ;?>>
                        <button class="btn <?php echo isset($_GET['type']) && $_GET['type'] == 'apartment' ? 'active' : '' ;?>" onclick="filter({name: 'type', value: 'apartment'})">
                            <i class="fa fa-building-o"></i>
                            Apartments
                        </button>
                    </li>
                    <li <?php echo isset($_GET['type']) && $_GET['type'] == 'duplex' ? 'class=active' : '' ;?>>
                        <button class="btn <?php echo isset($_GET['type']) && $_GET['type'] == 'duplex' ? 'active' : '' ;?>" onclick="filter({name: 'type', value: 'duplex'})">
                            <i class="fa fa-building-o"></i>
                            Duplex
                        </button>
                    </li>
                    <li <?php echo isset($_GET['type']) && $_GET['type'] == 'villa' ? 'class=active' : '' ;?>>
                        <button class="btn <?php echo isset($_GET['type']) && $_GET['type'] == 'villa' ? 'active' : '' ;?>" onclick="filter({name: 'type', value: 'villa'})">
                            <i class="fa fa-home"></i>
                            Villa
                        </button>
                    </li>
                    <li <?php echo isset($_GET['type']) && $_GET['type'] == 'basement' ? 'class=active' : '' ;?>>
                        <button class="btn <?php echo isset($_GET['type']) && $_GET['type'] == 'basement' ? 'active' : '' ;?>" onclick="filter({name: 'type', value: 'basement'})">
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
            </div>
        </div>

        <div class="filter-btn-mobo">
            <button id="example3" type="button" class="btn btn-pophover" data-container="body" data-toggle="popover" data-placement="bottom" onclick="changeIcon(this);"> Bedrooms &nbsp;<i class="fa fa-angle-down"></i></button>
            <div id="content3">
                <h4>Bedrooms</h4>
                <ul class="main-36">
                    <li <?php echo (isset($_GET['bedroom']) && $_GET['bedroom'] == 'any') || !isset($_GET['bedroom']) ? 'class=active' : '' ;?>>
                        <button class="btn propery_any <?php echo isset($_GET['bedroom']) && $_GET['bedroom'] == 'any' || !isset($_GET['bedroom']) ? 'active' : '' ;?>" onclick="filter({name: 'bedroom', value: 'any'})">
                            Any
                        </button>
                    </li>
                    <li <?php echo isset($_GET['bedroom']) && $_GET['bedroom'] == '1' ? 'class=active' : '' ;?>>
                        <button class="btn <?php echo isset($_GET['bedroom']) && $_GET['bedroom'] == '1' ? 'active' : '' ;?>" onclick="filter({name: 'bedroom', value: '1'})">
                            1+
                        </button>
                    </li>
                    <li <?php echo isset($_GET['bedroom']) && $_GET['bedroom'] == '2' ? 'class=active' : '' ;?>>
                        <button class="btn <?php echo isset($_GET['bedroom']) && $_GET['bedroom'] == '2' ? 'active' : '' ;?>" onclick="filter({name: 'bedroom', value: '2'})">
                            2+
                        </button>
                    </li>
                    <li <?php echo isset($_GET['bedroom']) && $_GET['bedroom'] == '3' ? 'class=active' : '' ;?>>
                        <button class="btn <?php echo isset($_GET['bedroom']) && $_GET['bedroom'] == '3' ? 'active' : '' ;?>" onclick="filter({name: 'bedroom', value: '3'})">
                            3+
                        </button>
                    </li>
                    <li <?php echo isset($_GET['bedroom']) && $_GET['bedroom'] == '4' ? 'class=active' : '' ;?>>
                        <button class="btn <?php echo isset($_GET['bedroom']) && $_GET['bedroom'] == '4' ? 'active' : '' ;?>" onclick="filter({name: 'bedroom', value: '4'})">
                            4+
                        </button>
                    </li>
                    <li <?php echo isset($_GET['bedroom']) && $_GET['bedroom'] == '5' ? 'class=active' : '' ;?>>
                        <button class="btn <?php echo isset($_GET['bedroom']) && $_GET['bedroom'] == '5' ? 'active' : '' ;?>" onclick="filter({name: 'bedroom', value: '5'})">
                            5+
                        </button>
                    </li>
                    <div class="clearfix"></div>
                </ul>

            </div>
            <div class="clearfix"></div>
        </div>
     

        <div class="filter-btn-mobo sortby">
            <button id="example5" type="button" class="btn btn-pophover" data-container="body" data-toggle="popover" data-placement="bottom" onclick="changeIcon(this);"> Bathroom &nbsp;<i class="fa fa-angle-down"></i> </button>
            <div id="content5">
                <h4>Bathroom</h4>
                <h5 style="text-align: center;">Bathroom</h5>
                <ul class="main-36">
                    <li <?php echo (isset($_GET['bathroom']) && $_GET['bathroom'] == 'any') || !isset($_GET['bathroom']) ? 'class=active' : '' ;?>>
                        <button class="btn propery_any <?php echo isset($_GET['bathroom']) && $_GET['bathroom'] == 'any' || !isset($_GET['bathroom']) ? 'active' : '' ;?>" onclick="filter({name: 'bathroom', value: 'any'})">
                            Any
                        </button>
                    </li>
                    <li <?php echo isset($_GET['bathroom']) && $_GET['bathroom'] == '1' ? 'class=active' : '' ;?>>
                        <button class="btn <?php echo isset($_GET['bathroom']) && $_GET['bathroom'] == '1' ? 'active' : '' ;?>" onclick="filter({name: 'bathroom', value: '1'})">
                            1+
                        </button>
                    </li>
                    <li <?php echo isset($_GET['bathroom']) && $_GET['bathroom'] == '2' ? 'class=active' : '' ;?>>
                        <button class="btn <?php echo isset($_GET['bathroom']) && $_GET['bathroom'] == '2' ? 'active' : '' ;?>" onclick="filter({name: 'bathroom', value: '2'})">
                            2+
                        </button>
                    </li>
                    <li <?php echo isset($_GET['bathroom']) && $_GET['bathroom'] == '3' ? 'class=active' : '' ;?>>
                        <button class="btn <?php echo isset($_GET['bathroom']) && $_GET['bathroom'] == '3' ? 'active' : '' ;?>" onclick="filter({name: 'bathroom', value: '3'})">
                            3+
                        </button>
                    </li>
                    <li <?php echo isset($_GET['bathroom']) && $_GET['bathroom'] == '4' ? 'class=active' : '' ;?>>
                        <button class="btn <?php echo isset($_GET['bathroom']) && $_GET['bathroom'] == '4' ? 'active' : '' ;?>" onclick="filter({name: 'bathroom', value: '4'})">
                            4+
                        </button>
                    </li>
                    <li <?php echo isset($_GET['bathroom']) && $_GET['bathroom'] == '5' ? 'class=active' : '' ;?>>
                        <button class="btn <?php echo isset($_GET['bathroom']) && $_GET['bathroom'] == '5' ? 'active' : '' ;?>" onclick="filter({name: 'bathroom', value: '5'})">
                            5+
                        </button>
                    </li>
                    <div class="clearfix"></div>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="w-50 d-flex justify-content-between title-bar">
    <div class="pl-4">
        <h5><?php echo isset($_GET['street']) && $_GET['street'] != 'any' ? $_GET['street'] : 'All';?></h5>
        <small><?php echo isset($properties) ? count($properties) : 0?> rentals available on DiraLeads</small>
    </div>
    <div class="filter-btn-mobo sortby">
        <button id="example4" type="button" class="btn btn-pophover" data-container="body" data-toggle="popover" data-placement="bottom" onclick="changeIcon(this);"> Sort By &nbsp;<i class="fa fa-angle-down"></i> </button>
        <div id="content4">
            <h4>Sort By</h4>
            <ul class="main-33">
                <li class="active"><button class="btn <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] == 'low-high' ? 'active' : '' ;?>" onclick="filter({name: 'sort_by', value: 'low-high'})">Low to High</button></li>
                <li><button class="btn <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] == 'high-low' ? 'active' : '' ;?>" onclick="filter({name: 'sort_by', value: 'high-low'})">High to Low</button></li>
                <li class="active"><button class="btn <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] == 'newest' ? 'active' : '' ;?>" onclick="filter({name: 'sort_by', value: 'newest'})">Newest</button></li>
                <li class="active"><button class="btn <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] == 'oldest' ? 'active' : '' ;?>" onclick="filter({name: 'sort_by', value: 'oldest'})">Oldest</button></li>
                <div class="clearfix"></div>
            </ul>
        </div>  
    </div>
</div>

<div class="row search-page">
    <div class="col-lg-6 h-100">
        <div class="w-100 item-list">
        <?php  if (!isset($properties) || count($properties) == 0) {?>
            <h5 class="text-center">No Rentals</h5>
        <?php } else {
                foreach($properties as $property) {
        ?>
            <div class="item-card">
                <?php  $path = isset($property['images']) && count($property['images']) > 0 ? $property['images'][0]['path'] : 'home-2.jpg'; ?>
                <div class="item-image" style="background-image: url(<?php echo site_url('uploads/' . $path);?>)">
                    <div class="item-badge">
                    </div>
                    <a href="javascript:;" >❤</a>
                </div>
                <div class="item-desc">
                    <!-- <h5>$<?php echo isset($property['price']) ? $property['price'] : 0; ?>/mo</h5> -->
                    <p class="font-weight-bold">$<?php echo isset($property['days_price']) ? $property['days_price'] : 0; ?>/day, $<?php echo isset($property['weekly_price']) ? $property['weekly_price'] : 0; ?>/week</p>
                    <p>🏠<?php echo isset($property['bedrooms']) ? $property['bedrooms'] : 0;?>bd 🎉<?php echo isset($property['bathrooms']) ? $property['bathrooms'] : 0;?>ba ✨ <?php echo isset($property['florbas']) ? $property['florbas'] : 0;?> sqft</p>
                    <p><?php echo isset($property['title']) ? $property['title'] : ''; ?></p>
                    <p><?php echo isset($property['street']) ? $property['street'] : ''; ?></p>
                </div>
            </div>
        <?php } } ?>
        </div>
    </div>
    <div class="col-lg-6 map-region">
        <div id="map"></div>
    </div>
</div>

<div class="item-card" id="item-detail-dialog">
    <div class="item-image">
        <div class="item-badge">
        </div>
        <a href="javascript:;" >❤</a>
    </div>
    <div class="item-desc">
        <p class="font-weight-bold"></p>
        <p></p>
        <p></p>
        <p></p>
    </div>
</div>

<input type="hidden" id="filter_type" value="<?php echo isset($_GET['type']) ? $_GET['type'] : 'any'; ?>" />
<input type="hidden" id="filter_price" value="<?php echo isset($_GET['price']) ? $_GET['price'] : 'any'; ?>"/>
<input type="hidden" id="filter_bedroom" value="<?php echo isset($_GET['bedroom']) ? $_GET['bedroom'] : 'any'; ?>" />
<input type="hidden" id="filter_bathroom" value="<?php echo isset($_GET['bathroom']) ? $_GET['bathroom'] : 'any'; ?>" />
<input type="hidden" id="filter_more" value="<?php echo isset($_GET['more']) ? $_GET['more'] : 'any'; ?>" />
<input type="hidden" id="filter_sort_by" value="<?php echo isset($_GET['sort_by']) ? $_GET['sort_by'] : 'any'; ?>" />
<input type="hidden" id="filter_street" value="<?php echo isset($_GET['street']) ? $_GET['street'] : 'any';?>" />
<input type="hidden" id="filter_location" value="<?php echo isset($_GET['location']) ? $_GET['location'] : 'any' ?>" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="<?php echo site_url('/assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo site_url('/assets/js/bootstrap.js'); ?>"></script>
<script src="<?php echo site_url('assets/properties/js/bootstrap-select.min.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha256-2Pjr1OlpZMY6qesJM68t2v39t+lMLvxwpa8QlRjJroA=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> -->
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
            // return $('#content2').html();
            return `
                <h4>Price</h4>
                <div class="main-35 input-box-mob">
                    <ul class="main-36">
                        <li <?php echo !isset($_GET['price']) || $_GET['price'] == 'any' || $_GET['price'] == '0|0' ? 'class=active' : ''; ?>>
                            <button class="btn propery_any <?php echo !isset($_GET['price']) || $_GET['price'] == 'any' || $_GET['price'] == '0|0' ? 'class=active' : ''; ?>" onclick="filter({name: 'price', value: '0|0'})">
                                Any
                            </button>
                        </li>
                        <ul class="p-sec-n">
                            <li><input type="number" class="form-control" id="price_min" placeholder="No Min" name="min" title="No Min" value="<?php echo isset($_GET['price']) && $_GET['price'] != 'any' ? explode("|", $_GET['price'])[0] : '0';?>" onkeydown="setPrice(this, event, 'min')"></li>
                            <li class="middle-s">to</li>
                            <li><input type="number" class="form-control" id="price_max" placeholder="No Max" name="max" title="No Max" value="<?php echo isset($_GET['price']) && $_GET['price'] != 'any' ? explode("|", $_GET['price'])[1] : '0';?>" onkeydown="setPrice(this, event, 'max')"></li>
                        </ul>
                    </ul>
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="btn-md button-theme btn-block" name="pricefilter_button" onclick="setPriceFilter()">Filter</button>
                        </div>
                    </div>
                </div>
            `;
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
        $('#example5').popover(ops5);
    });
    
    function initMap(uluru = { lat: 37.0522, lng: -122.2437 }) {
        const map = new google.maps.Map(
            document.getElementById('map'), { zoom: 8, center: uluru }
        );

        let streets = `<?php echo $streets; ?>`;
        console.log("streets:", streets);
        streets = JSON.parse(streets);
        
        geocoder = new google.maps.Geocoder();
        streets.forEach((street) => {
            var marker = new google.maps.Marker({
                map,
                position: street.location
            });
            marker.addListener('mouseover', function (event) {
                document.getElementById('item-detail-dialog').style = `display: block; top: ${event.ub.clientY}px; left: ${event.ub.clientX}px;`;
                $('#item-detail-dialog .item-desc p')[0].innerHTML = `$${street.property.days_price || 0}/day, $${street.property.weekly_price || 0}/week`;
                console.log("Mouse Over: ", event);
            });

            marker.addListener('mouseout', function () {
                document.getElementById('item-detail-dialog').style = "display: none;";
            });
        });
        

        var searchEl = document.getElementById('street_search');
        var autocomplete = new google.maps.places.Autocomplete(searchEl);
        autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            const place = autocomplete.getPlace();
            const geolocation = [];
            geolocation.push(place.geometry.location.lat());
            geolocation.push(place.geometry.location.lng());
            console.log("Geolocation: ", geolocation);
            console.log("Place: ", searchEl.value);
            document.getElementById('filter_location').value = JSON.stringify(geolocation);
            $('#street_search').removeClass('invaild-input');
            filter({ name: 'street', value: searchEl.value});
        });
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

    function setPrice(element, event, option) {
        if (event.keyCode == 13) {
            let filterPrice = [0, 0];
            if (document.getElementById('filter_price').value != 'any')
                filterPrice = document.getElementById('filter_price').value.split('|');
            
            if (option == 'min') {
                filterPrice[0] = element.value;
            } else {
                filterPrice[1] = element.value;
            }
            filterPrice = filterPrice.join('|');

            filter({ name: 'price', value: filterPrice });
        }
    }   

    function setPriceFilter() {
        const minPrice = document.getElementById('price_min').value == '' ? 0 : document.getElementById('price_min').value;
        const maxPrice = document.getElementById('price_max').value == '' ? 0 : document.getElementById('price_max').value;

        document.getElementById('filter_price').value = `${minPrice}|${maxPrice}`;

        filter({ name: 'price', value: `${minPrice}|${maxPrice}`});
    }

    function filter(option) {

        console.log("Option: ", option.value);

        document.getElementById(`filter_${option.name}`).value = option.value;

        const filterType = document.getElementById('filter_type').value;
        const filterPrice = document.getElementById('filter_price').value;
        const filterBed = document.getElementById('filter_bedroom').value;
        const filterBath = document.getElementById('filter_bathroom').value;
        const filterMore = document.getElementById('filter_more').value;
        const filterSort = document.getElementById('filter_sort_by').value;
        const filterStreet = document.getElementById('filter_street').value;
        const filterLocation = document.getElementById('filter_location').value;
        const location = `/properties?type=${filterType}&bedroom=${filterBed}&bathroom=${filterBath}&more=${filterMore}&sort_by=${filterSort}&price=${filterPrice}&street=${filterStreet}&location=${filterLocation}`;

        console.log("Location: ", location);
        document.location.href = location;
    }

</script>