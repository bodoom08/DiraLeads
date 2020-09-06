<html>
    <head>
        <title><?php echo isset($title) && html_escape($title) != 'Home' ? html_escape($title) . ' | ' . html_escape(CFG_TITLE) : html_escape(CFG_TITLE); ?></title>
        <!-- ================================================================ -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <!-- ================================================================ -->
        <link rel="icon" href="assets/favicon.svg" sizes="any" type="image/svg+xml">
        <link rel="icon" type="image/png" href="assets/favicon.png" />
        <!-- ================================================================ -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <!-- ========================== Custom Style ====================================== -->
        <style>
            /* Public Style */
            .btn-brown {
                color: #fff;
                background: #a27107;
                border-color: #a27107;
            }
            .btn-brown:hover {
                color: #fff;
                background: #433357;
                border-color: #433357;
            }
            .btn-outline-purple {
                color: #433357;
                border-color: #433357;
            }
            .btn-outline-purple:hover {
                color: #fff;
                background: #433357;
                border-color: #433357;
            }
            .check-box {
                padding: .5rem 1rem;
                line-height: 1.5;
                border-radius: .3rem;
                border-color: #6c757d;
                border: 1px solid #6c757d;
                padding-left: 2rem;
            }
            .list-group-item {
                border: none;
                padding: .25rem;
            }
            /** Popover Style */
            .popover {
                max-width: calc(100% - .5rem) !important;
            }
            /* Navbar Style */
            nav {
                padding: 0 !important;
            }
            @media only screen and (min-width: 1024px) {
                nav {
                    padding: 0 40px !important;
                }
            }
            
            .navbar {
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            }
            .navbar-brand img {
                width: 150px;
                padding: .5rem;
            }
            .navbar .nav-link, .dropdown-item {
                font-family: "Raleway", sans-serif;
                font-weight: 600;
                font-size: 16px;
                color: #000 !important;
            }

            /* Filter Option Styles */
            .filter-option {
                font-size: 16px;
                font-weight: 600;
            }
            .filter-option:after {
                display: inline-block;
                margin-left: .255em;
                vertical-align: .255em;
                content: "";
                border-left: .3em solid transparent;
                border-right: .3em solid transparent;
            }
            .filter-option.option-closed:after {
                border-top: .3em solid;
                border-bottom: 0;
            }
            .filter-option.option-opened:after {
                border-top: 0;
                border-bottom: .3em solid;
            }
            .filter-all-body {
                max-height: calc((((((((90vh - 74px) - 64px) - 4px) - 32px) - 88px) - 16px) - 16px) - 4px);
                overflow: scroll;
                margin-bottom: 2rem;
            }
            .filter-all-type {
                width: 100%;
                padding: .5rem;
                display: flex;
                justify-content: center;
            }
            .filter-all-type button {
                margin: 0;
                border-radius: 0;
            }
            .filter-all-type button:first-child {
                border-top-left-radius: .25rem;
                border-bottom-left-radius: .25rem;
                border-right: none;
            }
            .filter-all-type button:last-child {
                border-top-right-radius: .25rem;
                border-bottom-right-radius: .25rem;
                border-left: none;
            }

            /** Search Page */
            .search-filters-row {
                position: fixed;
                top: 75px;
                background: #fff;
                z-index: 100;
                width: 100%;
            }
            .search-result {
                width: 100%;
                padding: 0 .25rem;
                position: absolute;
                top: 140px;
            }
            .search-detail-title {
                font-weight: bold;
                font-size: 20px;
                line-height: 1.2;
            }
            .search-detail-result {
                font-size: 16px;
                color: rgb(134, 144, 153);
                font-weight: normal;
                margin: 0px;
                padding-bottom: 8px;
            }
            .property-card-image-slider {
                margin-bottom: .5rem;
            }
            .property-card-image-slider .carousel-inner {
                height: 160px;
                overflow: hidden;
                border-radius: .5rem;
            }
            .property-detail {
                padding: 0 .5rem;
            }
            .property-detail div {
                font-size: 16px;
                line-height: 1.5;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .property-detail svg {
                width: 20px;
                height: 20px;
            }
            .property-detail .property-detail-price {
                font-weight: bold;
                font-size: 20px;
                line-height: 1.2;
            }

            /** Map Style */
            .map-region {
                position: fixed;
                right: 0;
                height: calc(100vh - 170px);
            }
            .map-region #map {
                width: 100%;
                height: 100%;
                border-radius: .5rem;
            }
        </style>
        <!-- ========================== Google Map Scripts ================================= -->
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPhDpAUyER52TsCsLFNOOxT_l5-y7e78A&libraries=places&callback=initMap"></script>
    </head>
    <body>
        <!-- ========================= HEADER ======================================= -->
        <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-white">
            <a class="navbar-brand" href="<?php echo site_url()?>">
                <img src="<?php echo site_url('uploads/diraleads-logo.svg')?>" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <div class="ml-auto">
                </div>
                <ul class="navbar-nav navbar-right my-2 my-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Why DiraLeads</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/renters">The Renter's View</a>
                            <a class="dropdown-item" href="/owners">The Owner's Perch</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/properties">View Rentals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/property">List Your Rental</a>
                    </li>
                    <?php if (empty($_SESSION['id'])) {?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('login')?>">
                            <img src="<?php echo site_url('assets/images/login.png'); ?>"> Login / Signup
                        </a>
                    </li>
                    <?php } else {?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="<?php echo site_url('/assets/img/avatar/user.png'); ?>" width="20" alt="avatar">
                            Hi, <?php echo explode(' ', $_SESSION['name'])[0]; ?>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="userDropdownMenuLink">
                            <a class="dropdown-item" href="<?php echo site_url('dashboard')?>">Dashboard</a>
                            <a class="dropdown-item" href="<?php echo site_url('my_rentals')?>">My Rentals</a>
                            <a class="dropdown-item" href="<?php echo site_url('subscription/user')?>">My Subscriptions</a>
                            <a class="dropdown-item" href="<?php echo site_url('profile')?>">My Profile</a>
                            <a class="dropdown-item" href="<?php echo site_url('login/logout')?>">Logout</a>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>

        <div class="search-filters-row">
            <form class="form-inline my-2 p-1 d-inline-block col-sm-12 col-md-3 col-lg-2">
                <div class="input-group">
                    <input type="text" id="search-place" class="form-control" placeholder="Montreal, QC, Canada" aria-label="Montreal, QC, Canada" aria-describedby="button-search">
                    <div class="input-group-append">
                        <button class="btn btn-brown" type="submit" id="button-search">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                                <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>

            <!-- ========================== Filters for Web view ====================================== -->
            <div class="d-none d-sm-inline-block">
                <ul class="list-group list-group-horizontal my-2">
                    <li class="list-group-item">
                        <a tabindex="0" id="filter-type" class="btn btn-lg btn-white btn-outline-secondary filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom" title="Rental Type">
                            Rental Type&nbsp;&nbsp;
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a tabindex="0" id="filter-price" class="btn btn-lg btn-white btn-outline-secondary filter-option option-closed" role="button" data-container="body" data-toggle="popover" data-placement="bottom"  title="Price">
                            Price&nbsp;&nbsp;
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a tabindex="0" id="filter-bed" class="btn btn-lg btn-white btn-outline-secondary filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom" title="Bedrooms">
                            Bedrooms&nbsp;&nbsp;
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a tabindex="0" id="filter-floor" class="btn btn-lg btn-white btn-outline-secondary filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom" title="Floor">
                            Floor&nbsp;&nbsp;
                        </a>
                    </li>

                    <li class="list-group-item">
                        <div class="form-group form-check mb-0 check-box">
                            <input type="checkbox" class="form-check-input" id="show-rental">
                            <label class="form-check-label" for="show-rental">Only show Rentals with Pictures</label>
                        </div>
                    </li>

                    <li class="list-group-item">
                        <a tabindex="0" id="filter-more" class="btn btn-lg btn-white btn-outline-secondary filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom" title="More">
                            More&nbsp;&nbsp;
                        </a>
                    </li>
                </ul>
            </div>

            <!-- ====================================== Filters for Mobile View ======================================== -->
            <ul class="list-group list-group-horizontal my-2 d-flex d-sm-none justify-content-between">
                <li class="list-group-item">
                    <a tabindex="0" id="filter-all" class="btn btn-lg btn-white btn-outline-secondary filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom" title="Filter">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-sliders" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3h9.05zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8h2.05zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1h9.05z"/>
                        </svg>&nbsp;
                        Filters
                    </a>
                </li>

                <li class="list-group-item">
                    <a tabindex="0" id="filter-sort" class="btn btn-lg btn-white btn-outline-secondary filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom" title="Sort By">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-sort-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 2a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-1 0v-10A.5.5 0 0 1 3 2z"/>
                            <path fill-rule="evenodd" d="M5.354 10.146a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L3 11.793l1.646-1.647a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 9a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z"/>
                        </svg>&nbsp;
                        Sort by
                    </a>
                </li>
            </ul>
        </div>
   
        <!-- ================================ Search Results Page ============================================= -->
        <div class="search-result">
            <div class="col-sm-12 col-md-6 d-inline-block p-1">
                <div >
                    <div class="d-flex justify-content-between">
                        <div class="search-detail">
                            <div class="search-detail-title">Apartments for Rent Near Me</div>
                            <div class="search-detail-result">3,537 rentals available on Trulia</div>
                        </div>
                        <div class="search-detail-sort d-none d-sm-block">
                            <a tabindex="0" id="filter-sort-web" class="btn btn-lg btn-white btn-outline-secondary filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom" title="Sort By" style="height: unset;">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-sort-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M3 2a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-1 0v-10A.5.5 0 0 1 3 2z"/>
                                    <path fill-rule="evenodd" d="M5.354 10.146a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L3 11.793l1.646-1.647a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 9a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z"/>
                                </svg>&nbsp;
                                Sort by
                            </a>
                        </div>
                    </div>
                    <div class="w-100 d-flex flex-wrap">
                        <div class="col-sm-12 col-md-6 col-lg-4 p-1 mb-1 border-none">
                            <a href="javascript:;" class="w-100">
                                <div id="property-1" class="carousel slide property-card-image-slider" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#property-1" data-slide-to="0" class="active"></li>
                                        <li data-target="#property-1" data-slide-to="1"></li>
                                        <li data-target="#property-1" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="<?php echo site_url('assets/images/fp1.jpg')?>" class="d-block w-100" alt="img1">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?php echo site_url('assets/images/fp2.jpg')?>" class="d-block w-100" alt="img2">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?php echo site_url('assets/images/fp3.jpg')?>" class="d-block w-100" alt="img3">
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#property-1" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#property-1" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </a>
                            <div class="property-detail">
                                <div class="property-detail-price">$700/dy, $5,900/wk</div>
                                <div class="property-detail-capacity">
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M9.196 14.603h15.523v.027h1.995v10.64h-3.99v-4.017H9.196v4.017h-3.99V6.65h3.99v7.953zm2.109-1.968v-2.66h4.655v2.66h-4.655z" fill="#869099"></path></svg>
                                    5 bd</span>
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M23.981 15.947H26.6v1.33a9.31 9.31 0 0 1-9.31 9.31h-2.66a9.31 9.31 0 0 1-9.31-9.31v-1.33h16.001V9.995a2.015 2.015 0 0 0-2.016-2.015h-.67c-.61 0-1.126.407-1.29.965a2.698 2.698 0 0 1 1.356 2.342H13.3a2.7 2.7 0 0 1 1.347-2.337 4.006 4.006 0 0 1 3.989-3.63h.67a4.675 4.675 0 0 1 4.675 4.675v5.952z" fill="#869099"></path></svg>3 ba</span>
                                </div>
                                <div class="property-detail-address">
                                1350 Haight St
                                </div>
                                <div class="property-detail-city">
                                Haight, San Francisco, CA
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4 p-1 mb-1 border-none">
                            <a href="javascript:;" class="w-100">
                                <div id="property-2" class="carousel slide property-card-image-slider" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#property-2" data-slide-to="0" class="active"></li>
                                        <li data-target="#property-2" data-slide-to="1"></li>
                                        <li data-target="#property-2" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="<?php echo site_url('assets/img/home-1.jpg')?>" class="d-block w-100" alt="img1">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?php echo site_url('assets/img/home-2.jpg')?>" class="d-block w-100" alt="img2">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?php echo site_url('assets/img/home-3.jpg')?>" class="d-block w-100" alt="img3">
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#property-2" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#property-2" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </a>
                            <div class="property-detail">
                                <div class="property-detail-price">$700/dy, $5,900/wk</div>
                                <div class="property-detail-capacity">
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M9.196 14.603h15.523v.027h1.995v10.64h-3.99v-4.017H9.196v4.017h-3.99V6.65h3.99v7.953zm2.109-1.968v-2.66h4.655v2.66h-4.655z" fill="#869099"></path></svg>
                                    5 bd</span>
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M23.981 15.947H26.6v1.33a9.31 9.31 0 0 1-9.31 9.31h-2.66a9.31 9.31 0 0 1-9.31-9.31v-1.33h16.001V9.995a2.015 2.015 0 0 0-2.016-2.015h-.67c-.61 0-1.126.407-1.29.965a2.698 2.698 0 0 1 1.356 2.342H13.3a2.7 2.7 0 0 1 1.347-2.337 4.006 4.006 0 0 1 3.989-3.63h.67a4.675 4.675 0 0 1 4.675 4.675v5.952z" fill="#869099"></path></svg>3 ba</span>
                                </div>
                                <div class="property-detail-address">
                                1350 Haight St
                                </div>
                                <div class="property-detail-city">
                                Haight, San Francisco, CA
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4 p-1 mb-1 border-none">
                            <a href="javascript:;" class="w-100">
                                <div id="property-3" class="carousel slide property-card-image-slider" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#property-3" data-slide-to="0" class="active"></li>
                                        <li data-target="#property-3" data-slide-to="1"></li>
                                        <li data-target="#property-3" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="<?php echo site_url('assets/images/personal.jpg')?>" class="d-block w-100" alt="img1">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?php echo site_url('assets/images/personal2.jpg')?>" class="d-block w-100" alt="img2">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?php echo site_url('assets/images/personal3.jpg')?>" class="d-block w-100" alt="img3">
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#property-3" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#property-3" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </a>
                            <div class="property-detail">
                                <div class="property-detail-price">$700/dy, $5,900/wk</div>
                                <div class="property-detail-capacity">
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M9.196 14.603h15.523v.027h1.995v10.64h-3.99v-4.017H9.196v4.017h-3.99V6.65h3.99v7.953zm2.109-1.968v-2.66h4.655v2.66h-4.655z" fill="#869099"></path></svg>
                                    5 bd</span>
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M23.981 15.947H26.6v1.33a9.31 9.31 0 0 1-9.31 9.31h-2.66a9.31 9.31 0 0 1-9.31-9.31v-1.33h16.001V9.995a2.015 2.015 0 0 0-2.016-2.015h-.67c-.61 0-1.126.407-1.29.965a2.698 2.698 0 0 1 1.356 2.342H13.3a2.7 2.7 0 0 1 1.347-2.337 4.006 4.006 0 0 1 3.989-3.63h.67a4.675 4.675 0 0 1 4.675 4.675v5.952z" fill="#869099"></path></svg>3 ba</span>
                                </div>
                                <div class="property-detail-address">
                                1350 Haight St
                                </div>
                                <div class="property-detail-city">
                                Haight, San Francisco, CA
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4 p-1 mb-1 border-none">
                            <a href="javascript:;" class="w-100">
                                <div id="property-4" class="carousel slide property-card-image-slider" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#property-4" data-slide-to="0" class="active"></li>
                                        <li data-target="#property-4" data-slide-to="1"></li>
                                        <li data-target="#property-4" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="<?php echo site_url('assets/images/fp4.jpg')?>" class="d-block w-100" alt="img1">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?php echo site_url('assets/images/fp2.jpg')?>" class="d-block w-100" alt="img2">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?php echo site_url('assets/images/fp1.jpg')?>" class="d-block w-100" alt="img3">
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#property-4" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#property-4" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </a>
                            <div class="property-detail">
                                <div class="property-detail-price">$700/dy, $5,900/wk</div>
                                <div class="property-detail-capacity">
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M9.196 14.603h15.523v.027h1.995v10.64h-3.99v-4.017H9.196v4.017h-3.99V6.65h3.99v7.953zm2.109-1.968v-2.66h4.655v2.66h-4.655z" fill="#869099"></path></svg>
                                    5 bd</span>
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M23.981 15.947H26.6v1.33a9.31 9.31 0 0 1-9.31 9.31h-2.66a9.31 9.31 0 0 1-9.31-9.31v-1.33h16.001V9.995a2.015 2.015 0 0 0-2.016-2.015h-.67c-.61 0-1.126.407-1.29.965a2.698 2.698 0 0 1 1.356 2.342H13.3a2.7 2.7 0 0 1 1.347-2.337 4.006 4.006 0 0 1 3.989-3.63h.67a4.675 4.675 0 0 1 4.675 4.675v5.952z" fill="#869099"></path></svg>3 ba</span>
                                </div>
                                <div class="property-detail-address">
                                1350 Haight St
                                </div>
                                <div class="property-detail-city">
                                Haight, San Francisco, CA
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4 p-1 mb-1 border-none">
                            <a href="javascript:;" class="w-100">
                                <div id="property-5" class="carousel slide property-card-image-slider" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#property-5" data-slide-to="0" class="active"></li>
                                        <li data-target="#property-5" data-slide-to="1"></li>
                                        <li data-target="#property-5" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="<?php echo site_url('assets/images/gal1.webp')?>" class="d-block w-100" alt="img1">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?php echo site_url('assets/images/gal2.webp')?>" class="d-block w-100" alt="img2">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?php echo site_url('assets/img/home-5.jpg')?>" class="d-block w-100" alt="img3">
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#property-5" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#property-5" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </a>
                            <div class="property-detail">
                                <div class="property-detail-price">$700/dy, $5,900/wk</div>
                                <div class="property-detail-capacity">
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M9.196 14.603h15.523v.027h1.995v10.64h-3.99v-4.017H9.196v4.017h-3.99V6.65h3.99v7.953zm2.109-1.968v-2.66h4.655v2.66h-4.655z" fill="#869099"></path></svg>
                                    5 bd</span>
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M23.981 15.947H26.6v1.33a9.31 9.31 0 0 1-9.31 9.31h-2.66a9.31 9.31 0 0 1-9.31-9.31v-1.33h16.001V9.995a2.015 2.015 0 0 0-2.016-2.015h-.67c-.61 0-1.126.407-1.29.965a2.698 2.698 0 0 1 1.356 2.342H13.3a2.7 2.7 0 0 1 1.347-2.337 4.006 4.006 0 0 1 3.989-3.63h.67a4.675 4.675 0 0 1 4.675 4.675v5.952z" fill="#869099"></path></svg>3 ba</span>
                                </div>
                                <div class="property-detail-address">
                                1350 Haight St
                                </div>
                                <div class="property-detail-city">
                                Haight, San Francisco, CA
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4 p-1 mb-1 border-none">
                            <a href="javascript:;" class="w-100">
                                <div id="property-6" class="carousel slide property-card-image-slider" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#property-6" data-slide-to="0" class="active"></li>
                                        <li data-target="#property-6" data-slide-to="1"></li>
                                        <li data-target="#property-6" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="<?php echo site_url('assets/images/gal1.webp')?>" class="d-block w-100" alt="img1">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?php echo site_url('assets/images/gal2.webp')?>" class="d-block w-100" alt="img2">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?php echo site_url('assets/img/home-5.jpg')?>" class="d-block w-100" alt="img3">
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#property-6" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#property-6" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </a>
                            <div class="property-detail">
                                <div class="property-detail-price">$700/dy, $5,900/wk</div>
                                <div class="property-detail-capacity">
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M9.196 14.603h15.523v.027h1.995v10.64h-3.99v-4.017H9.196v4.017h-3.99V6.65h3.99v7.953zm2.109-1.968v-2.66h4.655v2.66h-4.655z" fill="#869099"></path></svg>
                                    5 bd</span>
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M23.981 15.947H26.6v1.33a9.31 9.31 0 0 1-9.31 9.31h-2.66a9.31 9.31 0 0 1-9.31-9.31v-1.33h16.001V9.995a2.015 2.015 0 0 0-2.016-2.015h-.67c-.61 0-1.126.407-1.29.965a2.698 2.698 0 0 1 1.356 2.342H13.3a2.7 2.7 0 0 1 1.347-2.337 4.006 4.006 0 0 1 3.989-3.63h.67a4.675 4.675 0 0 1 4.675 4.675v5.952z" fill="#869099"></path></svg>3 ba</span>
                                </div>
                                <div class="property-detail-address">
                                1350 Haight St
                                </div>
                                <div class="property-detail-city">
                                Haight, San Francisco, CA
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4 p-1 mb-1 border-none">
                            <a href="javascript:;" class="w-100">
                                <div id="property-7" class="carousel slide property-card-image-slider" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#property-7" data-slide-to="0" class="active"></li>
                                        <li data-target="#property-7" data-slide-to="1"></li>
                                        <li data-target="#property-7" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="<?php echo site_url('assets/images/gal1.webp')?>" class="d-block w-100" alt="img1">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?php echo site_url('assets/images/gal2.webp')?>" class="d-block w-100" alt="img2">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?php echo site_url('assets/img/home-5.jpg')?>" class="d-block w-100" alt="img3">
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#property-7" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#property-7" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </a>
                            <div class="property-detail">
                                <div class="property-detail-price">$700/dy, $5,900/wk</div>
                                <div class="property-detail-capacity">
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M9.196 14.603h15.523v.027h1.995v10.64h-3.99v-4.017H9.196v4.017h-3.99V6.65h3.99v7.953zm2.109-1.968v-2.66h4.655v2.66h-4.655z" fill="#869099"></path></svg>
                                    5 bd</span>
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M23.981 15.947H26.6v1.33a9.31 9.31 0 0 1-9.31 9.31h-2.66a9.31 9.31 0 0 1-9.31-9.31v-1.33h16.001V9.995a2.015 2.015 0 0 0-2.016-2.015h-.67c-.61 0-1.126.407-1.29.965a2.698 2.698 0 0 1 1.356 2.342H13.3a2.7 2.7 0 0 1 1.347-2.337 4.006 4.006 0 0 1 3.989-3.63h.67a4.675 4.675 0 0 1 4.675 4.675v5.952z" fill="#869099"></path></svg>3 ba</span>
                                </div>
                                <div class="property-detail-address">
                                1350 Haight St
                                </div>
                                <div class="property-detail-city">
                                Haight, San Francisco, CA
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4 p-1 mb-1 border-none">
                            <a href="javascript:;" class="w-100">
                                <div id="property-8" class="carousel slide property-card-image-slider" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#property-8" data-slide-to="0" class="active"></li>
                                        <li data-target="#property-8" data-slide-to="1"></li>
                                        <li data-target="#property-8" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="<?php echo site_url('assets/images/gal1.webp')?>" class="d-block w-100" alt="img1">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?php echo site_url('assets/images/gal2.webp')?>" class="d-block w-100" alt="img2">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?php echo site_url('assets/img/home-5.jpg')?>" class="d-block w-100" alt="img3">
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#property-8" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#property-8" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </a>
                            <div class="property-detail">
                                <div class="property-detail-price">$700/dy, $5,900/wk</div>
                                <div class="property-detail-capacity">
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M9.196 14.603h15.523v.027h1.995v10.64h-3.99v-4.017H9.196v4.017h-3.99V6.65h3.99v7.953zm2.109-1.968v-2.66h4.655v2.66h-4.655z" fill="#869099"></path></svg>
                                    5 bd</span>
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M23.981 15.947H26.6v1.33a9.31 9.31 0 0 1-9.31 9.31h-2.66a9.31 9.31 0 0 1-9.31-9.31v-1.33h16.001V9.995a2.015 2.015 0 0 0-2.016-2.015h-.67c-.61 0-1.126.407-1.29.965a2.698 2.698 0 0 1 1.356 2.342H13.3a2.7 2.7 0 0 1 1.347-2.337 4.006 4.006 0 0 1 3.989-3.63h.67a4.675 4.675 0 0 1 4.675 4.675v5.952z" fill="#869099"></path></svg>3 ba</span>
                                </div>
                                <div class="property-detail-address">
                                1350 Haight St
                                </div>
                                <div class="property-detail-city">
                                Haight, San Francisco, CA
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4 p-1 mb-1 border-none">
                            <a href="javascript:;" class="w-100">
                                <div id="property-9" class="carousel slide property-card-image-slider" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#property-9" data-slide-to="0" class="active"></li>
                                        <li data-target="#property-9" data-slide-to="1"></li>
                                        <li data-target="#property-9" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="<?php echo site_url('assets/images/gal1.webp')?>" class="d-block w-100" alt="img1">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?php echo site_url('assets/images/gal2.webp')?>" class="d-block w-100" alt="img2">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="<?php echo site_url('assets/img/home-5.jpg')?>" class="d-block w-100" alt="img3">
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#property-9" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#property-9" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </a>
                            <div class="property-detail">
                                <div class="property-detail-price">$700/dy, $5,900/wk</div>
                                <div class="property-detail-capacity">
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M9.196 14.603h15.523v.027h1.995v10.64h-3.99v-4.017H9.196v4.017h-3.99V6.65h3.99v7.953zm2.109-1.968v-2.66h4.655v2.66h-4.655z" fill="#869099"></path></svg>
                                    5 bd</span>
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M23.981 15.947H26.6v1.33a9.31 9.31 0 0 1-9.31 9.31h-2.66a9.31 9.31 0 0 1-9.31-9.31v-1.33h16.001V9.995a2.015 2.015 0 0 0-2.016-2.015h-.67c-.61 0-1.126.407-1.29.965a2.698 2.698 0 0 1 1.356 2.342H13.3a2.7 2.7 0 0 1 1.347-2.337 4.006 4.006 0 0 1 3.989-3.63h.67a4.675 4.675 0 0 1 4.675 4.675v5.952z" fill="#869099"></path></svg>3 ba</span>
                                </div>
                                <div class="property-detail-address">
                                1350 Haight St
                                </div>
                                <div class="property-detail-city">
                                Haight, San Francisco, CA
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-none d-sm-inline-block map-region p-1">
                <div id="map"></div>
            </div>
        </div>

        <!-- ====================================== Script ========================================== -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

        <!-- ============================= Google Map Script ========================================== -->
        <script>
            function initMap(marker = { lat: 31.0461, lng: 34.08516 }) {
                var map = new google.maps.Map(
                    document.getElementById('map'),
                    {
                        zoom: 8,
                        center: marker
                    }
                );
                
                var searchEl = document.getElementById('search-place');
                var autocomplete = new google.maps.places.Autocomplete(searchEl);
            }
        </script>

        <!-- ============================= Custom Script ========================================== -->
        <script>
            /**
            **  Search Filter Rendering
            **/
            const anyType = {
                'html': true,
                sanitize: false,
                content: function () {
                    return `
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item border-0"><button class="btn btn-outline-purple">Any</button></li>
                        <li class="list-group-item border-0"><button class="btn btn-outline-purple">Sale</button></li>
                        <li class="list-group-item border-0"><button class="btn btn-outline-purple">Rent</button></li>
                        <li class="list-group-item border-0"><button class="btn btn-outline-purple">Short Term Rent</button></li>
                    </ul>
                    `;
                }
            }
            const anyPrice = {
                'html': true,
                sanitize: false,
                content: function () {
                    return `
                    <p class="mb-1 text-center">Select Price's Range</p>
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item"><input type="number" class="form-control" placeholder="Min Price" value="0" /></li>
                        <li class="list-group-item"><input type="number" class="form-control" placeholder="Max Price" value="0" /></li>
                    </ul>
                    `;
                }
            }
            const anyBed = {
                'html': true,
                sanitize: false,
                content: function () {
                    return `
                        <ul class="list-group list-group-horizontal mb-2">
                            <li class="list-group-item"><button class="btn btn-outline-purple">Any</button></li>
                            <li class="list-group-item"><button class="btn btn-outline-purple">1+</button></li>
                            <li class="list-group-item"><button class="btn btn-outline-purple">2+</button></li>
                            <li class="list-group-item"><button class="btn btn-outline-purple">3+</button></li>
                            <li class="list-group-item"><button class="btn btn-outline-purple">4+</button></li>
                            <li class="list-group-item"><button class="btn btn-outline-purple">5+</button></li>
                        </ul>
                        <p class="mb-1 text-center">Or Select Bedroom's Range</p>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item"><input type="number" class="form-control" value="0" placeholder="Min" /></li>
                            <li class="list-group-item"><input type="number" class="form-control" value="0" placeholder="Max" /></li>
                        </ul>
                    `;
                }
            }
            const anyFloor = {
                'html': true,
                sanitize: false,
                content: function () {
                    return `
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item"><button class="btn btn-outline-purple">Any</button></li>
                            <li class="list-group-item"><button class="btn btn-outline-purple">1+</button></li>
                            <li class="list-group-item"><button class="btn btn-outline-purple">2+</button></li>
                            <li class="list-group-item"><button class="btn btn-outline-purple">3+</button></li>
                            <li class="list-group-item"><button class="btn btn-outline-purple">4+</button></li>
                            <li class="list-group-item"><button class="btn btn-outline-purple">5+</button></li>
                        </ul>
                        <p class="mb-1 text-center">Or Select Floor's Range</p>
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item"><input type="number" class="form-control" value="0" placeholder="Min" /></li>
                            <li class="list-group-item"><input type="number" class="form-control" value="0" placeholder="Max" /></li>
                        </ul>
                    `;
                }
            }
            const anyMore = {
                'html': true,
                sanitize: false,
                content: function () {
                    return `
                    <div class="filter-all-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <p class="font-weight-bold mb-1">Amenities</p>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="form-group form-check mb-0 check-box border-0 p-0 pl-3">
                                            <input type="checkbox" class="form-check-input" id="amenties-1">
                                            <label class="form-check-label" for="amenties-1">Elevator</label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="form-group form-check mb-0 check-box border-0 p-0 pl-3">
                                            <input type="checkbox" class="form-check-input" id="amenties-2">
                                            <label class="form-check-label" for="amenties-2">Heating</label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="form-group form-check mb-0 check-box border-0 p-0 pl-3">
                                            <input type="checkbox" class="form-check-input" id="amenties-3">
                                            <label class="form-check-label" for="amenties-3">Dryer</label>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="list-group-item">
                                <p class="font-weight-bold mb-1">Bathroom</p>
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item"><button class="btn btn-outline-purple">Any</button></li>
                                    <li class="list-group-item"><button class="btn btn-outline-purple">1+</button></li>
                                    <li class="list-group-item"><button class="btn btn-outline-purple">2+</button></li>
                                    <li class="list-group-item"><button class="btn btn-outline-purple">3+</button></li>
                                    <li class="list-group-item"><button class="btn btn-outline-purple">4+</button></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <button class="btn btn-outline-purple btn-block">View Rentals</button>
                    `;
                }
            }
            const anyAll = {
                'html': true,
                sanitize: false,
                content: function () {
                    return `
                    <div class="filter-all-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <p class="font-weight-bold mb-1">Amenities</p>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="form-group form-check mb-0 check-box border-0 p-0 pl-3">
                                            <input type="checkbox" class="form-check-input" id="amenties-1">
                                            <label class="form-check-label" for="amenties-1">Elevator</label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="form-group form-check mb-0 check-box border-0 p-0 pl-3">
                                            <input type="checkbox" class="form-check-input" id="amenties-2">
                                            <label class="form-check-label" for="amenties-2">Heating</label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="form-group form-check mb-0 check-box border-0 p-0 pl-3">
                                            <input type="checkbox" class="form-check-input" id="amenties-3">
                                            <label class="form-check-label" for="amenties-3">Dryer</label>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="list-group-item">
                                <p class="font-weight-bold mb-1">Bathroom</p>
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item"><button class="btn btn-outline-purple">Any</button></li>
                                    <li class="list-group-item"><button class="btn btn-outline-purple">1+</button></li>
                                    <li class="list-group-item"><button class="btn btn-outline-purple">2+</button></li>
                                    <li class="list-group-item"><button class="btn btn-outline-purple">3+</button></li>
                                    <li class="list-group-item"><button class="btn btn-outline-purple">4+</button></li>
                                </ul>
                            </li>
                            <li class="list-group-item">
                                <p class="font-weight-bold mb-1">Bedrooms</p>
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item"><button class="btn btn-outline-purple">Any</button></li>
                                    <li class="list-group-item"><button class="btn btn-outline-purple">1+</button></li>
                                    <li class="list-group-item"><button class="btn btn-outline-purple">2+</button></li>
                                    <li class="list-group-item"><button class="btn btn-outline-purple">3+</button></li>
                                    <li class="list-group-item"><button class="btn btn-outline-purple">4+</button></li>
                                </ul>
                            </li>
                            <li class="list-group-item">
                                <p class="font-weight-bold mb-1">Floors</p>
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item"><button class="btn btn-outline-purple">Any</button></li>
                                    <li class="list-group-item"><button class="btn btn-outline-purple">1+</button></li>
                                    <li class="list-group-item"><button class="btn btn-outline-purple">2+</button></li>
                                    <li class="list-group-item"><button class="btn btn-outline-purple">3+</button></li>
                                    <li class="list-group-item"><button class="btn btn-outline-purple">4+</button></li>
                                </ul>
                            </li>
                            <li class="list-group-item">
                                <p class="font-weight-bold mb-1">Price</p>
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item"><input type="number" class="form-control" placeholder="Min" value="0" /></li>
                                    <li class="list-group-item"><input type="number" class="form-control" placeholder="Max" value="0" /></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <button class="btn btn-outline-purple btn-block">View Rentals</button>
                    `;
                }
            }
            const anySort = {
                'html': true,
                sanitize: false,
                content: function () {
                    return `
                        <ul class="list-group">
                            <li class="list-group-item">
                                <button class="btn btn-outline-purple">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-sort-numeric-down-alt" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4 2a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-1 0v-11A.5.5 0 0 1 4 2z"/>
                                        <path fill-rule="evenodd" d="M6.354 11.146a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L4 12.793l1.646-1.647a.5.5 0 0 1 .708 0z"/>
                                        <path d="M9.598 5.82c.054.621.625 1.278 1.761 1.278 1.422 0 2.145-.98 2.145-2.848 0-2.05-.973-2.688-2.063-2.688-1.125 0-1.972.688-1.972 1.836 0 1.145.808 1.758 1.719 1.758.69 0 1.113-.351 1.261-.742h.059c.031 1.027-.309 1.856-1.133 1.856-.43 0-.715-.227-.773-.45H9.598zm2.757-2.43c0 .637-.43.973-.933.973-.516 0-.934-.34-.934-.98 0-.625.407-1 .926-1 .543 0 .941.375.941 1.008zM12.438 14V8.668H11.39l-1.262.906v.969l1.21-.86h.052V14h1.046z"/>
                                    </svg>
                                    Descending by Price
                                </button>
                            </li>

                            <li class="list-group-item">
                                <button class="btn btn-outline-purple">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-sort-numeric-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4 14a.5.5 0 0 0 .5-.5v-11a.5.5 0 0 0-1 0v11a.5.5 0 0 0 .5.5z"/>
                                        <path fill-rule="evenodd" d="M6.354 4.854a.5.5 0 0 0 0-.708l-2-2a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L4 3.207l1.646 1.647a.5.5 0 0 0 .708 0z"/>
                                        <path d="M12.438 7V1.668H11.39l-1.262.906v.969l1.21-.86h.052V7h1.046zm-2.84 5.82c.054.621.625 1.278 1.761 1.278 1.422 0 2.145-.98 2.145-2.848 0-2.05-.973-2.688-2.063-2.688-1.125 0-1.972.688-1.972 1.836 0 1.145.808 1.758 1.719 1.758.69 0 1.113-.351 1.261-.742h.059c.031 1.027-.309 1.856-1.133 1.856-.43 0-.715-.227-.773-.45H9.598zm2.757-2.43c0 .637-.43.973-.933.973-.516 0-.934-.34-.934-.98 0-.625.407-1 .926-1 .543 0 .941.375.941 1.008z"/>
                                    </svg>
                                    Ascending by Price
                                </button>
                            </li>

                            <li class="list-group-item">
                                <button class="btn btn-outline-purple">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-sort-alpha-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4 2a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-1 0v-11A.5.5 0 0 1 4 2z"/>
                                        <path fill-rule="evenodd" d="M6.354 11.146a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L4 12.793l1.646-1.647a.5.5 0 0 1 .708 0z"/>
                                        <path d="M9.664 7l.418-1.371h1.781L12.281 7h1.121l-1.78-5.332h-1.235L8.597 7h1.067zM11 2.687l.652 2.157h-1.351l.652-2.157H11zM9.027 14h3.934v-.867h-2.645v-.055l2.567-3.719v-.691H9.098v.867h2.507v.055l-2.578 3.719V14z"/>
                                    </svg>
                                    Latest
                                </button>
                            </li>

                            <li class="list-group-item">
                                <button class="btn btn-outline-purple">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-sort-alpha-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4 14a.5.5 0 0 0 .5-.5v-11a.5.5 0 0 0-1 0v11a.5.5 0 0 0 .5.5z"/>
                                        <path fill-rule="evenodd" d="M6.354 4.854a.5.5 0 0 0 0-.708l-2-2a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L4 3.207l1.646 1.647a.5.5 0 0 0 .708 0z"/>
                                        <path d="M9.664 7l.418-1.371h1.781L12.281 7h1.121l-1.78-5.332h-1.235L8.597 7h1.067zM11 2.687l.652 2.157h-1.351l.652-2.157H11zM9.027 14h3.934v-.867h-2.645v-.055l2.567-3.719v-.691H9.098v.867h2.507v.055l-2.578 3.719V14z"/>
                                    </svg>
                                    Oldest
                                </button>
                            </li>
                        </ul>
                    `;
                }
            }

            $(function () {
                $('#filter-type').popover(anyType);
            });
            $(function () {
                $('#filter-price').popover(anyPrice);
            });
            $(function () {
                $('#filter-bed').popover(anyBed);
            });
            $(function () {
                $('#filter-floor').popover(anyFloor);
            });
            $(function () {
                $('#filter-more').popover(anyMore);
            });
            $(function () {
                $('#filter-sort').popover(anySort);
            });
            $(function () {
                $('#filter-sort-web').popover(anySort);
            });
            $(function () {
                $('#filter-all').popover(anyAll);
            });
        </script>

        <script>
            /**
            **  Filter Caret Style
             */
            $('#filter-type').on('shown.bs.popover', function () {
                $('#filter-type').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-opened');
                $('#filter-price').popover('hide');
                $('#filter-bed').popover('hide');
                $('#filter-floor').popover('hide');
                $('#filter-more').popover('hide');
                $('#filter-all').popover('hide');
                $('#filter-sort').popover('hide');
                $('#filter-sort-web').popover('hide');
            });
            $('#filter-type').on('hidden.bs.popover', function () {
                $('#filter-type').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-closed');
            });

            $('#filter-price').on('shown.bs.popover', function () {
                $('#filter-price').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-opened');
                $('#filter-type').popover('hide');
                $('#filter-bed').popover('hide');
                $('#filter-floor').popover('hide');
                $('#filter-more').popover('hide');
                $('#filter-all').popover('hide');
                $('#filter-sort').popover('hide');
                $('#filter-sort-web').popover('hide');
            });
            $('#filter-price').on('hidden.bs.popover', function () {
                $('#filter-price').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-closed');
            });
            
            $('#filter-bed').on('shown.bs.popover', function () {
                $('#filter-bed').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-opened');
                $('#filter-type').popover('hide');
                $('#filter-price').popover('hide');
                $('#filter-floor').popover('hide');
                $('#filter-more').popover('hide');
                $('#filter-all').popover('hide');
                $('#filter-sort').popover('hide');
                $('#filter-sort-web').popover('hide');
            });
            $('#filter-bed').on('hidden.bs.popover', function () {
                $('#filter-bed').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-closed');
            });
            
            $('#filter-floor').on('shown.bs.popover', function () {
                $('#filter-floor').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-opened');
                $('#filter-type').popover('hide');
                $('#filter-price').popover('hide');
                $('#filter-bed').popover('hide');
                $('#filter-more').popover('hide');
                $('#filter-all').popover('hide');
                $('#filter-sort').popover('hide');
                $('#filter-sort-web').popover('hide');
            });
            $('#filter-floor').on('hidden.bs.popover', function () {
                $('#filter-floor').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-closed');
            });
            
            $('#filter-more').on('shown.bs.popover', function () {
                $('#filter-more').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-opened');
                $('#filter-type').popover('hide');
                $('#filter-price').popover('hide');
                $('#filter-bed').popover('hide');
                $('#filter-floor').popover('hide');
                $('#filter-all').popover('hide');
                $('#filter-sort').popover('hide');
                $('#filter-sort-web').popover('hide');
            });
            $('#filter-more').on('hidden.bs.popover', function () {
                $('#filter-more').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-closed');
            });
            
            $('#filter-all').on('shown.bs.popover', function () {
                $('#filter-all').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-opened');
                $('#filter-type').popover('hide');
                $('#filter-price').popover('hide');
                $('#filter-bed').popover('hide');
                $('#filter-floor').popover('hide');
                $('#filter-more').popover('hide');
                $('#filter-sort').popover('hide');
                $('#filter-sort-web').popover('hide');
            });
            $('#filter-all').on('hidden.bs.popover', function () {
                $('#filter-all').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-closed');
            });
            
            $('#filter-sort').on('shown.bs.popover', function () {
                $('#filter-sort').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-opened');
                $('#filter-type').popover('hide');
                $('#filter-price').popover('hide');
                $('#filter-bed').popover('hide');
                $('#filter-floor').popover('hide');
                $('#filter-more').popover('hide');
                $('#filter-all').popover('hide');
                $('#filter-sort-web').popover('hide');
            });
            $('#filter-sort').on('hidden.bs.popover', function () {
                $('#filter-sort').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-closed');
            });

            $('#filter-sort-web').on('shown.bs.popover', function () {
                $('#filter-sort-web').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-opened');
                $('#filter-type').popover('hide');
                $('#filter-price').popover('hide');
                $('#filter-bed').popover('hide');
                $('#filter-floor').popover('hide');
                $('#filter-more').popover('hide');
                $('#filter-all').popover('hide');
                $('#filter-sort').popover('hide');
            });
            $('#filter-sort-web').on('hidden.bs.popover', function () {
                $('#filter-sort-web').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-closed');
            });
        </script>
    </body>
</html>