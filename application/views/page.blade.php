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
{!! html_entity_decode($content) !!}
@endsection

@push('scripts')
<script src="http://demo.tinywall.net/numscroller/numscroller-1.0.js"></script>
<script type="text/javascript">
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


    $(window).on("scroll", function() {
        elem = $('body').find('#no_of_sale_counter');
        var hT = $(elem).offset().top,
            hH = $(elem).outerHeight(),
            wH = $(window).height(),
            wS = $(this).scrollTop();
        if (wS > (hT + hH - wH) && scrollto == false) {
            scrollto = true;
            setTimeout(() => {
                animate_no();
            }, 500);

        }
    });

    function animate_no() {
        i = 0;
        no_of_sale = parseInt('<?php echo $no_of_sale; ?>');
        no_of_rent = parseInt('<?php echo $no_of_rent; ?>');
        no_of_short_term_rent = parseInt('<?php echo $no_of_short_term_rent; ?>');
        no_of_users = parseInt('<?php echo $no_of_users; ?>');
        const intervalDelay = 100;
        interval = setInterval(() => {
            ++i;
            if (i == no_of_sale) {
                clearInterval(interval);
            }
            $('body').find('#no_of_sale_counter').text(i);
        }, intervalDelay);
        j = 0;
        intervalRent = setInterval(() => {
            ++j;
            if (j == no_of_rent) {
                clearInterval(intervalRent);
            }
            $('body').find('#no_of_rent_counter').text(j);
        }, intervalDelay);
        k = 0;
        intervalShortTermRent = setInterval(() => {
            ++k;
            if (k == no_of_short_term_rent) {
                clearInterval(intervalShortTermRent);
            }
            $('body').find('#no_of_short_term_counter').text(k);
        }, intervalDelay);
        l = 0;
        intervalUsers = setInterval(() => {
            ++l;
            if (l == no_of_users) {
                clearInterval(intervalUsers);
            }
            $('body').find('#no_of_seller_counter').text(l);
        }, intervalDelay);

    }


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
</script>

<script>
    var widgets = Array.from(document.getElementsByTagName('widget'));
    var widgetNames = widgets.map(widget => widget.getAttribute('name'));
    var request = new XMLHttpRequest();
    request.open('POST', `/page/widgets`, true);
    request.setRequestHeader('Content-Type', 'application/json');

    $.ajax({
        type: "POST",
        url: '/page/widgets',
        data: {
            widgetNames: JSON.stringify(widgetNames),
            <?php echo $CI->security->get_csrf_token_name(); ?>: '<?php echo $CI->security->get_csrf_hash(); ?>'
        },
        success: function(data) {
            var data = JSON.parse(data);
            widgets.map(widget => {
                var newElem = document.createElement("div");
                newElem.innerHTML = data[widget.getAttribute('name')];
                widget.parentNode.replaceChild(newElem, widget);
            });

            $(document).ready(() => {
                $('form').ajaxForm({
                    dataType: 'json',
                    success: function(arg) {
                        toastr[arg.type](arg.text);
                    },
                    error: function(arg) {
                        toastr[arg.type](arg.text);
                    }
                });
            })
        },
        error: function(error) {
            console.log(error);
        },
        complete: function() {
            console.log('Complete');
        }

    });

    // request.onload = function() {
    //     if (request.status >= 200 && request.status < 400) {
    //         var data = JSON.parse(request.responseText);
    //         widgets.map(widget => {
    //             var newElem = document.createElement("div");
    //             newElem.innerHTML = data[widget.getAttribute('name')];
    //             widget.parentNode.replaceChild(newElem, widget);
    //         });

    //         $(document).ready(() => {
    //             $('form').ajaxForm({
    //                 dataType: 'json',
    //                 success: function(arg) {
    //                     toastr[arg.type](arg.text);
    //                 },
    //                 error: function(arg) {
    //                     toastr[arg.type](arg.text);
    //                 }
    //             });
    //         })
    //     }
    // };

    // request.onerror = function() {

    // };

    // request.send(data);
</script>
@endpush