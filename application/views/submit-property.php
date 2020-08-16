<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/front_end_layout/top', [
    'title' => 'List Your Property',
]);
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<link rel="stylesheet" href="//unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
<link rel="stylesheet" href="<?php echo site_url('assets/css/jquery-ui.multidatespicker.css') ?>">
<link href="<?php echo site_url('assets/css/fullcalendar.css') ?>" rel="stylesheet" />
<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
<style>
    /*.fc-time {
    display: none;
}
a.fc-day-grid-event.fc-event.fc-start.fc-end.fc-draggable {
    background-color: unset;
}*/
    .date-actions {
        position: relative;
        background: none;
        width: 100%;
        min-width: 200px;
        width: auto;
        height: auto;
        top: 25px;
        left: 10px;
        cursor: pointer;
        z-index: 30;
        background-color: white;
        border: 1px #dfdfdf solid;
        border-radius: 5px;
        box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.2);
    }

    .date {
        background-color: #f4f4f4;
        font-size: 16px;
        font-weight: bold;
        color: #333;
        text-align: left;
        min-height: 32px;
        line-height: 32px;
        text-indent: 12px;
        border-radius: 5px 5px 0 0;
    }

    .date-actions ul li a {
        font-size: 14px;
        color: #76d0be;
        white-space: normal;
        white-space: nowrap;
    }

    .date-actions ul li {
        padding-bottom: 10px;
    }

    .date-actions ul {
        padding: 11px 12px;
        margin: 0;
    }

    .fc-event.parashat {
        background-color: #257e4a;
        border-color: #257e4a;
        color: #FFF !important;
    }

    .fc-event.holiday.yomtov,
    .fc-event.holiday.yomtov a {
        background-color: #ffd446;
        border-color: #ffd446;
        color:  !important;
    }

    .fc-event.holiday.yomtov,
    .fc-event.holiday.yomtov a {
        background-color: #ffd446;
        border-color: #ffd446;
        color: #333;
    }

    .fc-event.hebdate,
    .fc-event.omer {
        background-color: #FFF;
        border-color: #FFF;
        color: #999;
    }

    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 40% !important;
        position: relative;
    }

    .event-model {
        width: 100% !important;
    }

    .modal-backdrop.fade {
        opacity: 0 !important;
    }

    .modal-backdrop {
        position: relative !important;
    }

    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    form#newsletterform .form-group label {
        font-size: 15px;
        font-weight: normal;
        color: #000;
    }

    form#newsletterform .form-group input {
        border: #e5e5e5 1px solid;
    }

    form#newsletterform .form-group {
        width: 50%;
        float: left;
        padding-right: 20px;
    }

    .form-group.custom-group {
        width: 100% !important;
        float: left;
        display: inline-block;
    }

    .modal-content span.close {
        position: absolute;
        right: 10px;
        top: 5px;
        opacity: inherit;
        color: #333;
    }

    .form-group.custom-group input {
        margin-right: 10px;
        margin-left: 10px;
    }

    .form-group.custom-group input:first-child {
        margin-right: 10px;
        margin-left: 0px;
    }

    .form-group input[type=checkbox] {
        margin-right: 10px;
    }

    input.seasonButton {
        font-size: 15px;
        background: #a27107;
        padding: 10px 30px;
        margin: 0 10px 0;
        border-radius: 30px;
        color: #fff;
        border: 0;
        text-align: center;
    }

    .form-group.button {
        width: 100% !important;
        text-align: center;
    }

    .tabbbing-one.two {
        text-align: left;
        display: inline-block;
    }

    .sessionalRule p {
        margin-bottom: 0px;
    }

    .sessionalRule {
        padding: 10px;
    }

    .sessionalRule p i {
        float: right;
        vertical-align: bottom;
        margin-top: 5px;
    }

    .sessionalRule:last-child {
        margin-right: 0px;
    }

    .tabbbing-one.two {
        text-align: left;
        display: inline-block;
        width: 100%;
    }

    .rule {
        width: 100%;
        float: left;
    }

    .seasonRule {
        width: 100%;
        float: left;
    }

    .sessionalRule p:first-child {
        font-weight: 700;
        font-size: 16px;
    }

    a.addRule {
        border: #a27107 1px solid;
        padding: 15px 50px;
        display: inline-block;
        margin-bottom: 30px;
        font-weight: 700;
        color: #a27107;
    }

    .form-group input[type=checkbox] {
        position: relative;
    }

    .form-group input[type=checkbox]::before {
        color: #fff;
        border-color: #a27107;
        background-color: #a27107;
    }

    .form-group input[type=checkbox]::after {
        position: absolute;
        top: .25rem;
        left: -1.5rem;
        display: block;
        width: 1rem;
        height: 1rem;
        content: "";
        background: no-repeat 50%/50% 50%;
    }

    .tabbbing-one.two .form-group {
        text-align: center;
    }

    .sessionalRule {
        padding: 10px;
        width: 31.33%;
        float: left;
        margin: 0 5px 10px 5px;
    }

    button.fc-month-button.fc-button.fc-state-default.fc-corner-left.fc-corner-right.fc-state-active {
        display: none;
    }

    button.fc-today-button.fc-button.fc-state-default.fc-corner-left.fc-corner-right {
        display: none;
    }

    .fc-toolbar .fc-center {
        float: right !important;
    }

    .modal-event .modal-content.event-model {
        padding: 0px;
    }

    button.close span {
        color: #fff;
    }

    .modal-event .modal-header {
        background-color: #a27107;
        color: #fff;
        padding: 10px;
    }

    .modal-event .modal-header h4 {
        color: #fff;
        font-size: 16px;
        font-weight: 600;
    }

    .custom-event .modal-content.event-model {
        padding: 0px;
    }

    button.close span {
        color: #fff;
    }

    .custom-event .modal-header {
        background-color: #a27107;
        color: #fff;
        padding: 10px;
    }

    .session_modal .modal-header {
        background-color: #a27107;
        color: #fff;
        padding: 20px;
    }

    .session_modal .modal-content {
        padding: 0 0px 20px 0px;
    }

    .session_modal .modal-content span {
        color: #fff !important;
    }

    form#newsletterform {
        padding: 15px;
    }

    .custom-event .modal-header h4 {
        color: #fff;
        font-size: 16px;
        font-weight: 600;
    }

    .form-group.custom-group .custom-control.custom-checkbox {
        width: 14%;
        float: left;
        padding-left: 5px;
    }

    .form-group.custom-group .custom-control.custom-checkbox:first-child {
        padding-left: 0px;
    }

    @media (max-width:767px) {
        .modal-content {
            width: 90%;
        }

        form#newsletterform .form-group {
            width: 100%;
        }

        .sessionalRule {
            padding: 10px;
            width: 100%;
            float: left;
            margin: 0 5px 10px 5px;
        }
    }

    /**Ben */

    .a-disabled {
        pointer-events: none;
        cursor: default;
    }

    .invaild-input {
        border: 1px solid red !important;
    }

    .upload-pictures {
        color: #fff;
    }

    .upload-pictures a {
        cursor: pointer;
        font-size: 15px;
        background: #a27107;
        padding: 10px 50px;
        margin: 0 10px 0;
        border-radius: 30px;
        border: 0;
        text-align: center;
    }

    .price-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        align-items: center;
    }

    .price-container label {
        margin-top: .5em;
    }

    .price-container input {
        width: 120px;
    }

    .weekend-container {
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin-bottom: 20px;
        margin-right: 20px;
    }

    .weekend-container label {
        margin-right: 20px;
    }

    .daily-container {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
    }

    .day-background {
        width: 100%;
        height: 25%;
        margin-bottom: 0px !important;
        font-size: 16px;
    }

    .weekend-background {
        background-color: #ea7676;
    }

    .season-background {
        background-color: #76eaaf;
        font-weight: bold;
    }

    .manual-background {
        background-color: #76a7ea;
        font-weight: bold;
    }

    .unavailable-background {
        background-color: #d4d0d0;
    }

    .modal-row input {
        border: #e5e5e5 1px solid;
        padding: 5px 10px 5px 10px;
    }

    .date-actions a:hover {
        color: grey;
    }

    .modal-content .row {
        margin-bottom: 10px;
    }

    .season-action {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
    }

    .season-action .fa-trash {
        font-size: 20px;
        color: red;
        cursor: pointer;
    }

    .season-action .rulEdit {
        border: 1px solid;
        border-radius: 3px;
        padding: 2px 6px;
        font-size: 14px;
        cursor: pointer;
    }
