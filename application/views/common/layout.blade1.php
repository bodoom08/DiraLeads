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
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    @stack('styles')
    <link rel="stylesheet" type="text/css" href="{{ site_url('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ site_url('assets/css/responsive.css') }}">
</head>

<body>
    <header class="main-header header-transparent sticky-header">
        <nav class="navbar navbar-expand-lg demo-2">
            <div class="container navbar-container">
                <a class="navbar-brand" href="/">
                    <img style="width: 146px;" src="uploads/{{ CFG_LOGO }}" alt="logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars iconbar"></i>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        @php
                        $header_menu = get_menu('main');
                        @endphp
                        @foreach ($header_menu as $menu)
                        @if ($menu['parent_menu_id'] == 0)
                        <li class="nav-item {{ $menu['url'] == current_url() ? 'active' : 'dropdown position-relative' }}">
                            <a href="{{ $menu['url'] }}" class="nav-link">{{ $menu['title'] }}</a>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                    @if (isset($_SESSION['id']))
                    <ul class="navbar-nav offcanvas-navbar position-relative">
                        <li class="nav-item ">
                            <h6>Hi, {{ explode(' ', $_SESSION['name'])[0] }}</h6>
                        </li>
                        <li class="nav-item  position-relative">
                            <a class="nav-link" href="{{ site_url('login/logout') }}">
                                Logout
                            </a>
                        </li>
                    </ul>
                    @else
                    <ul class="navbar-nav offcanvas-navbar position-relative">
                        <li class="nav-item  position-relative">
                            <a class="nav-link" href="{{ site_url('login') }}">
                                Login
                            </a>
                        </li>
                    </ul>
                    @endif
                </div>
            </div>

        </nav>
    </header>

    @if ( isset($banner_type) && $banner_type == 'main')
    <div class="banner" id="banner">
        <div id="bannerCarousole" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item banner-max-height active">
                    <img class="d-block w-100" src="assets/img/slider.jpg" alt="banner">
                    <div class="carousel-caption banner-slider-inner d-flex h-100 text-center">
                        <div class="carousel-content container">
                            <div class="text-center">
                                <p>WANT TO BUY OR RENT HOME ?</p>
                                <h3><span> DiraLeads</span> SOLVE YOUR<br />PROBLEMS</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item banner-max-height">
                    <img class="d-block w-100" src="assets/img/slider.jpg" alt="banner">
                    <div class="carousel-caption banner-slider-inner d-flex h-100 text-center">
                        <div class="carousel-content container">
                            <div class="text-center">
                                <p>WANT TO BUY OR RENT HOME ?</p>
                                <h3><span> DiraLeads</span> SOLVE YOUR<br />PROBLEMS</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item banner-max-height">
                    <img class="d-block w-100" src="assets/img/slider.jpg" alt="banner">
                    <div class="carousel-caption banner-slider-inner d-flex h-100 text-center">
                        <div class="carousel-content container">
                            <div class="text-center">
                                <p>WANT TO BUY OR RENT HOME ?</p>
                                <h3><span> DiraLeads</span> SOLVE YOUR<br />PROBLEMS</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#bannerCarousole" role="button" data-slide="prev">
                <span class="slider-mover-left" aria-hidden="true">
                    <i class="fa fa-angle-left"></i>
                </span>
            </a>
            <a class="carousel-control-next" href="#bannerCarousole" role="button" data-slide="next">
                <span class="slider-mover-right" aria-hidden="true">
                    <i class="fa fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
    @else
    <div class="sub-banner overview-bgi">
    </div>
    @endif

    @yield('content')

    <footer class="footer">
        <div class="container footer-inner">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-item clearfix">
                        <img style="max-height: 75px;" src="/uploads/{{ CFG_LOGO }}" alt="logo">
                        <div class="text">
                            <p>{{ CFG_FOOTER_DESC }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    @php
                    $footer_useful = get_menu('useful');
                    @endphp
                    <div class="footer-item">
                        <h4>
                            Useful Links
                        </h4>
                        <ul class="links">
                            @foreach ($footer_useful as $menu)
                            <li>
                                <a href="{{ $menu['url'] }}">{{ $menu['title'] }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    @php
                    $footer_quick = get_menu('quick');
                    @endphp
                    <div class="footer-item">
                        <h4>
                            Quick Links
                        </h4>
                        <ul class="links">
                            @foreach ($footer_quick as $menu)
                            <li>
                                <a href="{{ $menu['url'] }}">{{ $menu['title'] }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-item clearfix">
                        <h4>News & Update </h4>
                        <div class="f-border"></div>
                        <div class="Subscribe-box">
                            <form class="form-inline" action="#" method="GET">
                                <input type="text" class="form-control mb-sm-0" id="email-subscribe" placeholder="Email Address">
                                <button type="submit" name="email-subscribe-button" class="btn"><i class="fa fa-paper-plane"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="sub-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <p class="copy">© Copyright 2020. All rights reserved <a href="/">{{ CFG_TITLE }}</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/scrollup/2.4.1/jquery.scrollUp.min.js'></script>
    @stack('scripts')
    <script src="/assets/js/app.js"></script>
</body>

</html>