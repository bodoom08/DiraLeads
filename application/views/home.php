<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/layout/top', [
    'title' => 'Home'
]);
?>

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

<div class="services content-area ">
    <div class="container">

        <div class="main-title text-center">
            <p class="text-uppercase">Who you work with matters</p>
            <h1>Working with the Reality</h1>
        </div>
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="service-info">
                    <div class="icon">
                        <i class="flaticon-user"></i>
                    </div>
                    <h3>Personalized Service</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt</p>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="service-info">
                    <div class="icon">
                        <i class="flaticon-apartment-1"></i>
                    </div>
                    <h3>Luxury Real Estate Experts</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt</p>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="service-info">
                    <div class="icon">
                        <i class="flaticon-discount"></i>
                    </div>
                    <h3>Modern Building For Rent $ Sell</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="search-main bg-overlay" style="background-image: url('assets/img/search-bg.jpg');">
    <div class="container">

        <div class="main-title text-center">
            <h1 class="text-white">Find your Property</h1>
        </div>
        <div class="search-section-area">
            <div class="search-area-inner">
                <div class="search-contents">
                    <form method="GET">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="radio-main-box mb-20">
                                    <label class="radio-main">For Sale
                                        <input type="radio" checked="checked" name="radio" value="One">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="radio-main">For Rent
                                        <input type="radio" name="radio" value="Two">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="radio-main">For Short term Rental
                                        <input type="radio" name="radio" value="Three">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="showOne" class="myDiv">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields" name="form-area">
                                            <option>Area</option>
                                            <option>Area 1</option>
                                            <option>Area 2</option>
                                            <option>Area 2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields" name="form-area">
                                            <option>Sub Area</option>
                                            <option>Sub Area 1</option>
                                            <option>Sub Area 2</option>
                                            <option>Sub Area 3</option>
                                            <option>Sub Area 4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker" multiple>
                                            <option>Any</option>
                                            <option>House</option>
                                            <option>Town Home</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields">
                                            <option>1 Bed</option>
                                            <option>1 - 2 Beds </option>
                                            <option>2 - 3 Beds</option>
                                            <option>3 - 4 Beds</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields" name="form-area">
                                            <option>Size Area</option>
                                            <option>800</option>
                                            <option>1000</option>
                                            <option>1200</option>
                                            <option>1400</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields" name="any-status">
                                            <option>floor number</option>
                                            <option>1 floor</option>
                                            <option>2 floor</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker" multiple>
                                            <option>Available Now</option>
                                            <option>Both</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group name">
                                                <input type="text" name="name" class="form-control" placeholder="$ Min Price">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group name">
                                                <input type="text" name="name" class="form-control" placeholder="$ Max Price">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group mt-20">
                                        <button class="search-button">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="showTwo" class="myDiv">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields" name="form-area">
                                            <option>Area</option>
                                            <option>Area 1</option>
                                            <option>Area 2</option>
                                            <option>Area 2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields" name="form-area">
                                            <option>Sub Area</option>
                                            <option>Sub Area 1</option>
                                            <option>Sub Area 2</option>
                                            <option>Sub Area 3</option>
                                            <option>Sub Area 4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker" multiple>
                                            <option>Any</option>
                                            <option>House</option>
                                            <option>Town Home</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker" multiple>
                                            <option>Furnished </option>
                                            <option>Unfernished </option>
                                            <option>Both</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields">
                                            <option>Any</option>
                                            <option>1 Bed</option>
                                            <option>1 - 2 Beds </option>
                                            <option>2 - 3 Beds</option>
                                            <option>3 - 4 Beds</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields" name="form-area">
                                            <option>Size Area</option>
                                            <option>800</option>
                                            <option>1000</option>
                                            <option>1200</option>
                                            <option>1400</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker" multiple>
                                            <option>Available Now</option>
                                            <option>Both</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields" name="any-status">
                                            <option>floor number</option>
                                            <option>1 floor</option>
                                            <option>2 floor</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group name">
                                                <input type="text" name="name" class="form-control" placeholder="$ Min Price">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group name">
                                                <input type="text" name="name" class="form-control" placeholder="$ Max Price">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mt-0">
                                        <button class="search-button">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="showThree" class="myDiv">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields" name="form-area">
                                            <option>Area</option>
                                            <option>Area 1</option>
                                            <option>Area 2</option>
                                            <option>Area 2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields" name="form-area">
                                            <option>Sub Area</option>
                                            <option>Sub Area 1</option>
                                            <option>Sub Area 2</option>
                                            <option>Sub Area 3</option>
                                            <option>Sub Area 4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker" multiple>
                                            <option> Any</option>
                                            <option>House</option>
                                            <option>Town Home</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields">
                                            <option>Any</option>
                                            <option>1 Bed</option>
                                            <option>1 - 2 Beds </option>
                                            <option>2 - 3 Beds</option>
                                            <option>3 - 4 Beds</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields" name="any-status">
                                            <option>floor number</option>
                                            <option>1 floor</option>
                                            <option>2 floor</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <select class="selectpicker" multiple>
                                            <option>Amenities </option>
                                            <option>Yes</option>
                                            <option>No</option>
                                            <option>Both</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group name">
                                                <input type="text" name="name" class="form-control" placeholder="$ Min Price">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group name">
                                                <input type="text" name="name" class="form-control" placeholder="$ Max Price">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mt-0">
                                        <button class="search-button">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="categories content-area-7">
    <div class="container">

        <div class="main-title text-center">
            <p>Find Your Properties In Your City</p>
            <h1>Most Popular Places</h1>
        </div>
        <div class="row">
            <div class="col-lg-7 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-sm-6 col-pad">
                        <div class="category">
                            <div class="category_bg_box" style="background: url('assets/img/home-1.jpg');">
                                <div class="category-overlay">
                                    <div class="category-content">
                                        <h3 class="category-title">
                                            <a href="#">Area 1</a>
                                        </h3>
                                        <h4 class="category-subtitle">27 Properties</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-pad">
                        <div class="category">
                            <div class="category_bg_box" style="background: url('assets/img/home-2.jpg');">
                                <div class="category-overlay">
                                    <div class="category-content">
                                        <h3 class="category-title">
                                            <a href="#">Area 2</a>
                                        </h3>
                                        <h4 class="category-subtitle">98 Properties</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-pad">
                        <div class="category">
                            <div class="category_bg_box " style="background: url('assets/img/home-3.jpg');">
                                <div class="category-overlay">
                                    <div class="category-content">
                                        <h3 class="category-title">
                                            <a href="#">Area 3</a>
                                        </h3>
                                        <h4 class="category-subtitle">98 Properties</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-pad">
                        <div class="category">
                            <div class="category_bg_box " style="background: url('assets/img/home-4.jpg');">
                                <div class="category-overlay">
                                    <div class="category-content">
                                        <h3 class="category-title">
                                            <a href="#">Area 4</a>
                                        </h3>
                                        <h4 class="category-subtitle">98 Properties</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 col-sm-12 col-pad">
                <div class="category">
                    <div class="category_bg_box category_long_bg" style="background: url('assets/img/home-5.jpg');">
                        <div class="category-overlay">
                            <div class="category-content">
                                <h3 class="category-title">
                                    <a href="#">Area 5</a>
                                </h3>
                                <h4 class="category-subtitle">12 Properties</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="counters overview-bgi">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="counter-box">
                    <i class="flaticon-sale"></i>
                    <h1 class="counter">967</h1>
                    <p>Listings For Sale</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="counter-box">
                    <i class="flaticon-rent"></i>
                    <h1 class="counter">1276</h1>
                    <p>Listings For Rent</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="counter-box">
                    <i class="flaticon-user"></i>
                    <h1 class="counter">396</h1>
                    <p>Agents</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="counter-box">
                    <i class="flaticon-work"></i>
                    <h1 class="counter">177</h1>
                    <p>Brokers</p>
                </div>
            </div>
        </div>
        <a href="#" class="view-all mb-30">VIEW ALL</a>
    </div>
