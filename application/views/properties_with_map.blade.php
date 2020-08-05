<!DOCTYPE html>
<html lang="en">

  <head>
    <title>diraleads</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8" />

    <!-- External CSS libraries -->
    <link rel="stylesheet" type="text/css" href="assets/properties/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/properties/css/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/properties/css/bootstrap-submenu.css" />

    <link rel="stylesheet" type="text/css" href="assets/properties/css/bootstrap-select.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/properties/css/magnific-popup.css" />
    <link rel="stylesheet" href="assets/properties/css/leaflet.css" type="text/css" />
    <link rel="stylesheet" href="assets/properties/css/map.css" type="text/css" />
    <link rel='stylesheet'
      href='https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.css' />
    <link rel='stylesheet'
      href='https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.Default.css' />
    <link rel="stylesheet" type="text/css"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/properties/fonts/flaticon.css" />
    <link rel="stylesheet" type="text/css" href="assets/properties/fonts/linearicons/style.css" />
    <link rel="stylesheet" type="text/css" href="assets/properties/css/jquery.mCustomScrollbar.css" />
    <link rel="stylesheet" type="text/css" href="assets/properties/css/slick.css" />

    <!-- Custom stylesheet -->
    <link rel="stylesheet" type="text/css" href="assets/properties/css/style.css" />
    <link rel="stylesheet" type="text/css" id="style_sheet" href="assets/properties/css/skins/default.css" />

    <!-- Google fonts -->
    <link rel="stylesheet" type="text/css"
      href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,300,700" />

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link rel="stylesheet" type="text/css" href="assets/properties/css/ie10-viewport-bug-workaround.css" />

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9
      ]><script src="assets/properties/js/ie8-responsive-file-warning.js"></script
    ><![endif]-->
    <script src="assets/properties/js/ie-emulation-modes-warning.js"></script>
  </head>

  <body>
    <div class="page_loader"></div>
    <!-- Main header start -->
    <header class="main-header header-transparent sticky-header">
      <nav class="navbar navbar-expand-lg demo-2">
        <div class="container navbar-container">
          <a class="navbar-brand" href="#"><img style="width:146px" src="assets/properties/img/diraleads-logo.svg" />
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars iconbar"></i>
          </button>
          <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item dropdown position-relative">
                <a href="index.html" class="nav-link">
                  Home
                </a>
              </li>
              <li class="nav-item dropdown position-relative">
                <a href="about.html" class="nav-link">
                  About us
                </a>
              </li>
              <li class="nav-item active">
                <a href="properties-leftside.html" class="nav-link">
                  Property
                </a>
              </li>
              <li class="nav-item dropdown position-relative">
                <a href="list-your-properties.html" class="nav-link">
                  List your Property
                </a>
              </li>
              <li class="nav-item dropdown position-relative">
                <a href="subscribe.html" class="nav-link">
                  Subscribe
                </a>
              </li>
              <li class="nav-item dropdown position-relative">
                <a href="price-plans.html" class="nav-link">
                  Price Plans
                </a>
              </li>
              <li class="nav-item dropdown position-relative">
                <a href="contact.html" class="nav-link">
                  Contact us
                </a>
              </li>
            </ul>
            <ul class="navbar-nav offcanvas-navbar position-relative">
              <li class="nav-item  position-relative">
                <a class="nav-link" href="login.html">
                  Login
                </a>
              </li>
            </ul>
          </div>
        </div>
        <!-- container -->
      </nav>
    </header>
    <!-- Main header end -->
    <!-- Sub banner start -->
    <div class="sub-banner overview-bgi"></div>
    <!-- Sub Banner end -->

    <!-- Map content start -->
    <div class="map-content content-area container-fluid">
      <div class="row">
        <div class="col-lg-7 map-content-sidebar">
          <div class="properties-map-search properties-pad2">
            <div class="title-area">
              <h2 class="pull-left">Filters</h2>
              <a class="show-more-options pull-right" data-toggle="collapse" data-target="#options-content">
                <i class="fa fa-plus-circle"></i> Show More Options
              </a>
              <div class="clearfix"></div>
            </div>
            <div class="properties-map-search-content">
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="range-slider">
                    <label>Area</label>
                    <div data-min="0" data-max="10000" data-min-name="min_area" data-max-name="max_area"
                      data-unit="Sq ft" data-name="area" class="range-slider-ui ui-slider" aria-disabled="false">
                    </div>
                    <div class="clearfix"></div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="range-slider">
                    <label>Price</label>
                    <div data-min="0" data-max="150000" data-unit="USD" data-min-name="min_price"
                      data-max-name="max_price" class="range-slider-ui ui-slider" aria-disabled="false"></div>
                    <div class="clearfix"></div>
                  </div>
                </div>
              </div>
              <div id="options-content" class="collapse">
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <input class="form-control search-fields" placeholder="Enter address e.g. street, city" />
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <select class="selectpicker search-fields">
                        <option>All Status</option>
                        <option>For Sale</option>
                        <option>For Rent</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <select class="selectpicker search-fields">
                        <option>All Type</option>
                        <option>Apartments</option>
                        <option>Houses</option>
                        <option>Shop</option>
                        <option>Restaurant</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <select class="selectpicker search-fields">
                        <option>location</option>
                        <option>United States</option>
                        <option>American Samoa</option>
                        <option>Belgium</option>
                        <option>Canada</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <select class="selectpicker search-fields">
                        <option>Bedrooms</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <select class="selectpicker search-fields">
                        <option>Bathroom</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <select class="selectpicker search-fields">
                        <option>Balcony</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <select class="selectpicker search-fields">
                        <option>Garage</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                      </select>
                    </div>
                  </div>
                </div>
                <label class="margin-t-10">Features</label>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="checkbox checkbox-theme checkbox-circle">
                      <input id="checkbox1" type="checkbox" />
                      <label for="checkbox1">
                        Free Parking
                      </label>
                    </div>
                    <div class="checkbox checkbox-theme checkbox-circle">
                      <input id="checkbox2" type="checkbox" />
                      <label for="checkbox2">
                        Air Condition
                      </label>
                    </div>
                    <div class="checkbox checkbox-theme checkbox-circle">
                      <input id="checkbox3" type="checkbox" />
                      <label for="checkbox3">
                        Places to seat
                      </label>
                    </div>
                    <div class="checkbox checkbox-theme checkbox-circle">
                      <input id="checkbox4" type="checkbox" />
                      <label for="checkbox4">
                        Swimming Pool
                      </label>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="checkbox checkbox-theme checkbox-circle">
                      <input id="checkbox5" type="checkbox" />
                      <label for="checkbox5">
                        Laundry Room
                      </label>
                    </div>
                    <div class="checkbox checkbox-theme checkbox-circle">
                      <input id="checkbox6" type="checkbox" />
                      <label for="checkbox6">
                        Window Covering
                      </label>
                    </div>
                    <div class="checkbox checkbox-theme checkbox-circle">
                      <input id="checkbox7" type="checkbox" />
                      <label for="checkbox7">
                        Central Heating
                      </label>
                    </div>
                    <div class="checkbox checkbox-theme checkbox-circle">
                      <input id="checkbox8" type="checkbox" />
                      <label for="checkbox8">
                        Alarm
                      </label>
                    </div>
                    <br />
                  </div>
                </div>
              </div>
            </div>
            <div class="title-area hidden-sm hidden-xs">
              <h2 class="pull-left results-for">
                Results For : Properties Grid
              </h2>

              <div class="clearfix"></div>
            </div>
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
    <!-- Map content end -->

    <script src="assets/properties/js/jquery-2.2.0.min.js"></script>
    <script src="assets/properties/js/popper.min.js"></script>
    <script src="assets/properties/js/bootstrap.min.js"></script>
    <script src="assets/properties/js/bootstrap-submenu.js"></script>
    <script src="assets/properties/js/rangeslider.js"></script>
    <script src="assets/properties/js/jquery.mb.YTPlayer.js"></script>
    <script src="assets/properties/js/bootstrap-select.min.js"></script>
    <script src="assets/properties/js/jquery.easing.1.3.js"></script>
    <script src="assets/properties/js/jquery.scrollUp.js"></script>
    <script src="assets/properties/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.5.1/leaflet.js'></script>
    <script src="assets/properties/js/leaflet-providers.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/leaflet.markercluster.js'></script>
    <script src="assets/properties/js/dropzone.js"></script>
    <script src="assets/properties/js/slick.min.js"></script>
    <script src="assets/properties/js/jquery.filterizr.js"></script>
    <script src="assets/properties/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/properties/js/jquery.countdown.js"></script>
    <script src="assets/properties/js/maps.js"></script>
    <script src="assets/properties/js/app.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/properties/js/ie10-viewport-bug-workaround.js"></script>
    <!-- Custom javascript -->
    <script src="assets/properties/js/ie10-viewport-bug-workaround.js"></script>
  </body>

</html>