</style>
<div class="dashboard">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-12 col-sm-12 col-pad">
                <div class="dashboard-nav d-none d-xl-block d-lg-block">
                    <?php $this->load->view('common/front_end_layout/sidebar'); ?>
                </div>
            </div>
            <div class="col-lg-10 col-md-12 col-sm-12 col-pad">
                <div class="content-area5">
                    <div class="dashboard-content">
                        <div class="dashboard-list">
                            <h3 class="heading">Property Details</h3>
                            <div class="dashboard-message contact-2 bdr clearfix">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <!-- design process steps-->
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs process-model more-icon-preocess perent_icon" role="tablist">
                                            <li role="presentation1" class="active"><a href="#discover" aria-controls="" role="tab" data-toggle="tab"><i class="fa fa-home" aria-hidden="true"></i>
                                                    <p>Add a Property</p>
                                                </a></li>
                                            <li role="presentation2"><a href="#strategy" aria-controls="strategy" role="tab" data-toggle="tab"><i class="fa fa-bed" aria-hidden="true"></i>
                                                    <p>Amenities</p>
                                                </a></li>
                                            <li role="presentation3"><a href="#optimization" aria-controls="optimization" role="tab" data-toggle="tab"><i class="fa fa-picture-o" aria-hidden="true"></i>
                                                    <p>Upload Picture</p>
                                                </a></li>
                                            <li role="presentation4" id="datePrice"><a href="#content" aria-controls="content" role="tab" data-toggle="tab"><i class="fa fa-calendar" aria-hidden="true"></i>
                                                    <p>Dates & Price</p>
                                                </a></li>
                                        </ul>
                                        <!-- end design process steps-->
                                        <!-- Tab panes -->
                                        <?php echo form_open_multipart('property/property_listing', 'id="listingForm" class=""'); ?>
                                        <div class="tab-content">

                                            <div role="tabpanel" class="tab-pane active" id="discover">
                                                <div class="design-process-content">
                                                    <div class="tabbbing-one">
                                                        <ul class="row">
                                                            <li class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="propertyType">Property Type *</label>
                                                                    <select class="form-control" name="property_type" id="propertyType">
                                                                        <option value="apartment">Apartment</option>
                                                                        <option value="basement">Basement</option>
                                                                        <option value="house">House</option>
                                                                        <option value="duplex">Duplex</option>
                                                                        <option value="villa">Villa</option>
                                                                    </select>
                                                                </div>
                                                            </li>
                                                            <li class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlSelect1">Address *</label>
                                                                    <input type="text" id="geoLocation" name="street" rows="2" class="form-control md-textarea" placeholder="">
                                                                </div>
                                                            </li>
                                                            <li class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="neighborhood">Neighborhood *</label>
                                                                    <select class="form-control" name="area_id" id="neighborhood">
                                                                        <option value="">--select--</option>
                                                                        <?php foreach ($areas as $key => $value) : ?>
                                                                            <option value="<?php echo $value['id'] ?>"><?php echo $value['title'] ?></option>
                                                                        <?php endforeach; ?>
                                                                        <option value="other">Other</option>
                                                                    </select>
                                                                </div>
                                                            </li>
                                                            <li class="col-lg-6" id="neighborhood_other_container" style="display:none;">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlSelect1">Neighborhood other*</label>
                                                                    <input id="neighborhood_other" type="text" placeholder="Neighborhood" class="form-control" name="value[]">
                                                                </div>
                                                            </li>
                                                        </ul>

                                                        <ul class="row">
                                                            <li class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlSelect1">Bedrooms *</label>
                                                                    <input type="hidden" name="attribute_id[]" value="1">
                                                                    <input id="bedrooms" type="number" placeholder="Bedrooms" class="form-control" name="value[]">
                                                                </div>
                                                            </li>
                                                            <li class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlSelect1">Bathrooms *</label>
                                                                    <input type="hidden" name="attribute_id[]" value="2">
                                                                    <input type="number" id="bathrooms" placeholder="Bathrooms" class="form-control" name="value[]">
                                                                </div>
                                                            </li>
                                                            <li class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlSelect1">Floor Number *</label>
                                                                    <select class="form-control" id="floorNumber" name="attribute_id[]" id="florbas">
                                                                        <option value="">--Select--</option>
                                                                        <option value="8">Basement</option>
                                                                        <option value="6">1</option>
                                                                        <option value="6">2</option>
                                                                        <option value="6">3</option>
                                                                        <option value="6">4</option>
                                                                        <option value="6">5</option>
                                                                        <option value="6">6</option>
                                                                        <option value="6">7</option>
                                                                        <option value="6">8</option>
                                                                        <option value="6">9</option>
                                                                        <option value="6">10+</option>
                                                                    </select>

                                                                </div>
                                                                <input type="hidden" placeholder="Floor Number" class="form-control floor" name="value[]">
                                                            </li>
                                                            <!--   <li class="col-lg-3">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Floor Number</label>
                                        <input type="hidden" name="attribute_id[]" class="floor" value="6">
                                        <input type="number" placeholder="Floor Number" class="form-control floor" id="floor" name="value[]" onkeyup="myFunction()">
                                    </div>
                                </li>
                                  <li class="col-lg-3">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Basement</label>
                                        <input type="hidden" name="attribute_id[]" class="basement" value="8">
                                        <input type="number" placeholder="Basement" class="form-control basement" id="basement" name="value[]" onkeyup="myFunctionb()">
                                    </div>
                                </li> -->
                                                        </ul>

                                                        <ul class="row">
                                                            <li class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlSelect1">Description *</label>
                                                                    <textarea type="text" id="description" name="property_desc" rows="2" class="form-control md-textarea" placeholder="Description"></textarea>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="tabing-action">
                                                            <ul>
                                                                <!-- <li class="closed"><a href="#">Close</a></li> -->
                                                                <li class="next"><a href="javascript:void(0)">Next</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="strategy">
                                                <div class="design-process-content">
                                                    <div class="tabbbing-one two">
                                                        <ul class="amnity">
                                                            <li>
                                                                <h4>Indoor amenities</h4>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Elevator" id="customCheck2">
                                                                    <label class="custom-control-label" for="customCheck2">Elevator</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Wheelchair Accessible" id="customCheck3">
                                                                    <label class="custom-control-label" for="customCheck3">Wheelchair Accessible</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Air Conditioning" id="customCheck4">
                                                                    <label class="custom-control-label" for="customCheck4">Air Conditioning</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Heating" id="customCheck5">
                                                                    <label class="custom-control-label" for="customCheck5">Heating</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Linen and Towels" id="customCheck6">
                                                                    <label class="custom-control-label" for="customCheck6">Linen and Towels</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Washing Machine" id="customCheck7">
                                                                    <label class="custom-control-label" for="customCheck7">Washing Machine</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Dryer" id="customCheck8">
                                                                    <label class="custom-control-label" for="customCheck8">Dryer</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Kid-friendly" id="customCheck9">
                                                                    <label class="custom-control-label" for="customCheck9">Kid-friendly</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Crib" id="customCheck10">
                                                                    <label class="custom-control-label" for="customCheck10">Crib</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="High Chair" id="customCheck11">
                                                                    <label class="custom-control-label" for="customCheck11">High Chair</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Wi-Fi" id="customCheck12">
                                                                    <label class="custom-control-label" for="customCheck12">Wi-Fi</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Hair dryer" id="customCheck13">
                                                                    <label class="custom-control-label" for="customCheck13">Hair dryer</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <h4>Outdoor amenities</h4>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Garden/backyard" id="customCheck14">
                                                                    <label class="custom-control-label" for="customCheck14">Garden/backyard</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Porch/Balcony" id="customCheck15">
                                                                    <label class="custom-control-label" for="customCheck15">Porch/Balcony</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Parking" id="customCheck16">
                                                                    <label class="custom-control-label" for="customCheck16">Parking</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Pool" id="customCheck17">
                                                                    <label class="custom-control-label" for="customCheck17">Pool</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Sukkah" id="customCheck18">
                                                                    <label class="custom-control-label" for="customCheck18">Sukkah</label>
                                                                    <input type="number" id="sukkahSleep" placeholder="sleeps *" style="display:none;padding: 0px 10px 0px 10px !important;margin-left: 20px;">
                                                                </div>

                                                                <!-- <input type="number" id="sukkahSleep" placeholder="Sleep *" style="display:none;padding:0px !important;"> -->

                                                            </li>
                                                            <li>
                                                                <h4>Kitchen Amenities</h4>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Pesach Kitchen" id="customCheck19">
                                                                    <label class="custom-control-label" for="customCheck19">Pesach Kitchen</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Refrigerator" id="customCheck20">
                                                                    <label class="custom-control-label" for="customCheck20">Refrigerator</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Freezer" id="customCheck21">
                                                                    <label class="custom-control-label" for="customCheck21">Freezer</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Stove" id="customCheck22">
                                                                    <label class="custom-control-label" for="customCheck22">Stove</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Oven" id="customCheck23">
                                                                    <label class="custom-control-label" for="customCheck23">Oven</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Microwave" id="customCheck24">
                                                                    <label class="custom-control-label" for="customCheck24">Microwave</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Hot-Plate/Plata" id="customCheck25">
                                                                    <label class="custom-control-label" for="customCheck25">Hot-Plate/Plata</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Shabbos Kettle/Urn" id="customCheck26">
                                                                    <label class="custom-control-label" for="customCheck26">Shabbos Kettle/Urn</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Cooking Utensils" id="customCheck27">
                                                                    <label class="custom-control-label" for="customCheck27">Cooking Utensils</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Coffee Machine" id="customCheck28">
                                                                    <label class="custom-control-label" for="customCheck28">Coffee Machine</label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="tabing-action">
                                                            <ul>
                                                                <!-- <li class="closed"><a href="#">Close</a></li> -->
                                                                <li class="amintNext"><a href="javascript:void(0)">Next</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="optimization">
                                                <div class="design-process-content">
                                                    <div class="tabbbing-one two">
                                                        <ul class="row">
                                                            <li class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label for="upload_file">
                                                                        <ul>
                                                                            <li class="upload-pictures"><a>Upload Pictures</a></li>
                                                                        </ul>
                                                                        <input type="file" style="visibility:hidden;" id="upload_file" onchange="preview_image();" accept="image/x-png,image/jpeg" name="userfile[]" aria-label="File browser example" multiple>
                                                                    </label>
                                                                </div>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="property_thumbnails mt-2">
                                                                <div class="row" id="image_preview">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tabing-action">
                                                        <ul>
                                                            <!-- <li class="closed"><a href="#">Close</a></li> -->
                                                            <li class="optNext"><a href="javascript:void(0)">Next</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="content">
                                                <div class="design-process-content">
                                                    <ul class="nav nav-tabs process-model more-icon-preocess calender_icon" role="tablist">
                                                        <li role="presentation9" class="customCalender active mr-3" style="width:40%"><a href="#sessional" aria-controls="sessional" role="tab" data-toggle="tab">
                                                                <p>My Rental is available all year round</p>
                                                            </a></li>
                                                        <li role="presentation8" style="width:40%" class="costomSession"><a href="#yearly" aria-controls="yearly" role="tab" data-toggle="tab">
                                                                <p>My Rental is seasonal</p>
                                                            </a></li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="sessional">
                                                            <div class="tabbbing-one two">
                                                                <ul class="row">
                                                                    <li class="col-lg-10 m-auto">
                                                                        <div class="price-container">
                                                                            <div class="form-group daily-container">
                                                                                <label for="days">Days ($)</label>
                                                                                <input type="number" id="days" class="datedays" placeholder="Days *">
                                                                            </div>
                                                                            <div class="form-group daily-container">
                                                                                <label for="weekend">Weekend ($)</label>
                                                                                <input type="number" id="weekend" class="weekenddays" placeholder="Weekend *">
                                                                            </div>
                                                                            <div class="form-group daily-container">
                                                                                <label for="weekly">Weekly ($)</label>
                                                                                <input type="number" id="weekly" class="weekly" placeholder="Weekly *">
                                                                            </div>
                                                                            <div class="form-group daily-container">
                                                                                <label for="monthly">Monthly ($)</label>
                                                                                <input type="number" id="monthly" class="monthly" placeholder="Monthly *">
                                                                            </div>
                                                                            <!-- <span class="submitPrice" style="font-size: 15px;background: #a27107;padding: 10px 50px;margin: 0 10px 0;border-radius: 30px;color: #fff;border: 0;text-align: center;">Price</span> -->
                                                                        </div>
                                                                        <div class="price-container">
                                                                            <div class="form-group weekend-container">
                                                                                <label for="weekendFrom">Weekend </label>
                                                                                <label for="weekendFrom"> From</label>
                                                                                <select class="form-control" name="weekend_type" id="weekendFrom">
                                                                                    <option value="3">Thursday</option>
                                                                                    <option value="4">Friday</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group weekend-container">
                                                                                <label for="weekendTo">Till</label>
                                                                                <select class="form-control" name="weekend_type" id="weekendTo">
                                                                                    <option value="5">Motzei Shabbos</option>
                                                                                    <option value="6">Sunday</option>
                                                                                    <option value="7">Monday</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <input type="checkbox" class="custom-control-input" name="onlyWeekend" value="Only available in Weekend" id="customCheck29">
                                                                                <label class="custom-control-label" for="customCheck29">Weekend Only</label>
                                                                            </div>
                                                                        </div>
                                                                        <!-- <div class="custom-control custom-checkbox form-group">
                                                                            <input type="checkbox" class="custom-control-input" name="onlyWeekend" value="Only available in Weekend" id="customCheck29">
                                                                            <label class="custom-control-label" for="customCheck29">Only available in Weekend</label>
                                                                        </div> -->
                                                                        <div class="form-group">
                                                                            <a href="javascript:void()" class="addRule" id="addSeasonPrice">Add seasonal price rule...</a>
                                                                            <div class="seasonRule">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div id='calendar'></div>
                                                                        </div>
                                                                    </li>
                                                                </ul>

                                                            </div>
                                                        </div>
                                                        <div role="tabpanel" class="tab-pane" id="yearly">
                                                            <div class="tabbbing-one two">
                                                                <ul class="row">
                                                                    <li class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <a href="javascript:void()" class="addRule" id="addRule">Add sessional price rule...</a>
                                                                            <div class="rule">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div id='seasonCalendar'></div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="tabing-action">
                                                        <ul>
                                                            <li class="submitnext"><a id="submitBtn">Finish</a>
                                                                <!-- <li class="submitnext"><a data-toggle="modal" data-target="#exampleModal">Review</a> -->
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" value="" id="selectedPrice" name="date_price">
                                            <input type="hidden" value="" id="date" name="date">
                                            <input type="hidden" id="price" value="500" name="price">
                                            <input type="hidden" id="session" value="" name="rule_data">
                                            <input type="hidden" id="allRrentals" value="true" name="allRrentals">
                                            <input type="hidden" class="disableDate" value=''>

                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="modal fade modal-event" tabindex="-1" id="seasonModal" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content event-model">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add seasonal price</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="col-sm-4" for="seasonTitle">Season title</label>
                                                <input type="text" name="title" id="seasonTitle" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="col-sm-4" for="seasonStart">Starts at</label>
                                                <input type="text" name="starts_at" class="startDate" id="seasonStart" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="col-sm-4" for="seasonEnd">Ends at</label>
                                                <input type="text" name="ends_at" class="startDate" id="seasonEnd" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="col-sm-4" for="seasonPrice">Price</label>
                                                <input type="number" name="ends_at" class="" id="seasonPrice" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6" style="text-align: center;">
                                                <input type="checkbox" class="custom-control-input" name="onlyWeekend" id="customCheck30">
                                                <label class="custom-control-label" style="font-size: 16px;" for="customCheck30">Fixed Price</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default eventClose" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="add-season">Add season</button>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class="modal fade modal-event" tabindex="-1" id="manualBook" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content event-model">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add a manual booking</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="title">Title</label>
                                                <input style="width: 100%;" type="text" name="title" id="manualTitle" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="manualStart">Check-In Date*</label>
                                                <input type="text" name="starts_at" class="startDate" id="manualStart" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="manualEnd">Check-Out Date*</label>
                                                <input type="text" name="ends_at" class="startDate" id="manualEnd" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="manualFirstName">First Name*</label>
                                                <input type="text" name="first_name" class="" id="manualFirstName" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="manualLastName">Last Name</label>
                                                <input type="text" name="last_name" class="" id="manualLastName" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="manualPhoneNumber">Phone number</label>
                                                <input type="text" name="phone_number" class="" id="manualPhoneNumber" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="manualEmail">Email</label>
                                                <input type="text" name="email" class="" id="manualEmail" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="manualPrivateNote">Private notes</label>
                                                <textarea rows="5" style="width: 100%;" name="private_note" id="manualPrivateNote">Notes</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default eventClose" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="add-manual-booking">Add booking</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <div class="fade modal custom-event" tabindex="-1" id="blockModal" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content event-model">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="titleblock" id="titleblock" value="Blocked" />
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="starts-at">Check-In date*</label>
                                                <input type="text" name="starts_atblock" class="startDate" id="starts-atblock" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="ends-at">Check-out date*</label>
                                                <input type="text" name="ends_atblock" class="startDate" id="ends-atblock" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="blcokPrivateNote">Private notes</label>
                                                <textarea rows="5" style="width: 100%;" name="private_note" id="blcokPrivateNote">Notes</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default eventClose" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="save-block-event">Block dates</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                        <div class="fade modal custom-event" tabindex="-1" id="priceModal" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content event-model">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="col-sm-3" for="starts-at">Price</label>
                                                <input type="text" name="pricechange" id="pricechange" />
                                                <input type="hidden" id="hiddenDate">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default closePrice" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="save-price-event">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="myModal" class="session_modal modal modal-event">
                            <!-- <div id="newsletterform" class="modal-dialog" role="document"> -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add a season</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <!-- <form id="newsletterform"> -->
                                <div class="modal-body ">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="fname">Season name</label>
                                            <input type="text" style="width: 100%;" id="fname" name="session" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="lname">Check-In Date*</label>
                                            <input type="text" style="width: 100%;" id="startDate" class="startDate" name="startDate" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="lname">Check-Out Date*</label>
                                            <input type="text" style="width: 100%;" id="endDate" class="startDate" name="endDate" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="seasonRate">Seasnal rates</label>
                                            <select class="form-control" name="weekend_type" id="seasonRate">
                                                <option value="daily">Daily</option>
                                                <option value="fixed">Fixed</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6" id="seasonFixedPrice" style="display:none;">
                                            <label for="fixedSeasonalPrice">Season price ($)*</label>
                                            <input type="number" style="width: 100%;" id="fixedSeasonalPrice" class="weekenddays" />
                                        </div>
                                    </div>
                                    <div id="seasonDailyPrice">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="sDayPrice">Days ($)</label>
                                                <input type="number" style="width: 100%;" id="sDayPrice" class="datedays" placeholder="Days *">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="sWeekendPrice">Weekend ($)</label>
                                                <input type="number" style="width: 100%;" id="sWeekendPrice" class="weekenddays" placeholder="Weekend *">
                                            </div>
                                        </div>
                                        <div class="row" id="dailySeasonalPrice">
                                            <div class="col-sm-4">
                                                <label for="sWeekendFrom">Weekend </label>
                                                <label for="sWeekendFrom"> From</label>
                                                <select class="form-control" name="weekend_type" id="sWeekendFrom">
                                                    <option value="3">Thursday</option>
                                                    <option value="4">Friday</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="sWeekendTo">Till</label>
                                                <select class="form-control" name="weekend_type" id="sWeekendTo">
                                                    <option value="5">Motzei Shabbos</option>
                                                    <option value="6">Sunday</option>
                                                    <option value="7">Monday</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row" style="text-align: center;">
                                            <div class="col-sm-12">
                                                <input type="checkbox" class="custom-control-input" name="onlyWeekend" id="customCheck31">
                                                <label class="custom-control-label" for="customCheck31">Only available in Weekend</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <li class="row modal-row">
                                            <div class="form-group">
                                                <label for="lname">Check in days:</label><br>
                                                <div class="custom-control custom-checkbox" style="padding-left:0px;">
                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="any day" id="anyCheck">
                                                    <label class="custom-control-label" for="anyCheck">any day</label>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="row modal-row">
                                            <div class="form-group custom-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input dayCheck" name="amenities[]" value="Sun" id="customSun">
                                                    <label class="custom-control-label" for="customSun">Sun</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input dayCheck" name="amenities[]" value="Mon" id="customMon">
                                                    <label class="custom-control-label" for="customMon">Mon</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input dayCheck" name="amenities[]" value="Tue" id="customTue">
                                                    <label class="custom-control-label" for="customTue">Tue</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input dayCheck" name="amenities[]" value="Wed" id="customWed">
                                                    <label class="custom-control-label" for="customWed">Wed</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input dayCheck" name="amenities[]" value="Thur" id="customThu">
                                                    <label class="custom-control-label" for="customThu">Thur</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input dayCheck" name="amenities[]" value="Fri" id="customFri">
                                                    <label class="custom-control-label" for="customFri">Fri</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input dayCheck" name="amenities[]" value="Sat" id="customSat">
                                                    <label class="custom-control-label" for="customSat">Sat</label>
                                                </div>
                                            </div>
                                        </li> -->

                                    <div class="modal-footer">
                                        <div class="form-group button"><input type="button" class="seasonButton" value="Save rule" id="saveRule"></div>
                                    </div>
                                    <!-- </form> -->
                                </div>
                            </div>
                        </div>

                        <div id="seasonModal" class="session_modal modal modal-event">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add a season</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body ">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="seasonTitle">Season title</label>
                                            <input type="text" style="width: 100%;" id="seasonTitle" name="session" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="seasonStart">Season start at*</label>
                                            <input type="text" style="width: 100%;" id="seasonStart" class="startDate" name="startDate" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="seasonEnd">Season end at*</label>
                                            <input type="text" style="width: 100%;" id="seasonEnd" class="startDate" name="endDate" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="fseasonRate">Seasnal rates</label>
                                            <select class="form-control" name="weekend_type" id="fseasonRate">
                                                <option value="daily">Daily</option>
                                                <option value="fixed">Fixed</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6" id="fseasonFixedPrice" style="display:none;">
                                            <label for="ffixedSeasonalPrice">Season price ($)*</label>
                                            <input type="number" style="width: 100%;" id="ffixedSeasonalPrice" class="weekenddays" />
                                        </div>
                                    </div>
                                    <div id="fseasonDailyPrice">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="fsDayPrice">Days ($)</label>
                                                <input type="number" style="width: 100%;" id="fsDayPrice" class="datedays" placeholder="Days *">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="fsWeekendPrice">Weekend ($)</label>
                                                <input type="number" style="width: 100%;" id="fsWeekendPrice" class="weekenddays" placeholder="Weekend *">
                                            </div>
                                        </div>
                                        <div class="row" style="text-align: center;">
                                            <div class="col-sm-12">
                                                <input type="checkbox" class="custom-control-input" name="onlyWeekend" id="customCheck32">
                                                <label class="custom-control-label" for="customCheck32">Only available in Weekend</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="form-group button"><input type="button" class="seasonButton" value="Add season" id="add-season"></div>
                                        <input type="hidden" id="season" value="" name="season_data">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="fEditSeasonModal" class="session_modal modal modal-event">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit a season</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="fEditSeasonTitle">Season title</label>
                                            <input type="text" style="width: 100%;" id="fEditSeasonTitle" name="session" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="fEditSeasonStart">Seasn start at*</label>
                                            <input type="text" style="width: 100%;" id="fEditSeasonStart" class="startDate" name="startDate" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="fEditSeasonEnd">Season end at*</label>
                                            <input type="text" style="width: 100%;" id="fEditSeasonEnd" class="startDate" name="endDate" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="fEditSeasonRate">Seasnal rates</label>
                                            <select class="form-control" name="weekend_type" id="fEditSeasonRate">
                                                <option value="daily">Daily</option>
                                                <option value="fixed">Fixed</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6" id="fEditSeasonFixedPrice" style="display:none;">
                                            <label for="fEditfixedSeasonalPrice">Season price ($)*</label>
                                            <input type="number" style="width: 100%;" id="fEditfixedSeasonalPrice" class="weekenddays" />
                                        </div>
                                    </div>
                                    <div id="fEditSeasonDailyPrice">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="fEditSDayPrice">Days ($)</label>
                                                <input type="number" style="width: 100%;" id="fEditSDayPrice" class="datedays" placeholder="Days *">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="fEditSWeekendPrice">Weekend ($)</label>
                                                <input type="number" style="width: 100%;" id="fEditSWeekendPrice" class="weekenddays" placeholder="Weekend *">
                                            </div>
                                        </div>
                                        <div class="row" style="text-align: center;">
                                            <div class="col-sm-12">
                                                <input type="checkbox" class="custom-control-input" name="onlyWeekend" id="customCheck33">
                                                <label class="custom-control-label" for="customCheck33">Only available in Weekend</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="form-group button"><input type="button" class="seasonButton" value="Update season" id="fEdit-season"></div>
                                        <input type="hidden" id="fEditID" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="editSeasonModal" class="session_modal modal-event modal">
                            <!-- <div id="newsletterform" class="modal-dialog" role="document"> -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Update a season</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <!-- <form id="newsletterform"> -->
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="editSeasonName">Season name</label>
                                            <input type="text" style="width: 100%;" id="editSeasonName" name="session" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="editStartDate">Check-In Date*</label>
                                            <input type="text" style="width: 100%;" id="editStartDate" class="startDate" name="startDate" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="editEndDate">Check-Out Date*</label>
                                            <input type="text" style="width: 100%;" id="editEndDate" class="startDate" name="endDate" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="editSeasonRate">Seasnal rates</label>
                                            <select class="form-control" name="weekend_type" id="editSeasonRate">
                                                <option value="daily">Daily</option>
                                                <option value="fixed">Fixed</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6" id="editSeasonFixedPrice" style="display:none;">
                                            <label for="editFixedSeasonalPrice">Season price ($)*</label>
                                            <input type="number" style="width: 100%;" id="editFixedSeasonalPrice" class="weekenddays" />
                                        </div>
                                    </div>
                                    <div id="editSeasonDailyPrice">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="sEditDayPrice">Days ($)</label>
                                                <input type="number" style="width: 100%;" id="sEditDayPrice" class="datedays" placeholder="Days *">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="sEditWeekendPrice">Weekend ($)</label>
                                                <input type="number" style="width: 100%;" id="sEditWeekendPrice" class="weekenddays" placeholder="Weekend *">
                                            </div>
                                        </div>
                                        <div class="row" id="eidtDailySeasonalPrice">
                                            <div class="col-sm-6">
                                                <label for="sEditWeekendFrom">Weekend </label>
                                                <label for="sEditWeekendFrom"> From</label>
                                                <select class="form-control" name="weekend_type" id="sEditWeekendFrom">
                                                    <option value="3">Thursday</option>
                                                    <option value="4">Friday</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="sEditWeekendTo">Till</label>
                                                <select class="form-control" name="weekend_type" id="sEditWeekendTo">
                                                    <option value="5">Motzei Shabbos</option>
                                                    <option value="6">Sunday</option>
                                                    <option value="7">Monday</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row" style="text-align: center;">
                                            <div class="col-sm-12">
                                                <input type="checkbox" class="custom-control-input" name="onlyWeekend" value="Only available in Weekend" id="customCheck32">
                                                <label class="custom-control-label" for="customCheck32">Only available in Weekend</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <input type="hidden" value="" id="editID">
                                        <div class="form-group button"><input type="button" class="seasonButton" value="Update rule" id="updateRule"></div>
                                    </div>
                                    <!-- </form> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- </div> -->
            <p class="sub-banner-2 text-center">© Copyright <?php echo date('Y'); ?>. All rights reserved</p>
        </div>
    </div>
