<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo isset($title) && html_escape($title) != 'Home' ? html_escape($title) . ' | ' . html_escape(CFG_TITLE) : html_escape(CFG_TITLE); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">

    <link rel="icon" href="assets/favicon.svg" sizes="any" type="image/svg+xml">
    <link rel="icon" type="image/png" href="assets/favicon.png" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css' />
    <link rel="stylesheet" type="text/css" href="{{ site_url('assets/css/bootstrap.min.css') }}">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css' />
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    @stack('styles')
    <link rel="stylesheet" type="text/css" href="{{ site_url('assets/css/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ site_url('assets/css/styles.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ site_url('assets/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ site_url('assets/css/mystyles.css') }}">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-148732850-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-148732850-1');
    </script>
</head>

<body class="@if ( isset($slug)){{$slug}}@endif">
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

                    <li class="nav-item dropdown" id="about-diraleads-web">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Why DiraLeads <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/renters" style="font-family: Raleway, sans-serif;">The Renter's View</a>
                            <a class="dropdown-item" href="/owners" style="font-family: Raleway, sans-serif;">The Owner's Perch</a>
                        </div>
                    </li>
                    <!-- Mobile View -->
                    <li class="nav-item" id="about-diraleads-mobile">
                        <a href="javascript:showAboutOptions()">
                        Why DiraLeads <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="nav-item" id="about-diraleads-renter" style="display: none">
                        <a class="nav-link" href="/renters" style="font-family: Raleway, sans-serif;">The Renter's View</a>
                    </li>
                    <li class="nav-item" id="about-diraleads-owner" style="display:none">
                        <a class="nav-link" href="/renters" style="font-family: Raleway, sans-serif;">The Owner's View</a>
                    </li>
                    <!--  -->
                    <li class="nav-item">
                        <a class="nav-link" href="/properties">View Rentals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/rental">List Your Rental</a>
                    </li>

                    @if (!isset($_SESSION['id']))
                    <li class="nav-item login">
                        <a class="nav-link" href="{{ site_url('login') }}">
                            <img src="{{ site_url('assets/images/login.png') }}"> Login / Signup

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
                            <img src="{{ site_url('/assets/img/avatar/user.png') }}" width="20" alt="avatar">
                            Hi, {{ explode(' ', $_SESSION['name'])[0] }}
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?php echo site_url('dashboard'); ?>">Dashboard</a>
                            <a class="dropdown-item" href="<?php echo site_url('my_rentals'); ?>">My Rentals</a>
                            <a class="dropdown-item" href="<?php echo site_url('subscription/user'); ?>">My Subscriptions</a>
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

    @if ( isset($banner_type) && $banner_type == 'main' && $slug != 'terms' && $slug != 'about')
    <div class="banner-main">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/images/slide1.webp" class="" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="assets/images/slide2.webp" class="" alt="...">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="banner-text w-100">
            <p class="primary-text text-center">The Jewish short-term rental marketplace</p>
            <p class="secondary-text text-center">Connecting renters with property owners for brief stays in</p>
            <p class="secondary-text text-center">heimishe neighborhoods worldwide</p>
        </div>

        <div class="search-main">
            <div class="tabbing-sec p-0 border-0">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="search-box" style="padding: 5px 20px;">
                            <ul>
                                <li>
                                    <div class="form-group">
                                        <label for="filter_area">Area</label>
                                        <select class="form-control areaSelect" id="filter_area">
                                            @if ( isset($areas))
                                            <option value="any">Any</option>
                                            @foreach ($areas as $area)

                                            <option value="{{$area['title']}}">{{ $area['title'] }}</option>

                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <label for="filter_date">Dates</label>
                                        <input type="text" class="form-control dateRangePicker" id="filter_date" name="daterange" readonly>

                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <label for="bedroom">Bedrooms</label>
                                        <div class="max-min">
                                            <input type="number" id="bedroom" name="name" class="form-control" placeholder="Bedrooms">
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <label for="price_max">Price</label>
                                        <div class="max-min">
                                            <input type="number" id="price_max" name="name" class="form-control" placeholder="max">
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex justify-content-center align-items-center p-0">
                                    <a class="areaFilter" href="javascript:search();">LOCATE MY DREAM RENTAL</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif

    @yield('content')

    <div class="footer-sec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5 col-12">
                    <div class="footer-link">
                        <img src="{{ site_url() }}uploads/{{ CFG_LOGO }}" alt="logo">
                        <p>Connecting Jewish property owners and
                            renters worldwide - the hassle-free way</p>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    @php
                    $footer_useful = get_menu('useful');
                    @endphp
                    <div class="foot footer-menu">
                        <h3>
                            Useful Links
                        </h3>
                        <ul>
                            @foreach ($footer_useful as $menu)
                            <li>
                                @if($menu['url'] == 'home')
                                @php $menu['url'] = '/'; @endphp
                                @endif

                                <a href="{{ $menu['url'] }}">{{ $menu['title']}}</a>
                                <!-- <a href="{{ $menu['url'] }}">{{ ucfirst(strtolower($menu['title']))}}</a> -->
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <input type="hidden" class="loggedId" value="{{isset($_SESSION['id']) && $_SESSION['id']}}">
                <div class="col-lg-4 col-12">
                    <div class="foot footer-email">
                        <h3>News & Update </h3>
                        <form id="subscribe-email-form" class="form-inline" action="#" method="GET">
                            <input type="text" class="form-control mb-sm-0" id="email-subscribe" placeholder="Email Address">
                            <button type="submit" name="email-subscribe-button" class="btn"><img src="{{ site_url('assets/images/email.png') }}"></button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-12 col-12">
                    <div class="copy-right">
                        <p>© Copyright 2020. All rights reserved <a href="/">{{ CFG_TITLE }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/scrollup/2.4.1/jquery.scrollUp.min.js'></script>

    @stack('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
    <script src="{{ site_url('/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ site_url('/assets/js/app.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.areaFilter').on('click', function() {
                var site = "<?php echo site_url() ?>";
                var areaSelect = $('.areaSelect').find(":selected").val();
                var dateRange = $('.dateRangePicker').val().split('-');
                var from = dateRange[0];
                var to = dateRange[1];
                var price_max = $('#price_max').val();
                var toDate = moment(to).format("YYYY-DD-MM");
                var fromDate = moment(from).format("YYYY-DD-MM");
                var bedroom = $('#bedroom').val();
                window.location = site + 'properties/lists?for=short%20term%20rent&area=' + areaSelect + '&fromDate=' + fromDate + '&toDate=' + toDate + '&bedroom=' + bedroom + '&price_max=' + price_max

            })
        })

        // Email Subscribe
        $('#subscribe-email-form').submit(function(e) {
            e.preventDefault();
        });

        $('button[name="email-subscribe-button"]').click(function() {
            $('#subscribe-email-form').submit(function(e) {
                e.preventDefault();
            });

            $.ajax({
                url: '<?php echo site_url('email_enquiry/email_subscribe') ?>',
                type: "POST",
                dataType: 'json',
                data: {
                    email: $('#email-subscribe').val(),
                    <?php $CI = &get_instance();
                    echo $CI->security->get_csrf_token_name(); ?>: '<?php echo $CI->security->get_csrf_hash(); ?>'
                },
                success: function(data) {
                    console.log(data)
                    if (data.success == false)
                        toastr.error(data.error);
                    else
                        toastr.success(data.message);
                },
                error: function() {},
                complete: function() {
                    console.log('complete');
                }
            });
            // toastr.success('Success messages');
        });
    </script>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.customer-logos').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 3500,
                    arrows: true,
                    dots: false,
                    pauseOnHover: false,
                    responsive: [{
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1
                        }
                    }, {
                        breakpoint: 520,
                        settings: {
                            slidesToShow: 1
                        }
                    }]
                });
            }, 1000);
        });
    </script>

    <script>
        function search() {
            const areaId = document.getElementById('filter_area').value == '' ? 'any' : document.getElementById('filter_area').value;
            const bedroom = document.getElementById('bedroom').value == '' ? 'any' : document.getElementById('bedroom').value;
            const price = document.getElementById('price_max').value == '' ? 0 : document.getElementById('price_max').value;

            document.location.href = `/properties?type=any&bedroom=${bedroom}&bathroom=any&more=any&sort_by=any&price=0|${price}&street=any&location=any&area=${areaId}`;
        }
    </script>
    
    <script>
        $(document).ready(function () {
            setVisibleNavBar();

            $(window).resize(function () {
                setVisibleNavBar();
            });
        });

        function setVisibleNavBar() {
            
            if ($(document).width() < 1200) {
                    document.getElementById('about-diraleads-mobile').style = "display: block;";
                    document.getElementById('about-diraleads-web').style = "display: none;";
                } else {
                    document.getElementById('about-diraleads-web').style = "display: block;";
                    document.getElementById('about-diraleads-mobile').style = "display: none;";
                    document.getElementById('about-diraleads-owner').style = "display: none;";
                    document.getElementById('about-diraleads-renter').style = "display: none;";
                }
        }

        function showAboutOptions() {
            if ( document.getElementById('about-diraleads-owner').style.display == 'block') {
                document.getElementById('about-diraleads-owner').style = "display: none;";
                document.getElementById('about-diraleads-renter').style = "display: none;";
            } else {
                document.getElementById('about-diraleads-owner').style = "display: block;";
                document.getElementById('about-diraleads-renter').style = "display: block;";
            }
        }

    </script>
</body>

</html>