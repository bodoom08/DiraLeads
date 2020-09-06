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
            /* Navbar Style */
            .navbar {
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            }
            .navbar-brand img {
                width: 150px;
                padding: .5rem;
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
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <a class="navbar-brand" href="<?php echo site_url()?>">
                <img src="<?php echo site_url('uploads/diraleads-logo.svg')?>" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <form class="form-inline mr-auto mt-4 mb-0">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Montreal QC Canada" aria-label="Montreal QC Canada" aria-describedby="button-search">
                        <div class="input-group-append">
                            <button class="btn btn-danger" type="submit" id="button-search">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                                    <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
                <ul class="navbar-nav my-2 my-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Why DiraLeads</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">The Renter's View</a>
                            <a class="dropdown-item" href="#">The Owner's Perch</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">View Rentals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">List Your Rental</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- ========================== Filters for Web view ====================================== -->
        <ul class="list-group list-group-horizontal my-2 d-none d-sm-flex">
            <li class="list-group-item border-0 p-1">
                <a tabindex="0" id="filter-type" class="btn btn-lg btn-white btn-outline-secondary filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom" data-trigger="focus" title="Rental Type">
                    Rental Type&nbsp;&nbsp;
                </a>
            </li>

            <li class="list-group-item border-0 p-1">
                <a tabindex="0" id="filter-price" class="btn btn-lg btn-white btn-outline-secondary filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom" data-trigger="focus" title="Any Price">
                    Any Price&nbsp;&nbsp;
                </a>
            </li>

            <li class="list-group-item border-0 p-1">
                <a tabindex="0" id="filter-bed" class="btn btn-lg btn-white btn-outline-secondary filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom" data-trigger="focus" title="Any Beds">
                    Any Beds&nbsp;&nbsp;
                </a>
            </li>

            <li class="list-group-item border-0 p-1">
                <a tabindex="0" id="filter-bath" class="btn btn-lg btn-white btn-outline-secondary filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom" data-trigger="focus" title="Any Bath">
                    Any Bath&nbsp;&nbsp;
                </a>
            </li>

            <li class="list-group-item border-0 p-1">
                <a tabindex="0" id="filter-more" class="btn btn-lg btn-white btn-outline-secondary filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom" data-trigger="focus" title="More">
                    More&nbsp;&nbsp;
                </a>
            </li>
        </ul>

        <!-- ====================================== Filters for Mobile View ======================================== -->
        <ul class="list-group list-group-horizontal my-2 d-flex d-sm-none justify-content-between">
            <li class="list-group-item border-0 p-1">
                <a tabindex="0" id="filter-all" class="btn btn-lg btn-white btn-outline-secondary filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom" data-trigger="focus" title="Filter">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-sliders" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3h9.05zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8h2.05zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1h9.05z"/>
                    </svg>&nbsp;
                    Filters
                </a>
            </li>

            <li class="list-group-item border-0 p-1">
                <a tabindex="0" id="filter-sort" class="btn btn-lg btn-white btn-outline-secondary filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom" data-trigger="focus" title="Sort By">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-sort-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 2a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-1 0v-10A.5.5 0 0 1 3 2z"/>
                        <path fill-rule="evenodd" d="M5.354 10.146a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L3 11.793l1.646-1.647a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 9a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z"/>
                    </svg>&nbsp;
                    Sort by
                </a>
            </li>
        </ul>
   
        <!-- ================================ Search Results Page ============================================= -->
        <div class="w-100 d-flex px-1">
            <div class="w-50 d-inline-block">
                AAA
            </div>
            <div class="w-50 d-inline-block map-region">
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
                    <ul class="list-group">
                        <li class="list-group-item border-0"><button class="btn btn-outline-danger btn-block">Any</button></li>
                        <li class="list-group-item border-0"><button class="btn btn-outline-danger btn-block">Sale</button></li>
                        <li class="list-group-item border-0"><button class="btn btn-outline-danger btn-block">Rent</button></li>
                        <li class="list-group-item border-0"><button class="btn btn-outline-danger btn-block">Short Term Rent</button></li>
                    </ul>
                    `;
                }
            }
            const anyPrice = {
                'html': true,
                sanitize: false,
                content: function () {
                    return `
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item border-0 p-1"><input type="text" class="form-control" placeholder="Min Price" /></li>
                        <li class="list-group-item border-0 p-1"><input type="text" class="form-control" placeholder="Max Price" /></li>
                    </ul>
                    `;
                }
            }
            const anyBed = {
                'html': true,
                sanitize: false,
                content: function () {
                    return `
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item border-0 p-1"><button class="btn btn-outline-danger">Any</button></li>
                        <li class="list-group-item border-0 p-1"><button class="btn btn-outline-danger">+1</button></li>
                        <li class="list-group-item border-0 p-1"><button class="btn btn-outline-danger">+2</button></li>
                        <li class="list-group-item border-0 p-1"><button class="btn btn-outline-danger">+3</button></li>
                        <li class="list-group-item border-0 p-1"><button class="btn btn-outline-danger">+4</button></li>
                        <li class="list-group-item border-0 p-1"><button class="btn btn-outline-danger">+5</button></li>
                    </ul>
                    `;
                }
            }
            const anyBath = {
                'html': true,
                sanitize: false,
                content: function () {
                    return `
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item border-0 p-1"><button class="btn btn-outline-danger">Any</button></li>
                            <li class="list-group-item border-0 p-1"><button class="btn btn-outline-danger">+1</button></li>
                            <li class="list-group-item border-0 p-1"><button class="btn btn-outline-danger">+2</button></li>
                            <li class="list-group-item border-0 p-1"><button class="btn btn-outline-danger">+3</button></li>
                        </ul>
                    `;
                }
            }
            const anyMore = {
                'html': true,
                sanitize: false,
                content: function () {
                    return `
                    <div class="more-filter-options">
                        Comming Soon
                    </div>
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
                $('#filter-bath').popover(anyBath);
            });
            $(function () {
                $('#filter-more').popover(anyMore);
            });
        </script>

        <script>
            /**
            **  Filter Caret Style
             */
            $('#filter-type').on('shown.bs.popover', function () {
                $('#filter-type').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-opened');
            });
            $('#filter-type').on('hidden.bs.popover', function () {
                $('#filter-type').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-closed');
            });

            $('#filter-price').on('shown.bs.popover', function () {
                $('#filter-price').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-opened');
            });
            $('#filter-price').on('hidden.bs.popover', function () {
                $('#filter-price').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-closed');
            });
            
            $('#filter-bed').on('shown.bs.popover', function () {
                $('#filter-bed').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-opened');
            });
            $('#filter-bed').on('hidden.bs.popover', function () {
                $('#filter-bed').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-closed');
            });
            
            $('#filter-bath').on('shown.bs.popover', function () {
                $('#filter-bath').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-opened');
            });
            $('#filter-bath').on('hidden.bs.popover', function () {
                $('#filter-bath').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-closed');
            });
            
            $('#filter-more').on('shown.bs.popover', function () {
                $('#filter-more').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-opened');
            });
            $('#filter-more').on('hidden.bs.popover', function () {
                $('#filter-more').attr('class', 'btn btn-lg btn-white btn-outline-secondary filter-option option-closed');
            });
        </script>
    </body>
</html>