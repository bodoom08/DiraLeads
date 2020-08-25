<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/layout/top', [
    'title' => 'Properties'
]);
?>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPhDpAUyER52TsCsLFNOOxT_l5-y7e78A&callback=initMap"></script>

<div class="container">
    <!-- Filter Options -->
    <div class="row">
    </div>

    <!-- Panel -->
    <div class="row">
        <div class="col-lg-6"></div>
        <div class="col-lg-6">
            <div id="map"></div>
        </div>
    </div>
</div>

<script>
    function initMap() {
        const coord = { lat: -25.344, lng: 131.036 };
        const map = new google.maps.Map(
            document.getElementById('map'), 
            { zoom: 4, center: coord }
        );
        const marker = new google.maps.Marker({ position: coord, map });
    }
</script>
