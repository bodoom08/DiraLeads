<?php
// Home Page Live Data 
if (isset($livedata)) {
    $no_of_sale = array_key_exists('no_of_sale', $livedata) ? $livedata['no_of_sale'] : 0;
    $no_of_rent = array_key_exists('no_of_rent', $livedata) ? $livedata['no_of_rent'] : 0;
    $no_of_short_term_rent = array_key_exists('no_of_short_term_rent', $livedata) ? $livedata['no_of_short_term_rent'] : 0;
    $no_of_agent = array_key_exists('no_of_agent', $livedata) ? $livedata['no_of_agent'] : 0;
    $no_of_users = array_key_exists('no_of_users', $livedata) ? $livedata['no_of_users'] : 0;
} else {
    $no_of_sale = $no_of_rent = $no_of_agent = $no_of_users = 0;
}
?>
@extends('common.layout')

@section('content')
<div class="split-section simplifying-text">
    <p>Simplifying the listing and letting of rentals for owners and renters</p>
</div>
<div class="service-sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="tabbing-sec" id="tile-1">
                    <div class="heading-sec">
                        <!-- <p>The DiraLeads Advantage</p> -->
                        <h2>The DiraLeads Advantage</h2>
                        <!-- <div class="home-icon">
                            <img src="assets/images/home.png">
                        </div> -->
                    </div>
                    <ul class="nav nav-pills mb-3" id="ser-tab" role="tablist">
                        <div class="sliderrr"></div>
                        <li class="nav-item">
                            <a class="nav-link active" id="ser-home-tab" data-toggle="pill" href="#ser-home" role="tab" aria-controls="ser-home" aria-selected="true">RENTERS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ser-profile-tab" data-toggle="pill" href="#ser-profile" role="tab" aria-controls="ser-profile" aria-selected="false">PROPERTY OWNERS</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="ser-tabContent">
                        <div class="tab-pane fade show active" id="ser-home" role="tabpanel" aria-labelledby="ser-home-tab">
                            <div class="service-box">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="content-sec">
                                                <img src="assets/images/icon1.png">
                                                <h3>SIMPLIFIED PROCESS</h3>
                                                <p>Search hundreds of listings in areas that suit your unique requirements - all in one place</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="content-sec">
                                                <img src="assets/images/icon2.png">
                                                <h3>Personalized Service</h3>
                                                <p>Filter by date, availability, location, or price to find the rental that suits your needs best</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="content-sec">
                                                <img src="assets/images/icon3.png">
                                                <h3>HEIMISHE NEIGHBORHOODS</h3>
                                                <p>Choose among a variety of Jewish locales with the shuls and kosher amenities that you require</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="content-sec">
                                                <img src="assets/images/icon1.png">
                                                <h3>SIMPLIFIED PROCESS</h3>
                                                <p>The hassle-free way of getting your apartment in front of thousands of potential renters</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="content-sec">
                                                <img src="assets/images/icon2.png">
                                                <h3>Personalized Service</h3>
                                                <p>The ability to decide on the availability of your rental and exactly how and when renters contact you</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="content-sec">
                                                <img src="assets/images/icon3.png">
                                                <h3>HEIMISHE RENTERS</h3>
                                                <p>The patronage of like-minded community members who appreciate and respect your values</p>
                                            </div>
                                        </a>
                                    </li>
                            </div>
                            </ul>
                            <!-- <a href="javascript:void(0);">See More</a> -->
                        </div>
                        <div class="tab-pane fade show" id="ser-profile" role="tabpanel" aria-labelledby="ser-profile-tab">
                            <div class="service-box">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="content-sec">
                                                <img src="assets/images/icon1.png">
                                                <h3>Personalized Service</h3>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="content-sec">
                                                <img src="assets/images/icon2.png">
                                                <h3>Personalized Service</h3>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="content-sec">
                                                <img src="assets/images/icon3.png">
                                                <h3>Personalized Service</h3>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <a href="javascript:void(0);">See More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="split-section">
    <p><b>DiraLeads:</b> Forever changing the landscape of the heimishe short-term rentals industry</p>
