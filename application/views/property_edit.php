<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/front_end_layout/top', [
    'title' => 'Update Your Property',
]);
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<link rel="stylesheet" href="//unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
<link rel="stylesheet" href="<?php echo site_url('assets/css/jquery-ui.multidatespicker.css') ?>">
<link href="<?php echo site_url('assets/css/fullcalendar.css') ?>" rel="stylesheet" />

<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>

<style>
    /*
.fc-time {
    display: none;
}
a.fc-day-grid-event.fc-event.fc-start.fc-end.fc-draggable {
    background-color: unset;
}
*/
    .date-action-dialog {
        width: 100%;
        height: 100%;
        background: transparent;
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 100;
    }

    .date-action {
        display: none;
        position: absolute;
        background: none;
        width: 100%;
        min-width: 200px;
        width: auto;
        height: auto;
        top: 25px;
        left: 10px;
        cursor: pointer;
        z-index: 130;
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

    .date-action ul li a {
        font-size: 14px;
        color: #76d0be;
        white-space: normal;
        white-space: nowrap;
    }

    .date-action ul li {
        padding-bottom: 10px;
    }

    .date-action ul {
        padding: 11px 12px;
        margin: 0;
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
        justify-content: space-between;
        align-items: center;
    }

    .price-container label {
        margin-top: .5em;
    }

    .price-container input {
        /* width: 120px; */
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

    .weekend-container select {
        width: 200px;
    }

    .daily-container {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
    }

    .daily-container input {
        width: 90%;
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

    .overlay {
        /* display: flex; */
        text-align: center;
        position: absolute;
        top: 50%;
        left: 50%;
        -moz-transform: translateX(-50%) translateY(-50%);
        -webkit-transform: translateX(-50%) translateY(-50%);
        transform: translateX(-50%) translateY(-50%);
        width: 100%;
        height: 100%;
        background-color: rgb(0, 0, 0, 0.5);
        font-size: 5rem;
        color: white;
    }

    .overlay i {
        margin-top: 40%;
    }

    /**
    Muhammad Theme
*/
    input.mhButton {
        text-align: center;
        font-size: 15px;
        border-radius: 30px;
        padding: 10px 30px;
        margin: 0 10px 0;
        border: 0;
    }

    .mhButton.confirmButton {
        background: #a27107;
        color: #fff;
    }

    .mhButton.cancelButton {
        background: #eee;
        color: #a27107;
    }

    #thumbnailPreview,
    #thumbnailPreview img {
        max-width: 100%;
        max-height: 250px;
    }

    .control-thumbnail {
        width: 2rem;
        height: 2rem;
        background-image: url(/assets/images/arrow_left.png);
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        position: absolute;
        top: 50%;
        cursor: pointer;
    }

    .control-thumbnail-left {
        left: 0.1rem;
    }

    .control-thumbnail-right {
        right: 0.1rem;
        transform: rotateZ(180deg);
    }

    .fc-content-skeleton tbody tr:first-child {
        height: unset;
    }

    .fc-content-skeleton tbody tr {
        height: 20px;
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
                            <?php extract($property); ?>
                            <h3 class="heading">Property Details</h3>
                            <div class="dashboard-message contact-2 bdr clearfix">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <!-- design process steps-->
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs process-model more-icon-preocess perent_icon" role="tablist">
                                            <li role="presentation1" class="active">
                                                <a href="#discover" aria-controls="" role="tab" data-toggle="tab">
                                                    <i class="fa fa-home" aria-hidden="true"></i>
                                                    <p>Add a Property</p>
                                                </a>
                                            </li>

                                            <li role="presentation2">
                                                <a href="#strategy" aria-controls="strategy" role="tab" data-toggle="tab">
                                                    <i class="fa fa-bed" aria-hidden="true"></i>
                                                    <p>Amenities</p>
                                                </a>
                                            </li>

                                            <li role="presentation3">
                                                <a href="#optimization" aria-controls="optimization" role="tab" data-toggle="tab">
                                                    <i class="fa fa-picture-o" aria-hidden="true"></i>
                                                    <p>Upload Picture</p>
                                                </a>
                                            </li>

                                            <li role="presentation4" id="datePrice">
                                                <a href="#content" aria-controls="content" role="tab" data-toggle="tab">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    <p>Dates & Price</p>
                                                </a>
                                            </li>
                                        </ul>
                                        <!-- end design process steps-->
                                        <!-- Tab panes -->
                                        <?php echo form_open_multipart('my_rentals/update', 'id="updateForm" class=""'); ?>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="discover">
                                                <div class="design-process-content">
                                                    <div class="tabbbing-one">
                                                        <ul class="row">
                                                            <li class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="propertyType">Property Type *</label>
                                                                    <select class="form-control" name="property_type" id="propertyType">
                                                                        <option value="apartment" <?php echo $property_details['type'] == 'apartment' ? 'selected' : '' ?>>Apartment</option>
                                                                        <!-- <option value="basement" <?php echo $property_details['type'] == 'basement' ? 'selected' : '' ?>>Basement</option> -->
                                                                        <option value="house" <?php echo $property_details['type'] == 'house' ? 'selected' : '' ?>>House</option>
                                                                        <option value="duplex" <?php echo $property_details['type'] == 'duplex' ? 'selected' : '' ?>>Duplex</option>
                                                                        <option value="villa" <?php echo $property_details['type'] == 'villa' ? 'selected' : '' ?>>Villa</option>
                                                                    </select>
                                                                </div>
                                                            </li>

                                                            <li class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlSelect1">Address *</label>
                                                                    <input type="text" id="geoLocation" name="street" rows="2" value="<?php echo $property_details['street'] ?>" class="form-control md-textarea" placeholder="">
                                                                </div>
                                                            </li>

                                                            <li class="col-lg-6">

                                                                <div class="form-group">
                                                                    <label for="neighborhood">Neighborhood *</label>
                                                                    <select class="form-control" name="area_id" id="neighborhood">
                                                                        <option value="">--select--</option>
                                                                        <?php foreach ($areas as $key => $value) : ?>
                                                                            <option value="<?php echo $value['id'] ?>" <?php echo $property_details['area_id'] == $value['id'] ? 'selected' : '' ?>><?php echo $value['title'] ?></option>
                                                                        <?php endforeach; ?>
                                                                        <option value="other">Other</option>
                                                                    </select>
                                                                </div>
                                                            </li>

                                                            <li class="col-lg-6" id="neighborhood_other_container" style="display:none;">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlSelect1">Neighborhood other*</label>
                                                                    <input id="neighborhood_other" type="text" placeholder="Neighborhood" class="form-control" name="value[area_other]">
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <?php
                                                        $bedroom_val = isset($property_attributes[0]['value']) ? $property_attributes[0]['value'] : '';
                                                        $bathroom_val = isset($property_attributes[1]['value']) ? $property_attributes[1]['value'] : '';
                                                        $floor_num = isset($property_attributes[2]['value']) ? $property_attributes[2]['value'] : '';
                                                        ?>
                                                        <ul class="row">
                                                            <li class="col-lg-4 ">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlSelect1">Bedrooms *</label>
                                                                    <input type="hidden" name="attribute_id[bedrooms]" value="1">
                                                                    <input id="bedrooms" type="number" value="<?php echo $bedroom_val; ?>" placeholder="Bedrooms" class="form-control" name="value[bedrooms]">
                                                                </div>
                                                            </li>

                                                            <li class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlSelect1">Bathrooms *</label>
                                                                    <input type="hidden" name="attribute_id[bathrooms]" value="2">
                                                                    <input type="number" id="bathrooms" value="<?php echo $bathroom_val; ?>" placeholder="Bathrooms" class="form-control" name="value[bathrooms]">
                                                                </div>
                                                            </li>

                                                            <li class="col-lg-4" id="floorContainer">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlSelect1">Floor Number *</label>
                                                                    <select class="form-control" id="floorNumber" name="value[florbas]" id="florbas">
                                                                        <option value="">--Select--</option>
                                                                        <option value="0">Basement</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                        <option value="7">7</option>
                                                                        <option value="8">8</option>
                                                                        <option value="9">9</option>
                                                                        <option value="10">10+</option>
                                                                    </select>
                                                                </div>
                                                                <input type="hidden" placeholder="Floor Number" class="form-control floor" name="attribute_id[florbas]" value="1">
                                                            </li>
                                                            <!--   
                                                                <li class="col-lg-3">
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
                                                                    <textarea type="text" id="description" name="property_desc" rows="2" class="form-control md-textarea" placeholder=""><?php echo $property_details['description'] ?></textarea>
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
                                            <?php
                                            $amenities = isset($property_details['amenities']) ? explode(',', $property_details['amenities']) : [];
                                            ?>
                                            <div role="tabpanel" class="tab-pane" id="strategy">
                                                <div class="design-process-content">
                                                    <div class="tabbbing-one two">
                                                        <ul class="amnity">
                                                            <li>
                                                                <h4>Indoor amenities</h4>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Elevator" id="customCheck2" <?php if (in_array('Elevator', $amenities)) {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                } ?>>
                                                                    <label class="custom-control-label" for="customCheck2">Elevator</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Wheelchair Accessible" id="customCheck3" <?php if (in_array('Wheelchair Accessible', $amenities)) {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?>>
                                                                    <label class="custom-control-label" for="customCheck3">Wheelchair Accessible</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Air Conditioning" id="customCheck4" <?php if (in_array('Air Conditioning', $amenities)) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="custom-control-label" for="customCheck4">Air Conditioning</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Heating" id="customCheck5" <?php if (in_array('Heating', $amenities)) {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                } ?>>
                                                                    <label class="custom-control-label" for="customCheck5">Heating</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Linen and Towels" id="customCheck6" <?php if (in_array('Linen and Towels', $amenities)) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="custom-control-label" for="customCheck6">Linen and Towels</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Washing Machine" id="customCheck7" <?php if (in_array('Washing Machine', $amenities)) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="custom-control-label" for="customCheck7">Washing Machine</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Dryer" id="customCheck8" <?php if (in_array('Dryer', $amenities)) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            } ?>>
                                                                    <label class="custom-control-label" for="customCheck8">Dryer</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Kid-friendly" id="customCheck9" <?php if (in_array('Kid-friendly', $amenities)) {
                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                    } ?>>
                                                                    <label class="custom-control-label" for="customCheck9">Kid-friendly</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Crib" id="customCheck10" <?php if (in_array('Crib', $amenities)) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            } ?>>
                                                                    <label class="custom-control-label" for="customCheck10">Crib</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="High Chair" id="customCheck11" <?php if (in_array('High Chair', $amenities)) {
                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                    } ?>>
                                                                    <label class="custom-control-label" for="customCheck11">High Chair</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Wi-Fi" id="customCheck12" <?php if (in_array('Wi-Fi', $amenities)) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            } ?>>
                                                                    <label class="custom-control-label" for="customCheck12">Wi-Fi</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Hair dryer" id="customCheck13" <?php if (in_array('Hair dryer', $amenities)) {
                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                    } ?>>
                                                                    <label class="custom-control-label" for="customCheck13">Hair dryer</label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <h4>Outdoor amenities</h4>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Garden/backyard" id="customCheck14" <?php if (in_array('Garden/backyard', $amenities)) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="custom-control-label" for="customCheck14">Garden/backyard</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Porch/Balcony" id="customCheck15" <?php if (in_array('Porch/Balcony', $amenities)) {
                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                    } ?>>
                                                                    <label class="custom-control-label" for="customCheck15">Porch/Balcony</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Parking" id="customCheck16" <?php if (in_array('Parking', $amenities)) {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                } ?>>
                                                                    <label class="custom-control-label" for="customCheck16">Parking</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Pool" id="customCheck17" <?php if (in_array('Pool', $amenities)) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            } ?>>
                                                                    <label class="custom-control-label" for="customCheck17">Pool</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Sukkah" id="customCheck18" <?php if (in_array('Sukkah', $amenities)) {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                } ?>>
                                                                    <label class="custom-control-label" for="customCheck18">Sukkah</label>
                                                                    <input type="number" name="sleep_number" id="sukkahSleep" placeholder="sleeps *" style="display:none;padding: 0px 10px 0px 10px !important;margin-left: 20px;">
                                                                </div>

                                                            </li>
                                                            <li>
                                                                <h4>Kitchen Amenities</h4>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Pesach Kitchen" id="customCheck19" <?php if (in_array('Pesach Kitchen', $amenities)) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="custom-control-label" for="customCheck19">Pesach Kitchen</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Refrigerator" id="customCheck20" <?php if (in_array('Refrigerator', $amenities)) {
                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                    } ?>>
                                                                    <label class="custom-control-label" for="customCheck20">Refrigerator</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Freezer" id="customCheck21" <?php if (in_array('Freezer', $amenities)) {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                } ?>>
                                                                    <label class="custom-control-label" for="customCheck21">Freezer</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Stove" id="customCheck22" <?php if (in_array('Stove', $amenities)) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            } ?>>
                                                                    <label class="custom-control-label" for="customCheck22">Stove</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Oven" id="customCheck23" <?php if (in_array('Oven', $amenities)) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            } ?>>
                                                                    <label class="custom-control-label" for="customCheck23">Oven</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Microwave" id="customCheck24" <?php if (in_array('Microwave', $amenities)) {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                } ?>>
                                                                    <label class="custom-control-label" for="customCheck24">Microwave</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Hot-Plate/Plata" id="customCheck25" <?php if (in_array('Hot-Plate/Plata', $amenities)) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="custom-control-label" for="customCheck25">Hot-Plate/Plata</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Shabbos Kettle/Urn" id="customCheck26" <?php if (in_array('Shabbos Kettle/Urn', $amenities)) {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?>>
                                                                    <label class="custom-control-label" for="customCheck26">Shabbos Kettle/Urn</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Cooking Utensils" id="customCheck27" <?php if (in_array('Cooking Utensils', $amenities)) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
                                                                    <label class="custom-control-label" for="customCheck27">Cooking Utensils</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="amenities[]" value="Coffee Machine" id="customCheck28" <?php if (in_array('Coffee Machine', $amenities)) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?>>
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
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group" style="text-align:center;">
                                                                <label for="upload_file">
                                                                    <ul>
                                                                        <li class="upload-pictures"><a>Upload Pictures</a></li>
                                                                    </ul>
                                                                    <input type="file" style="visibility:hidden;" id="upload_file" onchange="preview_image();" accept="image/x-png,image/jpeg" name="userfile[]" aria-label="File browser example" multiple>
                                                                </label>
                                                            </div>
                                                        </div>
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
                                                        <li role="presentation9" class="customCalender active mr-3" style="width:40%">
                                                            <a href="#sessional" aria-controls="sessional" role="tab" data-toggle="tab">
                                                                <p>My Rental is available all year round</p>
                                                            </a>
                                                        </li>

                                                        <li role="presentation8" style="width:40%" class="customSession">
                                                            <a href="#yearly" aria-controls="yearly" role="tab" data-toggle="tab">
                                                                <p>My Rental is seasonal</p>
                                                            </a>
                                                        </li>
                                                    </ul>

                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="sessional">
                                                            <div class="tabbbing-one two">
                                                                <ul class="row">
                                                                    <li class="col-lg-10 col-md-10 m-auto">
                                                                        <div class="price-container">
                                                                            <div class="form-group daily-container col-lg-3 col-md-6 p-1">
                                                                                <label for="days">Days ($)</label>
                                                                                <input type="number" name="prices[days]" id="days" value="<?php echo $property_details['days_price'] > 0 ? $property_details['days_price'] : ''; ?>" class="datedays" placeholder="Days *">
                                                                            </div>
                                                                            <div class="form-group daily-container col-lg-3 col-md-6 p-1">
                                                                                <label for="weekend">Weekend ($)</label>
                                                                                <input type="number" name="prices[weekend]" id="weekend" value="<?php echo $property_details['weekend_price']  > 0 ? $property_details['weekend_price'] : ''; ?>" class="weekenddays" placeholder="Weekend *">
                                                                            </div>
                                                                            <div class="form-group daily-container col-lg-3 col-md-6 p-1">
                                                                                <label for="weekly">Weekly ($)</label>
                                                                                <input type="number" name="prices[weekly]" id="weekly" value="<?php echo $property_details['weekly_price']  > 0 ? $property_details['weekly_price'] : ''; ?>" class="weekly" placeholder="Weekly *">
                                                                            </div>
                                                                            <div class="form-group daily-container col-lg-3 col-md-6 p-1">
                                                                                <label for="monthly">Monthly ($)</label>
                                                                                <input type="number" name="prices[monthly]" id="monthly" value="<?php echo $property_details['monthly_price']  > 0 ? $property_details['monthly_price'] : ''; ?>" class="monthly" placeholder="Monthly *">
                                                                            </div>
                                                                        </div>

                                                                        <div class="price-container">
                                                                            <div class="form-group weekend-container">
                                                                                <label for="weekendFrom">Weekend </label>
                                                                                <label for="weekendFrom"> From</label>
                                                                                <select class="form-control" name="weekend_type[from]" id="weekendFrom">
                                                                                    <option value="3">Thursday</option>
                                                                                    <option value="4">Friday</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group weekend-container">
                                                                                <label for="weekendTo">Till</label>
                                                                                <select class="form-control" name="weekend_type[to]" id="weekendTo">
                                                                                    <option value="5">Motzei Shabbos</option>
                                                                                    <option value="6">Sunday</option>
                                                                                    <option value="7">Monday</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <input type="checkbox" class="custom-control-input" name="only_weekend" id="customCheck29">
                                                                                <label class="custom-control-label" for="customCheck29">Weekend Only</label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="price-container">
                                                                            <div class="form-group daily-container" style="width: 100%;">
                                                                                <label for=" manualPrivateNote">Private notes</label>
                                                                                <textarea rows="5" style="width: 100%;" name="private_note[manual]" id="manualPrivateNote" placeholder="Notes"></textarea>
                                                                            </div>
                                                                        </div>

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
                                                                    <li class="col-lg-10 m-auto">
                                                                        <div class="price-container">
                                                                            <div class="form-group daily-container" style="width: 100%;">
                                                                                <label for=" manualPrivateNote">Private notes</label>
                                                                                <textarea rows="5" style="width: 100%;" name="private_note[sessional]" id="manualPrivateNote" placeholder="Notes"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <a href="javascript:void()" class="addRule" id="addRule">Add sessional price rule...</a>
                                                                            <div class="rule"></div>
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
                                                            <li class="submitnext"><a id="submitBtn">Finish</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" value="" id="selectedPrice" name="date_price">
                                            <input type="hidden" value="" id="date" name="date">
                                            <input type="hidden" id="price" value="500" name="price">
                                            <input type="hidden" id="session" value="" name="seasonal_price[session]">
                                            <input type="hidden" id="season" value="" name="seasonal_price[season]">
                                            <input type="hidden" id="allRrentals" value="true" name="allRrentals">
                                            <input type="hidden" class="disableDate" value=''>
                                            <input type="hidden" name="geolocation" class="geolocation" value='' />
                                            <input type="hidden" name="is_annual" class="isAnnual" value="true" />
                                            <input type="hidden" name="manualBooking" class="disableDetail" value="[]" />
                                            <input type="hidden" name="blockedDate" class="blockDetail" value="[]" />
                                            <input type="hidden" name="property_id" id="property_id" value="0" />
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                                <label for="manualLastName">Last Name*</label>
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
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default eventClose" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="add-manual-booking">Add booking</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <div class="modal fade modal-event" tabindex="-1" id="editManualBook" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content event-model">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit a manual booking</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="title">Title</label>
                                                <input style="width: 100%;" type="text" name="title" id="editManualTitle" />
                                                <input type="hidden" id="hid_editManualTitle" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="manualStart">Check-In Date*</label>
                                                <input type="text" name="starts_at" class="updateStartDate" id="editManualStart" />
                                                <input type="hidden" id="hid_editManualStart" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="manualEnd">Check-Out Date*</label>
                                                <input type="text" name="ends_at" class="updateStartDate" id="editManualEnd" />
                                                <input type="hidden" id="hid_editManualEnd" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="manualFirstName">First Name*</label>
                                                <input type="text" name="first_name" class="" id="editManualFirstName" />
                                                <input type="hidden" id="hid_editManualFirstName" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="manualLastName">Last Name*</label>
                                                <input type="text" name="last_name" class="" id="editManualLastName" />
                                                <input type="hidden" id="hid_editManualLastName" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="manualPhoneNumber">Phone number</label>
                                                <input type="text" name="phone_number" class="" id="editManualPhoneNumber" />
                                                <input type="hidden" id="hid_editManualPhoneNumber" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="manualEmail">Email</label>
                                                <input type="text" name="email" class="" id="editManualEmail" />
                                                <input type="hidden" id="hid_editManualEmail" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default eventClose" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="update-manual-booking">Update booking</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div>

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
                                                <label for="blockPrivateNote">Private notes</label>
                                                <textarea rows="5" style="width: 100%;" name="private_note" id="blockPrivateNote" placeholder="Notes"></textarea>
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

                        <div class="fade modal custom-event" tabindex="-1" id="updateBlockModal" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content event-model">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="titleblock" id="edit-titleblock" value="Blocked" />
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="starts-at">Check-In date*</label>
                                                <input type="hidden" id="hid_editBlockStart" />
                                                <input type="text" name="starts_atblock" class="updateBlockDate" id="edit-starts-atblock" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="ends-at">Check-out date*</label>
                                                <input type="hidden" id="hid_editBlockEnd" />
                                                <input type="text" name="ends_atblock" class="updateBlockDate" id="edit-ends-atblock" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="blockPrivateNote">Private notes</label>
                                                <textarea rows="5" style="width: 100%;" name="private_note" id="edit-blockPrivateNote" placeholder="Notes"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default eventClose" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="update-block-event">Block dates</button>
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
                                            <label for="startDate">Check-In Date*</label>
                                            <input type="text" style="width: 100%;" id="startDate" class="startDate" name="startDate" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="endDate">Check-Out Date*</label>
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
                                            <div class="col-sm-6">
                                                <label for="sWeekendFrom">Weekend </label>
                                                <label for="sWeekendFrom"> From</label>
                                                <select class="form-control" name="weekend_type" id="sWeekendFrom">
                                                    <option value="3">Thursday</option>
                                                    <option value="4">Friday</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
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
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="fsWeekendFrom">Weekend </label>
                                                <label for="fsWeekendFrom"> From</label>
                                                <select class="form-control" name="weekend_type" id="fsWeekendFrom">
                                                    <option value="3">Thursday</option>
                                                    <option value="4">Friday</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="fsWeekendTo">Till</label>
                                                <select class="form-control" name="weekend_type" id="fsWeekendTo">
                                                    <option value="5">Motzei Shabbos</option>
                                                    <option value="6">Sunday</option>
                                                    <option value="7">Monday</option>
                                                </select>
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
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="fEditSWeekendFrom">Weekend </label>
                                                <label for="fEditSWeekendFrom"> From</label>
                                                <select class="form-control" name="weekend_type" id="fEditSWeekendFrom">
                                                    <option value="3">Thursday</option>
                                                    <option value="4">Friday</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="fEditSWeekendTo">Till</label>
                                                <select class="form-control" name="weekend_type" id="fEditSWeekendTo">
                                                    <option value="5">Motzei Shabbos</option>
                                                    <option value="6">Sunday</option>
                                                    <option value="7">Monday</option>
                                                </select>
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

                        <div id="actionModal" class="session_modal modal modal-event">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add a action</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body ">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group button"><input type="button" class="seasonButton" value="Add a manual booking" id="addManualBooking"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group button"><input type="button" class="seasonButton" value="Block dates" id="addBlockDates"></div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="actionStart" />
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

                        <div id="propertyConfirmationModal" class="session_modal modal-event modal">
                            <!-- <div id="newsletterform" class="modal-dialog" role="document"> -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Property Confirmation</h4>
                                    <button type="button" class="close" id="closeConfirmDialog"><span aria-hidden="true">&times;</span></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="propertySpec" class="font-weight-bold">Properties</label>
                                            <ul class="pl-2" id="propertySpec">
                                                <li>Type: &nbsp;<label></label></li>
                                                <li>Address: &nbsp;<label></label></li>
                                                <li>NeighborHood: &nbsp;<label></label></li>
                                                <li>NeighborHood Other: &nbsp;<label></label></li>
                                                <li>Bedrooms: &nbsp;<label></label></li>
                                                <li>Bathrooms: &nbsp;<label></label></li>
                                                <li>Floor Number: &nbsp;<label></label></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6" class="font-weight-bold">
                                            <label class="font-weight-bold">Thumbnail</label>
                                            <input type="hidden" id="ctrlThumbIndex" value="0" />
                                            <span class="control-thumbnail control-thumbnail-left" id="ctrlThumbLeft"></span>
                                            <span class="control-thumbnail control-thumbnail-right" id="ctrlThumbRight"></span>

                                            <div class="d-flex justify-content-center" id="thumbnailPreview">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="font-weight-bold">Amenities</label>
                                            <ul id="amenitySpec" class="pl-2">
                                            </ul>
                                        </div>

                                        <div class="col-md-6">
                                            <div>
                                                <label class="font-weight-bold">Date & Price</label>
                                                <ul id="datePriceSpec">
                                                    <li>Price: &nbsp;<label></label></li>
                                                    <li>Weekend Type: &nbsp;<label></label></li>
                                                    <li style="display:none;"><label>Weekend only</label></li>
                                                </ul>
                                            </div>

                                            <label class="font-weight-bold">Virtual Number</label>
                                            <p id="virtualNumber"><?php echo isset($virtual_number) ? $virtual_number : ''; ?></p>
                                        </div>
                                    </div>

                                    <div class="fa-3x overlay" style="display: none;">
                                        <i class="fa fa-spinner fa-spin"></i>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <div class="form-group button">
                                        <input type="button" class="mhButton confirmButton" value="Confirm" id="confirmSubmit" />
                                        <input type="button" class="mhButton cancelButton" value="Cancel" id="cancelSubmit" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /.modal -->
                    </div>
                </div>
            </div>

            <!-- <div class="date-actions" id="date-action" style="display: none;">
                <div class="date">
                    <label>${start}</label>
                    <a class="float-right mr-3" href="javascript:closeDateAction();">X</a>
                </div>
                <ul>
                    <li><a href="javascript:openManualBooking();" id="MainNavHelp">Add a manual Booking</a></li>
                    <li><a href="javascript:openBlockDate();" id="MainNa">Block this date</a></li>
                </ul>
                <ul>
                    <li><a href="javascript:editManualBooking();">Edit a manual Booking</a></li>
                    <li><a href="javascript:removeManualBooking();">Remove a manual Booking</a></li>
                </ul>
            </div> -->

            <div class="date-action-dialog" id="date-action-dialog">
                <div class="date-action" id="date-action">
                    <div class="date">
                        <label>2020-08-18</label>
                        <a class="float-right mr-3" href="javascript:closeDateAction();">X</a>
                    </div>
                    <ul>
                        <li><a href="javascript:openManualBooking();" id="MainNavHelp">Add a manual Booking</a></li>
                        <li><a href="javascript:openBlockDate();" id="MainNa">Block this date</a></li>
                    </ul>
                    <ul>
                        <li><a href="javascript:editManualBooking();">Edit a manual Booking</a></li>
                        <li><a href="javascript:removeManualBooking();">Remove a manual Booking</a></li>
                    </ul>
                    <ul>
                        <li><a href="javascript:editBlockDate();">Edit a block date</a></li>
                        <li><a href="javascript:removeBlockDate();">Remove a block date</a></li>
                    </ul>
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

<script src='<?php echo site_url('assets/js/fullcalendar.js'); ?>'></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js" integrity="sha512-rmZcZsyhe0/MAjquhTgiUcb4d9knaFc7b5xAfju483gbEXTkeJRUMIPk6s3ySZMYUHEcjKbjLjyddGWMrNEvZg==" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script> -->
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

            const place = autocomplete.getPlace();
            const geolocation = [];
            geolocation.push(place.geometry.location.lat());
            geolocation.push(place.geometry.location.lng());

            $('.geolocation').val(JSON.stringify(geolocation));

            $('[name="street').removeClass('invaild-input');
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPhDpAUyER52TsCsLFNOOxT_l5-y7e78A&libraries=places&callback=initMap&language=en" async defer></script>

<script>
    $(function() {
        $("#datepicker-1").datepicker();
    });
    $('#updateForm').on('keyup keypress', function(e) {
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
        console.log("DEC: ", el);
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

    $(document).ready(function() {
        $('#propertyType').on("change paste keyup", function() {
            if ($('#propertyType').val() == 'house' || $('#propertyType').val() == 'villa') {
                $('#floorContainer').css('display', 'none');
            } else {
                $('#floorContainer').css('display', 'block');
            }
        });

        $('#geoLocation').on("change paste keyup", function() {
            if ($('.geolocation').val() != '') {
                $('#geoLocation').removeClass('invaild-input');
            } else {
                $('#geoLocation').addClass('invaild-input');
            }
        });

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
                } else {
                    $('#neighborhood_other_container').css('display', 'none');
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
                if ($('#description').val().length >= 60) {
                    $('#description').removeClass('invaild-input');
                } else {
                    $('#description').addClass('invaild-input');
                }
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
            var street = $('.geolocation').val();
            if (street == '') {
                $('#geoLocation').addClass('invaild-input');
                valid = false;
            } else {
                $('#geoLocation').removeClass('invaild-input');
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
                if ($('#propertyType').val() == 'house' || $('#propertyType').val() == 'villa') {
                    $('#floorNumber').removeClass('invaild-input');
                } else {
                    $('#floorNumber').addClass('invaild-input');
                    valid = false;
                }

            }

            if ($('#description').val() == '') {
                $('#description').addClass('invaild-input');
                valid = false;
            } else {
                if ($('#description').val().length < 60) {
                    toastr.warning('Description should have a minimum of 60 letters');
                    $('#description').addClass('invaild-input');
                    valid = false;
                }
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

                $('#discover').removeClass('active');
                $('#strategy').removeClass('active');
                $('#optimization').removeClass('active');
                $('#content').removeClass('active');

                var role = $(this).attr('role');
                if (role == "presentation1") {
                    $('#discover').addClass('active');
                } else if (role == 'presentation2') {
                    $('#strategy').addClass('active');
                } else if (role == 'presentation3') {
                    $('#optimization').addClass('active');
                } else if (role == 'presentation4') {
                    $('#content').addClass('active');
                } else if (role == 'presentation8' || role == 'presentation9') {
                    $('#content').addClass('active');
                }
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

        $('#days').on("change paste keyup", function() {
            if ($('#days').val() != '') {
                setValidDatePrice();
            }
            renderCalendarPrice();
        });

        $('#weekend').on("change paste keyup", function() {
            if ($('#weekend').val() != '') {
                setValidDatePrice();
            }
            renderCalendarPrice();
        });

        $('#weekly').on("change paste keyup", function() {
            if ($('#weekly').val() != '') {
                setValidDatePrice();
            }
            renderCalendarPrice();
        });

        $('#monthly').on("change paste keyup", function() {
            if ($('#monthly').val() != '') {
                setValidDatePrice();
            }
            renderCalendarPrice();
        });

        $('#weekendFrom').on("change paste keyup", function() {
            renderCalendarPrice();
        });
        $('#weekendTo').on("change paste keyup", function() {
            renderCalendarPrice();
        });
        $('#customCheck29').on('change', function() { //Sukkah Sleep reveal
            renderCalendarPrice();
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
            let amenities = [];
            var data = $('#updateForm').serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                if (item.name == "amenities[]") amenities.push(item.value);
                return obj;
            }, {});

            console.log("data", data);

            if (!checkValidate()) {
                toastr.warning('Please fill required fields');
                return false;
            }

            // Assing Property specs to $propertySpec
            $('#propertySpec li label')[0].innerHTML = data['property_type'];
            $('#propertySpec li label')[1].innerHTML = data['street'];

            $('#propertySpec li')[3].style.display = "none";
            $('#propertySpec li label')[4].innerHTML = document.getElementById('bedrooms').value;
            $('#propertySpec li label')[5].innerHTML = document.getElementById('bathrooms').value;
            $('#propertySpec li label')[6].innerHTML = document.getElementById('floorNumber').value;

            if (data['area_id'] == 'other') {
                $('#propertySpec li label')[2].innerHTML = document.getElementById('neighborhood_other').value
            } else {
                $('#propertySpec li label')[2].innerHTML = document.querySelector("#neighborhood option[value='" + data['area_id'] + "']").innerHTML;
            }
            document.getElementById('ctrlThumbIndex').value = '0';
            // Add thumbnail as preview
            if ($('#image_preview div img').length === 0) {
                $('#thumbnailPreview').append(`<p class="text-center">No Image</p>`);
            } else {
                const length = $('#image_preview div img').length;
                $('#thumbnailPreview').append(`<img src='${$('#image_preview div img')[0].src}' />`);
            }

            amenities.forEach(amenity => {
                $('#amenitySpec').append(`<li>${amenity}</li>`);
            });

            const weekDays = [
                "Thursday",
                "Friday",
                "Motzei Shabbos",
                "Sunday",
                "Monday"
            ];

            dailyPrice = document.getElementById('days').value ? `Daily: $${document.getElementById('days').value} ` : '';
            weekendPrice = document.getElementById('weekend').value ? `Weekend: $${document.getElementById('weekend').value} ` : '';
            weeklyPrice = document.getElementById('weekly').value ? `'Weekly: $${document.getElementById('weekly').value} ` : '';
            monthlyPrice = document.getElementById('monthly').value ? `Monthly: $${document.getElementById('monthly').value}  ` : '';
            $('#datePriceSpec li label')[0].innerHTML = dailyPrice + weekendPrice + weeklyPrice + monthlyPrice;

            if ($('.customCalender').hasClass('active')) {
                $('#datePriceSpec').parent().css('display', 'block');
                $('#datePriceSpec li:nth-child(2)').css('display', 'block');
                const weekFrom = parseInt(document.getElementById('weekendFrom').value, 10) - 3;
                const weekTo = parseInt(document.getElementById('weekendTo').value, 10) - 3;
                $('#datePriceSpec li label')[1].innerHTML = `${weekDays[weekFrom]} ~ ${weekDays[weekTo]}`;
                if ($('#customCheck29').is(':checked')) {
                    $('#datePriceSpec li:nth-child(3)').css('display', 'block');
                } else {
                    $('#datePriceSpec li:nth-child(3)').css('display', 'none');
                }
            } else {
                $('#datePriceSpec').parent().css('display', 'none');
            }

            if ($('#image_preview img').length < 2) {
                document.getElementById('ctrlThumbLeft').style = "display: none;";
                document.getElementById('ctrlThumbRight').style = "display: none;";
            } else {
                document.getElementById('ctrlThumbLeft').style = "display: block;";
                document.getElementById('ctrlThumbRight').style = "display: block;";
            }

            $('#propertyConfirmationModal').show();
        });

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

        renderFirstCalendar();

        function renderFirstCalendar() {
            console.log("render first calendar");
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
                timeZone: 'local',
                events: {
                    url: "https://www.hebcal.com/hebcal/?cfg=fc&v=1&maj=on&min=on&nx=on&year=now&month=x&ss=on&mf=on&d=on&s=on&lg=a",
                    cache: true
                },
                select: function(start, end, jsEvent, view) {


                    if ($('.fc-widget-content[data-date="' + moment(start).format('YYYY-MM-DD') + '"] p.day-background.manual-background').length > 0) {

                        $('#date-action ul')[0].style = "display: none";
                        $('#date-action ul')[1].style = "display: block";
                        $('#date-action ul')[2].style = "display: none";
                    } else if ($('.fc-widget-content[data-date="' + moment(start).format('YYYY-MM-DD') + '"] p.day-background.unavailable-background').length > 0) {
                        $('#date-action ul')[0].style = "display: none";
                        $('#date-action ul')[1].style = "display: none";
                        $('#date-action ul')[2].style = "display: block";
                    } else {
                        $('#date-action ul')[0].style = "display: block";
                        $('#date-action ul')[1].style = "display: none";
                        $('#date-action ul')[2].style = "display: none";
                    }

                    const dialogEl = document.getElementById('date-action-dialog');
                    const dateEl = document.getElementById('date-action');
                    dialogEl.style.display = "block";
                    dateEl.style = `display: block; position: absolute !important; top: ${jsEvent.pageY - 30}px !important; left: ${jsEvent.pageX}px !important; z-index: 130;`;

                    $('#date-action .date label').html(moment(start).format('YYYY-MM-DD'));
                },
                eventAfterAllRender: function() {
                    renderCalendarPrice();
                    console.log("calendar is rendered");
                },
                eventClick: function(event, jsEvent) {
                    // Display the modal and set the values to the event values.
                    if (event.title == 'Blocked') {
                        $('#blockModal').modal('show');
                        $('#blockModal').find('#titleblock').val(event.title);
                        $('#blockModal').find('#starts-atblock').val(event.start);
                        $('#blockModal').find('#ends-atblock').val(event.end);
                        $('#blockModal').find('.eventClose').text('Delete');
                    } else {

                        if ($('.fc-widget-content[data-date="' + moment(start).format('YYYY-MM-DD') + '"] p.day-background.manual-background').length > 0) {

                            $('#date-action ul')[0].style = "display: none";
                            $('#date-action ul')[1].style = "display: block";
                            $('#date-action ul')[2].style = "display: none";
                        } else if ($('.fc-widget-content[data-date="' + moment(start).format('YYYY-MM-DD') + '"] p.day-background.unavailable-background').length > 0) {
                            $('#date-action ul')[0].style = "display: none";
                            $('#date-action ul')[1].style = "display: none";
                            $('#date-action ul')[2].style = "display: block";
                        } else {
                            $('#date-action ul')[0].style = "display: block";
                            $('#date-action ul')[1].style = "display: none";
                            $('#date-action ul')[2].style = "display: none";
                        }

                        const dialogEl = document.getElementById('date-action-dialog');
                        const dateEl = document.getElementById('date-action');
                        dialogEl.style.display = "block";
                        dateEl.style = `display: block; position: absolute !important; top: ${jsEvent.pageY - 30}px !important; left: ${jsEvent.pageX}px !important; z-index: 130;`;

                        $('#date-action .date label').html(moment(event.start).format('YYYY-MM-DD'));

                        $(".fc-day-grid-event").attr("href", 'javascript:void');
                        var start = convert(moment(event.start._i).format());
                        var end = convert(moment(end).format());
                        var a = start.split("-");
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
        }

        function renderSecondCalendar() {
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
                eventOrder: "-title",
                events: {
                    url: "https://www.hebcal.com/hebcal/?cfg=fc&v=1&maj=on&min=on&nx=on&year=now&month=x&ss=on&mf=on&d=on&s=on&lg=a",
                    cache: true,
                    success: function(events) {
                        console.log("Success function");
                        // a function that returns an object
                        for (var i = 0; i < events.length; i++) {
                            if (events[i].className == "hebdate") {
                                events[i].order = 1;
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
                    console.log("Event Rendering");
                    // $el.addClass("custom-event");
                    // console.log(eventObj);
                },
                eventAfterAllRender: function() {
                    renderSession();
                },
                select: function(start, end, jsEvent, view) {

                    if ($('.fc-widget-content[data-date="' + moment(start).format('YYYY-MM-DD') + '"] p.day-background.manual-background').length > 0) {

                        $('#date-action ul')[0].style = "display: none";
                        $('#date-action ul')[1].style = "display: block";
                        $('#date-action ul')[2].style = "display: none";
                    } else if ($('.fc-widget-content[data-date="' + moment(start).format('YYYY-MM-DD') + '"] p.day-background.unavailable-background').length > 0) {
                        $('#date-action ul')[0].style = "display: none";
                        $('#date-action ul')[1].style = "display: none";
                        $('#date-action ul')[2].style = "display: block";
                    } else {
                        $('#date-action ul')[0].style = "display: block";
                        $('#date-action ul')[1].style = "display: none";
                        $('#date-action ul')[2].style = "display: none";
                    }

                    const dialogEl = document.getElementById('date-action-dialog');
                    const dateEl = document.getElementById('date-action');
                    dialogEl.style.display = "block";
                    dateEl.style = `display: block; position: absolute !important; top: ${jsEvent.pageY - 30}px !important; left: ${jsEvent.pageX}px !important; z-index: 130;`;


                    $('#date-action .date label').html(moment(start).format('YYYY-MM-DD'));
                },
                eventClick: function(event, jsEvent) {

                    // Display the modal and set the values to the event values.
                    if (event.title == 'Blocked') {
                        $('#blockModal').modal('show');
                        $('#blockModal').find('#titleblock').val(event.title);
                        $('#blockModal').find('#starts-atblock').val(event.start);
                        $('#blockModal').find('#ends-atblock').val(event.end);
                        $('#blockModal').find('.eventClose').text('Delete');
                    } else {


                        if ($('.fc-widget-content[data-date="' + moment(start).format('YYYY-MM-DD') + '"] p.day-background.manual-background').length > 0) {

                            $('#date-action ul')[0].style = "display: none";
                            $('#date-action ul')[1].style = "display: block";
                            $('#date-action ul')[2].style = "display: none";
                        } else if ($('.fc-widget-content[data-date="' + moment(start).format('YYYY-MM-DD') + '"] p.day-background.unavailable-background').length > 0) {
                            $('#date-action ul')[0].style = "display: none";
                            $('#date-action ul')[1].style = "display: none";
                            $('#date-action ul')[2].style = "display: block";
                        } else {
                            $('#date-action ul')[0].style = "display: block";
                            $('#date-action ul')[1].style = "display: none";
                            $('#date-action ul')[2].style = "display: none";
                        }

                        const dialogEl = document.getElementById('date-action-dialog');
                        const dateEl = document.getElementById('date-action');
                        dialogEl.style.display = "block";
                        dateEl.style = `display: block; position: absolute !important; top: ${jsEvent.pageY - 30}px !important; left: ${jsEvent.pageX}px !important; z-index: 130;`;

                        $('#date-action .date label').html(moment(event.start).format('YYYY-MM-DD'));

                    }
                }
            });
            //clear calendar and cards
            $('.fc-bg td').html('');
        }

        $(document).on('click', '.costomSession', function() {
            renderSecondCalendar();

        });

        function renderCalendarPrice() {
            //clear calendar and cards
            $('.fc-bg td').html('');
            // render normal price
            if (validateForthTab()) {
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
            }

            //
            $('.seasonRule').html('');


            // set price in dates and render cards
            var seasonData = $('#season').val();
            var seasons = seasonData != '' ? seasonData.split('&') : [];
            seasons.forEach(season => {
                var values = season.split('|');
                var seasonID = values[0];
                var title = values[1];
                var startDate = new Date(values[2]);
                var endDate = new Date(values[3]);
                var seasonRate = values[4];
                if (seasonRate == 'daily') {
                    var dayPrice = values[5];
                    var weekendPriceValue = values[6];
                    var isOnlyWeekend = values[7];
                    var weekendFrom = values[8];
                    var weekendTo = values[9];
                    var dailyPriceD = dayPrice != '' ? '$' + dayPrice : '';

                    console.log(dayPrice, weekendPriceValue, isOnlyWeekend, weekendFrom, weekendTo);
                    if (dayPrice) {
                        price = "Day: $" + dayPrice;
                        if (weekendPriceValue) {
                            if (isOnlyWeekend == 'true') {
                                price = "Only Weekend: $" + weekendPriceValue;
                            } else {
                                price += "  Weekend: $" + weekendPriceValue;
                            }
                        }
                    } else {
                        if (weekendPriceValue) {
                            price = "Weekend: $" + weekendPriceValue;
                        }
                    }
                    $('.seasonRule').append('<div class="sessionalRule sessionHide' + seasonID + '" style="background-color:#DCDCDC"><p>' + title + '</p><p>Season rate: ' + seasonRate + '</p><p>' + price + '</p><p>' + values[2] + ' - ' + values[3] + '</p><div class="season-action"><i class="fa fa-trash" data=' + seasonID + ' tab="1" aria-hidden="true"></i><span class="rulEdit" tab="1" data=' + seasonID + ' edit-id=' + seasonID + '>Edit</span></div><input type="hidden" class="rulname' + seasonID + '" value="' + title + '"><input type="hidden" class="rulStartDate' + seasonID + '" value="' + convert(startDate) + '"><input type="hidden" class="rulendDate' + seasonID + '" value="' + convert(endDate) + '"><input type="hidden" class="rulSeasonRate' + seasonID + '" value="' + seasonRate + '"><input type="hidden" class="rulDayPrice' + seasonID + '" value="' + dayPrice + '"><input type="hidden" class="rulWeekendPrice' + seasonID + '" value="' + weekendPriceValue + '"><input type="hidden" class="rulWeekendAval' + seasonID + '" value="' + isOnlyWeekend + '"><input type="hidden" class="rulWeekendStart' + seasonID + '" value="' + weekendFrom + '"><input type="hidden" class="rulWeekendEnd' + seasonID + '" value="' + weekendTo + '"></div>');
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
                    var weekday = [
                        [],
                        [],
                        [],
                        [],
                        [],
                        [],
                        []
                    ];
                    between.forEach(day => {
                        var dayObj = $('.fc-widget-content[data-date="' + convert(day) + '"]');
                        dayObj.html(dailyPriceD);
                        if (dayObj.hasClass('fc-mon')) {
                            weekday[0].push(dayObj);
                        } else if (dayObj.hasClass('fc-tue')) {
                            weekday[1].push(dayObj);
                        } else if (dayObj.hasClass('fc-wed')) {
                            weekday[2].push(dayObj);
                        } else if (dayObj.hasClass('fc-thu')) {
                            weekday[3].push(dayObj);
                        } else if (dayObj.hasClass('fc-fri')) {
                            weekday[4].push(dayObj);
                        } else if (dayObj.hasClass('fc-sat')) {
                            weekday[5].push(dayObj);
                        } else if (dayObj.hasClass('fc-sun')) {
                            weekday[6].push(dayObj);
                        }
                    });

                    var midWeekend = Math.floor((parseInt(weekendTo) + parseInt(weekendFrom)) / 2) % 7;
                    for (var i = weekendFrom; i <= weekendTo; i++) {
                        console.log(weekday[i % 7]);
                        weekday[i % 7].forEach(weekendDay => {
                            weekendDay.html('$' + weekendPriceValue);
                        })

                    }
                    // weekday[midWeekend].forEach(weekendDay => {
                    //     weekendDay.html(weekendPrice(weekendPriceValue));
                    // });

                } else {

                    between.forEach(day => {
                        $('.fc-widget-content[data-date="' + convert(day) + '"]').html(seasonalPrice());
                    });
                    $('.fc-widget-content[data-date="' + convert(middate) + '"]').html(seasonalPrice(fixedPriceD));
                }
            });

            renderManualBooking();
            renderBlockDate();
        }

        function renderManualBooking() {
            let disableDetails = $('.disableDetail').val() == "" ? [] : JSON.parse($('.disableDetail').val());
            console.log("DisabledDatails: ", disableDetails)
            disableDetails.forEach(detail => {
                let startd = new Date(detail.checkInDate);
                let endd = new Date(detail.checkOutDate);

                console.log("StartD: ", startd);
                console.log("EndD: ", endd);
                const midd = new Date((startd.getTime() + endd.getTime()) / 2);
                let between = [];
                while (startd <= endd) {
                    between.push(new Date(startd));
                    startd.setDate(startd.getDate() + 1);;
                }

                between.forEach(day => {
                    $('.fc-widget-content[data-date="' + convert(day) + '"]').html(manualPrice());
                });

                $('.fc-widget-content[data-date="' + convert(midd) + '"]').html(manualPrice(detail.title));

            })
        }

        function renderBlockDate() {
            let blockDetails = $('.blockDetail').val() == "" ? [] : JSON.parse($('.blockDetail').val());
            console.log("BlockDetails: ", blockDetails)
            blockDetails.forEach(detail => {
                let startd = new Date(moment(detail.checkInDate).format("MM-DD-YYYY"));
                let endd = new Date(moment(detail.checkOutDate).format("MM-DD-YYYY"));

                console.log("StartD:", startd);
                console.log("EndD: ", endd);
                const midd = new Date((startd.getTime() + endd.getTime()) / 2);
                let between = [];
                while (startd <= endd) {
                    between.push(new Date(startd));
                    startd.setDate(startd.getDate() + 1);
                }

                // console.log("Between: ", between);

                between.forEach(day => {
                    $('.fc-widget-content[data-date="' + convert(day) + '"]').html(unavailablePrice());
                });

                $('.fc-widget-content[data-date="' + convert(midd) + '"]').html(unavailablePrice('unavailable'));
            });
        }

        function renderSession() {
            //clear calendar and cards
            $('.fc-bg td').html('');

            $('.rule').html('');


            // set price in dates and render cards
            var seasonData = $('#session').val();
            var seasons = seasonData != '' ? seasonData.split('&') : [];
            console.log("renderSession", seasons);
            seasons.forEach(season => {
                var values = season.split('|');
                var seasonID = values[0];
                var title = values[1];
                var startDate = new Date(values[2]);
                var endDate = new Date(values[3]);
                var seasonRate = values[4];
                if (seasonRate == 'daily') {
                    var dayPrice = values[5];
                    var weekendPriceValue = values[6];
                    var isOnlyWeekend = values[7];
                    var weekendFrom = values[8];
                    var weekendTo = values[9];
                    var dailyPriceD = dayPrice != '' ? '$' + dayPrice : '';

                    console.log(dayPrice, weekendPriceValue, isOnlyWeekend, weekendFrom, weekendTo);
                    if (dayPrice) {
                        price = "Day: $" + dayPrice;
                        if (weekendPriceValue) {
                            if (isOnlyWeekend == 'true') {
                                price = "Only Weekend: $" + weekendPriceValue;
                            } else {
                                price += "  Weekend: $" + weekendPriceValue;
                            }
                        }
                    } else {
                        if (weekendPriceValue) {
                            price = "Weekend: $" + weekendPriceValue;
                        }
                    }
                    $('.rule').append('<div class="sessionalRule sessionHide' + seasonID + '" style="background-color:#DCDCDC"><p>' + title + '</p><p>Season rate: ' + seasonRate + '</p><p>' + price + '</p><p>' + values[2] + ' - ' + values[3] + '</p><div class="season-action"><i class="fa fa-trash" data=' + seasonID + ' tab="2" aria-hidden="true"></i><span class="rulEdit" tab="2" data=' + seasonID + ' edit-id=' + seasonID + '>Edit</span></div><input type="hidden" class="rulname' + seasonID + '" value="' + title + '"><input type="hidden" class="rulStartDate' + seasonID + '" value="' + convert(startDate) + '"><input type="hidden" class="rulendDate' + seasonID + '" value="' + convert(endDate) + '"><input type="hidden" class="rulSeasonRate' + seasonID + '" value="' + seasonRate + '"><input type="hidden" class="rulDayPrice' + seasonID + '" value="' + dayPrice + '"><input type="hidden" class="rulWeekendPrice' + seasonID + '" value="' + weekendPriceValue + '"><input type="hidden" class="rulWeekendAval' + seasonID + '" value="' + isOnlyWeekend + '"><input type="hidden" class="rulWeekendStart' + seasonID + '" value="' + weekendFrom + '"><input type="hidden" class="rulWeekendEnd' + seasonID + '" value="' + weekendTo + '"></div>');
                } else {
                    var fixedPrice = values[5];
                    var fixedPriceD = '$' + fixedPrice;
                    price = 'Fixed: $' + fixedPrice;
                    $('.rule').append('<div class="sessionalRule sessionHide' + seasonID + '" style="background-color:#DCDCDC"><p>' + title + '</p><p>Season rate: ' + seasonRate + '</p><p>' + price + '</p><p>' + values[2] + ' - ' + values[3] + '</p><div class="season-action"><i class="fa fa-trash" data=' + seasonID + ' tab="2" aria-hidden="true"></i><span class="rulEdit" tab="2" data=' + seasonID + ' edit-id=' + seasonID + '>Edit</span></div><input type="hidden" class="rulname' + seasonID + '" value="' + title + '"><input type="hidden" class="rulStartDate' + seasonID + '" value="' + convert(startDate) + '"><input type="hidden" class="rulendDate' + seasonID + '" value="' + convert(endDate) + '"><input type="hidden" class="rulSeasonRate' + seasonID + '" value="' + seasonRate + '"><input type="hidden" class="rulPrice' + seasonID + '" value="' + fixedPrice + '"></div>');
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
                    var weekday = [
                        [],
                        [],
                        [],
                        [],
                        [],
                        [],
                        []
                    ];
                    between.forEach(day => {
                        var dayObj = $('.fc-widget-content[data-date="' + convert(day) + '"]');
                        dayObj.html(dailyPriceD);
                        if (dayObj.hasClass('fc-mon')) {
                            weekday[0].push(dayObj);
                        } else if (dayObj.hasClass('fc-tue')) {
                            weekday[1].push(dayObj);
                        } else if (dayObj.hasClass('fc-wed')) {
                            weekday[2].push(dayObj);
                        } else if (dayObj.hasClass('fc-thu')) {
                            weekday[3].push(dayObj);
                        } else if (dayObj.hasClass('fc-fri')) {
                            weekday[4].push(dayObj);
                        } else if (dayObj.hasClass('fc-sat')) {
                            weekday[5].push(dayObj);
                        } else if (dayObj.hasClass('fc-sun')) {
                            weekday[6].push(dayObj);
                        }
                    });

                    var midWeekend = Math.floor((parseInt(weekendTo) + parseInt(weekendFrom)) / 2) % 7;
                    for (var i = weekendFrom; i <= weekendTo; i++) {
                        console.log(weekday[i % 7]);
                        weekday[i % 7].forEach(weekendDay => {
                            weekendDay.html('$' + weekendPriceValue);
                        })
                    }
                    // weekday[midWeekend].forEach(weekendDay => {
                    //     weekendDay.html(weekendPrice(weekendPriceValue));
                    // });

                } else {

                    between.forEach(day => {
                        $('.fc-widget-content[data-date="' + convert(day) + '"]').html(seasonalPrice());
                    });
                    $('.fc-widget-content[data-date="' + convert(middate) + '"]').html(seasonalPrice(fixedPriceD));
                }
            });

            renderManualBooking();
            renderBlockDate();

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

            var sWeekendFrom = $("#fsWeekendFrom").val();
            var sWeekendTo = $("#fsWeekendTo").val();
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
                $('#season').val(seasonData + seasonID + '|' + title + '|' + convert(startDate) + '|' + convert(endDate) + '|' + seasonRate + '|' + sDayPrice + '|' + sWeekendPrice + '|' + isOnlyWeekend + '|' + sWeekendFrom + '|' + sWeekendTo);


            } else {
                if (!seasonFixedPrice) {
                    toastr.warning('Price is required');
                    return false;
                }
                $('#season').val(seasonData + seasonID + '|' + title + '|' + convert(startDate) + '|' + convert(endDate) + '|' + seasonRate + '|' + seasonFixedPrice);

            }
            seasonID++;
            renderCalendarPrice();
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
            $('#seasonTitle').val('');
            $('#seasonStart').val('');
            $('#seasonEnd').val('');
            $('#fseasonRate').val('daily');
            $('#ffixedSeasonalPrice').val('');
            $('#fsDayPrice').val('');
            $('#fsWeekendPrice').val('');
            $('#fsWeekendFrom').val('3');
            $('#fsWeekendTo').val('5');
            $('#customCheck32').prop('checked', false);

            $('#fseasonFixedPrice').css('display', 'none');
            $('#fseasonDailyPrice').css('display', 'block');

            $('#seasonModal').modal('show');
        });
        $('#add-manual-booking').on('click', function() {
            var title = $('#manualTitle').val();
            var startd = new Date($('#manualStart').val());
            var endd = new Date($('#manualEnd').val());
            var firstName = $('#manualFirstName').val();
            var lastName = $('#manualLastName').val();
            var phoneNumber = $('#manualPhoneNumber').val();
            var email = $('#manualEmail').val();


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
            var disableDetail = JSON.parse($('.disableDetail').val());
            console.log("Disabled Detail: ", disableDetail);

            disableDetail.push({
                title,
                firstName,
                lastName,
                email,
                phoneNumber,
                checkInDate: $('#manualStart').val(),
                checkOutDate: $('#manualEnd').val()
            });

            // var dateprice = $('#selectedPrice').val();
            // if (dateprice != '') {
            //     dateprice = dateprice + '&';
            // }
            // $('#selectedPrice').val(dateprice + eachdate);
            // $('#date').val(convert(endd));

            $('.disableDate').val(disableDate + converts($('#manualStart').val()) + ',' + converts($('#manualEnd').val()));
            $('.disableDetail').val(JSON.stringify(disableDetail));

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
            var notes = $('#blockPrivateNote').val();
            var blockDetail = JSON.parse($('.blockDetail').val());

            if (startd == '') {
                toastr.warning('Start date is required');
                return false;
            }

            if (endd == '') {
                toastr.warning('End date is required');
                return false;
            }

            blockDetail.push({
                checkInDate: moment(startd).format("YYYY-MM-DD"),
                checkOutDate: moment(endd).format("YYYY-MM-DD"),
                privateNotes: notes
            });

            $('.blockDetail').val(JSON.stringify(blockDetail));

            var middate = new Date((startd.getTime() + endd.getTime()) / 2);
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
            $('#blockModal').find('textarea').val('');
            $('#blockModal').modal('hide');
        });


        $('#update-manual-booking').on('click', function() {
            removeManualBooking();


            var title = $('#editManualTitle').val();
            var startd = new Date($('#editManualStart').val());
            var endd = new Date($('#editManualEnd').val());
            var firstName = $('#editManualFirstName').val();
            var lastName = $('#editManualLastName').val();
            var phoneNumber = $('#editManualPhoneNumber').val();
            var email = $('#editManualEmail').val();

            // var past_startd = new Date($('#hid_editManualStart').val());
            // var past_endd = new Date($('#hid_editManualEnd').val());

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

            var disableDate = $('.disableDate').val();
            if (disableDate != '') {
                disableDate = disableDate + '|'
            }
            var disableDetail = JSON.parse($('.disableDetail').val());
            console.log("Disabled Detail: ", disableDetail);

            disableDetail.push({
                title,
                firstName,
                lastName,
                email,
                phoneNumber,
                checkInDate: startd,
                checkOutDate: endd
            });

            $('.disableDate').val(disableDate + converts($('#editManualStart').val()) + ',' + converts($('#editManualEnd').val()));
            $('.disableDetail').val(JSON.stringify(disableDetail));


            var middate = new Date((startd.getTime() + endd.getTime()) / 2);

            var between = [];
            while (startd <= endd) {
                between.push(new Date(startd));
                startd.setDate(startd.getDate() + 1);
            }

            between.forEach(day => {
                $('.fc-widget-content[data-date="' + convert(day) + '"]').html(manualPrice());
            });

            $('.fc-widget-content[data-date="' + convert(middate) + '"]').html(manualPrice(title));

            document.getElementById('hid_editManualStart').value = '';
            document.getElementById('hid_editManualEnd').value = '';
            $('#calendar').fullCalendar('unselect');
            $('#editManualBook').find('.eventClose').text('Close');
            $('#editManualBook').find('input').val('');
            $('#editManualBook').modal('hide');
        });

        $('#update-block-event').on('click', function() {
            removeBlockDate();

            let startd = $('#edit-starts-atblock').val();
            let endd = $('#edit-ends-atblock').val();
            const note = $('#edit-blockPrivateNote').val();
            let blockDetail = JSON.parse($('.blockDetail').val());

            if (startd == '') {
                toastr.warning('Start date is required');
                return false;
            }

            if (endd == '') {
                toastr.warning('End date is required');
                return false;
            }

            blockDetail.push({
                checkInDate: moment(startd).format("YYYY-MM-DD"),
                checkOutDate: moment(endd).format("YYYY-MM-DD"),
                privateNotes: note
            });

            $('.blockDetail').val(JSON.stringify(blockDetail));

            startd = new Date(startd);
            endd = new Date(endd);

            var middate = new Date((startd.getTime() + endd.getTime()) / 2);
            var between = [];
            while (startd <= endd) {
                between.push(new Date(startd));
                startd.setDate(startd.getDate() + 1);
            }

            between.forEach(day => {
                $('.fc-widget-content[data-date="' + convert(day) + '"]').html(unavailablePrice());
            });

            $('.fc-widget-content[data-date="' + convert(middate) + '"]').html(unavailablePrice('unavailable'));

            var disableDate = $('.disableDate').val();
            if (disableDate != '') {
                disableDate = disableDate + '|'
            }
            $('.disableDate').val(disableDate + converts($('#edit-starts-atblock').val()) + ',' + converts($('#edit-ends-atblock').val()));

            document.getElementById('hid_editBlockStart').value = '';
            document.getElementById('hid_editBlockEnd').value = '';
            $('#calendar').fullCalendar('unselect');
            $('#updateBlockModal').find('.eventClose').text('Close');
            $('#updateBlockModal').find('input').val('');
            $('#updateBlockModal').find('textarea').val('');
            $('#updateBlockModal').modal('hide');

        });

        function timeOutForCalendar() {
            setTimeout(function() {
                $('.fc-month-button').trigger('click');
                $(".fc-event").removeAttr("href");
            }, 500);
            setTimeout(function() {
                $(".fc-day-grid-event").attr("href", 'javascript:void');
            }, 1000);
        }
        $('#datePrice').click(function() {

            timeOutForCalendar();
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
            $('#fname').val('');
            $('#startDate').val('');
            $('#endDate').val('');
            $('#seasonRate').val('daily');
            $('#fixedSeasonalPrice').val('');
            $('#sDayPrice').val('');
            $('#sWeekendPrice').val('');
            $('#sWeekendFrom').val('3');
            $('#sWeekendTo').val('5');
            $('#customCheck31').prop('checked', false);

            $('#seasonFixedPrice').css('display', 'none');
            $('#seasonDailyPrice').css('display', 'block');
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

            var sessionData = $('#session').val();
            if (sessionData != '') {
                sessionData = sessionData + '&';
            }

            if (seasonRate == "daily") {

                if (!sDayPrice && !sWeekendPrice) {
                    toastr.warning('Price is required');
                    return false;
                }
                $('#session').val(sessionData + click + '|' + seasonName + '|' + convert(startDate) + '|' + convert(endDate) + '|' + seasonRate + '|' + sDayPrice + '|' + sWeekendPrice + '|' + isOnlyWeekend + '|' + sWeekendFrom + '|' + sWeekendTo);

            } else {
                if (!seasonFixedPrice) {
                    toastr.warning('Price is required');
                    return false;
                }
                $('#session').val(sessionData + click + '|' + seasonName + '|' + convert(startDate) + '|' + convert(endDate) + '|' + seasonRate + '|' + seasonFixedPrice);
            }

            // if (seasonRate == "daily") {
            //     if (!sDayPrice && !sWeekendPrice) {
            //         toastr.warning('Price is required');
            //         return false;
            //     }
            //     var price = '';

            //     if (sDayPrice) {
            //         price = "Day: $" + sDayPrice;
            //         if (sWeekendPrice) {
            //             if (isOnlyWeekend) {
            //                 price = "Only Weekend: $" + sWeekendPrice;
            //             } else {
            //                 price += "  Weekend: $" + sWeekendPrice;
            //             }
            //         }
            //     } else {
            //         if (sWeekendPrice) {
            //             price = "Weekend: $" + sWeekendPrice;
            //         }
            //     }
            //     $('.rule').append('<div class="sessionalRule sessionHide' + click + '" style="background-color:#DCDCDC"><p>' + seasonName + '</p><p>Season rate: ' + seasonRate + '</p><p>' + price + '</p><p>' + startDate + ' - ' + endDate + '</p><div class="season-action"><i class="fa fa-trash" data=' + click + ' aria-hidden="true"></i><span class="rulEdit" data=' + click + ' edit-id=' + click + '>Edit</span></div><input type="hidden" class="rulname' + click + '" value="' + seasonName + '"><input type="hidden" class="rulStartDate' + click + '" value="' + convert(startDate) + '"><input type="hidden" class="rulendDate' + click + '" value="' + convert(endDate) + '"><input type="hidden" class="rulSeasonRate' + click + '" value="' + seasonRate + '"><input type="hidden" class="rulDayPrice' + click + '" value="' + sDayPrice + '"><input type="hidden" class="rulWeekendPrice' + click + '" value="' + sWeekendPrice + '"><input type="hidden" class="rulWeekendAval' + click + '" value="' + isOnlyWeekend + '"><input type="hidden" class="rulWeekendStart' + click + '" value="' + sWeekendFrom + '"><input type="hidden" class="rulWeekendEnd' + click + '" value="' + sWeekendTo + '"></div>');
            // } else {
            //     if (!seasonFixedPrice) {
            //         toastr.warning('Price is required');
            //         return false;
            //     }
            //     price = 'Fixed: $' + seasonFixedPrice;
            //     $('.rule').append('<div class="sessionalRule sessionHide' + click + '" style="background-color:#DCDCDC"><p>' + seasonName + '</p><p>Season rate: ' + seasonRate + '</p><p>' + price + '</p><p>' + startDate + ' - ' + endDate + '</p><div class="season-action"><i class="fa fa-trash" data=' + click + ' aria-hidden="true"></i><span class="rulEdit" data=' + click + ' edit-id=' + click + '>Edit</span></div><input type="hidden" class="rulname' + click + '" value="' + seasonName + '"><input type="hidden" class="rulStartDate' + click + '" value="' + convert(startDate) + '"><input type="hidden" class="rulendDate' + click + '" value="' + convert(endDate) + '"><input type="hidden" class="rulSeasonRate' + click + '" value="' + seasonRate + '"><input type="hidden" class="rulPrice' + click + '" value="' + seasonFixedPrice + '"></div>');

            // }

            renderSession();
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
                var updateItem = '' + id + '|' + seasonName + '|' + startDate + '|' + endDate + '|' + seasonRate + '|' + sDayPrice + '|' + sWeekendPrice + '|' + isOnlyWeekend + '|' + sWeekendFrom + '|' + sWeekendTo;

            } else {
                if (!seasonFixedPrice) {
                    toastr.warning('Price is required');
                    return false;
                }
                var updateItem = '' + id + '|' + seasonName + '|' + startDate + '|' + endDate + '|' + seasonRate + '|' + seasonFixedPrice;
            }
            console.log('UpdatedItem', updateItem);

            var session = $('#session').val();
            var y = session.split('&');
            console.log('y', y);

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
            // $('.sessionHide' + id).html(updatedRule);

            renderSession();

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

            var sWeekendStart = $('#fEditSWeekendFrom').val();
            var sWeekendEnd = $('#fEditSWeekendTo').val();

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
                var updateItem = '' + id + '|' + seasonName + '|' + startDate + '|' + endDate + '|' + seasonRate + '|' + sDayPrice + '|' + sWeekendPrice + '|' + isOnlyWeekend + '|' + sWeekendStart + '|' + sWeekendEnd;

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

            renderCalendarPrice();
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
                console.log(seasons);
                var newSeason = seasons.filter(season => {
                    var values = season.split('|');
                    if (values[0] == id) {
                        return false;
                    } else {
                        return true;
                    }
                });
                var newSeasonData = newSeason.length > 0 ? newSeason.join('&') : [];
                console.log(newSeasonData);
                $('#season').val(newSeasonData);
                renderCalendarPrice();
            } else { //second tab
                var days = $('.rulDays' + id).val();
                var sessionData = $('#session').val();
                var sessions = sessionData.split('&');

                var newSession = sessions.filter(session => {
                    var values = session.split('|');
                    if (values[0] == id) {
                        return false;
                    } else {
                        return true;
                    }
                });
                var newSessionData = newSession.length > 0 ? newSession.join('&') : [];
                console.log(newSessionData);
                $('#session').val(newSessionData);
                renderSession();
            }

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
                    var weekendStart = $('.rulWeekendStart' + id).val();
                    var weekendEnd = $('.rulWeekendEnd' + id).val();

                    console.log('weekend', weekendStart, weekendEnd);

                    $('#fEditSDayPrice').val(dayPrice);
                    $('#fEditSWeekendPrice').val(weekendPrice);
                    $('#fEditSWeekendFrom').val(weekendStart);
                    $('#fEditSWeekendTo').val(weekendEnd);

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
                    var weekendAval = $('.rulWeekendAval' + id).val() == 'true' ? true : false;
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

        $(".updateStartDate").datepicker({
            dateFormat: "mm-dd-yy",

            beforeShowDay: function(date) {
                var disabledArrs = "12/06/2010,18/06/2010";
                var disableDate = $('.disableDate').val();
                let allowDateFrom = document.getElementById('hid_editManualStart').value;
                let allowDateTo = document.getElementById('hid_editManualEnd').value;

                if (disableDate != '') {
                    disabledArrs = disableDate
                }
                var disabledArr = disabledArrs.split('|');
                disabledArr = disabledArr.filter(day => {
                    const between = day.split(',');
                    if (moment(between[0], "DD/MM/YYYY").format('YYYY-MM-DD') == moment(allowDateFrom, 'MM-DD-YYYY').format('YYYY-MM-DD') && moment(between[1], "DD/MM/YYYY").format('YYYY-MM-DD') == moment(allowDateTo, 'MM-DD-YYYY').format('YYYY-MM-DD'))
                        return false;
                    return true;
                });
                console.log("DisabledArr", disabledArr);

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

        $(".updateBlockDate").datepicker({
            dateFormat: "mm-dd-yy",

            beforeShowDay: function(date) {
                var disabledArrs = "12/06/2010,18/06/2010";
                var disableDate = $('.disableDate').val();
                let allowDateFrom = document.getElementById('hid_editBlockStart').value;
                let allowDateTo = document.getElementById('hid_editBlockEnd').value;

                if (disableDate != '') {
                    disabledArrs = disableDate
                }
                var disabledArr = disabledArrs.split('|');
                disabledArr = disabledArr.filter(day => {
                    const between = day.split(',');
                    if (moment(between[0], "DD/MM/YYYY").format('YYYY-MM-DD') == moment(allowDateFrom, 'MM-DD-YYYY').format('YYYY-MM-DD') && moment(between[1], "DD/MM/YYYY").format('YYYY-MM-DD') == moment(allowDateTo, 'MM-DD-YYYY').format('YYYY-MM-DD'))
                        return false;
                    return true;
                });
                console.log("DisabledArr", disabledArr);

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
        });

        $(document).on('click', '.changepricefin', function() {
            var date = $(this).attr('currentdata');
            $('#hiddenDate').val(date);
            var price = $('.fc-widget-content[data-date="' + date + '"]').text();
            var itemId = price.substring(1, price.length);
            $('#pricechange').val(itemId);
        });

        // $(document).on('click', '.manualBooking', function(event) {
        //     var date = $(this).attr('currentdata');
        //     $('#manualStart').val(date);
        //     console.log(event);
        //     event.stopPropagation();
        // });

        // $('#addManualBooking').click(function(event) {
        //     var date = $('#actionStart').val();
        //     // var date = $(this).attr('currentdata');
        //     $('#manualStart').val(date);
        //     $('#actionModal').modal('hide');
        //     $('#manualBook').modal('show');
        //     console.log(event);
        //     event.stopPropagation();
        // });

        $(document).on('click', '.blockDates', function() {
            var date = $(this).attr('currentdata');
            $('#starts-atblock').val(date);
            console.log('.fc-widget-content[data-date="' + date + '"]');
        });

        // $('#addBlockDates').click(function() {
        //     var date = $('#actionStart').val();
        //     // var date = $(this).attr('currentdata');
        //     $('#starts-atblock').val(date);
        //     $('#actionModal').modal('hide');
        //     $('#blockModal').modal('show');
        //     console.log('.fc-widget-content[data-date="' + date + '"]');
        // });

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

        // Confirmation before submit
        $(document).on('click', '#confirmSubmit', function() {
            if (document.getElementById('confirmSubmit').className.includes('disabled'))
                return;
            document.getElementById('confirmSubmit').className += " disabled";

            $('#propertyConfirmationModal div.overlay').css('display', 'block');
            $('#updateForm').ajaxSubmit({
                data: {
                    'short_term_available_date': function() {
                        return $('#multi-date-select').multiDatesPicker('value');
                    }
                },
                dataType: 'json',
                beforeSubmit: function() {
                    event.preventDefault();
                    $('.fa-spinner').prop('display', 'inline');
                    $('#submitBtn').prop('disabled', 'disabled');
                },
                success: function(response) {
                    if (response.type == 'success') {
                        $('#propertyConfirmationModal').hide();
                        $('#thumbnailPreview').empty();
                        $('#amenitySpec').empty();
                        document.location.href = "/my_rentals";

                    } else {
                        toastr.warning(response.text);
                        return false;
                    }
                }
            });

        });

        $(document).on('click', '#cancelSubmit', function() {
            // Cancel form submit
            $('#propertyConfirmationModal').hide();
            $('#thumbnailPreview').empty();
            $('#amenitySpec').empty();
        });

        $(document).on('click', '#closeConfirmDialog', function() {
            // Cancel form submit
            $('#propertyConfirmationModal').hide();
            $('#thumbnailPreview').empty();
            $('#amenitySpec').empty();
        });

        $(document).on('click', '#ctrlThumbLeft', function() {
            // ThumbLeft
            const index = parseInt(document.getElementById('ctrlThumbIndex').value, 10);
            if (index > 0) {
                document.getElementById('ctrlThumbIndex').value = index - 1;
                $('#thumbnailPreview').empty();
                $('#thumbnailPreview').append(`<img src='${$('#image_preview div img')[index-1].src}' />`);
            }
        });

        $(document).on('click', '#ctrlThumbRight', function() {
            // ThumbRight
            const index = parseInt(document.getElementById('ctrlThumbIndex').value, 10);
            if (index < $('#image_preview div img').length - 1) {
                document.getElementById('ctrlThumbIndex').value = index + 1;
                $('#thumbnailPreview').empty();
                $('#thumbnailPreview').append(`<img src='${$('#image_preview div img')[index+1].src}' />`);
            }
        });
        $('#date-action-dialog').click(function(e) {
            if (e.target == this) closeDateAction();
            console.log("Dialog CLICKED!", e.target);
        });


        // render calendar price when tab is switched
        $(document).on('click', '.customCalender', function() {
            renderCalendarPrice();
            if ($('.isAnnual').val() == 'true') return;
            $('.isAnnual').val('true');
            $('.disableDate').val('[]');
            $('.manualBooking').val('[]');
            $('.blockedDate').val('[]');
        });

        $(document).on('click', '.customSession', function() {
            renderSession();

            if ($('.isAnnual').val() == 'true') {
                $('.isAnnual').val('false');
                $('.disableDate').val('[]');
                $('.manualBooking').val('[]');
                $('.blockedDate').val('[]');
            }
        });

        // set weekend type for annual rentals
        $('#weekendFrom').val('<?php echo $property_details['weekend_from'] ?>');
        $('#weekendTo').val('<?php echo $property_details['weekend_to'] ?>');

        var isOnlyWeekend = <?php echo $property_details['only_weekend'] ?>;
        console.log("isonly Weekend", isOnlyWeekend);

        $('#customCheck29').prop('checked', isOnlyWeekend);

        //set private note for annual rentals
        var privateNote = "<?php echo $property_details['is_annual'] == 'true' ? $property_details['private_note'] : ''; ?>";
        $('#annualPrivateNote').val(privateNote);

        // set seasonal pricing data
        var isAnnual = "<?php echo $property_details['is_annual']; ?>";
        var seasonalPrice = "<?php echo $property_details['seasonal_price']; ?>";
        if (isAnnual == "true") { // switch tab
            $('#season').val(seasonalPrice);
            $('.costomSession').removeClass('active');
            $('.customCalender').addClass('active');
        } else {
            $('#session').val(seasonalPrice);
            $('.costomSession').addClass('active');
            $('.customCalender').removeClass('active');
        }

        //set mannual booking
        var manualBooking = '<?php echo $property_details['manual_booking']; ?>';
        $('.disableDetail').val(manualBooking);

        //set block dates
        var blockdates = '<?php echo $property_details['blocked_date']; ?>';
        $('.blockDetail').val(blockdates);

        //if date and availability is clicked

        var date = "<?php echo isset($_SESSION['forDate']) ? $_SESSION['forDate'] : '' ?>";
        if (date != '') {

            // renderFirstCalendar();

            $('.more-icon-preocess li:first').removeClass('active');

            $('#discover').removeClass('active');
            $('.more-icon-preocess li:nth-child(4)').addClass('active');
            $('#content').addClass('active');
            timeOutForCalendar();

        }

    });

    function closeDateAction() {
        const dialogEl = document.getElementById('date-action-dialog');
        const dateEl = document.getElementById('date-action');
        dialogEl.style.display = "none";
        dateEl.style.display = 'none';
    }

    function openManualBooking() {
        closeDateAction();
        const dateEl = document.getElementById('manualStart');
        dateEl.value = moment($('#date-action .date label').html(), "YYYY-MM-DD").format("MM-DD-YYYY");
        $('#manualBook').modal('show');
    }

    function openBlockDate() {
        document.getElementById('starts-atblock').value = moment($('#date-action .date label').html()).format("MM-DD-YYYY");

        closeDateAction();
        $('#blockModal').modal('show');
    }

    function editManualBooking() {

        const selectedDate = moment($('#date-action .date label').html());
        let disabledData = JSON.parse($('.disableDetail').val());
        disabledData = disabledData.map(day => ({
            ...day,
            checkInDate: moment(day.checkInDate),
            checkOutDate: moment(day.checkOutDate)
        }));

        disabledData = disabledData.filter(day => {
            if (day.checkInDate <= selectedDate && selectedDate <= day.checkOutDate)

                return true;
            return false;
        });

        if (disabledData.length == 0) {
            console.log("No Data");
            return;
        }


        document.getElementById('hid_editManualStart').value = disabledData[0].checkInDate.format('MM-DD-YYYY');
        document.getElementById('hid_editManualEnd').value = disabledData[0].checkOutDate.format('MM-DD-YYYY');
        document.getElementById('hid_editManualTitle').value = disabledData[0].title;
        document.getElementById('hid_editManualFirstName').value = disabledData[0].firstName;
        document.getElementById('hid_editManualLastName').value = disabledData[0].lastName;
        document.getElementById('hid_editManualPhoneNumber').value = disabledData[0].phoneNumber;
        document.getElementById('hid_editManualEmail').value = disabledData[0].email;

        document.getElementById('editManualStart').value = disabledData[0].checkInDate.format('MM-DD-YYYY');
        document.getElementById('editManualEnd').value = disabledData[0].checkOutDate.format('MM-DD-YYYY');
        document.getElementById('editManualTitle').value = disabledData[0].title;
        document.getElementById('editManualFirstName').value = disabledData[0].firstName;
        document.getElementById('editManualLastName').value = disabledData[0].lastName;
        document.getElementById('editManualPhoneNumber').value = disabledData[0].phoneNumber;
        document.getElementById('editManualEmail').value = disabledData[0].email;

        closeDateAction();
        $('#editManualBook').modal('show');

    }

    function removeManualBooking() {
        const selectedDate = moment($('#date-action .date label').html());
        let disabledData = JSON.parse($('.disableDetail').val());
        disabledData = disabledData.map(day => ({
            ...day,
            checkInDate: moment(day.checkInDate),
            checkOutDate: moment(day.checkOutDate)
        }));
        disabledData = disabledData.filter(day => {
            if (day.checkInDate <= selectedDate && selectedDate <= day.checkOutDate)
                return false;
            return true;
        });

        $('.disableDetail').val(JSON.stringify(disabledData));

        let disabledDates = $('.disableDate').val().split('|');

        console.log("disabledDates", disabledDates);

        disabledDates = disabledDates.map(day => {

            const oneDay = day.split(',');
            return {
                from: moment(oneDay[0], "DD/MM/YYYY"),
                to: moment(oneDay[1], "DD/MM/YYYY")
            }
        });
        console.log("disabledDates", disabledDates);

        let removableDate;

        disabledDates = disabledDates.filter(day => {
            if (day.from <= selectedDate && day.to >= selectedDate) {
                removableDate = {
                    ...day
                };
                return false;
            }
            return true;
        });

        disabledDates = disabledDates.map(day => (`${day.from.format('DD/MM/YYYY')},${day.to.format('DD/MM/YYYY')}`));
        $('.disableDate').val(disabledDates.join('|'));
        closeDateAction();

        const startDay = new Date(removableDate.from.format('YYYY-MM-DD'));
        const endDay = new Date(removableDate.to.format('YYYY-MM-DD'));

        let between = [];
        while (removableDate.from <= removableDate.to) {
            between.push(removableDate.from.format('YYYY-MM-DD'));
            removableDate.from.add(1, 'days');
        }

        between.forEach(day => {
            $('.fc-widget-content[data-date="' + moment(day).format("YYYY-MM-DD") + '"]').empty();
        });
    }

    function editBlockDate() {
        // Edit Block Date
        const selectedDate = moment($('#date-action .date label').html());
        let blockDetail = JSON.parse($('.blockDetail').val());

        blockDetail = blockDetail.filter(day => {
            if (moment(day.checkInDate) <= selectedDate && selectedDate <= moment(day.checkOutDate)) return true;
            return false;
        });

        if (blockDetail.length == 0) {
            console.log("No Data");
            return;
        }

        document.getElementById('edit-starts-atblock').value = moment(blockDetail[0].checkInDate).format("MM-DD-YYYY");
        document.getElementById('edit-ends-atblock').value = moment(blockDetail[0].checkOutDate).format("MM-DD-YYYY");
        document.getElementById('edit-blockPrivateNote').value = blockDetail[0].privateNotes;

        document.getElementById('hid_editBlockStart').value = moment(blockDetail[0].checkInDate).format("MM-DD-YYYY");
        document.getElementById('hid_editBlockEnd').value = moment(blockDetail[0].checkOutDate).format("MM-DD-YYYY");

        closeDateAction();
        $('#updateBlockModal').modal('show');
    }

    function removeBlockDate() {
        // Remove Block Date
        const selectedDate = moment($('#date-action .date label').html());
        let blockDetail = JSON.parse($('.blockDetail').val());
        let disableDate = $('.disableDate').val().split('|');
        let removableDate;

        blockDetail = blockDetail.filter(day => {
            if (moment(day.checkInDate) <= selectedDate && selectedDate <= moment(day.checkOutDate)) {
                removableDate = {
                    checkInDate: moment(day.checkInDate),
                    checkOutDate: moment(
                        day.checkOutDate)
                };
                return false;
            }
            return true;
        });
        disableDate = disableDate.filter(day => {
            const date = day.split(',');
            if (moment(date[0], "DD/MM/YYYY") <= selectedDate && selectedDate <= moment(date[1], "DD/MM/YYYY")) return false;
            return true;
        });

        $('.disableDate').val(disableDate.join('|'));
        $('.blockDetail').val(JSON.stringify(blockDetail));

        var between = [];
        while (removableDate.checkInDate <= removableDate.checkOutDate) {
            between.push(removableDate.checkInDate.format("YYYY-MM-DD"));
            removableDate.checkInDate.add(1, 'days');
        }

        between.forEach(day => {
            $('.fc-widget-content[data-date="' + day + '"]').empty();
        });
        closeDateAction();
    }
</script>

<script>
    //set neighborhood other
    $('#neighborhood_other_container').css('display', 'none');
    var neighborhoodOther = '<?php echo $property_details['area_other']; ?>';
    var neighborhood = <?php echo $property_details['area_id']; ?>;

    console.log(neighborhoodOther);
    if (neighborhoodOther && neighborhood == 0) {
        $('#neighborhood').val('other');
        $('#neighborhood_other').val(neighborhoodOther);
        $('#neighborhood_other_container').css('display', 'block');
    }

    // set floor number
    var floorNumber = <?php echo $property_details['florbas']; ?>;
    console.log("floor Number", floorNumber);
    $('#floorNumber').val(floorNumber);

    //set Sukkah
    var hasSukkah = '<?php $amenities = explode(',', $property_details['amenities']);
                        echo in_array('Sukkah', $amenities); ?>';
    var sleepNumber = '<?php echo $property_details['sleep_number']; ?>';
    if (hasSukkah) {
        $('#sukkahSleep').val(sleepNumber);
        $('#sukkahSleep').css('display', 'block');
    } else {
        $('#sukkahSleep').css('display', 'none');
    }
</script>

<script>
    // show image preview
    var editImage = <?php echo json_encode($property_images); ?>;
    editImage.forEach(function(row, index) {
        $('#image_preview').append("<div class='thumbnails_box'><img src='" + '<?php echo site_url('uploads/') ?>' + row.path + "' width='100%' alt='' title='" + row.path + "'><i class='fa fa-window-close remove' onclick=removethis(this);></i></div>");
    });
</script>
<script>
    // set property_id
    var propertyID = <?php echo $property_details['id']; ?>;
    console.log("virutal_number", propertyID);
    $('#property_id').val(propertyID);
</script>
<script>
    // set geoLocation
    var coords = "<?php echo $property_details['coords']; ?>";

    $('.geolocation').val(coords);
</script>