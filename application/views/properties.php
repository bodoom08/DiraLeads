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
    <link rel="stylesheet" href="<?php echo site_url('assets/css/properties.css') ?>">
    </link>
    <!-- ========================== Google Map Scripts ================================= -->
    <!-- Old -->
    <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPhDpAUyER52TsCsLFNOOxT_l5-y7e78A&libraries=places&callback=initMap"></script> -->
    <!-- New -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByMhYirwn_EOt2HPNbeWtVE-BVEypa6kI&language=en&libraries=places&callback=initMap"></script>

    <!-- ============================= Google Map Script ========================================== -->
    <script>
        var map;
        var searchEl;
        var autocomplete;

        function initMap(marker = {
            lat: 31.0461,
            lng: 34.08516
        }) {
            map = new google.maps.Map(
                document.getElementById('map'), {
                    zoom: 17,
                    center: marker
                }
            );

            searchEl = document.getElementById('search-place');
            autocomplete = new google.maps.places.Autocomplete(searchEl);
            autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                const place = autocomplete.getPlace();
                map.setCenter(place.geometry.location);

                filter('location', place.geometry.location);
                document.getElementById('search-detail-title').innerHTML = `Apartments for ${searchEl.value}`;
            });

            try {
                try {
                    let streets = `<?php echo $streets; ?>`;
                    streets = JSON.parse(streets);
                    streets.forEach((street) => {
                        var newMarker = new google.maps.Marker({
                            position: street.location,
                            icon: {
                                path: google.maps.SymbolPath.CIRCLE,
                                scale: 5,
                                strokeColor: '#433357'
                            },
                            map
                        });

                        var ghostMarkerEl = document.createElement('a');
                        ghostMarkerEl.id = "ghost-marker";

                        newMarker.addListener('mouseover', function(event) {
                            console.log("Event: ", event);
                            event.ub.path[1].appendChild(ghostMarkerEl);
                            event.ub.path[1].style.opacity = 1;
                            event.ub.path[1].style.overflow = "unset";

                            ghostMarkerEl.href = `/properties/rental_detail/${street.property.id}`;

                            if (street.property.images && street.property.images.length > 0)
                                document.getElementById('property-overview-image').src = '/uploads/' + street.property.images[0].path;
                            document.getElementById('property-overview-price').innerHTML = `$${street.property.days_price ? street.property.days_price : 0}/dy, $${street.property.weekend_price ? street.property.weekend_price : 0}/wk`;
                            document.getElementById('property-overview-capacity').innerHTML = `<span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M9.196 14.603h15.523v.027h1.995v10.64h-3.99v-4.017H9.196v4.017h-3.99V6.65h3.99v7.953zm2.109-1.968v-2.66h4.655v2.66h-4.655z" fill="#869099"></path></svg>${street.property.bedrooms} bd</span><span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M23.981 15.947H26.6v1.33a9.31 9.31 0 0 1-9.31 9.31h-2.66a9.31 9.31 0 0 1-9.31-9.31v-1.33h16.001V9.995a2.015 2.015 0 0 0-2.016-2.015h-.67c-.61 0-1.126.407-1.29.965a2.698 2.698 0 0 1 1.356 2.342H13.3a2.7 2.7 0 0 1 1.347-2.337 4.006 4.006 0 0 1 3.989-3.63h.67a4.675 4.675 0 0 1 4.675 4.675v5.952z" fill="#869099"></path></svg>${street.property.bathrooms} ba</span>`;
                            document.getElementById('property-overview-address').innerHTML = `${street.property.title}`;
                            document.getElementById('property-overview-city').innerHTML = `${street.property.street}`;

                            let cardLocation = {
                                left: event.ub.clientX,
                                top: event.ub.clientY
                            }
                            document.getElementById('property-overview-card').style.top = event.ub.clientY + 30;
                            document.getElementById('property-overview-card').style.left = event.ub.clientX + 30;

                            if (event.ub.clientY + 200 >= $('#map').height() + $('#map').offset().top)
                                document.getElementById('property-overview-card').style.top = event.ub.clientY - 270;
                            if (event.ub.clientX + 200 >= $('#map').width() + $('#map').offset().left)
                                document.getElementById('property-overview-card').style.left = event.ub.clientX - 300;
                            document.getElementById('property-overview-card').style.display = 'block';
                        });
                        newMarker.addListener('mouseout', function(event) {
                            const ghostMarker = document.getElementById('ghost-marker');
                            event.ub.path[1].removeChild(ghostMarker);
                            event.ub.path[1].style.opacity = 0;
                            event.ub.path[1].style.overflow = "hidden";
                            document.getElementById('property-overview-card').style.display = 'none';
                        });
                    });
                } catch (error) {
                    console.log("No Street...");
                }


                if (navigator.geolocation) {
                    var options = {
                        timeout: 6000
                    };
                    navigator.geolocation.getCurrentPosition(function(position) {
                        map.setCenter({
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        });
                        const currentMarker = new google.maps.Marker({
                            position: {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            },
                            map
                        });
                    }, function(err) {
                        console.log("Error: ", err);
                    }, options);
                }
            } catch (error) {
                console.log("Error mapping");
            }
        }
    </script>
</head>