</div>

<div class="sell-main">
    <div class="container">
        <div class="main-title text-center">
            <p>Find Your Properties In Your City-</p>
            <h1>Sell or Rent Your Property</h1>
        </div>
        <div class="radio-main-box">
            <label class="radio-main">I AM
                <input type="radio" checked="checked" name="radio">
                <span class="checkmark"></span>
            </label>
            <label class="radio-main">OWNER
                <input type="radio" name="radio">
                <span class="checkmark"></span>
            </label>
            <label class="radio-main">AGENT
                <input type="radio" name="radio">
                <span class="checkmark"></span>
            </label>
            <label class="radio-main">BUILDER
                <input type="radio" name="radio">
                <span class="checkmark"></span>
            </label>
        </div>
        <a href="#" class="view-all">CONTINUE</a>
    </div>
</div>

<div class="signup-main bg-overlay" style="background-image: url(assets/img/reg.jpeg)">
    <div class="container">

        <div class="main-title text-center">
            <h1 class="white-text">Create Account</h1>
        </div>
        <p class="white-text text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
        <a href="subscribe.html" class="view-all">Register</a>
    </div>
</div>

<div class="contact-main">
    <div class="container">

        <div class="main-title text-center">
            <p>See Our Daily News & Updates</p>
            <h1>Contact Us</h1>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="contact-info ">
                    <h4>LET'S TALK</h4>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 ">
                            <p><i class="flaticon-phone"></i> <span>+12 345 678 971</span></p>
                        </div>
                        <div class="col-md-12 col-sm-12 ">
                            <p><i class="flaticon-mail"></i> <span><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="6801060e07280c0d0507460b0705">[email&#160;protected]</a></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <style>
                    .alert-danger p,
                    .alert-success p {
                        font-size: 12px;
                        line-height: 10px;
                        margin-bottom: 10px;
                        text-transform: initial;
                        font-weight: 600;
                    }
                </style>
                <div class="col-md-12 alert alert-danger" id="frmerror" style="display:none;">
                </div>

                <div class="col-md-12 alert alert-success" id="frmsuccess" style="display:none;">
                </div>

                <!-- <form action="#"> -->
                <div class="row">
                    <div class="form-group col-md-4">
                        <input type="text" required name="name" class="form-control" placeholder="Name *">
                    </div>
                    <div class="form-group col-md-4">
                        <input type="email" required name="email" class="form-control" placeholder="Email *">
                    </div>
                    <div class="form-group col-md-4">
                        <input type="tel" required name="phone" class="form-control" placeholder="Phone Number *">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <textarea required name="message" class="form-control" placeholder="Message *"></textarea>
                    </div>
                </div>
                <button type="submit" name="send-message" class="view-all">Send Message</button>
                <!-- </form> -->
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('common/layout/bottom'); ?>