</div>
<div class="property-sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="heading-sec">
                    <p style="color:white;">Wish you could see what the property you’re considering looks like?</p>
                    <h2>Our Rentals</h2>
                    <div class="home-icon">
                        <img src="assets/images/home.png">
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="counter">
            <?php $count = 0; ?>
            @foreach($propertiea_counts as $key=>$value)
            <?php
            if ($count > 7) {
                break;
            }
            ?>
            <div class="col-lg-3 col-md-3 col-12">
                <a href="{{ 'properties/lists?area='.$key }}" target="blank">
                    <div class="rent-num">
                        <h2 class="counter-value" data-count="{{$value}}">0</h2>
                        <p>{{$key}}</p>
                    </div>
                </a>
            </div>
            <?php $count++ ?>
            @endforeach
        </div>
        <div class="col-lg-12 col-md-12 col-12">
            <div class="button-sec">
                <a href="/properties/lists">View All</a>
            </div>
        </div>
    </div>
</div>
</div>





<div class="place-sec">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="heading-sec">
                    <p>Curious to learn more about the amenities and attractions of the heimishe areas we service?</p>
                    <h2>Explore the neighborhood</h2>
                    <div class="home-icon">
                        <img src="assets/images/home.png">
                    </div>
                </div>
            </div>
        </div>
        <section class="customer-logos slider">

            @php $i = 0;
            $j=0;
            $count = count($propertiea_counts)@endphp
            @foreach($propertiea_counts as $key=>$value)

            @php
            $i++;
            $j++;
            @endphp
            @if($j < 13) @if($i=='1' ) <div class="slide">
                <div class="mason-sec">
                    <ul>
                        @endif


                        @if($i == '1' || $i == '4')
                        <li><a href="{{ 'properties/lists?area='.$key }}" target="blank">
                                <div class="gallery-sec">
                                    <img src="assets/images/gal1.png">
                                    <div class="hovr-content">
                                        <h3>{{$key}}</h3>
                                        <!--  <p>{{$value}} Porperties</p> -->
                                        <img src="assets/images/search.png">
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endif
                        @if($i == '2')
                        <li class="mason-sec">
                            @endif

                            @if($i == '2' || $i == '3')

                            <div class="slide"><a href="{{ 'properties/lists?area='.$key }}" target="blank">
                                    <div class="gallery-sec">
                                        <img src="assets/images/gal2.png">
                                        <div class="hovr-content">
                                            <h3>{{$key}}</h3>
                                            <!--  <p>{{$value}} Porperties</p> -->
                                            <img src="assets/images/search.png">
                                        </div>
                                    </div>
                                </a>
                            </div>


                            @endif
                            @if($i == '3')
                        </li>
                        @endif


                        @if($i == '4')
                        @php $i = '0' @endphp
                    </ul>
                </div>
    </div>
    @endif
    @endif
    @endforeach
    </section>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="button-sec">
                <a href="/properties">VIEW NEIGHBORHOOD FEATURES</a>
            </div>
        </div>
    </div>
</div>
</div>