<body>
    <!-- ========================= HEADER ======================================= -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-white">
        <a class="navbar-brand" href="<?php echo site_url() ?>">
            <img src="<?php echo site_url('uploads/diraleads-logo.svg') ?>" />
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
                <!-- ============================= Login ================================ -->
                <?php if (empty($_SESSION['id'])) { ?>
                    <li class="nav-item login">
                        <a class="nav-link" href="<?php echo site_url('login') ?>" style="color: #fff !important;">
                            <img src="<?php echo site_url('assets/images/login.png'); ?>"> Login / Signup
                        </a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="<?php echo site_url('/assets/img/avatar/user.png'); ?>" width="20" alt="avatar">
                            Hi, <?php echo explode(' ', $_SESSION['name'])[0]; ?>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="userDropdownMenuLink">
                            <a class="dropdown-item" href="<?php echo site_url('dashboard') ?>">Dashboard</a>
                            <a class="dropdown-item" href="<?php echo site_url('my_rentals') ?>">My Rentals</a>
                            <a class="dropdown-item" href="<?php echo site_url('subscription/user') ?>">My Subscriptions</a>
                            <a class="dropdown-item" href="<?php echo site_url('profile') ?>">My Profile</a>
                            <a class="dropdown-item" href="<?php echo site_url('login/logout') ?>">Logout</a>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
    <!-- ================================= Maintain ======================================== -->
    <div style="overflow: visible; pointer-events: none; position: fixed; width: 100%; top: 0; right: 0; left: 0; background-color: rgba(255, 141, 141, 0.26); padding: 5px; text-align: center; color: red; z-index: 10000; font-size: 18px;">We are still working on making this page perfect, thanks for your patiance</div>
    <!-- ================================= Search Filters ======================================== -->
    <div class="search-filters-row">
        <div class="form-inline my-2 p-1 d-inline-block col-sm-12 col-md-3 col-lg-2">
            <div class="input-group">
                <input type="text" id="search-place" class="form-control" aria-describedby="button-search">
                <div class="input-group-append">
                    <!-- <button class="btn btn-brown" type="submit" id="button-search"> -->
                    <button class="btn btn-brown" id="button-search">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
                            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- ========================== Filters for Web view ====================================== -->
        <div class="d-none d-sm-inline-block">
            <ul class="list-group list-group-horizontal my-2">
                <li class="list-group-item">
                    <a tabindex="0" id="filter-type" class="btn btn-lg btn-white btn-outline-purple filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom">
                        Rental Type&nbsp;&nbsp;
                    </a>
                </li>

                <!-- <li class="list-group-item">
                    <a tabindex="0" id="filter-price" class="btn btn-lg btn-white btn-outline-purple filter-option option-closed" role="button" data-container="body" data-toggle="popover" data-placement="bottom">
                        Price&nbsp;&nbsp;
                    </a>
                </li> -->

                <li class="list-group-item">
                    <a tabindex="0" id="filter-bed" class="btn btn-lg btn-white btn-outline-purple filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom">
                        Bedrooms&nbsp;&nbsp;
                    </a>
                </li>

                <li class="list-group-item">
                    <a tabindex="0" id="filter-floor" class="btn btn-lg btn-white btn-outline-purple filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom">
                        Floor&nbsp;&nbsp;
                    </a>
                </li>

                <li class="list-group-item">
                    <div class="form-group form-check mb-0 check-box">
                        <input type="checkbox" class="form-check-input" id="show-rental" onclick="setHasPic()">
                        <label class="form-check-label" for="show-rental" style="font-size: 16px;font-weight: 600;">Only show Rentals with Pictures</label>
                    </div>
                </li>

                <li class="list-group-item">
                    <a tabindex="0" id="filter-more" class="btn btn-lg btn-white btn-outline-purple filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom" title="More">
                        More&nbsp;&nbsp;
                    </a>
                </li>
            </ul>
        </div>

        <!-- ====================================== Filters for Mobile View ======================================== -->
        <ul class="list-group list-group-horizontal my-2 d-flex d-sm-none justify-content-between">
            <li class="list-group-item">
                <a tabindex="0" id="filter-all" class="btn btn-lg btn-white btn-outline-purple filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom" title="Filter">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-sliders" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3h9.05zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8h2.05zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1h9.05z" />
                    </svg>&nbsp;
                    Filters
                </a>
            </li>

            <li class="list-group-item">
                <a tabindex="0" id="filter-sort" class="btn btn-lg btn-white btn-outline-purple filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom" title="Sort By">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-sort-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 2a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-1 0v-10A.5.5 0 0 1 3 2z" />
                        <path fill-rule="evenodd" d="M5.354 10.146a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L3 11.793l1.646-1.647a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 9a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z" />
                    </svg>&nbsp;
                    Sort by
                </a>
            </li>
        </ul>
    </div>

    <!-- ================================ Search Results Page ============================================= -->
    <div class="search-result">
        <!-- ===================================== Search Rentals ===================================== -->
        <div class="col-sm-12 col-md-6 d-inline-block p-1">
            <div>
                <!-- ============================= Search Location ===================================== -->
                <div class="d-flex justify-content-between">
                    <div class="search-detail">
                        <div class="search-detail-title" id="search-detail-title">Apartments for Rent Near Me</div>
                        <div class="search-detail-result" id="search-results-count">
                            <?php echo isset($properties) ? count($properties) : '0' ?>
                            rentals available on Diraleads
                        </div>
                    </div>
                    <div class="search-detail-sort d-none d-sm-block">
                        <a tabindex="0" id="filter-sort-web" class="btn btn-lg btn-white btn-outline-purple filter-option option-closed" role="button" data-toggle="popover" data-placement="bottom" title="Sort By" style="height: unset;">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-sort-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3 2a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-1 0v-10A.5.5 0 0 1 3 2z" />
                                <path fill-rule="evenodd" d="M5.354 10.146a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L3 11.793l1.646-1.647a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 9a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z" />
                            </svg>&nbsp;
                            Sort by
                        </a>
                    </div>
                </div>

                <!-- =============================== Rental Cards ======================================== -->
                <div class="w-100 d-flex flex-wrap" id="property-cards">
                    <?php if (!isset($properties) || count($properties) == 0) { ?>
                        <h5 class="text-center">No Rentals</h5>
                        <?php } else {
                        foreach ($properties as $id => $property) {
                        ?>
                            <div class="col-sm-12 col-md-6 col-lg-4 p-1 mb-1 border-none">
                                <div class="property-card" onmouseover="showCardOnMap('[<?php echo isset($property['coords']) ? $property['coords']['lat'] : 31.0461 ?>, <?php echo isset($property['coords']) ? $property['coords']['lng'] : 34.08516 ?>]', '<?php echo isset($property['images']) && count($property['images']) > 0 ? $property['images'][0]['path'] : 'diraleads-logo.svg' ?>', '<?php echo $property['days_price'] ?>', '<?php echo $property['weekly_price'] ?>', '<?php echo $property['bedrooms'] ?>','<?php echo $property['bathrooms'] ?>', '<?php echo isset($property['title']) ? $property['title'] : '' ?>', '<?php echo $property['street'] ?>')" onmouseout="closeCardOnMap()" onclick="goDetailPage('<?php echo site_url('properties/rental_detail/' . $property['id']) ?>')">
                                    <div id="property-<?php echo $id ?>" class="carousel slide property-card-image-slider" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            <?php if (!isset($property['images']) || count($property['images']) == 0) { ?>
                                                <li data-target="#property-<?php echo $id ?>" data-slide-to="0" class="active"></li>
                                                <?php } else {
                                                foreach ($property['images'] as $index => $image) {
                                                ?>
                                                    <li data-target="#property-<?php echo $id ?>" data-slide-to="<?php echo $index ?>" class="<?php echo $index == 0 ? 'active' : '' ?>"></li>
                                            <?php }
                                            } ?>
                                        </ol>
                                        <div class="carousel-inner">
                                            <?php if (!isset($property['images']) || count($property['images']) == 0) { ?>
                                                <div class="carousel-item active">
                                                    <img src="<?php echo site_url('uploads/diraleads-logo.svg') ?>" class="d-block w-100" alt="img1">
                                                </div>
                                                <?php } else {
                                                foreach ($property['images'] as $index => $image) {
                                                ?>
                                                    <div class="carousel-item <?php echo $index == 0 ? 'active' : '' ?>">
                                                        <img src="/uploads/<?php echo $image['path'] ?>" class="d-block w-100" alt="img<?php echo $index ?>">
                                                    </div>
                                            <?php }
                                            } ?>
                                        </div>
                                        <!-- <a class="carousel-control-prev" href="#property-<?php echo $id ?>" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#property-<?php echo $id ?>" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a> -->
                                    </div>
                                    <div class="property-detail">
                                        <div class="property-detail-price">$<?php echo isset($property['days_price']) ? $property['days_price'] : 0 ?>/dy, $<?php echo isset($property['weekly_price']) ? $property['weekly_price'] : 0 ?>/wk</div>
                                        <div class="property-detail-capacity">
                                            <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.196 14.603h15.523v.027h1.995v10.64h-3.99v-4.017H9.196v4.017h-3.99V6.65h3.99v7.953zm2.109-1.968v-2.66h4.655v2.66h-4.655z" fill="#869099"></path>
                                                </svg>
                                                <?php echo $property['bedrooms'] ?> bd</span>
                                            <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M23.981 15.947H26.6v1.33a9.31 9.31 0 0 1-9.31 9.31h-2.66a9.31 9.31 0 0 1-9.31-9.31v-1.33h16.001V9.995a2.015 2.015 0 0 0-2.016-2.015h-.67c-.61 0-1.126.407-1.29.965a2.698 2.698 0 0 1 1.356 2.342H13.3a2.7 2.7 0 0 1 1.347-2.337 4.006 4.006 0 0 1 3.989-3.63h.67a4.675 4.675 0 0 1 4.675 4.675v5.952z" fill="#869099"></path>
                                                </svg><?php echo $property['bathrooms'] ?> ba</span>

                                            <?php if ($property['florbas'] > 0) { ?>
                                                <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M13.748 21.276l-3.093-3.097v3.097h3.093zm12.852 5.32H10.655v.004h-5.32v-.004H5.32v-5.32h.015V5.32L26.6 26.596z" fill="#869099"></path>
                                                    </svg><?php echo $property['florbas'] ?> fl</span>
                                            <?php } ?>
                                        </div>
                                        <div class="property-detail-address">
                                            <?php echo isset($property['title']) ? $property['title'] : '' ?>
                                        </div>
                                        <div class="property-detail-city">
                                            <?php echo $property['street'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
        </div>

        <!-- ============================================== Google Map ======================================= -->
        <div class="col-md-6 d-none d-sm-inline-block map-region p-1">
            <div id="map">
            </div>
        </div>
    </div>

    <!-- =============================== Property card on map =============================================  -->
    <div class="property-overview-card" id="property-overview-card">
        <div class="property-overview-image">
            <img src="<?php echo site_url('uploads/diraleads-logo.svg') ?>" class="w-100 block" alt="img1" id="property-overview-image" />
        </div>
        <div class="property-overview-detail">
            <div class="property-detail-price" id="property-overview-price"></div>
            <div class="property-detail-capacity" id="property-overview-capacity"></div>
            <div class="property-detail-address" id="property-overview-address"></div>
            <div class="property-detail-city" id="property-overview-city"></div>
        </div>
    </div>

    <!-- =============================== Hidden Filter Options ========================================== -->
    <input type="hidden" id="hid-rental-type" value="[]" />
    <input type="hidden" id="hid-bed" value="" />
    <input type="hidden" id="hid-floor" value="" />
    <input type="hidden" id="hid-sort" value="any" />
    <input type="hidden" id="hid-has-pic" value="false" />
    <input type="hidden" id="hid-amenities" value="[]" />
    <input type="hidden" id="hid-bath" value="" />
    <input type="hidden" id="hid-lang" value="" />
    <input type="hidden" id="hid-sleep" value="0" />
    <input type="hidden" id="hid-property-filter" value="{}" />

    <!-- ====================================== Script ========================================== -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <!-- ============================= Custom Script for Filter ========================================== -->
    <script>
        /**
         **  Search Filter Rendering
         **/

        const anyType = {
            'html': true,
            sanitize: false,
            content: function() {
                const rentalTypes = ['Apartment', 'Basement', 'House', 'Duplex', 'Villa'];
                const rentals = document.getElementById('hid-rental-type').value;
                let rentalContent = "";
                rentalTypes.forEach((rental, index) => {
                    rentalContent = `
                            ${rentalContent}
                            <li class="list-group-item">
                                <div class="form-group form-check mb-0 check-box border-0 p-0 pl-3">
                                    <input type="checkbox" class="form-check-input" id="rental-type-${index}" ${rentals.includes(rental) ? 'checked': ''} onclick="setRentalType(${index})">
                                    <label class="form-check-label" for="rental-type-${index}">${rental}</label>
                                </div>
                            </li>
                        `;
                });
                return `
                    <ul class="list-group">
                        ${rentalContent}
                    </ul>
                    `;
            }
        }
        const anyPrice = {
            'html': true,
            sanitize: false,
            content: function() {
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
            content: function() {
                const bedTypes = ['Any', '1+', '2+', '3+', '4+'];
                const bed = document.getElementById('hid-bed').value;
                let bedContent = "";

                bedTypes.forEach((bedType, index) => {
                    bedContent = `
                            ${bedContent}
                            <li class="list-group-item">
                                <button class="btn btn-outline-purple ${index == bed ? 'active' : ''}" id="bed-type-${index}" onclick="setFilter('bed', ${index})">${bedType}</button>
                            </li>
                        `;
                });
                return `
                        <ul class="list-group list-group-horizontal mb-2">
                            ${bedContent}
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
            content: function() {
                const floorTypes = ['Any', '1+', '2+', '3+', '4+'];
                const floor = document.getElementById('hid-floor').value;
                let floorContent = "";
                floorTypes.forEach((floorType, index) => {
                    floorContent = `
                            ${floorContent}
                            <li class="list-group-item">
                                <button class="btn btn-outline-purple ${index == floor ? 'active' : ''}" id="floor-type-${index}" onclick="setFilter('floor', ${index})">${floorType}</button>
                            </li>
                        `;
                });

                return `
                        <ul class="list-group list-group-horizontal">
                            ${floorContent}
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
            content: function() {
                const amenities = ['Elevator', 'Heating', 'Dryer', 'High Chair', 'Wheelchair Accessible', 'Linen and Towels', 'Kid-friendly', 'Wi-Fi', 'Air Conditioning', 'Washing Machine', 'Crib', 'Hair dryer', 'Garden/backyard', 'Pool', 'Porch/Balcony', 'Sukkah', 'Parking', 'Pesach Kitchen', 'Refrigerator', 'Freezer', 'Stove', 'Oven', 'Microwave', 'Hot-Plate/Plata', 'Shabbos Kettle/Urn', 'Cooking Utensils', 'Coffee Machine'];
                const hidAmenities = document.getElementById('hid-amenities').value;
                const sukkahContent = `<input type="number" id="sukkah-sleep" placeholder="Sleep" value="${document.getElementById('hid-sleep').value}" ${hidAmenities.includes('Sukkah') ? '' : 'disabled'} min="0" onchange="changeSleep()"/>`;
                let amenityContent = '';
                amenities.forEach((amenity, index) => {
                    amenityContent = `${amenityContent}
                            <li class="list-group-item d-flex justify-content-between">
                                <div class="form-group form-check mb-0 check-box border-0 p-0 pl-3">
                                    <input type="checkbox" class="form-check-input" id="amenity-${index}" ${hidAmenities.includes(amenity) ? 'checked' : ''} onclick="setAmenity(${index})">
                                    <label class="form-check-label" for="amenity-${index}">${amenity}</label>
                                </div>
                                ${amenity == "Sukkah" ? sukkahContent : ''}
                            </li>
                        `;
                });

                const bathTypes = ['any', '1+', '2+', '3+', '4+'];
                const hidBath = document.getElementById('hid-bath').value;
                let bathContent = '';
                bathTypes.forEach((bath, index) => {
                    bathContent = `${bathContent}
                            <li class="list-group-item"><button class="btn btn-outline-purple ${index == hidBath ? 'active' : ''}" id="bath-type-${index}" onclick="setFilter('bath', ${index})">${bath}</button></li>
                        `;
                });

                const langs = [{
                    key: 'en',
                    label: 'English'
                }, {
                    key: 'hb',
                    label: 'Hebrew'
                }, {
                    key: 'yd',
                    label: 'Yiddish'
                }];
                const languages = document.getElementById('hid-lang').value;
                let langContent = '';
                langs.forEach(lang => {
                    langContent = `${langContent}
                            <li class="list-group-item">
                                <div class="form-group form-check mb-0 check-box border-0 p-0 pl-3">
                                    <input type="checkbox" class="form-check-input" id="lang-${lang.key}" onclick="setLang('${lang.key}')" ${languages.includes(lang.key) ? 'checked' : ''}>
                                    <label class="form-check-label" for="lang-${lang.key}">${lang.label}</label>
                                </div>
                            </li>
                        `;
                });
                return `
                    <div class="filter-all-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <p class="font-weight-bold mb-1">Bathroom</p>
                                <ul class="list-group list-group-horizontal">
                                    ${bathContent}
                                </ul>
                            </li>
                            <li class="list-group-item">
                                <p class="font-weight-bold mb-1">Languages</p>
                                <ul class="list-group">
                                    ${langContent}
                                </ul>
                            </li>
                            <li class="list-group-item">
                                <p class="font-weight-bold mb-1">Amenities</p>
                                <ul class="list-group">
                                    ${amenityContent}
                                </ul>
                            </li>
                        </ul>
                    </div>
                    `;
            }
        }
        const anyAll = {
            'html': true,
            sanitize: false,
            content: function() {
                const rentalTypes = ['Apartment', 'Basement', 'House', 'Duplex', 'Villa'];
                const rentals = document.getElementById('hid-rental-type').value;
                let rentalContent = "";
                rentalTypes.forEach((rental, index) => {
                    rentalContent = `
                            ${rentalContent}
                            <li class="list-group-item">
                                <div class="form-group form-check mb-0 check-box border-0 p-0 pl-3">
                                    <input type="checkbox" class="form-check-input" id="rental-type-${index}" ${rentals.includes(rental) ? 'checked': ''} onclick="setRentalType(${index})">
                                    <label class="form-check-label" for="rental-type-${index}">${rental}</label>
                                </div>
                            </li>
                        `;
                });
                const amenities = ['Elevator', 'Heating', 'Dryer', 'High Chair', 'Wheelchair Accessible', 'Linen and Towels', 'Kid-friendly', 'Wi-Fi', 'Air Conditioning', 'Washing Machine', 'Crib', 'Hair dryer', 'Garden/backyard', 'Pool', 'Porch/Balcony', 'Sukkah', 'Parking', 'Pesach Kitchen', 'Refrigerator', 'Freezer', 'Stove', 'Oven', 'Microwave', 'Hot-Plate/Plata', 'Shabbos Kettle/Urn', 'Cooking Utensils', 'Coffee Machine'];
                const hidAmenities = document.getElementById('hid-amenities').value;
                const sukkahContent = `<input type="number" id="sukkah-sleep" placeholder="Sleep" value="${document.getElementById('hid-sleep').value}" ${hidAmenities.includes('Sukkah') ? '' : 'disabled'} min="0" onchange="changeSleep()"/>`;
                let amenityContent = '';
                amenities.forEach((amenity, index) => {
                    amenityContent = `${amenityContent}
                            <li class="list-group-item d-flex justify-content-between">
                                <div class="form-group form-check mb-0 check-box border-0 p-0 pl-3">
                                    <input type="checkbox" class="form-check-input" id="amenity-${index}" ${hidAmenities.includes(amenity) ? 'checked' : ''} onclick="setAmenity(${index})">
                                    <label class="form-check-label" for="amenity-${index}">${amenity}</label>
                                </div>
                                ${amenity == "Sukkah" ? sukkahContent : ''}
                            </li>
                        `;
                });
                const typeButtons = ["Any", "1+", "2+", "3+", "4+"];
                const types = ['bath', 'bed', 'floor'];
                let typeContents = {};
                types.forEach(type => {
                    typeContents[type] = [];
                    const value = document.getElementById(`hid-${type}`).value;
                    typeButtons.forEach((btn, index) => {
                        typeContents[type] = `${typeContents[type]}
                                <li class="list-group-item"><button class="btn btn-outline-purple ${index == value ? 'active' : ''}" onclick="setFilter('${type}', ${index})">${btn}</button></li>
                            `;
                    });
                });

                const bathTypes = ['any', '1+', '2+', '3+', '4+'];
                const hidBath = document.getElementById('hid-bath').value;
                let bathContent = '';
                bathTypes.forEach((bath, index) => {
                    bathContent = `${bathContent}
                            <li class="list-group-item"><button class="btn btn-outline-purple ${index == hidBath ? 'active' : ''}" id="bath-type-${index}" onclick="setFilter('bath', ${index})">${bath}</button></li>
                        `;
                });

                const langs = [{
                    key: 'en',
                    label: 'English'
                }, {
                    key: 'hb',
                    label: 'Hebrew'
                }, {
                    key: 'yd',
                    label: 'Yiddish'
                }];
                const languages = document.getElementById('hid-lang').value;
                let langContent = '';
                langs.forEach(lang => {
                    langContent = `${langContent}
                            <li class="list-group-item">
                                <div class="form-group form-check mb-0 check-box border-0 p-0 pl-3">
                                    <input type="checkbox" class="form-check-input" id="lang-${lang.key}" onclick="setLang('${lang.key}')" ${languages.includes(lang.key) ? 'checked' : ''}>
                                    <label class="form-check-label" for="lang-${lang.key}">${lang.label}</label>
                                </div>
                            </li>
                        `;
                });
                return `
                    <div class="filter-all-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <p class="font-weight-bold mb-1">Rental Types</p>
                                <ul class="list-group">
                                    ${rentalContent}
                                </ul>
                            </li>
                            <li class="list-group-item">
                                <p class="font-weight-bold mb-1">Languages</p>
                                <ul class="list-group">
                                    ${langContent}
                                </ul>
                            </li>
                            <li class="list-group-item">
                                <p class="font-weight-bold mb-1">Amenities</p>
                                <ul class="list-group">
                                    ${amenityContent}
                                </ul>
                            </li>
                            <li class="list-group-item">
                                <p class="font-weight-bold mb-1">Bathroom</p>
                                <ul class="list-group list-group-horizontal">
                                    ${typeContents['bath']}
                                </ul>
                            </li>
                            <li class="list-group-item">
                                <p class="font-weight-bold mb-1">Bedrooms</p>
                                <ul class="list-group list-group-horizontal">
                                    ${typeContents['bed']}
                                </ul>
                            </li>
                            <li class="list-group-item">
                                <p class="font-weight-bold mb-1">Floors</p>
                                <ul class="list-group list-group-horizontal">
                                    ${typeContents['floor']}
                                </ul>
                            </li>
                            <!--
                            <li class="list-group-item">
                                <p class="font-weight-bold mb-1">Price</p>
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item"><input type="number" class="form-control" placeholder="Min" value="0" /></li>
                                    <li class="list-group-item"><input type="number" class="form-control" placeholder="Max" value="0" /></li>
                                </ul>
                            </li>
                            -->
                        </ul>
                    </div>
                    <button class="btn btn-purple btn-block">View Rentals</button>
                    `;
            }
        }
        const anySort = {
            'html': true,
            sanitize: false,
            content: function() {
                const sort = document.getElementById('hid-sort').value;
                return `
                        <ul class="list-group">
                            <li class="list-group-item">
                                <button class="btn btn-outline-purple ${sort == 'any' ? 'active' : ''}" onclick="setOrder('any')" id="sort-any">Any</button>
                            </li>
                            <li class="list-group-item">
                                <button class="btn btn-outline-purple ${sort == 'high-low-price' ? 'active' : ''}" onclick="setOrder('high-low-price')" id="sort-high-low-price">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-sort-numeric-down-alt" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4 2a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-1 0v-11A.5.5 0 0 1 4 2z"/>
                                        <path fill-rule="evenodd" d="M6.354 11.146a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L4 12.793l1.646-1.647a.5.5 0 0 1 .708 0z"/>
                                        <path d="M9.598 5.82c.054.621.625 1.278 1.761 1.278 1.422 0 2.145-.98 2.145-2.848 0-2.05-.973-2.688-2.063-2.688-1.125 0-1.972.688-1.972 1.836 0 1.145.808 1.758 1.719 1.758.69 0 1.113-.351 1.261-.742h.059c.031 1.027-.309 1.856-1.133 1.856-.43 0-.715-.227-.773-.45H9.598zm2.757-2.43c0 .637-.43.973-.933.973-.516 0-.934-.34-.934-.98 0-.625.407-1 .926-1 .543 0 .941.375.941 1.008zM12.438 14V8.668H11.39l-1.262.906v.969l1.21-.86h.052V14h1.046z"/>
                                    </svg>
                                    Descending by Price
                                </button>
                            </li>

                            <li class="list-group-item">
                                <button class="btn btn-outline-purple ${sort == 'low-high-price' ? 'active' : ''}" onclick="setOrder('low-high-price')" id="sort-low-high-price">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-sort-numeric-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4 14a.5.5 0 0 0 .5-.5v-11a.5.5 0 0 0-1 0v11a.5.5 0 0 0 .5.5z"/>
                                        <path fill-rule="evenodd" d="M6.354 4.854a.5.5 0 0 0 0-.708l-2-2a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L4 3.207l1.646 1.647a.5.5 0 0 0 .708 0z"/>
                                        <path d="M12.438 7V1.668H11.39l-1.262.906v.969l1.21-.86h.052V7h1.046zm-2.84 5.82c.054.621.625 1.278 1.761 1.278 1.422 0 2.145-.98 2.145-2.848 0-2.05-.973-2.688-2.063-2.688-1.125 0-1.972.688-1.972 1.836 0 1.145.808 1.758 1.719 1.758.69 0 1.113-.351 1.261-.742h.059c.031 1.027-.309 1.856-1.133 1.856-.43 0-.715-.227-.773-.45H9.598zm2.757-2.43c0 .637-.43.973-.933.973-.516 0-.934-.34-.934-.98 0-.625.407-1 .926-1 .543 0 .941.375.941 1.008z"/>
                                    </svg>
                                    Ascending by Price
                                </button>
                            </li>

                            <li class="list-group-item">
                                <button class="btn btn-outline-purple ${sort == 'latest' ? 'active' : ''}" onclick="setOrder('latest')"  id="sort-latest">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-sort-alpha-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4 2a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-1 0v-11A.5.5 0 0 1 4 2z"/>
                                        <path fill-rule="evenodd" d="M6.354 11.146a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L4 12.793l1.646-1.647a.5.5 0 0 1 .708 0z"/>
                                        <path d="M9.664 7l.418-1.371h1.781L12.281 7h1.121l-1.78-5.332h-1.235L8.597 7h1.067zM11 2.687l.652 2.157h-1.351l.652-2.157H11zM9.027 14h3.934v-.867h-2.645v-.055l2.567-3.719v-.691H9.098v.867h2.507v.055l-2.578 3.719V14z"/>
                                    </svg>
                                    Latest
                                </button>
                            </li>

                            <li class="list-group-item">
                                <button class="btn btn-outline-purple ${sort == 'oldest' ? 'active' : ''}" onclick="setOrder('oldest')"  id="sort-oldest">
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

        $(function() {
            $('#filter-type').popover(anyType);
        });
        // $(function() {
        //     $('#filter-price').popover(anyPrice);
        // });
        $(function() {
            $('#filter-bed').popover(anyBed);
        });
        $(function() {
            $('#filter-floor').popover(anyFloor);
        });
        $(function() {
            $('#filter-more').popover(anyMore);
        });
        $(function() {
            $('#filter-sort').popover(anySort);
        });
        $(function() {
            $('#filter-sort-web').popover(anySort);
        });
        $(function() {
            $('#filter-all').popover(anyAll);
        });
    </script>

    <!-- ============================ Filter Caret Style control ============================================ -->
    <script>
        /**
         **  Filter Caret Style
         */
        $('#filter-type').on('shown.bs.popover', function() {
            document.getElementById('filter-type').className = document.getElementById('filter-type').className.split('option-closed').join('option-opened');
            // $('#filter-price').popover('hide');
            $('#filter-bed').popover('hide');
            $('#filter-floor').popover('hide');
            $('#filter-more').popover('hide');
            $('#filter-all').popover('hide');
            $('#filter-sort').popover('hide');
            $('#filter-sort-web').popover('hide');
        });
        $('#filter-type').on('hidden.bs.popover', function() {
            document.getElementById('filter-type').className = document.getElementById('filter-type').className.split('option-opened').join('option-closed');
            $('#filter-type').attr('class', 'btn btn-lg btn-white btn-outline-purple filter-option option-closed');
        });

        // $('#filter-price').on('shown.bs.popover', function() {
        //     document.getElementById('filter-price').className = document.getElementById('filter-price').className.split('option-closed').join('option-opened');
        //     $('#filter-type').popover('hide');
        //     $('#filter-bed').popover('hide');
        //     $('#filter-floor').popover('hide');
        //     $('#filter-more').popover('hide');
        //     $('#filter-all').popover('hide');
        //     $('#filter-sort').popover('hide');
        //     $('#filter-sort-web').popover('hide');
        // });
        // $('#filter-price').on('hidden.bs.popover', function() {
        //     document.getElementById('filter-price').className = document.getElementById('filter-price').className.split('option-opened').join('option-closed');
        // });

        $('#filter-bed').on('shown.bs.popover', function() {
            document.getElementById('filter-bed').className = document.getElementById('filter-bed').className.split('option-closed').join('option-opened');
            $('#filter-type').popover('hide');
            // $('#filter-price').popover('hide');
            $('#filter-floor').popover('hide');
            $('#filter-more').popover('hide');
            $('#filter-all').popover('hide');
            $('#filter-sort').popover('hide');
            $('#filter-sort-web').popover('hide');
        });
        $('#filter-bed').on('hidden.bs.popover', function() {
            document.getElementById('filter-bed').className = document.getElementById('filter-bed').className.split('option-opened').join('option-closed');
        });

        $('#filter-floor').on('shown.bs.popover', function() {
            document.getElementById('filter-floor').className = document.getElementById('filter-floor').className.split('option-closed').join('option-opened');
            $('#filter-type').popover('hide');
            // $('#filter-price').popover('hide');
            $('#filter-bed').popover('hide');
            $('#filter-more').popover('hide');
            $('#filter-all').popover('hide');
            $('#filter-sort').popover('hide');
            $('#filter-sort-web').popover('hide');
        });
        $('#filter-floor').on('hidden.bs.popover', function() {
            document.getElementById('filter-floor').className = document.getElementById('filter-floor').className.split('option-opened').join('option-closed');
        });

        $('#filter-more').on('shown.bs.popover', function() {
            document.getElementById('filter-more').className = document.getElementById('filter-more').className.split('option-closed').join('option-opened');
            $('#filter-type').popover('hide');
            // $('#filter-price').popover('hide');
            $('#filter-bed').popover('hide');
            $('#filter-floor').popover('hide');
            $('#filter-all').popover('hide');
            $('#filter-sort').popover('hide');
            $('#filter-sort-web').popover('hide');
        });
        $('#filter-more').on('hidden.bs.popover', function() {
            document.getElementById('filter-more').className = document.getElementById('filter-more').className.split('option-opened').join('option-closed');
        });

        $('#filter-all').on('shown.bs.popover', function() {
            document.getElementById('filter-all').className = document.getElementById('filter-all').className.split('option-closed').join('option-opened');
            $('#filter-type').popover('hide');
            // $('#filter-price').popover('hide');
            $('#filter-bed').popover('hide');
            $('#filter-floor').popover('hide');
            $('#filter-more').popover('hide');
            $('#filter-sort').popover('hide');
            $('#filter-sort-web').popover('hide');
        });
        $('#filter-all').on('hidden.bs.popover', function() {
            document.getElementById('filter-all').className = document.getElementById('filter-all').className.split('option-opened').join('option-closed');
        });

        $('#filter-sort').on('shown.bs.popover', function() {
            document.getElementById('filter-sort').className = document.getElementById('filter-sort').className.split('option-closed').join('option-opened');
            $('#filter-type').popover('hide');
            // $('#filter-price').popover('hide');
            $('#filter-bed').popover('hide');
            $('#filter-floor').popover('hide');
            $('#filter-more').popover('hide');
            $('#filter-all').popover('hide');
            $('#filter-sort-web').popover('hide');
        });
        $('#filter-sort').on('hidden.bs.popover', function() {
            document.getElementById('filter-sort').className = document.getElementById('filter-sort').className.split('option-opened').join('option-closed');
        });

        $('#filter-sort-web').on('shown.bs.popover', function() {
            document.getElementById('filter-sort-web').className = document.getElementById('filter-sort-web').className.split('option-closed').join('option-opened');
            $('#filter-type').popover('hide');
            // $('#filter-price').popover('hide');
            $('#filter-bed').popover('hide');
            $('#filter-floor').popover('hide');
            $('#filter-more').popover('hide');
            $('#filter-all').popover('hide');
            $('#filter-sort').popover('hide');
        });
        $('#filter-sort-web').on('hidden.bs.popover', function() {
            document.getElementById('filter-sort-web').className = document.getElementById('filter-sort-web').className.split('option-opened').join('option-closed');
        });

        $('body').on('click', function(e) {
            $('[data-toggle=popover]').each(function() {
                // hide any open popovers when the anywhere else in the body is clicked
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
                }
            });
        });
    </script>

    <!-- ================================== Scripts for card popup on google map ================================== -->
    <script>
        function showCardOnMap(coords, image, days_price, weekly_price, bedrooms, bathrooms, title, street) {
            const location = JSON.parse(coords);
            if (map) {
                try {
                    map.setCenter({
                        lat: location[0],
                        lng: location[1]
                    });
                } catch (error) {
                    console.log("Map is not loaded...");
                }
            }


            document.getElementById('property-overview-image').src = `/uploads/${image}`;
            document.getElementById('property-overview-price').innerHTML = `$${days_price ? days_price : 0}/dy, $${weekly_price ? weekly_price : 0}/wk`;
            document.getElementById('property-overview-capacity').innerHTML = `<span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M9.196 14.603h15.523v.027h1.995v10.64h-3.99v-4.017H9.196v4.017h-3.99V6.65h3.99v7.953zm2.109-1.968v-2.66h4.655v2.66h-4.655z" fill="#869099"></path></svg>${bedrooms} bd</span><span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M23.981 15.947H26.6v1.33a9.31 9.31 0 0 1-9.31 9.31h-2.66a9.31 9.31 0 0 1-9.31-9.31v-1.33h16.001V9.995a2.015 2.015 0 0 0-2.016-2.015h-.67c-.61 0-1.126.407-1.29.965a2.698 2.698 0 0 1 1.356 2.342H13.3a2.7 2.7 0 0 1 1.347-2.337 4.006 4.006 0 0 1 3.989-3.63h.67a4.675 4.675 0 0 1 4.675 4.675v5.952z" fill="#869099"></path></svg>${bathrooms} ba</span>`;
            document.getElementById('property-overview-address').innerHTML = `${title}`;
            document.getElementById('property-overview-city').innerHTML = `${street}`;

            const center = {
                left: ($('#map').offset().left - window.scrollX) + $('#map').width() / 2,
                top: ($('#map').offset().top - window.scrollY) + $('#map').height() / 2
            }
            var ghostMarkerEl = document.createElement('div');
            ghostMarkerEl.id = "ghost-marker";
            ghostMarkerEl.style.left = center.left - 13;
            ghostMarkerEl.style.top = center.top - 13;
            document.body.appendChild(ghostMarkerEl);

            document.getElementById('property-overview-card').style.top = center.top - 100;
            document.getElementById('property-overview-card').style.left = center.left + 30;
            document.getElementById('property-overview-card').style.display = 'block';
        }

        function closeCardOnMap() {
            document.getElementById('property-overview-card').style.display = 'none';
            var ghostMarkerEl = document.getElementById('ghost-marker');
            document.body.removeChild(ghostMarkerEl);
        }
    </script>

    <!-- ============================= Actions for Filter Control =============================== -->
    <script>
        function changeSleep() {
            document.getElementById('hid-sleep').value = document.getElementById('sukkah-sleep').value;
        }

        function setRentalType(index) {
            const rentalTypes = ['Apartment', 'Basement', 'House', 'Duplex', 'Villa'];
            let types = [];

            for (let i = 0, length = rentalTypes.length; i < length; i++) {
                if (document.getElementById(`rental-type-${i}`).checked)
                    types.push(rentalTypes[i]);
            }

            document.getElementById(`hid-rental-type`).value = JSON.stringify(types);
            filter('type', types);
        }

        function setFilter(key, index) {
            for (let i = 0; i < 5; i++) {
                if (i == index) document.getElementById(`${key}-type-${i}`).className += " active";
                else document.getElementById(`${key}-type-${i}`).className = 'btn btn-outline-purple';
            }

            document.getElementById(`hid-${key}`).value = index;
            filter(key, index);
        }

        function setOrder(order) {
            const sortTypes = ['any', 'high-low-price', 'low-high-price', 'latest', 'oldest'];
            for (let i = 0, length = sortTypes.length; i < length; i++) {
                if (order == sortTypes[i]) document.getElementById(`sort-${sortTypes[i]}`).className += ' active';
                else document.getElementById(`sort-${sortTypes[i]}`).className = "btn btn-outline-purple";
            }
            document.getElementById('hid-sort').value = order;
            filter('sort', order);
        }

        function setHasPic() {
            document.getElementById('hid-has-pic').value = document.getElementById('hid-has-pic').value == "true" ? "false" : "true";
            filter('has_pic', document.getElementById('hid-has-pic').value);
        }

        function setLang(lang) {
            const langs = [{
                key: 'en',
                label: 'English'
            }, {
                key: 'hb',
                label: 'Hebrew'
            }];
            let languages = [];
            for (let i = 0, length = langs.length; i < length; i++) {
                if (document.getElementById(`lang-${langs[i].key}`).checked)
                    languages.push(langs[i].key);
            }
            document.getElementById('hid-lang').value = JSON.stringify(languages);
            filter('lang', languages);
        }

        function setAmenity(index) {

            const amenities = ['Elevator', 'Heating', 'Dryer', 'High Chair', 'Wheelchair Accessible', 'Linen and Towels', 'Kid-friendly', 'Wi-Fi', 'Air Conditioning', 'Washing Machine', 'Crib', 'Hair dryer', 'Garden/backyard', 'Pool', 'Porch/Balcony', 'Sukkah', 'Parking', 'Pesach Kitchen', 'Refrigerator', 'Freezer', 'Stove', 'Oven', 'Microwave', 'Hot-Plate/Plata', 'Shabbos Kettle/Urn', 'Cooking Utensils', 'Coffee Machine'];
            let types = [];

            for (let i = 0, length = amenities.length; i < length; i++) {
                if (document.getElementById(`amenity-${i}`).checked)
                    types.push(amenities[i]);
            }
            if (amenities[index] == "Sukkah") {
                document.getElementById('sukkah-sleep').disabled = !document.getElementById('sukkah-sleep').disabled;
            }

            document.getElementById('hid-amenities').value = JSON.stringify(types);
            filter('amenities', types);
        }

        function filter(key, value) {
            const filterEl = document.getElementById('hid-property-filter');
            let filters = JSON.parse(filterEl.value);
            filters[key] = value;
            document.getElementById('hid-property-filter').value = JSON.stringify(filters);

            console.log("Filters: ", filters);

            $.ajax({
                method: 'POST',
                url: "<?php echo site_url('properties/search') ?>",
                data: filters,
                success: function(response) {
                    const res = JSON.parse(response);
                    const properties = res.properties;
                    document.getElementById('property-cards').innerHTML = '';
                    document.getElementById('search-results-count').innerHTML = `${properties.length} rentals available on Diraleads`;

                    if (properties.length == 0)
                        drawNoResult();
                    else
                        drawRentalCard(properties);
                },
                fail: function(error) {
                    console.log("Error: ", error);
                }
            });
        }

        function drawRentalCard(properties) {
            let elements = '';
            properties.forEach((property, index) => {
                elements = `${elements}
                    <div class="col-sm-12 col-md-6 col-lg-4 p-1 mb-1 border-none">
                        <div class="property-card" onmouseover="showCardOnMap('[${property.coords ? property.coords.lat : 31.0461}, ${property.coords ? property.coords.lng : 34.08516}]', '${property.images && property.images.length > 0 ? property.images[0].path : 'diraleads-logo.svg'}', '${property.days_price}', '${property.weekly_price}', '${property.bedrooms}', '${property.bathrooms}', '${property.title}', '${property.street}')" onmouseout="closeCardOnMap()" onclick="goDetailPage('/properties/rental_detail/${property.id}')">
                            <div id="property-${index}" class="carousel slide property-card-image-slider" data-ride="carousel">
                                <ol class="carousel-indicators">
                                ${ !property.images || property.images.length == 0 ? `<li data-target="#property-${index}" data-slide-to="0" class="active"></li>` : property.images.map((image, idx) => (
                                    `<li data-target="#property-${idx}" data-slide-to="${idx}" class="${idx == 0 ? 'active' : ''}"></li>`
                                ))}
                                </ol>
                                <div class="carousel-inner">
                                ${ !property.images || property.images.length == 0 ? `<div class="carousel-item active"><img src="/uploads/diraleads-logo.svg" class="d-block w-100" alt="img1"></div>` : property.images.map((image, idx) => (
                                    `<div class="carousel-item ${idx == 0 ? 'active' : ''}"><img src="/uploads/${image.path}" class="d-block w-100" alt="img${idx}"/></div>`
                                ))}
                                </div>
                                <!--
                                <a class="carousel-control-prev" href="#property-${index}" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#property-${index}" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                                -->
                            </div>
                            <div class="property-detail">
                                <div class="property-detail-price">$${property.days_price ? property.days_price : 0}/dy, $${property.weekly_price ? property.weekly_price : 0}/wk</div>
                                <div class="property-detail-capacity">
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M9.196 14.603h15.523v.027h1.995v10.64h-3.99v-4.017H9.196v4.017h-3.99V6.65h3.99v7.953zm2.109-1.968v-2.66h4.655v2.66h-4.655z" fill="#869099"></path></svg>
                                    ${property.bedrooms} bd</span>
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M23.981 15.947H26.6v1.33a9.31 9.31 0 0 1-9.31 9.31h-2.66a9.31 9.31 0 0 1-9.31-9.31v-1.33h16.001V9.995a2.015 2.015 0 0 0-2.016-2.015h-.67c-.61 0-1.126.407-1.29.965a2.698 2.698 0 0 1 1.356 2.342H13.3a2.7 2.7 0 0 1 1.347-2.337 4.006 4.006 0 0 1 3.989-3.63h.67a4.675 4.675 0 0 1 4.675 4.675v5.952z" fill="#869099"></path></svg>${property.bathrooms} ba</span>
                                    ${property.florbas ? `<span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M13.748 21.276l-3.093-3.097v3.097h3.093zm12.852 5.32H10.655v.004h-5.32v-.004H5.32v-5.32h.015V5.32L26.6 26.596z" fill="#869099"></path></svg>${property.florbas}fl</span>` : ''}
                                </div>
                                <div class="property-detail-address">
                                ${property.title}
                                </div>
                                <div class="property-detail-city">
                                ${property.street}
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
            });

            document.getElementById('property-cards').innerHTML = elements;
        }

        function drawNoResult() {
            document.getElementById('property-cards').innerHTML = `<h5 class="text-center">No Rentals</h5>`;
        }

        function goDetailPage(location) {
            document.location.href = location;
        }
    </script>


</body>

</html>

<script>
    var data = <?php echo json_encode($properties); ?>;
    console.log("Properteis", data);
</script>