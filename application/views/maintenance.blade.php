@extends('common.layout')
@push('styles')
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ site_url('assets/maintenance/plugins/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ site_url('assets/maintenance/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ site_url('assets/maintenance/plugins/animate/animate.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ site_url('assets/maintenance/plugins/select2/select2.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ site_url('assets/maintenance/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ site_url('assets/maintenance/css/main.css')}}">
<!--===============================================================================================-->
@endpush

@section('content')
<!--  -->
<div class="position-relative w-100">
	<!-- <div class="bg-diraleads">
		<img src="{{ site_url('assets/maintenance/images/bg04.webp')}}" />
	</div> -->

<div class="size1 overlay1 bg-img1" style="background-image: url({{ site_url('assets/maintenance/images/bg04.webp') }})">
		<!--  -->
		<div class="size1 flex-col-c-m p-l-15 p-r-15 p-t-50 p-b-50">
			<h3 class="l1-txt1 txt-center p-b-25">
			We are stocking on rentals
			</h3>

			<p class="m2-txt1 txt-center p-b-48">
				You will be able to browse for your rental in
			</p>

			<div class="flex-w flex-c-m cd100 p-b-33">
				<div class="flex-col-c-m size2 bor1 m-l-15 m-r-15 m-b-20">
					<span class="l2-txt1 p-b-9 days">35</span>
					<span class="s2-txt1">Days</span>
				</div>

				<div class="flex-col-c-m size2 bor1 m-l-15 m-r-15 m-b-20">
					<span class="l2-txt1 p-b-9 hours">17</span>
					<span class="s2-txt1">Hours</span>
				</div>

				<div class="flex-col-c-m size2 bor1 m-l-15 m-r-15 m-b-20">
					<span class="l2-txt1 p-b-9 minutes">50</span>
					<span class="s2-txt1">Minutes</span>
				</div>

				<div class="flex-col-c-m size2 bor1 m-l-15 m-r-15 m-b-20">
					<span class="l2-txt1 p-b-9 seconds">39</span>
					<span class="s2-txt1">Seconds</span>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection


@push('scripts')
<!--===============================================================================================-->
<script>
	const date = new Date("");
	$('.days').val(date.getDate());
	$('.hours').val(date.getHours());
	$('.minutes').val(date.getMinutes());
	$('.seconds').val(date.getSeconds());
</script>
<!--===============================================================================================-->	
<script src="{{ site_url('assets/maintenance/plugins/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{ site_url('assets/maintenance/plugins/bootstrap/js/popper.js')}}"></script>
<script src="{{ site_url('assets/maintenance/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{ site_url('assets/maintenance/plugins/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{ site_url('assets/maintenance/plugins/countdowntime/moment.min.js')}}"></script>
<script src="{{ site_url('assets/maintenance/plugins/countdowntime/moment-timezone.min.js')}}"></script>
<script src="{{ site_url('assets/maintenance/plugins/countdowntime/moment-timezone-with-data.min.js')}}"></script>
<script src="{{ site_url('assets/maintenance/plugins/countdowntime/countdowntime.js')}}"></script>
<script>
	$('.cd100').countdown100({
		endtimeYear: 2020,
		endtimeMonth: 9,
		endtimeDate: 8,
		endtimeHours: 0,
		endtimeMinutes: 0,
		endtimeSeconds: 0,
		timeZone: ""
	});
</script>
<!--===============================================================================================-->
<script src="{{ site_url('assets/maintenance/plugins/tilt/tilt.jquery.min.js')}}"></script>
<script >
	$('.js-tilt').tilt({
		scale: 1.1
	})
</script>
<!--===============================================================================================-->
<script src="{{ site_url('assets/maintenance/js/main.js')}}"></script>
@endpush