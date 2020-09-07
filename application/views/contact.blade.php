@extends('common.layout')

@section('content')
<div class="contact-sec">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-12">
				<div class="main-title text-center">
					<!-- <p>See Our Daily News &amp; Updates</p> -->
					<h1>Contact Us </h1>
					<!-- <div class="home-icon">
						<img src="assets/images/home.png">
					</div> -->
					<p>We waited until we could do it right. Then we did! Instead of creating a carbon copy.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4 col-md-5 col-12">
					<div class="info-sec">
						<p>Have a question? Need help finding the perfect rental? We’re eager to help!</p>
						<div class="details">
							<p><span>📱 Phone</span><a href="callto:7183134643">718-313-4643</a></p>
							<p><span>📧 Email</span><a href="mailto: rentals@Diraleads.com">rentals@Diraleads.com</a></p>
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
									<input name="name" id="contact_name" type="text" class="form-control" placeholder="Name *" required="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="md-form">
									<input name="email" id="contact_email" type="email" class="form-control" placeholder="Email *" required="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="md-form">
									<input name="phone" id="contact_phone" type="number" class="form-control" placeholder="Phone Number *" maxlength="11" minlength="10" required="">
								</div>
							</div>
							<!-- <div class="col-md-6">
								<div class="md-form">
									<input name="subject" id="contact_subject" type="text" class="form-control" placeholder="Subject *" required="">
								</div>
							</div> -->
							<div class="col-md-12">
								<div class="md-form">
									<textarea name="message" id="contact_message" class="form-control" placeholder="How can we help?" required=""></textarea>
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


<style>
	.invalid-input {
		border: 1px solid red !important;
	}

	.main-title p {
		margin-bottom: 20px !important;
	}
</style>



<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<!-- <script src="http://demo.tinywall.net/numscroller/numscroller-1.0.js"></script> -->
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
	button = $(document).find('button[name="send-message"]');
	working = "Working..."
	normal = "send message";
	$(document).on('click', 'button[name="send-message"]', function() {

		var valid = true;

		var name = $('#contact_name').val();
		var email = $('#contact_email').val();
		var phone = $('#contact_phone').val();
		// var subject = ($('#contact_subject').length > 0) ? $('#contact_subject').val() : 'Message';
		var send_message = $('#contact_message').val();

		console.log(name, email, phone, send_message);

		if (name == '') {
			$('#contact_name').addClass('invalid-input');
			// toastr.warning('Please fill name field');
			valid = false;
		} else {
			$('#contact_name').removeClass('invalid-input');
		}

		if (!validateEmail(email)) {
			$('#contact_email').addClass('invalid-input');
			// toastr.warning('Please fill email field');
			valid = false;
		} else {
			$('#contact_email').removeClass('invalid-input');
		}

		if (phone == '') {
			$('#contact_phone').addClass('invalid-input');
			// toastr.warning('Please fill phone field');
			valid = false;
		} else {
			if ($('#contact_phone').val().length < 10 || $('#contact_phone').val().length > 11) {
				toastr.warning('Please input valid phone number');
				$('#contact_phone').addClass('invalid-input');
				valid = false;
			} else {
				$('#contact_phone').removeClass('invalid-input');
			}
		}

		// if (subject == '') {
		// 	$('#contact_subject').addClass('invalid-input');
		// 	// toastr.warning('Please fill subject field');
		// 	valid = false;
		// } else {
		// 	$('#contact_subject').removeClass('invalid-input');
		// }

		if (send_message == '') {
			$('#contact_message').addClass('invalid-input');
			// toastr.warning('Please fill message field');
			valid = false;
		} else {
			$('#contact_message').removeClass('invalid-input');
		}

		if (!valid) {
			toastr.warning('Please fill required field');

		} else {
			$(button).text(working).attr('disabled', true);
			$.ajax({
				url: "<?php echo site_url('/contact') ?>",
				type: 'POST',
				dataType: 'json',
				data: {
					name: $('#contact_name').val(),
					email: $('#contact_email').val(),
					phone: $('#contact_phone').val(),
					// subject: ($('#contact_subject"]').length > 0) ? $('#contact_subject"]').val() : 'Message',
					message: $('#contact_message').val(),
					<?php $CI = &get_instance();
					echo $CI->security->get_csrf_token_name(); ?>: '<?php echo $CI->security->get_csrf_hash(); ?>'
				},
				success: function(arg) {
					if (arg.success == false) {
						$('#frmsuccess').html('').hide();
						$('#frmerror').html("Please fill required fields").show();
						setTimeout(function() {
							$('#frmerror').html('').hide();
						}, 3000);
						// $('html, body').animate({scrollTop: $('#frmerror').scrollTop()});
					} else {
						$('#frmerror').html('').hide();
						$('input, textarea').val('');
						toastr.success('Your message was sent successfully!');
					}

					$(button).text(normal).attr('disabled', false);

				}
			});

		}
	});

	function validateEmail(email) {
		const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(String(email).toLowerCase());
	}

	$('#contact_name').on("change paste keyup", function() {
		console.log($('#contact_name').val());
		if ($('#contact_name').val() != '') {
			$('#contact_name').removeClass('invalid-input');
		} else {
			$('#contact_name').addClass('invalid-input');
		}
	});


	$('#contact_email').on("change paste keyup", function() {
		var email = $('#contact_email').val();
		if (validateEmail(email)) {
			$('#contact_email').removeClass('invalid-input');
		} else {
			$('#contact_email').addClass('invalid-input');
		}
	});

	$('#contact_phone').on("change paste keyup", function() {
		console.log($('#contact_phone').val().length == 10 || $('#contact_phone').val().length == 11);
		if ($('#contact_phone').val() != '') {
			if ($('#contact_phone').val().length < 10 || $('#contact_phone').val().length > 11) {
				$('#contact_phone').addClass('invalid-input');
			} else {
				$('#contact_phone').removeClass('invalid-input');
			}

		} else {
			$('#contact_phone').addClass('invalid-input');
		}
	});

	$('#contact_subject').on("change paste keyup", function() {
		console.log($('#contact_subject').val());
		if ($('#contact_subject').val() != '') {
			$('#contact_subject').removeClass('invalid-input');
		} else {
			$('#contact_subject').addClass('invalid-input');
		}
	});

	$('#contact_message').on("change paste keyup", function() {

		if ($('#contact_message').val() != '') {
			$('#contact_message').removeClass('invalid-input');
		} else {
			$('#contact_message').addClass('invalid-input');
		}
	});
</script>

@endsection