</div>
</div>
</div>

<?php $this->load->view('common/front_end_layout/bottom'); ?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo site_url('assets/js/jquery-ui.multidatespicker.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="<?php echo site_url('assets/js/moment.min.js') ?>"></script>
<script src="<?php echo site_url('assets/js/jquery-ui.custom.min.js') ?>"></script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.3.0/fullcalendar.min.js'></script>
<!-- Update for Google Autocomplete Places API -->
<script>
    function initMap() {

        var input = document.getElementById('geoLocation');

        var autocomplete = new google.maps.places.Autocomplete(input);
        // Set initial restrict to the greater list of countries.
        // autocomplete.setComponentRestrictions({
        //     'country': ['us', 'ca', 'il', 'fr', 'uk', 'be', 'ch', 'at', 'au', 'za', 'ar']
        // });

        autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            $('[name="street').removeClass('invaild-input');
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPhDpAUyER52TsCsLFNOOxT_l5-y7e78A&libraries=places&callback=initMap&language=en" async defer></script>

<script>
    $(function() {
        $("#datepicker-1").datepicker();
    });
    $('#listingForm').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });
</script>

<script>
    window.removeFileName = [];
</script>
<script>
    $(".datepicker").datepicker({
        dateFormat: "yy-mm-dd",
        autoclose: true
    });
