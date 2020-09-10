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
    <!-- ========================== Full Calendar ========================================== -->
    <link rel="stylesheet" href="<?php echo site_url('assets/fullcalendar/main.css') ?>">
    </link>
    <script src="<?php echo site_url('assets/fullcalendar/main.js') ?>"></script>
    <!-- ========================== Google Map Scripts ================================= -->
    <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPhDpAUyER52TsCsLFNOOxT_l5-y7e78A&libraries=places&callback=initMap"></script> -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByMhYirwn_EOt2HPNbeWtVE-BVEypa6kI&libraries=places&callback=initMap"></script>

    <!-- ============================= Google Map Script ========================================== -->
    <script>
        function initMap(marker = {
            lat: 31.0461,
            lng: 34.08516
        }) {
            let coords = "<?php echo $property->coords ?>";
            let center = {
                ...marker
            };
            if (coords) {
                coords = JSON.parse(coords);
                center = {
                    lat: coords[0],
                    lng: coords[1]
                }
            }
            detailMap = new google.maps.Map(
                document.getElementById('detail-map'), {
                    zoom: 8,
                    center
                }
            );

            let newMarker = new google.maps.Marker({
                position: center,
                map: detailMap
            });
        }
    </script>

    <!-- =============================== Full Calendar Script ===================================== -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('availability-calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                editable: false,
                selectable: true,
                businessHours: true,
                dayMaxEvents: true,
                events: [],
                headerToolbar: {
                    start: 'title', // will normally be on the left. if RTL, will be on the right
                    center: '',
                    end: 'prev,next' // will normally be on the right. if RTL, will be on the left
                },
                titleFormat: {
                    year: 'numeric',
                    month: 'short'
                }
            });

            calendar.render();
        });
    </script>
</head>

<body>
    <!-- ========================= HEADER ======================================= -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
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

    <!-- =============================== Property Detail View ============================================= -->
    <div class="container mt-3">
        <div class="property-board-image">
            <div id="property-detail-image" class="carousel slide property-detail-image-slider" data-ride="carousel">
                <?php if (!isset($property->images) || count($property->images) == 0) { ?>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?php echo site_url('uploads/diraleads-logo.svg') ?>" class="d-block w-100" />
                        </div>
                    </div>
                <?php } else { ?>

                    <ol class="carousel-indicators">
                        <?php foreach ($property->images as $index => $image) { ?>
                            <li data-target="#property-detail-image" data-slide-to="<?php echo $index ?>" class="<?php echo $index == 0 ? 'active' : '' ?>"></li>
                        <?php } ?>
                    </ol>
                    <div class="carousel-inner">
                        <?php foreach ($property->images as $index => $image) { ?>
                            <div class="carousel-item <?php echo $index == 0 ? 'active' : '' ?>">
                                <img src="<?php echo site_url('uploads/' . $image['path']) ?>" class="d-block w-100" />
                            </div>
                        <?php  } ?>
                    </div>
                <?php } ?>
                <a class="carousel-control-prev" href="#property-detail-image" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#property-detail-image" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="property-detail-info">
                    <div class="property-info">
                        <h3>$<?php echo $property->days_price ?>/dy, $<?php echo $property->weekly_price ?>/wk</h3>
                        <p class="mb-2"><?php echo $property->title ?></p>
                        <h5><?php echo $property->street ?></h5>
                    </div>

                    <div class="property-description">
                        <h3>Description</h3>
                        <p style="overflow-wrap: break-word">
                            <?php echo $property->description ?>
                        </p>
                    </div>

                    <div class="property-amenities">
                        <h3>Amenities</h3>
                        <div class="row">
                            <?php foreach ($property->amenities as $amenity) { ?>
                                <div class="col-sm-6 col-md-4"><?php echo $amenity ?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="property-location">
                        <h3>Location</h3>
                        <div id="detail-map"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="property-contact-detail">
                    <div class="property-calendar">
                        <h3>Availability</h3>
                        <div id="availability-calendar"></div>
                    </div>

                    <form>
                        <h3>Contact</h3>
                        <div class="form-group">
                            <label for="property-host-name">Host Name: <?php echo $property->name; ?></label>
                            <!-- <input type="text" class="form-control" id="property-host-name" placeholder="Your Host Name" /> -->
                        </div>
                        <div class="form-group">
                            <label for="property-did-number">📱 DID Number: <?php echo $property->number; ?></label>
                            <!-- <input type="text" class="form-control" id="property-did-number" placeholder="DID Number" /> -->
                        </div>
                        <div class="form-group">
                            <label for="property-contact-name">Name</label>
                            <input type="text" class="form-control" id="property-contact-name" placeholder="Your Name" />
                        </div>
                        <div class="form-group">
                            <label for="property-contact-email">Email</label>
                            <input type="email" class="form-control" id="property-contact-email" placeholder="Your Email" />
                        </div>
                        <div class="form-group">
                            <label for="property-contact-message">Message</label>
                            <textarea class="form-control" id="property-contact-message" placeholder="Message"></textarea>
                        </div>
                        <button class="btn btn-purple btn-block" type="submit">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ====================================== Script ========================================== -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>

</html>

<script>
    var data = <?php echo json_encode($property); ?>;
    console.log(data);
</script>