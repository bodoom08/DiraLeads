<!DOCTYPE html>
<html lang="en">

    <head>
        <title>{{ CFG_TITLE }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <link rel="icon" href="assets/favicon.svg" sizes="any" type="image/svg+xml">
        <link rel="icon" type="image/png" href="assets/favicon.png" />
        <link rel='stylesheet'
            href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css' />
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css' />
        <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' />
        <link rel='stylesheet' href='assets/fonts/flaticon/font/flaticon.css'/>
        <link rel='stylesheet'
            href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
        @stack('styles')
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
        <?php
            $CI =& get_instance();
         ?>
    </head>

    <body>
        <header class="main-header header-2 fixed-header">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="/">
                        <img style="width: 146px;" src="uploads/{{ CFG_LOGO }}" alt="logo">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto d-lg-none d-xl-none">
                            <li class="nav-item dropdown active">
                                <a href="{{ site_url('dashboard') }}" class="nav-link">Dashboard</a>
                            </li>
                            <li class="active"><a href="<?php echo site_url('favourites'); ?>"><i class="flaticon-heart"></i> Favourites</a></li>
                            <li class="nav-item dropdown">
                                <a href="{{ site_url('messages') }}" class="nav-link">Messages</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="{{ site_url('my_properties') }}" class="nav-link">My Properties</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="{{ site_url('invoices') }}" class="nav-link">My Invoices</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="{{ site_url('preferences') }}" class="nav-link">Preferences</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="{{ site_url('property') }}" class="nav-link">Submit Property</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="{{ site_url('profile') }}" class="nav-link">My Profile</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="{{ site_url('login/logout') }}" class="nav-link">Logout</a>
                            </li>
                        </ul>
                        <div class="navbar-buttons ml-auto d-none d-xl-block d-lg-block">
                            <ul>
                                <li>
                                    <div class="dropdown btns">
                                        <a class="dropdown-toggle" data-toggle="dropdown">
                                            <img src="{{ base_url('assets/img/avatar/user.png') }}" alt="avatar">
                                            Hi, {{ $_SESSION['name'] }}
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ site_url('dashboard') }}">Dashboard</a>
                                            <a class="dropdown-item" href="{{ site_url('my_properties') }}">My
                                                Properties</a>
                                            <a class="dropdown-item" href="{{ site_url('profile') }}">My profile</a>
                                            <a class="dropdown-item" href="{{ site_url('login/logout') }}">Logout</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <div class="dashboard">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-2 col-md-12 col-sm-12 col-pad">
                        <div class="dashboard-nav d-none d-xl-block d-lg-block">
                            <div class="dashboard-inner">
                                <h4>Main</h4>
                                <ul>
                                    <li class="active"><a href="{{ site_url('dashboard') }}"><i
                                                class="flaticon-dashboard"></i> Dashboard</a></li>
                                    <li class="active"><a href="<?php echo site_url('favourites'); ?>"><i class="flaticon-heart"></i> Favourites</a></li>
                                </ul>
                                <h4>Property</h4>
                                <ul>
                                    <li><a href="{{ site_url('my_properties') }}"><i class="flaticon-apartment-1"></i>My
                                            Properties</a></li>
                                    <li><a href="{{ site_url('property') }}"><i class="flaticon-plus"></i>Submit
                                            Property</a></li>
                                </ul>
                                <h4>Subscription</h4>
                                <ul>
                                    <li><a href="{{ site_url('subscription/user') }}"><i class="flaticon-financial"></i>My
                                            Subcription</a></li>
                                    <li><a href="preferences"><i class="flaticon-heart"></i>My Preferences</a></li>
                                    <li><a href="{{ site_url('pricing/custom_pricing') }}"><i class="flaticon-financial"></i>Subscribe
                                            New Plan</a></li>
                                </ul>
                                <h4>Account</h4>
                                <ul>
                                    <li><a href="invoices"><i class="flaticon-bill"></i>My Invoices</a></li>
                                    <li><a href="{{ site_url('profile') }}"><i class="flaticon-people"></i>My
                                            Profile</a></li>
                                    <li><a href="{{ site_url('login/logout') }}"><i
                                                class="flaticon-logout"></i>Logout</a></li>
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
                                        <div class="col-sm-12 col-md-6">
                                            <div class="breadcrumb-nav">
                                                <ul>
                                                    <li>
                                                        <a href="index.html">Index</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="active">Dashboard</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @yield('content')
                            </div>
                            <p class="sub-banner-2 text-center">© Copyright 2019. All rights reserved</p>
                        </div>
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