</script>
<script>
    function available_status_change(ele) {
        $('#available_date').val($.datepicker.formatDate("yy-mm-dd", new Date()));
    }
</script>
<script>
    var i = 1;
    var attributes = <?php echo json_encode($attributes); ?>;
    $('#add').click(function() {
        i++;
        $('#dynamic_field').append(function() {
            selected = [];
            $('[name="attribute_id[]"]').each(function() {
                selected.push(this.value)
            });
            options = '';
            if (attributes.length == selected.length) {
                $('#add').prop('disabled', 'true');
                return '';
            } else {
                $('#add').removeAttr('disabled');
            }
            attributes.forEach(function(attribute) {
                if (selected.indexOf(attribute.id) < 0) {
                    options += `<option value="${attribute.id}" data-desc="${attribute.description}">${attribute.text}</option>`;
                }
            });
            return `
            <div class="row" id="row_` + i + `">
            <div class="col-md-4">
            <div class="form-group">
            <select name="attribute_id[]" id="attribute_` + i + `" class="form-control" onchange="attribute_desc(this)">
            ${options}
            </select>
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
            <input type="text" placeholder="Attribute Value" class="form-control" name="value[]">
            </div>
            </div>
            <div class="col-md-4">
            <button class="btn btn-danger btn-xs btn_remove" id="` + i + `" type="button" title="Dismiss Attribute"><i class="fa fa-times"></i></button>
            </div>
            </div>
            `;
        });
        $("#attribute_" + i + "").trigger('change');
    });


    $(document).on('click', '.btn_remove', function() {
        $('#add').removeAttr('disabled');
        var button_id = $(this).attr("id");
        $('#row_' + button_id + '').remove();
    });
</script>
<script>
    $(document).ready(function() {
        $('#attribute_1').trigger('change');

        $('#multi-date-select').multiDatesPicker({
            minDate: 0, // today
            // maxDate: 30, // +30 days from today
            dateFormat: "yy-mm-dd",
        });

        $('input[name="property"]').on('change', function() {
            property_val = $(this).val();
            if (property_val == 'short term rent') {
                $('#multi-date').removeClass('d-none');
            } else {
                $('#multi-date').addClass('d-none');
            }
        });
    });

    function attribute_desc(el) {
        var ph = $(el).find(':selected').data('desc') || 'Value';
        $(el).parents('div[id^=row_]').find('[name="value[]"]').attr('placeholder', ph);
    }

    function customTimeSet(elem) {
        if ($(elem).val() == 'custom') {
            $('#custom_div').show();
        } else {
            $('#custom_div').hide();
        }
    }
    $(document).ready(function() {
        $('#bedrooms').on("change paste keyup", function() {
            if ($('#bedrooms').val() != '') {
                $('#bedrooms').removeClass('invaild-input');
            } else {
                $('#bedrooms').addClass('invaild-input');
            }
        });

        $('#neighborhood').on("change paste keyup", function() {
            if ($('#neighborhood').val() != '') {
                $('#neighborhood').removeClass('invaild-input');
                if ($('#neighborhood').val() == 'other') {
                    console.log("other neighbourood");
                    $('#neighborhood_other_container').css('display', 'block');
                }
            } else {
                $('#neighborhood').addClass('invaild-input');

            }
        });
        $('#neighborhood_other').on("change paste keyup", function() {
            if ($('#neighborhood_other').val() != '') {
                $('#neighborhood_other').removeClass('invaild-input');
            } else {
                $('#neighborhood_other').addClass('invaild-input');
            }
        });
        $('#floorNumber').on("change paste keyup", function() {
            if ($('#floorNumber').val() != '') {
                $('#floorNumber').removeClass('invaild-input');
            } else {
                $('#floorNumber').addClass('invaild-input');
            }
        });
        $('#description').on("change paste keyup", function() {
            if ($('#description').val() != '') {
                $('#description').removeClass('invaild-input');
            } else {
                $('#description').addClass('invaild-input');
            }
        });

        $('#bathrooms').on("change paste keyup", function() {
            console.log($('#bathrooms').val());
            if ($('#bathrooms').val() != '') {
                $('#bathrooms').removeClass('invaild-input');
            } else {
                $('#bathrooms').addClass('invaild-input');
            }
        });

        function validateFirstTab() {
            var valid = true;
            if ($('#propertyType').val() == '') {
                $('#propertyType').addClass('invaild-input');
                valid = false;
            }
            var street = $('[name="street').val();
            if (street == '') {
                $('[name="street').addClass('invaild-input');
                valid = false;
            } else {
                $('[name="street').removeClass('invaild-input');
            }

            if ($('#neighborhood').val() == '') {
                $('#neighborhood').addClass('invaild-input');
                valid = false;
            } else {
                if ($('#neighborhood').val() == 'other') {
                    if ($('#neighborhood_other').val == '') {
                        $('#neighborhood_other').addClass('invaild-input');
                        valid = false;
                    }
                }
            }

            if ($('#bedrooms').val() == '') {
                $('#bedrooms').addClass('invaild-input');
                valid = false;
            }
            if ($('#bathrooms').val() == '') {
                $('#bathrooms').addClass('invaild-input');
                valid = false;
            }
            if ($('#floorNumber').val() == '') {
                $('#floorNumber').addClass('invaild-input');
                valid = false;
            }
            if ($('#description').val() == '') {
                $('#description').addClass('invaild-input');
                valid = false;
            }
            return valid;
        }
        $('.next').click(function() {
            // var valid = validateFirstTab();
            if (!validateFirstTab()) {
                toastr.warning('Please fill the required fields');
                return false;
            }
            var attr = $('[name="value[]').val();


            $('.more-icon-preocess li:first').removeClass('active');
            $('.more-icon-preocess li:nth-child(2)').addClass('active');
            // $('a[href="#discover"]').addClass('a-disabled');
            $('#discover').removeClass('active');
            $('#strategy').addClass('active');
        })
        $(document).on('click', '.a-disabled', function(e) {
            e.preventDefault();
        });

        function validateSecondTab() {
            if ($('#customCheck18').is(':checked') && $('#sukkahSleep').val() == '') {
                $('#sukkahSleep').addClass('invaild-input');
                return false;
            } else {
                $('#sukkahSleep').removeClass('invaild-input');
                return true;
            }
        }
        $('.amintNext').click(function() { //no mondatories in amenities
            // var amenities = $('[name="amenities[]"]:checked').val();
            // var amenities = $('input[name="amenities[]"]:checked').val();
            // if (amenities == null) {
            //     return false;
            // }
            if (!validateSecondTab()) {
                return false;
            }


            $('.more-icon-preocess li:nth-child(2)').removeClass('active');
            $('.more-icon-preocess li:nth-child(3)').addClass('active');
            // $('a[href="#strategy"]').addClass('a-disabled');
            $('#strategy').removeClass('active');
            $('#optimization').addClass('active');
        })
        $('.optNext').click(function() {
            setTimeout(function() {
                $('.fc-month-button').trigger('click');
            }, 500);
            $('.more-icon-preocess li:nth-child(3)').removeClass('active');
            $('.more-icon-preocess li:nth-child(4)').addClass('active');
            // $('a[href="#optimization"]').addClass('a-disabled');
            $('#optimization').removeClass('active');
            $('#content').addClass('active');
        })
        $(".process-model li").click(function() {
            if (!$(this).find("a").hasClass('a-disabled')) {
                $('.perent_icon li').removeClass('active');
                $(this).addClass('active');
            }

        });
        $(".calender_icon li").click(function() {
            if (!$(this).find("a").hasClass('a-disabled')) {
                $('.calender_icon li').removeClass('active');
                $(this).addClass('active');
            }
        });

        $('#customCheck18').on('change', function() { //Sukkah Sleep reveal
            var self = $(this);
            if (self.is(':checked')) {
                $('#sukkahSleep').css("display", "inline");
            } else {
                $('#sukkahSleep').css("display", "none");
            }
        });

        $('#sukkahSleep').on("change paste keyup", function() { // Sukkah Sleep validation
            console.log($('#sukkahSleep').val());
            if ($('#sukkahSleep').val() != '') {
                $('#sukkahSleep').removeClass('invaild-input');
            } else {
                $('#sukkahSleep').addClass('invaild-input');
            }
        });

        function weekendPrice(price = '') {
            var result = '<p class="day-background weekend-background">' + price + '</p>';
            return result;
        }

        function unavailablePrice(price = '') {
            var result = '<p class="day-background unavailable-background">' + price + '</p>';
            return result;
        }

        function validateForthTab() {
            var day = $('.datedays').val();
            var weekend = $('.weekenddays').val();
            var weekly = $('#weekly').val();
            var monthly = $('#monthly').val();

            if (day == '' && weekend == '' && weekly == '' && monthly == '') {
                $('.datedays').addClass('invaild-input');
                $('.weekenddays').addClass('invaild-input');
                $('#weekly').addClass('invaild-input');
                $('#monthly').addClass('invaild-input');
                return false;
            }
            return true;
        }

        function submitPrice() {
            if (!validateForthTab()) {
                return false;
            }
            var weekday = [];
            weekday.push($('.fc-day.fc-widget-content.fc-mon'));
            weekday.push($('.fc-day.fc-widget-content.fc-tue'));
            weekday.push($('.fc-day.fc-widget-content.fc-wed'));
            weekday.push($('.fc-day.fc-widget-content.fc-thu'));
            weekday.push($('.fc-day.fc-widget-content.fc-fri'));
            weekday.push($('.fc-day.fc-widget-content.fc-sat'));
            weekday.push($('.fc-day.fc-widget-content.fc-sun'));

            var day = $('.datedays').val();
            var weekend = $('.weekenddays').val();
            var weekly = $('#weekly').val();
            var monthly = $('#monthly').val();


            // if (weekend != '') {
            //     var week = '$' + weekend;
            // } else {
            //     var week = '';
            // }

            var week = weekend != '' ? '$' + weekend : '';

            // if (day != '') {
            //     var days = '$' + day;
            // } else {
            //     var days = '';
            // }

            var days = day != '' ? '$' + day : '';

            var weekendFrom = $('#weekendFrom').val();
            var weekendTo = $('#weekendTo').val();

            var midWeekend = Math.floor((parseInt(weekendTo) + parseInt(weekendFrom)) / 2) % 7;

            if ($('#customCheck29').is(':checked')) { // only available in weekend checked

                weekday.forEach(day => {
                    day.html(unavailablePrice());
                });
                weekday[1].html(unavailablePrice('unavailable'));

                if (week != '') {
                    for (var i = weekendFrom; i <= weekendTo; i++) {
                        weekday[i % 7].html(weekendPrice());
                    }
                    weekday[midWeekend].html(weekendPrice(week));
                } else {
                    for (var i = weekendFrom; i <= weekendTo; i++) {
                        weekday[i % 7].html(days);
                    }
                }
            } else {
                weekday.forEach(day => {
                    day.html(days);
                });

                if (week != '') {
                    for (var i = weekendFrom; i <= weekendTo; i++) {
                        weekday[i % 7].html(weekendPrice());
                    }
                    weekday[midWeekend].html(weekendPrice(week));
                } else {
                    for (var i = weekendFrom; i <= weekendTo; i++) {
                        weekday[i % 7].html(days);
                    }
                }
            }

            // renderSeason();
        }

        $('#days').on("change paste keyup", function() {
            if ($('#days').val() != '') {
                setValidDatePrice();
            }
            submitPrice();
        });

        $('#weekend').on("change paste keyup", function() {
            if ($('#weekend').val() != '') {
                setValidDatePrice();
            }
            submitPrice();
        });

        $('#weekly').on("change paste keyup", function() {
            if ($('#weekly').val() != '') {
                setValidDatePrice();
            }
            submitPrice();
        });

        $('#monthly').on("change paste keyup", function() {
            if ($('#monthly').val() != '') {
                setValidDatePrice();
            }
            submitPrice();
        });

        $('#weekendFrom').on("change paste keyup", function() {
            submitPrice();
        });
        $('#weekendTo').on("change paste keyup", function() {
            submitPrice();
        });
        $('#customCheck29').on('change', function() { //Sukkah Sleep reveal
            submitPrice();
        });

        function setValidDatePrice() {
            $('#days').removeClass('invaild-input');
            $('#weekend').removeClass('invaild-input');
            $('#weekly').removeClass('invaild-input');
            $('#monthly').removeClass('invaild-input');
        }

        function checkValidate() {
            if (validateFirstTab() && validateSecondTab() && validateForthTab()) {
                return true;
            }
            return false;
        }

        $('#submitBtn').click(function() {
            if (!checkValidate()) {
                toastr.warning('Please fill required fields');
                return false;
            }

            $('#listingForm').ajaxSubmit({
                data: {
                    'short_term_available_date': function() {
                        return $('#multi-date-select').multiDatesPicker('value');
                    }
                },
                dataType: 'json',
                beforeSubmit: function() {
                    event.preventDefault();
                    // console.log($('#multi-date-select').multiDatesPicker('value')); 
                    $('.fa-spinner').prop('display', 'inline');
                    $('#submitBtn').prop('disabled', 'disabled');
                },
                success: function(arg) {
                    toastr[arg.type](arg.text);
                    $('.fa-spinner').prop('display', 'block');
                    $('#submitBtn').removeAttr('disabled');
                    if (arg.type == 'success') {
                        window.location.href = '<?php echo site_url('my_rentals'); ?>';
                    }
                }
            });
        });
    })

    function preview_image() {
        var total_file = document.getElementById("upload_file").files.length;
        for (var i = 0; i < total_file; i++) {
            $('#image_preview').append("<div class='thumbnails_box'><img src='" + URL.createObjectURL(event.target.files[i]) + "' width='100%' alt='' title='" + event.target.files[i].name + "'><i class='fa fa-window-close remove' onclick='removethis(this);'></i></div>");
        }
    }

    function removethis(ele, name) {
        $title = $(ele).closest('.thumbnails_box').find('img').attr('title');
        removeFileName.push($title);
        console.log(removeFileName);
        $(ele).closest('.thumbnails_box').remove();
    }
    $(document).on('change', '#florbas', function() {
        var val = $(this).val();
        // var text = $(this).text();
        var selectedText = $("#florbas option:selected").text();
        if (selectedText == '--Select--') {
            $('.floor').val('');
            return false;
        }
        if (val == 8) {
            $('.floor').val('1');
        } else {
            $('.floor').val(selectedText);
        }
    })
