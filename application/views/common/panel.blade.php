<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ CFG_TITLE }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="icon" href="assets/favicon.svg" sizes="any" type="image/svg+xml">
    <link rel="icon" type="image/png" href="assets/favicon.png" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css' />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css' />
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' />
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='assets/fonts/flaticon/font/flaticon.css' />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    @stack('styles')
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">

    <?php
    $CI = &get_instance();
    ?>
</head>

<body>
    <div class="my-header">
        <nav class="navbar navbar-expand-xl navbar-light container-fluid">
            <a class="navbar-brand" href="{{ site_url() }}"><img src="<?php echo  site_url('uploads/diraleads-logo.svg'); ?>"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    @php
                    $header_menu = get_menu('main');
                    @endphp
                    <!--      @foreach ($header_menu as $menu)
                            @if ($menu['parent_menu_id'] == 0)    
                            <li class="nav-item {{ $menu['url'] == current_url() ? 'active' : '' }}">
                            @if($menu['title'] == 'Properties')
                                 <a href="{{ site_url($menu['url'])}}?for=short%20term%20rent" class="nav-link">{{ $menu['title'] }}</a>
                            @else
                                <a href="{{ site_url($menu['url']) }}" class="nav-link">{{ $menu['title'] }}</a>
                            @endif
                            </li>
                            @endif
                            @endforeach -->

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Why DiraLeads <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/renters" style="font-family: Raleway, sans-serif;">THE RENTER'S VIEW</a>
                            <a class="dropdown-item" href="/owners" style="font-family: Raleway, sans-serif;">THE OWNER'S PERCH</a>
                        </div>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);">Tour Neighborhoods</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="/properties">View Rentals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/rental">List Your Rental</a>
                    </li>

                    @if (!isset($_SESSION['id']))
                    <li class="nav-item login">
                        <a class="nav-link" href="{{ site_url('login') }}">
                            <img src="{{ site_url() }}assets/images/login.png"> Login / Signup

                        </a>
                    </li>
                    @endif
                </ul>
                @if (isset($_SESSION['id']))
                <style>
                    .dropdown-menu a {
                        color: #000 !important;
                    }
                </style>
                <ul class="navbar-nav offcanvas-navbar position-relative">
                    <div class="dropdown btns">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ site_url() }}/assets/img/avatar/user.png" width="20" alt="avatar">
                            Hi, {{ explode(' ', $_SESSION['name'])[0] }}
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?php echo site_url('dashboard'); ?>">Dashboard</a>
                            <a class="dropdown-item" href="<?php echo site_url('my_rentals'); ?>">My Rentals</a>
                            <a class="dropdown-item" href="<?php echo site_url('profile'); ?>">My profile</a>
                            <a class="dropdown-item" href="<?php echo site_url('login/logout'); ?>">Logout</a>
                        </div>
                    </div>
                    <li class="nav-item  position-relative d-none">
                        <a class="nav-link" href="{{ site_url('login/logout') }}">
                            Logout
                        </a>
                    </li>
                </ul>
                @endif
            </div>
        </nav>
    </div>

    <div class="dashboard">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2 col-md-12 col-sm-12 col-pad">
                    <div class="dashboard-nav d-none d-xl-block d-lg-block">
                        <div class="dashboard-inner">
                            <h4>Main</h4>
                            <ul>
                                <li class="<?php if (site_url('dashboard') == site_url('dashboard')) {
                                                echo "active";
                                            } ?>"><a href="{{ site_url('dashboard') }}"><i class="flaticon-dashboard"></i> Dashboard</a></li>
                                <li class=""><a href="<?php echo site_url('favourites'); ?>"><i class="flaticon-heart"></i> Favourites</a></li>
                            </ul>
                            <h4>Property</h4>
                            <ul>
                                <li><a href="{{ site_url('my_rentals') }}"><i class="flaticon-apartment-1"></i>My
                                        Rentals</a></li>
                                <!-- <li><a href="{{ site_url('property') }}"><i class="flaticon-plus"></i>Submit
                                            Property</a></li> -->
                            </ul>
                            <h4>Subscription</h4>
                            <ul>
                                <li><a href="{{ site_url('subscription/user') }}"><i class="flaticon-financial"></i>My Email Preferences</a></li>
                                {{-- <li><a href="preferences"><i class="flaticon-heart"></i>My Preferences</a></li> --}}
                                <!-- <li><a href="{{ site_url('pricing/custom_pricing') }}"><i class="flaticon-financial"></i>Subscribe
                                            New Plan</a></li> -->
                            </ul>
                            <h4>Account</h4>
                            <ul>
                                <!--  <li><a href="invoices"><i class="flaticon-bill"></i>My Invoices</a></li> -->
                                <li><a href="{{ site_url('profile') }}"><i class="flaticon-people"></i>My
                                        Profile</a></li>
                                <li><a href="{{ site_url('login/logout') }}"><i class="flaticon-logout"></i>Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-10 col-md-12 col-sm-12 col-pad">
                    <div class="content-area5">
                        <div class="dashboard-content">
                            <div class="dashboard-header clearfix">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <h4>Hello , {{ $_SESSION['name'] }}</h4>
                                    </div>
                                </div>
                            </div>

                            @yield('content')
                        </div>
                        <p class="sub-banner-2 text-center">© Copyright 2020. All rights reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="Properties-popup">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="slider-popup">
                    <div id="demo" class="carousel slide" data-ride="carousel">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/scrollup/2.4.1/jquery.scrollUp.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>
    @stack('scripts')
    <script src="/assets/js/app.js"></script>
    <script>
        $(function() {
            $('body').on('click', '.favLinkButton', function() {
                $.LoadingOverlay("show", {
                    image: "",
                    fontawesome: "fa fa-cog fa-spin"
                });
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
                        $.LoadingOverlay("hide");
                        if (data.response == 'remove') {
                            toastr.success('Rental removed from favorites');
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
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

        function showDetails(id) {
            $.ajax({
                type: "post",
                url: "<?php echo site_url('properties/viewDetails') ?>",
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
                        var base_path = "<?php echo  site_url("uploads/") ?>";
                        $(".carousel-inner").append("<div class='carousel-item " + active + "'><img src='" + base_path + value.path + "' /></li>");
                    });

                    $(".prepends").remove();
                    $(".contectDetail").append("<span>Property ID:" + res.property.id + "</span>" + "<span>Property Price:$" + res.property.price + "</span><span>Property status: For " + res.property.for+"</span><span>Property Type: " + res.property.type + "</span><p class='moreDetails'>");
                    $.each(res.property_attributes, function(key, value) {
                        var icon_path = '<?php echo site_url("") ?>';
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
</body>

</html>