<div class="get-started">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="sec">
                    <h2>Looking to get away for a bit?</h2>
                    <p>Tell us what you’re looking for in your next vacation, and we’ll email you with the rental options that suit your preferences as soon as they become available.</p>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-12">
                <div class="button-sec">
                    @if(isset($_SESSION['id']))
                    @php $href = site_url('/pricing/pricing_pref');@endphp
                    @else
                    @php $href = site_url('/login');@endphp
                    @endif
                    <a href="{{ $href }}" target="_blank">PLAN MY GETAWAY</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="contact-sec">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="heading-sec">
                    <!-- <p>See Our Daily News &amp; Updates</p> -->
                    <h2>Contact Us </h2>
                    <div class="home-icon">
                        <img src="assets/images/home.png">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-5 col-12">
                    <div class="info-sec">
                        <p>Have a question? Need help finding the perfect rental? We’re eager to help!</p>
                        <div class="details">
                            <p><span>Phone</span>111-111-1111</p>
                            <p><span>Email</span>info@DiraLeads.com</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-md-7 col-12">
                    <div class="contact-form">
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="md-form">
                                    <input name="name" type="text" class="form-control" placeholder="Name *" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="md-form">
                                    <input name="email" type="email" class="form-control" placeholder="Email *" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="md-form">
                                    <input name="phone" type="number" class="form-control" placeholder="Phone Number *" maxlength="10" minlength="10" required="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="md-form">
                                    <textarea name="message" class="form-control" placeholder="Message *" required=""></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="md-form">
                                    <button type="submit" id="send-message" name="send-message">Send</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src="http://demo.tinywall.net/numscroller/numscroller-1.0.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript">
    var a = 0;
    $(window).scroll(function() {

        var oTop = $('#counter').offset().top - window.innerHeight;
        if (a == 0 && $(window).scrollTop() > oTop) {
            $('.counter-value').each(function() {
                var $this = $(this),
                    countTo = $this.attr('data-count');
                $({
                    countNum: $this.text()
                }).animate({
                        countNum: countTo
                    },

                    {

                        duration: 500,
                        easing: 'swing',
                        step: function() {
                            $this.text(Math.floor(this.countNum));
                        },
                        complete: function() {
                            $this.text(this.countNum);
                            //alert('finished');
                        }

                    });
            });
            a = 1;
        }

    });

    $slug = '<?php echo $slug; ?>';
    scrollto = false;
    // console.log($slug);
    // $('body').on('click', '#send-message', function(){
    //     alert('ani');
    // });

    $(function() {
        no_of_sale = '<?php echo $no_of_sale; ?>';
        no_of_rent = '<?php echo $no_of_rent; ?>';
        no_of_short_term_rent = '<?php echo $no_of_short_term_rent; ?>';
        no_of_agent = '<?php echo $no_of_agent; ?>';
        no_of_users = '<?php echo $no_of_users; ?>';
        setTimeout(() => {
            // $('body h1 #no_of_sale_counter').text(1233);
            // $('body').find('#no_of_sale_counter').text(no_of_sale);
            // $('body').find('#no_of_rent_counter').text(no_of_rent);
            // $('body').find('#no_of_short_term_counter').text(no_of_short_term_rent);
            // $('body').find('#no_of_seller_counter').text(no_of_users);
        }, 1000);

    });

    $('body input[name="phone"]').on('keypress', function(e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
    });

    if ($slug == 'contact' || $slug == 'home') {
        button = $('body').find('button[name="send-message"]');
        working = "Working..."
        normal = "send message";
        $('body').on('click', 'button[name="send-message"]', function() {
            $(button).text(working).attr('disabled', true);
            $.ajax({
                url: "<?php echo site_url('email_enquiry/send_contact_email') ?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    name: $('input[name="name"]').val(),
                    email: $('input[name="email"]').val(),
                    phone: $('input[name="phone"]').val(),
                    subject: ($('input[name="subject"]').length > 0) ? $('input[name="subject"]').val() : 'Message',
                    send_message: $('textarea[name="message"]').val(),
                    <?php $CI = &get_instance();
                    echo $CI->security->get_csrf_token_name(); ?>: '<?php echo $CI->security->get_csrf_hash(); ?>'
                },
                success: function(arg) {
                    if (arg.success == false) {
                        $('#frmsuccess').html('').hide();
                        $('#frmerror').html(arg.error).show();
                        setTimeout(function() {
                            $('#frmerror').html('').hide();
                        }, 3000);
                        // $('html, body').animate({scrollTop: $('#frmerror').scrollTop()});
                    } else {
                        $('#frmerror').html('').hide();
                        $('#frmsuccess').html('Email Sent Successfully').show();
                        $('input, textarea').val('');
                        // $('html, body').animate({scrollTop: 0});
                    }

                    $(button).text(normal).attr('disabled', false);

                    // if (arg.property.coords) {
                    //     initMap(JSON.parse(arg.property.coords));
                    // } else {
                    //     initMap();
                    // }
                    // $('#email').html(arg.property.email);
                    // $('#mobile').html(arg.property.mobile);
                    // $('#description').html(arg.property.description);
                    // $('#address').html(arg.property.house_number + ', ' + arg.property.street);
                    // $('#contact span').text(arg.property.contact_number);
                    // $('#contact').attr('href', `tel:${arg.property.contact_number}`);

                    // var attributes = '';
                    // $.each(arg.property_attributes, function(i, row) {
                    //     attributes += '<li><img src="' + row.icon + '"> ' + row.value + ' ' + row.text + '</li>';
                    // });
                    // $('#conditions').html(attributes);
                    // var images = '';
                    // $.each(arg.property_images, function(i, row) {
                    //     images += '<li data-thumb="<?php //echo site_url('uploads/') 
                                                        ?>' +
                    //         row.path + '"><img src="<?php //echo site_url('uploads/') 
                                                        ?>' + row.path + '" /></li>';
                    // });
                    // $('#image-gallery').html(images);
                    // $("#myModal").modal();
                }
            });
        });
    }
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });
</script>
@endpush