</script>

<script>
    $(document).ready(function() {

        var compare = function(filter) {
            return function(a, b) { //closure
                var a = a[filter],
                    b = b[filter];

                if (a < b) {
                    return -1;
                } else if (a > b) {
                    return 1;
                } else {
                    return 0;
                }
            };
        };


        var d = moment().format('YYYY-MM-DD');

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month'
                // right: 'month,agendaWeek'
            },
            defaultDate: d,
            defaultView: 'month',
            editable: false,
            selectable: true,
            fixedWeekCount: false,
            timezone: false,
            events: {
                url: "https://www.hebcal.com/hebcal/?cfg=fc&v=1&maj=on&min=on&nx=on&year=now&month=x&ss=on&mf=on&d=on&s=on&lg=a",
                cache: true,
                success: function(events) { // a function that returns an object
                    for (var i = 0; i < events.length; i++) {
                        if (events[i].className == "hebdate") {
                            events[i].order = 1
                        } else {
                            events[i].order = 0;
                        }
                    }
                    var filter = compare("order");
                    events.sort(filter);
                    return events;
                }
            },
            eventRender: function(eventObj, $el) {
                // $el.addClass("custom-event");
                // console.log(eventObj);
            },

            select: function(start, end, jsEvent, view) {

                $('.date-actions').css('display', 'none');
                // var datedays = $('.datedays').val();
                // var weekenddays = $('.weekenddays').val();
                // if (datedays == '') {
                //     toastr.warning('Price fields are required');
                //     return false;
                // }
                // if (weekenddays == '') {
                //     toastr.warning('Price fields are required');
                //     return false;
                // }
                if (moment(start._d).add(1, 'days').format('YYYY-MM-DD') == moment(end._d).format('YYYY-MM-DD')) {
                    $(".fc-day-grid-event").attr("href", 'javascript:void');
                    var start = convert(moment(start).format());
                    var end = convert(moment(end).format());
                    var a = start.split("-");

                    // $('.fc-day-number[data-date="' + start + '"]').html(a[2].replace(/^0+/, '') + '<div class="date-actions"><div class="date">' + start + '</div><ul><li><a data-target="#manualBook" data-toggle="modal" class="MainNavText manualBooking" id="MainNavHelp" currentdata="' + start + '" href="#manualBook">Add a seasonal booking</a></li><li><a  data-target="#blockModal" data-toggle="modal" class="MainNavText" id="MainNa" href="#blockModal">Block this date</a></li><li><a  data-target="#priceModal" data-toggle="modal" class="MainNavText changepricefin" id="MainNa" href="#priceModal" currentdata="' + start + '">Change Price</a></li></ul></div>');
                    $('.fc-day-number[data-date="' + start + '"]').html(a[2].replace(/^0+/, '') + '<div class="date-actions"><div class="date">' + start + '</div><ul><li><a data-target="#manualBook" data-toggle="modal" class="MainNavText manualBooking" id="MainNavHelp" currentdata="' + start + '" href="#manualBook">Add a manual booking</a></li><li><a  data-target="#blockModal" data-toggle="modal" class="MainNavText" id="MainNa" href="#blockModal">Block this date</a></li></ul></div>');
                }
            },
            eventClick: function(event, element) {
                console.log(event.titlte);
                // Display the modal and set the values to the event values.
                if (event.title == 'Blocked') {
                    $('#blockModal').modal('show');
                    $('#blockModal').find('#titleblock').val(event.title);
                    $('#blockModal').find('#starts-atblock').val(event.start);
                    $('#blockModal').find('#ends-atblock').val(event.end);
                    $('#blockModal').find('.eventClose').text('Delete');
                } else {
                    $('.date-actions').css('display', 'none');
                    // $('#manualBook').modal('show');
                    // $('#manualBook').find('#manualTitle').val(event.title.split("$")[0]);
                    // $('#manualBook').find('#seaonPrice').val(event.description);
                    // $('#manualBook').find('#manualStart').val(event.start);
                    // $('#manualBook').find('#manualEnd').val(event.end);
                    // $('#manualBook').find('.eventClose').text('Delete');

                    $(".fc-day-grid-event").attr("href", 'javascript:void');
                    var start = convert(moment(event.start._i).format());
                    var end = convert(moment(end).format());
                    var a = start.split("-");

                    // $('.fc-day-number[data-date="' + start + '"]').html(a[2].replace(/^0+/, '') + '<div class="date-actions"><div class="date">' + start + '</div><ul><li><a data-target="#manualBook" data-toggle="modal" class="MainNavText manualBooking" id="MainNavHelp" currentdata="' + start + '" href="#manualBook">Add a seasonal booking</a></li><li><a  data-target="#blockModal" data-toggle="modal" class="MainNavText" id="MainNa" href="#blockModal">Block this date</a></li><li><a  data-target="#priceModal" data-toggle="modal" class="MainNavText changepricefin" id="MainNa" href="#priceModal" currentdata="' + start + '">Change Price</a></li></ul></div>');
                    $('.fc-day-number[data-date="' + start + '"]').html(a[2].replace(/^0+/, '') + '<div class="date-actions"><div class="date">' + start + '</div><ul><li><a data-target="#manualBook" data-toggle="modal" class="MainNavText manualBooking" id="MainNavHelp" currentdata="' + start + '" href="#manualBook">Add a manual booking</a></li><li><a  data-target="#blockModal" data-toggle="modal" class="MainNavText" id="MainNa" href="#blockModal">Block this date</a></li></ul></div>');

                }
                $(".eventClose").click(function() {
                    var startDate = new Date(convert(event.start));
                    var endDate = new Date(convert(event.end));
                    var disableDate = $('.disableDate').val();
                    var y = disableDate.split('|');
                    var removeItem = converts(event.start) + ',' + converts(event.end);
                    y = $.grep(y, function(value) {
                        return value != removeItem;
                    });
                    var seval = y.join('|');
                    var price = event.description
                    $('.disableDate').val(seval);
                    var selectedPrice = $('#selectedPrice').val();
                    var x = selectedPrice.split(',&');

                    var between = [];
                    while (startDate <= endDate) {
                        between.push(new Date(startDate));
                        startDate.setDate(startDate.getDate() + 1);
                    }
                    var eachdate = $('.fc-widget-content[data-date="' + convert(between[0]) + '"]').text() + '|' + convert(between[0]) + ',';
                    var i;
                    var str;
                    var itemId = 0;
                    for (i = 1; i < between.length; i++) {
                        eachdate += $('.fc-widget-content[data-date="' + convert(between[i]) + '"]').text() + '|' + convert(between[i]) + ',';
                    }
                    var removeItems = eachdate;
                    x = $.grep(x, function(values) {
                        return values != removeItems;
                    });
                    var updatedValu = x.join('|');
                    $('#selectedPrice').val(updatedValu);

                    $('#manualBook').find('input').val('');
                    $('#blockModal').find('input').val('');
                    $('#blockModal').find('.eventClose').text('Close');
                    $('#manualBook').find('.eventClose').text('Close');
                    // $('#calendar').fullCalendar('removeEvents', event._id);
                });
            }
        });
        // $('.costomSession').on('click', function() {
        // $('#seasonCalendar').fullCalendar({
        //     header: {
        //         left: 'prev,next today',
        //         center: 'title',
        //         right: 'month'
        //         // right: 'month,agendaWeek'
        //     },
        //     defaultDate: d,
        //     defaultView: 'month',
        //     editable: true,
        //     selectable: true,
        //     fixedWeekCount: false,
        //     timezone: false,
        //     eventOrder: "-id",
        //     events: {
        //         url: "https://www.hebcal.com/hebcal/?cfg=fc&v=1&maj=on&min=on&nx=on&year=now&month=x&ss=on&mf=on&d=on&s=on&lg=a",
        //         cache: true
        //     },
        // });
        //     console.log("yearly");
        // });
        $(document).on('click', '.costomSession', function() {
            $('#seasonCalendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month'
                    // right: 'month,agendaWeek'
                },
                defaultDate: d,
                defaultView: 'month',
                editable: false,
                selectable: true,
                fixedWeekCount: false,
                timezone: false,
                eventOrder: "-id",
                events: {
                    url: "https://www.hebcal.com/hebcal/?cfg=fc&v=1&maj=on&min=on&nx=on&year=now&month=x&ss=on&mf=on&d=on&s=on&lg=a",
                    cache: true
                },
            });
        });

        function renderSeason() {
            //clear calendar and cards
            // $('.fc-bg td').html('');
            submitPrice();
            $('.seasonRule').html('');

            // set price in dates and render cards
            var seasonData = $('#season').val();
            var seasons = seasonData.split('&');
            seasons.forEach(season => {
                var values = season.split('|');
                var seasonID = values[0];
                var title = values[1];
                var startDate = new Date(values[2]);
                var endDate = new Date(values[3]);
                var seasonRate = values[4];
                if (seasonRate == 'daily') {
                    var dayPrice = values[5];
                    var weekendPrice = values[6];
                    var isOnlyWeekend = values[7];
                    var dailyPriceD = '$' + dayPrice;
                    if (dayPrice) {
                        price = "Day: $" + dayPrice;
                        if (weekendPrice) {
                            if (isOnlyWeekend) {
                                price = "Only Weekend: $" + weekendPrice;
                            } else {
                                price += "  Weekend: $" + weekendPrice;
                            }
                        }
                    } else {
                        if (weekendPrice) {
                            price = "Weekend: $" + weekendPrice;
                        }
                    }
                    $('.seasonRule').append('<div class="sessionalRule sessionHide' + seasonID + '" style="background-color:#DCDCDC"><p>' + title + '</p><p>Season rate: ' + seasonRate + '</p><p>' + price + '</p><p>' + values[2] + ' - ' + values[3] + '</p><div class="season-action"><i class="fa fa-trash" data=' + seasonID + ' tab="1" aria-hidden="true"></i><span class="rulEdit" tab="1" data=' + seasonID + ' edit-id=' + seasonID + '>Edit</span></div><input type="hidden" class="rulname' + seasonID + '" value="' + title + '"><input type="hidden" class="rulStartDate' + seasonID + '" value="' + convert(startDate) + '"><input type="hidden" class="rulendDate' + seasonID + '" value="' + convert(endDate) + '"><input type="hidden" class="rulSeasonRate' + seasonID + '" value="' + seasonRate + '"><input type="hidden" class="rulDayPrice' + seasonID + '" value="' + dayPrice + '"><input type="hidden" class="rulWeekendPrice' + seasonID + '" value="' + weekendPrice + '"><input type="hidden" class="rulWeekendAval' + seasonID + '" value="' + isOnlyWeekend + '"></div>');
                } else {
                    var fixedPrice = values[5];
                    var fixedPriceD = '$' + fixedPrice;
                    price = 'Fixed: $' + fixedPrice;
                    $('.seasonRule').append('<div class="sessionalRule sessionHide' + seasonID + '" style="background-color:#DCDCDC"><p>' + title + '</p><p>Season rate: ' + seasonRate + '</p><p>' + price + '</p><p>' + values[2] + ' - ' + values[3] + '</p><div class="season-action"><i class="fa fa-trash" data=' + seasonID + ' tab="1" aria-hidden="true"></i><span class="rulEdit" tab="1" data=' + seasonID + ' edit-id=' + seasonID + '>Edit</span></div><input type="hidden" class="rulname' + seasonID + '" value="' + title + '"><input type="hidden" class="rulStartDate' + seasonID + '" value="' + convert(startDate) + '"><input type="hidden" class="rulendDate' + seasonID + '" value="' + convert(endDate) + '"><input type="hidden" class="rulSeasonRate' + seasonID + '" value="' + seasonRate + '"><input type="hidden" class="rulPrice' + seasonID + '" value="' + fixedPrice + '"></div>');
                }
                console.log(values);
                var middate = new Date((startDate.getTime() + endDate.getTime()) / 2);
                var between = [];
                var tempDate = startDate;
                while (tempDate <= endDate) {
                    between.push(new Date(tempDate));
                    tempDate.setDate(tempDate.getDate() + 1);
                }

                if (seasonRate == 'daily') {

                    between.forEach(day => {
                        $('.fc-widget-content[data-date="' + convert(day) + '"]').html(dailyPriceD);
                    });
                } else {

                    between.forEach(day => {
                        $('.fc-widget-content[data-date="' + convert(day) + '"]').html(seasonalPrice());
                    });
                    $('.fc-widget-content[data-date="' + convert(middate) + '"]').html(seasonalPrice(fixedPriceD));
                }
            });

        }

        var seasonID = 0;
        $('#add-season').on('click', function() { //add season in the first tab
            var title = $('#seasonTitle').val();
            var startDate = $('#seasonStart').val();
            var endDate = $('#seasonEnd').val();
            // var price = $('#seasonPrice').val();

            var seasonRate = $('#fseasonRate').val();

            var seasonFixedPrice = $("#ffixedSeasonalPrice").val();

            var sDayPrice = $('#fsDayPrice').val();
            var sWeekendPrice = $('#fsWeekendPrice').val();

            var isOnlyWeekend = $('#customCheck32').is(':checked');

            // var isFixedPrice = $('#customCheck30').is(':checked');
            if (title == '') {
                toastr.warning('Title is required');
                return false;
            }
            if (startDate == '') {
                toastr.warning('Start date is required');
                return false;
            }
            if (endDate == '') {
                toastr.warning('End date is required');
                return false;
            }


            var seasonData = $('#season').val();
            if (seasonData != '') {
                seasonData = seasonData + '&';
            }


            // var eventData = {
            //     title: title,
            //     start: new Date($('#starts-at').val()),
            //     end: new Date($('#ends-at').val())
            // };

            //  console.log(startd, endd);
            // var middate = new Date((startd.getTime() + endd.getTime()) / 2);

            // console.log("mid date->", middate);

            // var between = [];
            // while (startd <= endd) {
            //     between.push(new Date(startd));
            //     startd.setDate(startd.getDate() + 1);
            // }

            if (seasonRate == "daily") {

                if (!sDayPrice && !sWeekendPrice) {
                    toastr.warning('Price is required');
                    return false;
                }
                $('#season').val(seasonData + seasonID + '|' + title + '|' + convert(startDate) + '|' + convert(endDate) + '|' + seasonRate + '|' + sDayPrice + '|' + sWeekendPrice + '|' + isOnlyWeekend);


            } else {
                if (!seasonFixedPrice) {
                    toastr.warning('Price is required');
                    return false;
                }
                $('#season').val(seasonData + seasonID + '|' + title + '|' + convert(startDate) + '|' + convert(endDate) + '|' + seasonRate + '|' + seasonFixedPrice);

            }
            seasonID++;
            renderSeason();
            //show price on calendar

            // if (isFixedPrice) {
            //     between.forEach(day => {
            //         $('.fc-widget-content[data-date="' + convert(day) + '"]').html(seasonalPrice());
            //     });
            //     $('.fc-widget-content[data-date="' + convert(middate) + '"]').html(seasonalPrice(price));
            // } else {
            //     between.forEach(day => {
            //         $('.fc-widget-content[data-date="' + convert(day) + '"]').html(price);
            //     });
            // }

            //add event on calendar

            // var eachdate = $('.fc-widget-content[data-date="' + convert(between[0]) + '"]').text() + '|' + convert(between[0]) + ',';
            // var i;
            // var str;
            // var itemId = 0;
            // for (i = 1; i < between.length; i++) {
            //     eachdate += $('.fc-widget-content[data-date="' + convert(between[i]) + '"]').text() + '|' + convert(between[i]) + ',';
            // }

            // var disableDate = $('.disableDate').val();
            // if (disableDate != '') {
            //     disableDate = disableDate + '|'
            // }
            // var dateprice = $('#selectedPrice').val();
            // if (dateprice != '') {
            //     dateprice = dateprice + '&';
            // }
            // $('#selectedPrice').val(dateprice + eachdate);
            // $('#date').val(convert(endd));

            // $('.disableDate').val(disableDate + converts($('#starts-at').val()) + ',' + converts($('#ends-at').val()));
            // $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true

            $('#calendar').fullCalendar('unselect');
            $('#seasonModal').find('.eventClose').text('Close');

            $('#seasonModal').modal('hide');
            $('.date-actions').css('display', 'none');
        });

        function seasonalPrice(price = '') {
            return '<p class="day-background season-background">' + price + '</p>';
        }

        function manualPrice(price = '') {
            return '<p class="day-background manual-background">' + price + '</p>';
        }
        $('#addSeasonPrice').click(function() {
            $('#seasonModal').modal('show');
        });
        $('#add-manual-booking').on('click', function() {
            var title = $('#manualTitle').val();
            var startd = new Date($('#manualStart').val());
            var endd = new Date($('#manualEnd').val());
            var firstName = $('#manualFirstName').val();
            var lastName = $('#manualLastName').val();
            var phoneNumber = $('#manualPhoneNumber').val();
            var eamil = $('#manualEmail').val();


            if (title == '') {
                toastr.warning('Title field is required');
                return false;
            }
            if (startd == '') {
                toastr.warning('Start date is required');
                return false;
            }

            if (endd == '') {
                toastr.warning('End date is required');
                return false;
            }

            // console.log(startd, endd);
            var middate = new Date((startd.getTime() + endd.getTime()) / 2);

            // console.log("mid date->", middate);

            var between = [];
            while (startd <= endd) {
                between.push(new Date(startd));
                startd.setDate(startd.getDate() + 1);
            }

            between.forEach(day => {
                $('.fc-widget-content[data-date="' + convert(day) + '"]').html(manualPrice());
            });

            $('.fc-widget-content[data-date="' + convert(middate) + '"]').html(manualPrice(title));

            // var period = [];
            // price = '$' + price;

            // if (isFixedPrice) {
            //     between.forEach(day => {
            //         $('.fc-widget-content[data-date="' + convert(day) + '"]').html(seasonalPrice());
            //     });
            //     $('.fc-widget-content[data-date="' + convert(middate) + '"]').html(seasonalPrice(price));
            // } else {
            //     between.forEach(day => {
            //         $('.fc-widget-content[data-date="' + convert(day) + '"]').html(price);
            //     });
            // }

            // var eventData = {
            //     title: title,
            //     start: new Date($('#manualStart').val()),
            //     end: new Date($('#manualEnd').val())
            // };

            // var eachdate = $('.fc-widget-content[data-date="' + convert(between[0]) + '"]').text() + '|' + convert(between[0]) + ',';
            // var i;
            // var str;
            // var itemId = 0;
            // for (i = 1; i < between.length; i++) {
            //     eachdate += $('.fc-widget-content[data-date="' + convert(between[i]) + '"]').text() + '|' + convert(between[i]) + ',';
            // }

            var disableDate = $('.disableDate').val();
            if (disableDate != '') {
                disableDate = disableDate + '|'
            }
            // var dateprice = $('#selectedPrice').val();
            // if (dateprice != '') {
            //     dateprice = dateprice + '&';
            // }
            // $('#selectedPrice').val(dateprice + eachdate);
            // $('#date').val(convert(endd));

            $('.disableDate').val(disableDate + converts($('#manualStart').val()) + ',' + converts($('#manualEnd').val()));

            // $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true

            $('#calendar').fullCalendar('unselect');
            $('#manualBook').find('.eventClose').text('Close');
            $('#manualBook').find('input').val('');
            $('#manualBook').modal('hide');
            $('.date-actions').css('display', 'none');

        });
        $('#save-block-event').on('click', function() {
            // var title = $('#titleblock').val();
            // var startd = new Date($('#starts-atblock').val());
            // var endd = new Date($('#ends-atblock').val());


            var startd = new Date($('#starts-atblock').val());
            var endd = new Date($('#ends-atblock').val());

            if (startd == '') {
                toastr.warning('Start date is required');
                return false;
            }

            if (endd == '') {
                toastr.warning('End date is required');
                return false;
            }

            var middate = new Date((startd.getTime() + endd.getTime()) / 2);

            // console.log("mid date->", middate);

            var between = [];
            while (startd <= endd) {
                between.push(new Date(startd));
                startd.setDate(startd.getDate() + 1);
            }

            between.forEach(day => {
                $('.fc-widget-content[data-date="' + convert(day) + '"]').html(unavailablePrice());
            });

            $('.fc-widget-content[data-date="' + convert(middate) + '"]').html(unavailablePrice('unavailable'));

            // var eventData = {
            //     title: title,
            //     start: $('#starts-atblock').val(),
            //     end: $('#ends-atblock').val()
            // };
            var disableDate = $('.disableDate').val();
            if (disableDate != '') {
                disableDate = disableDate + '|'
            }
            $('.disableDate').val(disableDate + converts($('#starts-atblock').val()) + ',' + converts($('#ends-atblock').val()));
            // $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true

            $('#calendar').fullCalendar('unselect');
            $('#blockModal').find('.eventClose').text('Close');
            $('#blockModal').find('input').val('');
            $('#blockModal').modal('hide');
        });
        $('#datePrice').click(function() {

            setTimeout(function() {
                $('.fc-month-button').trigger('click');
                $(".fc-event").removeAttr("href");
            }, 500);
            setTimeout(function() {
                $(".fc-day-grid-event").attr("href", 'javascript:void');
            }, 1000);

        });
        $('.fc-next-button').click(function() {
            setTimeout(function() {
                $(".fc-day-grid-event").attr("href", 'javascript:void');
            }, 1000);
        });

        $('.fc-prev-button').click(function() {
            setTimeout(function() {
                $(".fc-day-grid-event").attr("href", 'javascript:void');
            }, 1000);
        })

        function convert(str) {
            var date = new Date(str);
            mnth = ("0" + (date.getMonth() + 1)).slice(-2);
            day = ("0" + date.getDate()).slice(-2);
            return [date.getFullYear(), mnth, day].join("-");
        }

        function updateDate(str) {
            var date = new Date(str);
            mnth = ("0" + (date.getMonth() + 1)).slice(-2);
            day = ("0" + date.getDate()).slice(-2);
            return [date.getFullYear(), mnth, day].join("-");
        }

        function converts(str) {
            var date = new Date(str);
            mnth = ("0" + (date.getMonth() + 1)).slice(-2);
            day = ("0" + date.getDate()).slice(-2);
            return [day, mnth, date.getFullYear()].join("/");
        }
        var enumerateDaysBetweenDates = function(startDate, endDate) {
            var dates = [];

            startDate = startDate.add(1, 'days');

            while (startDate.format('dd-mm-yy') !== endDate.format('dd-mm-yy')) {
                console.log(startDate.toDate());
                dates.push(startDate.toDate());
                startDate = startDate.add(1, 'days');
            }

            return dates;
        };

        function convertss(str) {
            var date = new Date(str);
            mnth = ("0" + (date.getMonth() + 1)).slice(-2);
            day = ("0" + date.getDate()).slice(-2);
            return [mnth, day, date.getFullYear()].join("/");
        }
        $('#addRule').click(function() {
            $('#myModal').show();
        });
        $('.dayCheck').click(function() {
            // alert('kails');
            if ($('#anyCheck').is(':checked')) {
                $("#anyCheck").prop('checked', false);
            }
        });
        $('#anyCheck').click(function() {
            // alert('fdgfdg');
            if ($('.dayCheck').is(':checked')) {
                $(".dayCheck").prop('checked', false);
            }
        });
        var click = 0;
        $('#saveRule').click(function() { // save season in the second tab

            var seasonName = $('#fname').val();
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            var seasonRate = $('#seasonRate').val();

            var seasonFixedPrice = $("#fixedSeasonalPrice").val();

            var sDayPrice = $('#sDayPrice').val();
            var sWeekendPrice = $('#sWeekendPrice').val();

            var sWeekendFrom = $("#sWeekendFrom").val();
            var sWeekendTo = $("#sWeekendTo").val();
            var isOnlyWeekend = $('#customCheck31').is(':checked');

            if (seasonName == '') {
                toastr.warning('Season name is required');
                return false;
            }
            if (startDate == '') {
                toastr.warning('Start date is required');
                return false;
            }
            if (endDate == '') {
                toastr.warning('End date is required');
                return false;
            }
            if (seasonRate == "daily") {
                if (!sDayPrice && !sWeekendPrice) {
                    toastr.warning('Price is required');
                    return false;
                }
                var price = '';

                if (sDayPrice) {
                    price = "Day: $" + sDayPrice;
                    if (sWeekendPrice) {
                        if (isOnlyWeekend) {
                            price = "Only Weekend: $" + sWeekendPrice;
                        } else {
                            price += "  Weekend: $" + sWeekendPrice;
                        }
                    }
                } else {
                    if (sWeekendPrice) {
                        price = "Weekend: $" + sWeekendPrice;
                    }
                }
                $('.rule').append('<div class="sessionalRule sessionHide' + click + '" style="background-color:#DCDCDC"><p>' + seasonName + '</p><p>Season rate: ' + seasonRate + '</p><p>' + price + '</p><p>' + startDate + ' - ' + endDate + '</p><div class="season-action"><i class="fa fa-trash" data=' + click + ' aria-hidden="true"></i><span class="rulEdit" data=' + click + ' edit-id=' + click + '>Edit</span></div><input type="hidden" class="rulname' + click + '" value="' + seasonName + '"><input type="hidden" class="rulStartDate' + click + '" value="' + convert(startDate) + '"><input type="hidden" class="rulendDate' + click + '" value="' + convert(endDate) + '"><input type="hidden" class="rulSeasonRate' + click + '" value="' + seasonRate + '"><input type="hidden" class="rulDayPrice' + click + '" value="' + sDayPrice + '"><input type="hidden" class="rulWeekendPrice' + click + '" value="' + sWeekendPrice + '"><input type="hidden" class="rulWeekendAval' + click + '" value="' + isOnlyWeekend + '"><input type="hidden" class="rulWeekendStart' + click + '" value="' + sWeekendFrom + '"><input type="hidden" class="rulWeekendEnd' + click + '" value="' + sWeekendTo + '"></div>');
            } else {
                if (!seasonFixedPrice) {
                    toastr.warning('Price is required');
                    return false;
                }
                price = 'Fixed: $' + seasonFixedPrice;
                $('.rule').append('<div class="sessionalRule sessionHide' + click + '" style="background-color:#DCDCDC"><p>' + seasonName + '</p><p>Season rate: ' + seasonRate + '</p><p>' + price + '</p><p>' + startDate + ' - ' + endDate + '</p><div class="season-action"><i class="fa fa-trash" data=' + click + ' aria-hidden="true"></i><span class="rulEdit" data=' + click + ' edit-id=' + click + '>Edit</span></div><input type="hidden" class="rulname' + click + '" value="' + seasonName + '"><input type="hidden" class="rulStartDate' + click + '" value="' + convert(startDate) + '"><input type="hidden" class="rulendDate' + click + '" value="' + convert(endDate) + '"><input type="hidden" class="rulSeasonRate' + click + '" value="' + seasonRate + '"><input type="hidden" class="rulPrice' + click + '" value="' + seasonFixedPrice + '"></div>');

            }

            var sessionData = $('#session').val();
            if (sessionData != '') {
                sessionData = sessionData + '&';
            }
            $('#session').val(sessionData + click + '|' + seasonName + '|' + convert(startDate) + '|' + convert(endDate) + '|' + seasonRate);
            $('#date').val(convert(endDate));
            $('#price').val(price);
            click++;
            $('#newsletterform').each(function() {
                this.reset();
            });
            $('#myModal').hide();
        });
        $('.close').click(function() {
            $('#newsletterform').each(function() {
                this.reset();
            });
            $('#myModal').hide();
            $('#editSeasonModal').hide();
            $('#fEditSeasonModal').hide();
        });

        $('#updateRule').click(function() {

            var id = $('#editID').val();

            var seasonName = $('#editSeasonName').val();
            var startDate = $('#editStartDate').val();
            var endDate = $('#editEndDate').val();
            var seasonRate = $('#editSeasonRate').val();

            var seasonFixedPrice = $("#editFixedSeasonalPrice").val();

            var sDayPrice = $('#sEditDayPrice').val();
            var sWeekendPrice = $('#sEditWeekendPrice').val();

            var sWeekendFrom = $("#sEditWeekendFrom").val();
            var sWeekendTo = $("#sEditWeekendTo").val();
            var isOnlyWeekend = $('#customCheck32').is(':checked');

            if (seasonName == '') {
                toastr.warning('Season name is required');
                return false;
            }
            if (startDate == '') {
                toastr.warning('Start date is required');
                return false;
            }
            if (endDate == '') {
                toastr.warning('End date is required');
                return false;
            }
            if (seasonRate == "daily") {
                if (!sDayPrice && !sWeekendPrice) {
                    toastr.warning('Price is required');
                    return false;
                }
                var price = '';

                if (sDayPrice) {
                    price = "Day: $" + sDayPrice;
                    if (sWeekendPrice) {
                        if (isOnlyWeekend) {
                            price = "Only Weekend: $" + sWeekendPrice;
                        } else {
                            price += "  Weekend: $" + sWeekendPrice;
                        }
                    }
                } else {
                    if (sWeekendPrice) {
                        price = "Weekend: $" + sWeekendPrice;
                    }
                }
                var updatedRule = '<p>' + seasonName + '</p><p>Season rate: ' + seasonRate + '</p><p>' + price + '</p><p>' + startDate + ' - ' + endDate + '</p><div class="season-action"><i class="fa fa-trash" data=' + click + ' aria-hidden="true"></i><span class="rulEdit" data=' + click + ' edit-id=' + click + '>Edit</span></div><input type="hidden" class="rulname' + click + '" value="' + seasonName + '"><input type="hidden" class="rulStartDate' + click + '" value="' + convert(startDate) + '"><input type="hidden" class="rulendDate' + click + '" value="' + convert(endDate) + '"><input type="hidden" class="rulSeasonRate' + click + '" value="' + seasonRate + '"><input type="hidden" class="rulDayPrice' + click + '" value="' + sDayPrice + '"><input type="hidden" class="rulWeekendPrice' + click + '" value="' + sWeekendPrice + '"><input type="hidden" class="rulWeekendAval' + click + '" value="' + isOnlyWeekend + '"><input type="hidden" class="rulWeekendStart' + click + '" value="' + sWeekendFrom + '"><input type="hidden" class="rulWeekendEnd' + click + '" value="' + sWeekendTo + '">';
            } else {
                if (!seasonFixedPrice) {
                    toastr.warning('Price is required');
                    return false;
                }
                price = 'Fixed: $' + seasonFixedPrice;
                var updatedRule = '<p>' + seasonName + '</p><p>Season rate: ' + seasonRate + '</p><p>' + price + '</p><p>' + startDate + ' - ' + endDate + '</p><div class="season-action"><i class="fa fa-trash" data=' + click + ' aria-hidden="true"></i><span class="rulEdit" data=' + click + ' edit-id=' + click + '>Edit</span></div><input type="hidden" class="rulname' + click + '" value="' + seasonName + '"><input type="hidden" class="rulStartDate' + click + '" value="' + convert(startDate) + '"><input type="hidden" class="rulendDate' + click + '" value="' + convert(endDate) + '"><input type="hidden" class="rulSeasonRate' + click + '" value="' + seasonRate + '"><input type="hidden" class="rulPrice' + click + '" value="' + seasonFixedPrice + '">';
            }

            var session = $('#session').val();
            var y = session.split('&');
            console.log(y);
            var updateItem = '' + id + '|' + name + '|' + startDate + '|' + endDate + '|' + seasonRate;
            updatedY = y.map((item) => {
                var values = item.split('|');
                if (values[0] == id) {
                    return updateItem;
                } else {
                    return item;
                }
            });
            var seval = updatedY.join('&');
            $('#session').val(seval);
            $('.sessionHide' + id).html(updatedRule);

            $('#editSeasonModal').hide();
        });

        $('#fEdit-season').click(function() { // update season in the first tab

            var id = $('#fEditID').val();

            var seasonName = $('#fEditSeasonTitle').val();
            var startDate = $('#fEditSeasonStart').val();
            var endDate = $('#fEditSeasonEnd').val();
            var seasonRate = $('#fEditSeasonRate').val();

            var seasonFixedPrice = $("#fEditfixedSeasonalPrice").val();

            var sDayPrice = $('#fEditSDayPrice').val();
            var sWeekendPrice = $('#fEditSWeekendPrice').val();

            var isOnlyWeekend = $('#customCheck33').is(':checked');

            if (seasonName == '') {
                toastr.warning('Season name is required');
                return false;
            }
            if (startDate == '') {
                toastr.warning('Start date is required');
                return false;
            }
            if (endDate == '') {
                toastr.warning('End date is required');
                return false;
            }
            if (seasonRate == "daily") {
                if (!sDayPrice && !sWeekendPrice) {
                    toastr.warning('Price is required');
                    return false;
                }
                var updateItem = '' + id + '|' + seasonName + '|' + startDate + '|' + endDate + '|' + seasonRate + '|' + sDayPrice + '|' + sWeekendPrice + '|' + isOnlyWeekend;

            } else {
                if (!seasonFixedPrice) {
                    toastr.warning('Price is required');
                    return false;
                }
                var updateItem = '' + id + '|' + seasonName + '|' + startDate + '|' + endDate + '|' + seasonRate + '|' + seasonFixedPrice;
            }

            var session = $('#season').val();
            var y = session.split('&');
            console.log(y);

            updatedY = y.map((item) => {
                var values = item.split('|');
                if (values[0] == id) {
                    return updateItem;
                } else {
                    return item;
                }
            });
            var seval = updatedY.join('&');
            $('#season').val(seval);

            $('#fEditSeasonModal').hide();

            renderSeason();
        });


        $('#seasonRate').on("change paste keyup", function() {
            var seasonalRate = $(this).val();
            if (seasonalRate == "fixed") {
                $("#seasonDailyPrice").css("display", "none");
                $("#seasonFixedPrice").css("display", "block");
            } else {
                $("#seasonDailyPrice").css("display", "block");
                $("#seasonFixedPrice").css("display", "none");
            }
        });
        $('#editSeasonRate').on("change paste keyup", function() {
            var seasonalRate = $(this).val();
            if (seasonalRate == "fixed") {
                $("#editSeasonDailyPrice").css("display", "none");
                $("#editSeasonFixedPrice").css("display", "block");
            } else {
                $("#editSeasonDailyPrice").css("display", "block");
                $("#editSeasonFixedPrice").css("display", "none");
            }
        });
        $('#fseasonRate').on("change paste keyup", function() {
            var seasonalRate = $(this).val();
            if (seasonalRate == "fixed") {
                $("#fseasonDailyPrice").css("display", "none");
                $("#fseasonFixedPrice").css("display", "block");
            } else {
                $("#fseasonDailyPrice").css("display", "block");
                $("#fseasonFixedPrice").css("display", "none");
            }
        });
        $('#fEditSeasonRate').on("change paste keyup", function() {
            var seasonalRate = $(this).val();
            if (seasonalRate == "fixed") {
                $("#fEditSeasonDailyPrice").css("display", "none");
                $("#fEditSeasonFixedPrice").css("display", "block");
            } else {
                $("#fEditSeasonDailyPrice").css("display", "block");
                $("#fEditSeasonFixedPrice").css("display", "none");
            }
        });
        $(document).on('click', '.fa-trash', function() {
            var id = $(this).attr('data');
            var tab = $(this).attr('tab');

            console.log(tab, id);

            var name = $('.rulname' + id).val();
            var startDate = $('.rulStartDate' + id).val();
            var endDate = $('.rulendDate' + id).val();
            var price = $('.rulPrice' + id).val();
            var seasonRate = $('.rulSeasonRate' + id).val();
            if (tab == 1) { // first tab
                var seasonData = $('#season').val();
                var seasons = seasonData.split('&');
                var newSeason = seasons.filter(season => {
                    var values = season.split('|');
                    if (values[0] == id) {
                        return false;
                    } else {
                        return true;
                    }
                });
                var newSeasonData = newSeason.join('&');
                $('#season').val(newSeasonData);
                renderSeason();
            } else { //second tab
                var days = $('.rulDays' + id).val();
                var session = $('#session').val();
                var y = session.split('&');
                console.log(y);
                var removeItem = '' + id + '|' + name + '|' + startDate + '|' + endDate + '|' + seasonRate;
                y = $.grep(y, function(value) {
                    return value != removeItem;
                });
                var seval = y.join('&');
                $('#session').val(seval);

            }
            $('.sessionHide' + id).hide();

        });

        $(document).on('click', '.rulEdit', function() {
            var id = $(this).attr('data');
            var tab = $(this).attr('tab');

            var name = $('.rulname' + id).val();
            var startDate = $('.rulStartDate' + id).val();
            var endDate = $('.rulendDate' + id).val();
            var seasonRate = $('.rulSeasonRate' + id).val();

            console.log(tab, id);
            if (tab == 1) { //first tab
                $('#fEditID').val(id);

                $('#fEditSeasonTitle').val(name);
                $('#fEditSeasonStart').val(startDate);
                $('#fEditSeasonEnd').val(endDate);
                $('#fEditSeasonRate').val(seasonRate);

                if (seasonRate == 'fixed') {
                    var price = $('.rulPrice' + id).val();

                    $('#fEditfixedSeasonalPrice').val(price);
                    $('#fEditSeasonFixedPrice').css('display', 'block');
                    $('#fEditSeasonDailyPrice').css('display', 'none');
                } else {
                    var dayPrice = $('.rulDayPrice' + id).val();
                    var weekendPrice = $('.rulWeekendPrice' + id).val();
                    var weekendAval = $('.rulWeekendAval' + id).val() == 'true' ? true : false;

                    $('#fEditSDayPrice').val(dayPrice);
                    $('#fEditSWeekendPrice').val(weekendPrice);

                    $('#customCheck33').prop('checked', weekendAval);

                    $('#fEditSeasonFixedPrice').css('display', 'none');
                    $('#fEditSeasonDailyPrice').css('display', 'block');
                }

                $('#fEditSeasonModal').show();

            } else { //second tab

                $('#editID').val(id);

                $('#editSeasonName').val(name);
                $('#editStartDate').val(startDate);
                $('#editEndDate').val(endDate);
                $('#editSeasonRate').val(seasonRate);

                if (seasonRate == 'fixed') {
                    var price = $('.rulPrice' + id).val();

                    $('#editFixedSeasonalPrice').val(price);
                    $('#editSeasonFixedPrice').css('display', 'block');
                    $('#editSeasonDailyPrice').css('display', 'none');
                } else {
                    var dayPrice = $('.rulDayPrice' + id).val();
                    var weekendPrice = $('.rulWeekendPrice' + id).val();
                    var weekendAval = $('.rulWeekendAval' + id).val();
                    var weekendStart = $('.rulWeekendStart' + id).val();
                    var weekendEnd = $('.rulWeekendEnd' + id).val();

                    $('#sEditDayPrice').val(dayPrice);
                    $('#sEditWeekendPrice').val(weekendPrice);

                    $('#customCheck32').prop('checked', weekendAval);

                    $('#sEditWeekendFrom').val(weekendStart);
                    $('#sEditWeekendTo').val(weekendEnd);

                    $('#editSeasonFixedPrice').css('display', 'none');
                    $('#editSeasonDailyPrice').css('display', 'block');
                }

                $('#editSeasonModal').show();
            }
        });

        $(document).on('click', '.R', function() {
            var date = $(this).attr('currentdata');
            $('#manualStart').val(date);
            console.log('.fc-widget-content[data-date="' + date + '"]');
        });



        $(".startDate").datepicker({
            dateFormat: "mm-dd-yy",

            beforeShowDay: function(date) {
                var disabledArrs = "12/06/2010,18/06/2010";
                var disableDate = $('.disableDate').val();
                if (disableDate != '') {
                    disabledArrs = disableDate
                }
                var disabledArr = disabledArrs.split('|');
                for (i = 0; i < disabledArr.length; i++) {
                    var data = disabledArr[i].split(",");
                    var From = data[0].split('/');

                    var To = data[1].split('/');
                    var FromDate = new Date(From[2], From[1] - 1, From[0]);
                    var ToDate = new Date(To[2], To[1] - 1, To[0]);

                    // Set a flag to be used when found
                    var found = false;
                    // Compare date
                    if (date >= FromDate && date <= ToDate) {
                        found = true;
                        return [false, "red"]; // Return false (disabled) and the "red" class.
                    }
                }

                //At the end of the for loop, if the date wasn't found, return true.
                if (!found) {
                    return [true, ""]; // Return true (Not disabled) and no class.
                }
            }
        });
        $(document).on('click', '.eventClose', function() {
            $('.date-actions').css('display', 'none');
        })

        $(document).on('click', '.changepricefin', function() {
            var date = $(this).attr('currentdata');
            $('#hiddenDate').val(date);
            var price = $('.fc-widget-content[data-date="' + date + '"]').text();
            var itemId = price.substring(1, price.length);
            $('#pricechange').val(itemId);
        });

        $(document).on('click', '.manualBooking', function() {
            var date = $(this).attr('currentdata');
            $('#manualStart').val(date);
            console.log('.fc-widget-content[data-date="' + date + '"]');
        });

        $(document).on('click', '#save-price-event', function() {
            var price = $('#pricechange').val();
            var date = $('#hiddenDate').val();
            var changep = '$' + price;
            $('.fc-widget-content[data-date="' + date + '"]').text(changep);
            $('#priceModal').hide();
            $('.date-actions').css('display', 'none');
        });
        $(document).on('click', '.closePrice', function() {
            $('.date-actions').css('display', 'none');
        });

    });
</script>