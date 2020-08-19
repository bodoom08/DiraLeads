<?php defined('BASEPATH') or exit('No direct script access allowed');
    
    $this->load->view('common/top', [
                      'title' => 'Properties'
                      ]);
    ?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
  <link rel="stylesheet" href="//unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
    <link rel="stylesheet" href="<?php echo site_url('../assets/css/jquery-ui.multidatespicker.css') ?>">
     <link rel="stylesheet" href="<?php echo site_url('../assets/css/styles.css') ?>">
 
<link href="<?php echo site_url('../assets/css/fullcalendar.css') ?>" rel="stylesheet" />


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://momentjs.com/downloads/moment.min.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.js'></script>
        <link rel='stylesheet' href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css" />

  <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>


<div class="dashboard">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-2 col-md-12 col-sm-12 col-pad">
        <div class="dashboard-nav d-none d-xl-block d-lg-block">
        <?php $this->load->view('common/sidebar'); ?>
        </div>
      </div>
      <div class="col-lg-10 col-md-12 col-sm-12 col-pad">
        <div class="content-area5">
          <div class="dashboard-content">
            <div class="dashboard-list">
              <h3 class="heading">Property Details</h3>
              <div class="dashboard-message contact-2 bdr clearfix">
                  <div class="row">
                      <div class="col-lg-12 col-md-12">
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
                        <?php echo form_open_multipart('property/property_listing', 'id="listingForm" class=""'); ?>
                           <div class="tab-content">
               
                  <div role="tabpanel" class="tab-pane active" id="discover">
                    <div class="design-process-content">
                        <div class="tabbbing-one">
                            <ul class="row">
                                <li class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Property Type</label>
                                        <select class="form-control" name="property_type" id="exampleFormControlSelect1">
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
                                        <label for="exampleFormControlSelect1">Address</label>
                                        <input type="text" name="street" rows="2" class="form-control md-textarea" id="autocomplete_area" placeholder="">
                                    </div> 
                                </li>

                                <li class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">User</label>
                                      <select name="user_id" class="form-control custom-select" required>
                                            <option value="">Select User</option>
                                            <?php foreach ($users as $key => $value) : ?>
                                                <?php 
                                                    $dataParams = [
                                                        'contact_type' => $value['contact_type'],
                                                        'day_of_the_weak'  => $value['day_of_the_weak'],
                                                        'time_of_day'  => $value['time_of_day'],
                                                        'from_time'  => $value['from_time'],
                                                        'to_time'  => $value['to_time'], 
                                                    ];
                                                ?>

                                                <?php
                                                extract($_GET);
                                                if(isset($userid_for)) { ?>
                                                    <option value="<?php echo $value['id'] ?>" data-pref="<?php echo htmlspecialchars(json_encode($dataParams), ENT_QUOTES, 'UTF-8'); ?>" <?php echo ($value['id'] == $userid_for) ? 'selected' : ''; ?>><?php echo $value['name'] ?></option>
                                                <?php } else { ?>                                                
                                                    <option value="<?php echo $value['id'] ?>" data-pref="<?php echo htmlspecialchars(json_encode($dataParams), ENT_QUOTES, 'UTF-8'); ?>"><?php echo $value['name'] ?></option>
                                                <?php } ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </li>

                                <li class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Neighborhood</label>
                                      <select class="form-control" name="area_id" id="exampleFormControlSelect1">
                                      <option value="">--select--</option>
                                        <?php foreach ($areas as $key => $value): ?>
                                                                            <option value="<?php echo $value['id'] ?>"><?php echo $value['title'] ?></option>
                                                                        <?php endforeach;?>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                              
                             <ul class="row">
                                <li class="col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Bedrooms</label>
                                        <input type="hidden" name="attribute_id[]" value="1">
                                        <input type="number" placeholder="Bedrooms" class="form-control" name="value[]">
                                    </div>
                                </li>
                                <li class="col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Bathrooms</label>
                                        <input type="hidden" name="attribute_id[]" value="2">
                                        <input type="number" placeholder="Bathrooms" class="form-control" name="value[]">
                                    </div>
                                </li>
                                <li class="col-lg-4">
                                    <div class="form-group">
                                      <label for="exampleFormControlSelect1">Floor Number</label>
                                      <select class="form-control" name="attribute_id[]" id="florbas">
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
                                        <label for="exampleFormControlSelect1">Description</label>
                                        <textarea type="text" id="message" name="property_desc" rows="2" class="form-control md-textarea" placeholder="Description"></textarea>
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
                                    </div>
                                    
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
                                        <label for="exampleFormControlSelect1">upload pictures</label>
                                        <input type="file" id="upload_file" onchange="preview_image();" accept="image/x-png,image/jpeg" name="userfile[]" aria-label="File browser example" multiple>
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
                  <li role="presentation9" class="customCalender active mr-3" style="width:40%"><a href="#sessional" aria-controls="sessional" role="tab" data-toggle="tab" >
                    <p>My Rental is available all year round</p>
                    </a></li>
                  <li role="presentation8" style="width:40%" class="costomSession"><a href="#yearly" aria-controls="yearly" role="tab" data-toggle="tab" >
                    <p>My Rental is seasonal</p>
                    </a></li>
                </ul>
                 <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="sessional">
                        <div class="tabbbing-one two">
                            <ul class="row">
                                <li class="col-lg-10 m-auto">
                                <input type="number" class="datedays" placeholder="Days">
                                <input type="number" class="weekenddays" placeholder="Weekend">
                                <span class="submitPrice" style="font-size: 15px;background: #a27107;padding: 10px 50px;margin: 0 10px 0;border-radius: 30px;color: #fff;border: 0;text-align: center;">Price</span>
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
                                        <a href="javascript:void()" id="addRule">Add sessional price rule...</a>
                                        <div class="rule">
                                       </div>
                                    </div>
                                </li>
                            </ul>
                        </div>    
                    
                    </div>
                     </div>
                                    <div class="tabing-action">
                                        <ul>
                                            <li class="submitnext"><button id="submitBtn" type="submit">Finish</button>
                                            <!-- <li class="submitnext"><a data-toggle="modal" data-target="#exampleModal">Review</a> -->
                                        </ul>
                                    </div>
                            </div>
                        </div>
                      
                      <input type="hidden" value="" id="selectedPrice" name="date_price">
                     <input type="hidden" value="" id="date" name="date">
                      <input type="hidden" id="price" value="500" name="price" >
                      <input type="hidden" id="session" value="" name="rule_data" >
                       <input type="hidden" id="allRrentals" value="true" name="allRrentals" >
                       <input type="hidden" class="disableDate" value=''>

              </div>
                        <div class="basic_information" style="display:none">
                            <!-- <h4 class="inner-title mb-4">Basic Information</h4> -->
                            <div class="clearfix">
                                <label class="radio-main"> Sell
                                    <input type="radio" checked="checked" name="property" value="sale">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="radio-main">Rent
                                    <input type="radio" name="property" value="rent">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="radio-main">Short term Rental
                                    <input type="radio" name="property" value="short term rent">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="">
                              <div class="row">
                                  <div class="col-md-7">
                                    <div class="form-group">
                                        <select name="user_id" class="form-control custom-select" required>
                                            <option value="">Select User</option>
                                            <?php foreach ($users as $key => $value) : ?>
                                                <?php 
                                                    $dataParams = [
                                                        'contact_type' => $value['contact_type'],
                                                        'day_of_the_weak'  => $value['day_of_the_weak'],
                                                        'time_of_day'  => $value['time_of_day'],
                                                        'from_time'  => $value['from_time'],
                                                        'to_time'  => $value['to_time'], 
                                                    ];
                                                ?>

                                                <?php
                                                extract($_GET);
                                                if(isset($userid_for)) { ?>
                                                    <option value="<?php echo $value['id'] ?>" data-pref="<?php echo htmlspecialchars(json_encode($dataParams), ENT_QUOTES, 'UTF-8'); ?>" <?php echo ($value['id'] == $userid_for) ? 'selected' : ''; ?>><?php echo $value['name'] ?></option>
                                                <?php } else { ?>                                                
                                                    <option value="<?php echo $value['id'] ?>" data-pref="<?php echo htmlspecialchars(json_encode($dataParams), ENT_QUOTES, 'UTF-8'); ?>"><?php echo $value['name'] ?></option>
                                                <?php } ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="col-md-7">
                                      <div class="row">
                                          <div class="col-md-6 d-none">
                                              <div class="form-group">
                                                  <input type="text" placeholder="House No" class="form-control" name="house_no" >
                                              </div>
                                          </div>
                                          <div class="col-md-12">
                                                <div class="input-group transparent-input-group curve mb-1">
                                                    <div class="input-group-prepend input-group-curve">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-thumb-tack" aria-hidden="true"></i></span>
                                                    </div>
                                                    <input type="text" placeholder="Street" class="form-control" id="autocomplete_area" name="street" required>
                                                </div>
                                          </div>
                                          <div class="col-md-6 ">
                                              <div class="form-group">
                                                  <select name="area_id" class="form-control custom-select" required>
                                                      <option value="">Select Area</option>
                                                      <?php foreach ($areas as $key => $value) : ?>
                                                          <option value="<?php echo $value['id'] ?>"><?php echo $value['title'] ?></option>
                                                      <?php endforeach; ?>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <select class="form-control custom-select" name="property_type" required>
                                                      <option>Property Types</option>
                                                      <option>House</option>
                                                      <option>Apartment</option>
                                                      <option>Duplex</option>
                                                      <option>Office</option>
                                                      <option>Others</option>
                                                  </select>
                                              </div>
                                          </div>
                                          <!-- <div class="col-md-4" id="rent" style="display: none">
                                              <div class="form-group">
                                                  <select class="form-control" name="rent">
                                                      <option>Furnished </option>
                                                      <option>Unfurnished </option>
                                                      <option>Both </option>
                                                  </select>
                                              </div>
                                          </div> -->
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <input type="text" placeholder="Price (USD)" class="form-control" name="price" required>
                                              </div>
                                          </div>
                                          <div class="col-md-6 d-none" id="multi-date">
                                                <div class="form-group">
                                                    <code><small>
                                                        <b>Available For</b>
                                                        </small></code>
                                                    <span id="multi-date-select" />
                                                </div>
                                            </div>
                                          <!-- <div class="col-md-6">
                                              <div class="form-group">
                                                  <input type="text" placeholder="Date Available" class="form-control datepicker" name="available_date" id="available_date" required>
                                                  <code><small>
                                                          <a id="available" href="javascript:(0);" onclick="available_status_change(this);"> Available Now</a>
                                                      </small></code>
                                              </div>
                                          </div> -->
                                          <div class="col-md-6">
                                              <div class="form-check">
                                                  <!-- <label class="form-check-label">
                                                      <input type="checkbox" id="available" class="form-check-input" value="on" name="available_now" onchange="available_status_change(this);"> Available
                                                      Now
                                                  </label> -->
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-5">
                                      <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                  <textarea class="form-control" placeholder="Property Description" name="property_desc" rows="1"></textarea>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="upload_media mt-2" id="dynamic_field">
                                  <h4 class="inner-title mb-3 ">Property Attribute </h4>
                                  <div class="row" id="row_1">
                                      <div class="col-md-4">
                                          <div class="form-group">
                                              <select name="attribute_id[]" id="attribute_1" class="form-control" onchange="attribute_desc(this)">
                                                  <?php foreach ($attributes as $key => $value) : ?>
                                                      <option value="<?php echo $value['id'] ?>" data-desc="<?php echo $value['description']; ?>"><?php echo $value['text'] ?></option>
                                                  <?php endforeach; ?>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="col-md-4">
                                          <div class="form-group">
                                              <input type="text" placeholder="Description" class="form-control" name="value[]">
                                          </div>
                                      </div>
                                      <div class="col-md-4">
                                          <button class="btn btn-success btn-xs" id="add" type="button" title="Add Attribute"><i class="fa fa-plus"></i></button>
                                      </div>
                                  </div>
                              </div>
                              <div class="upload_media mt-2">
                                  <h4 class="inner-title mb-3">Choose Location</h4>
                                  <div id="map-picker" style="height: 400px;"></div>
                                  <input type="hidden" id="lat_lng" name="lat_lng">
                              </div>
                              <div class="upload_media mt-2">
                                  <h4 class="inner-title mb-3 ">Upload Photo </h4>
                                  <div class="row">
                                      <div class="col-md-12">
                                          <div class="browse_submit">
                                              <span>Add Photos</span>
                                              <label class="file">
                                                  <input type="file" id="upload_file" name="userfile[]" aria-label="File browser example" multiple>
                                              </label>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="inner-title mb-3 " style="padding-left: 0px;">How People can Contact me ?</h4>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="phone" name="phone" value="on">
                                        <label class="custom-control-label" for="phone">Phone</label>
                                    </div>

                                    <!-- Default inline 2-->
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="email" name="email" value="on">
                                        <label class="custom-control-label" for="email">Email</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="inner-title mb-3 " style="padding-left: 0px;">Day of Week</h4>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="sunday" name="sunday" value="on">
                                        <label class="custom-control-label" for="sunday">Sunday</label>
                                    </div>

                                    <!-- Default inline 2-->
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="monday" name="monday" value="on">
                                        <label class="custom-control-label" for="monday">Monday</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="tuesday" name="tuesday" value="on">
                                        <label class="custom-control-label" for="tuesday">Tuesday</label>
                                    </div>

                                    <!-- Default inline 2-->
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="wednesday" name="wednesday" value="on">
                                        <label class="custom-control-label" for="wednesday">Wednesday</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="thursday" name="thursday" value="on">
                                        <label class="custom-control-label" for="thursday">Thursday</label>
                                    </div>

                                    <!-- Default inline 2-->
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="friday" name="friday" value="on">
                                        <label class="custom-control-label" for="friday">Friday</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="saturday" name="saturday" value="on">
                                        <label class="custom-control-label" for="saturday">Saturday</label>
                                    </div>
                                </div>
                            </div>
                            <div class="upload_media mt-2">
                                <h4 class="inner-title mb-3" style="padding-left: 0px;">Time of Day</h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="time" class="form-control custom-select" required onchange="customTimeSet(this);">
                                                <option value="">Select Time</option>
                                                <option value="24">24 Hrs</option>
                                                <option value="custom">Custom Time</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group" id="custom_div" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="time" class="form-control" placeholder="Start Time" name="start_time">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="time" class="form-control" placeholder="End Time" name="end_time">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                              <div class="browse_submit">
                                  <div class="clearfix"></div>
                                  <button type="submit" id="submitBtn" class=" float-left view-all"><i class="fa fa-spinner fa-spin" style="display: none;"></i> submit property</button>
                              </div>
                            </div>
                        </div>
                        </form>
                      </div>
                  </div>
              </div>
            </div>
          </div>
          <p class="sub-banner-2 text-center">© Copyright 2019. All rights reserved</p>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('common/bottom'); ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo site_url('../assets/js/jquery-ui.multidatespicker.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPhDpAUyER52TsCsLFNOOxT_l5-y7e78A&libraries=places"></script>


<script>
    var map;
    var marker;
    var initMapPicker = (latLng) => {
        map = L.map('map-picker', {
            center: latLng,
            zoom: 15
        });

        $('#lat_lng').val(`${latLng[0]}|${latLng[1]}`);

        L.tileLayer('https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}{r}.png?lang=en', {
            attribution: 'Map Data &copy; <a href="https://wikimediafoundation.org/wiki/Maps_Terms_of_Use">Wikimedia</a>'
        }).addTo(map);

        var mapIcon = L.icon({
            iconUrl: 'https://maps.gstatic.com/mapfiles/place_api/icons/geocode-71.png',
            shadowUrl: 'https://unpkg.com/leaflet@1.5.1/dist/images/marker-shadow.png',

            iconSize:     [50, 50], // size of the icon
            shadowSize:   [50, 50], // size of the shadow
            iconAnchor:   [12, 64], // point of the icon which will correspond to marker's location
            shadowAnchor: [4, 62],  // the same for the shadow
            popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
        });

        marker = L.marker(latLng, {
            draggable: true,
            autoPan: true,
            icon: mapIcon
        }).addTo(map);

        marker.on('dragend', (e) => {
            var newLatLng = marker.getLatLng()
            $('#lat_lng').val(`${newLatLng.lat}|${newLatLng.lng}`);
        });
    };

    var onPlaceChangedMapPicker = (lat, lng) => {
        map.removeLayer(marker);

        var mapIcon = L.icon({
            iconUrl: 'https://maps.gstatic.com/mapfiles/place_api/icons/geocode-71.png',
            shadowUrl: 'https://unpkg.com/leaflet@1.5.1/dist/images/marker-shadow.png',

            iconSize:     [50, 50], // size of the icon
            shadowSize:   [50, 50], // size of the shadow
            iconAnchor:   [12, 64], // point of the icon which will correspond to marker's location
            shadowAnchor: [4, 62],  // the same for the shadow
            popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
        });

        marker = L.marker([lat, lng], {
            draggable: true,
            autoPan: true,
            icon: mapIcon,
        }).addTo(map);
        map.panTo(new L.LatLng(lat, lng));

        $('#lat_lng').val(`${lat}|${lng}`);

        marker.on('dragend', (e) => {
            var newLatLng = marker.getLatLng()
            $('#lat_lng').val(`${newLatLng.lat}|${newLatLng.lng}`);
        });
    }

    // if (navigator.geolocation) {
    //     navigator.geolocation.getCurrentPosition(pos => {
    //         initMapPicker([pos.coords.latitude, pos.coords.longitude]);
    //     });
    // } else {
        initMapPicker([40.71427, -74.00597]);
        // toastr.info('Geolocation is not supported by this browser. Defaults to New York');
    // }
</script>

<!-- Update for Google Autocomplete Places API -->
<script>
   $(document).ready(function(){
        $('.next').click(function(){
            var attr = $('[name="value[]').val();
             var street = $('[name="street').val();
             if(street == ''){
                 return false;
             }
            $('.more-icon-preocess li:first').removeClass('active');
            $('.more-icon-preocess li:nth-child(2)').addClass('active');
            $('#discover').removeClass('active');
            $('#strategy').addClass('active');
        })

            $('.amintNext').click(function(){
                // var amenities = $('[name="amenities[]"]:checked').val();
               var amenities = $('input[name="amenities[]"]:checked').val();
                if(amenities == null){
                return false;   
                }
            $('.more-icon-preocess li:nth-child(2)').removeClass('active');
            $('.more-icon-preocess li:nth-child(3)').addClass('active');
            $('#strategy').removeClass('active');
            $('#optimization').addClass('active');
        })
            $('.optNext').click(function(){
              setTimeout(function(){   $('.fc-month-button').trigger('click'); }, 500);
            $('.more-icon-preocess li:nth-child(3)').removeClass('active');
            $('.more-icon-preocess li:nth-child(4)').addClass('active');
            $('#optimization').removeClass('active');
            $('#content').addClass('active');
        })
          $(".process-model li").click(function() { 
              $('.perent_icon li').removeClass('active');
              $(this).addClass('active');
          });
            $(".calender_icon li").click(function() { 
              $('.calender_icon li').removeClass('active');
              $(this).addClass('active');
          });
  
    });
$(document).ready(function() {
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
      editable: true,
      selectable: true,
      fixedWeekCount: false,
        timezone: false,
        events: {
            url: "https://www.hebcal.com/hebcal/?cfg=fc&v=1&maj=on&min=on&nx=on&year=now&month=x&ss=on&mf=on&d=on&s=on&lg=a",
            cache: true
        },
      select: function (start, end, jsEvent, view) {
         $('.date-actions').css('display','none');
         var datedays = $('.datedays').val();
         var weekenddays = $('.weekenddays').val();
         if(datedays == ''){
             toastr.warning('Price fields are required');
            return false;
         }
         if(weekenddays == ''){
             toastr.warning('Price fields are required');
            return false;
         }
         if(moment(start._d).add(1, 'days').format('YYYY-MM-DD')==moment(end._d).format('YYYY-MM-DD')){
        $(".fc-day-grid-event").attr("href",'javascript:void');
                    var start = convert(moment(start).format());
                    var end = convert(moment(end).format());
                    var a = start.split("-");
                    

                     $('.fc-day-number[data-date="'+start+'"]').html(a[2].replace(/^0+/, '')+'<div class="date-actions"><div class="date">'+start+'</div><ul><li><a data-target="#addEvent" data-toggle="modal" class="MainNavText" id="MainNavHelp" href="#addEvent">Add a manual booking</a></li><li><a  data-target="#blockModal" data-toggle="modal" class="MainNavText" id="MainNa" href="#blockModal">Block this date</a></li><li><a  data-target="#priceModal" data-toggle="modal" class="MainNavText changepricefin" id="MainNa" href="#priceModal" currentdata="'+start+'">Change Price</a></li></ul></div>');
                 
}
    },
     eventClick: function(event, element) {
                // Display the modal and set the values to the event values.
                if(event.title == 'Blocked'){
                $('#blockModal').modal('show');
                $('#blockModal').find('#titleblock').val(event.title);
                $('#blockModal').find('#starts-atblock').val(event.start);
                $('#blockModal').find('#ends-atblock').val(event.end);
                $('#blockModal').find('.eventClose').text('Delete');
                }else{
                $('#addEvent').modal('show');
                $('#addEvent').find('#title').val(event.title.split("$")[0]);
                $('#addEvent').find('#price-at').val(event.description);
                $('#addEvent').find('#starts-at').val(event.start);
                $('#addEvent').find('#ends-at').val(event.end);
                $('#addEvent').find('.eventClose').text('Delete');
              }
              $(".eventClose").click(function() {
                var startDate = new Date(convert(event.start));
                var endDate = new Date(convert(event.end));
                var disableDate = $('.disableDate').val();
                var y = disableDate.split('|');
                var removeItem = converts(event.start)+','+converts(event.end);
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
                var eachdate = $('.fc-widget-content[data-date="'+convert(between[0])+'"]').text()+'|'+convert(between[0])+',';
                var i;
                var str;
                var itemId = 0;
                for (i = 1; i < between.length; i++) {
                eachdate += $('.fc-widget-content[data-date="'+convert(between[i])+'"]').text()+'|'+convert(between[i])+',';
                }
              var removeItems = eachdate;
              x = $.grep(x, function(values) {
                return values != removeItems;
              });
              var updatedValu = x.join('|');
              $('#selectedPrice').val(updatedValu);

              $('#addEvent').find('input').val('');
              $('#blockModal').find('input').val('');
                 $('#blockModal').find('.eventClose').text('Close');
                $('#addEvent').find('.eventClose').text('Close');
              $('#calendar').fullCalendar('removeEvents',event._id);
              });
            }
              });
        $('#save-event').on('click', function() {
            var title = $('#title').val();
            var startd = new Date($('#starts-at').val());
            var endd = new Date($('#ends-at').val());

            if(title == ''){
            toastr.warning('Title field is required');
            return false;
            }
            if (title) {
                var eventData = {
                    title: title,
                    start: new Date($('#starts-at').val()),
                    end: new Date($('#ends-at').val())
                };

           var between = [];
            while (startd <= endd) {
                between.push(new Date(startd));
                startd.setDate(startd.getDate() + 1);
            }
            var eachdate = $('.fc-widget-content[data-date="'+convert(between[0])+'"]').text()+'|'+convert(between[0])+',';
            var i;
            var str;
            var itemId = 0;
            for (i = 1; i < between.length; i++) {
               eachdate += $('.fc-widget-content[data-date="'+convert(between[i])+'"]').text()+'|'+convert(between[i])+',';
            }

                 var disableDate = $('.disableDate').val();
                if(disableDate != ''){
                  disableDate = disableDate+'|'
                }
                   var dateprice =  $('#selectedPrice').val();
                   if(dateprice != ''){
                     dateprice = dateprice+'&';
                   }
                   $('#selectedPrice').val(dateprice+eachdate);
                   $('#date').val(convert(endd));
                  
                $('.disableDate').val(disableDate+converts($('#starts-at').val())+','+converts($('#ends-at').val()));
                $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
            }
            $('#calendar').fullCalendar('unselect');
             $('#addEvent').find('.eventClose').text('Close');
            $('#addEvent').find('input').val('');
            $('#addEvent').modal('hide');
            $('.date-actions').css('display','none');
        });
        $('#save-block-event').on('click', function() {
            var title = $('#titleblock').val();
            if (title) {
                var eventData = {
                    title: title,
                    start: $('#starts-atblock').val(),
                    end: $('#ends-atblock').val()
                };
                var disableDate = $('.disableDate').val();
                if(disableDate != ''){
                  disableDate = disableDate+'|'
                }
                $('.disableDate').val(disableDate+converts($('#starts-atblock').val())+','+converts($('#ends-atblock').val()));
                $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
            }
            $('#calendar').fullCalendar('unselect');
             $('#blockModal').find('.eventClose').text('Close');
            $('#blockModal').find('input').val('');
            $('#blockModal').modal('hide');
        });
    $('#datePrice').click(function(){
      
  setTimeout(function(){   $('.fc-month-button').trigger('click'); $(".fc-event").removeAttr("href"); }, 500);
    setTimeout(function(){ $(".fc-day-grid-event").attr("href",'javascript:void'); }, 1000); 
 
    });
$('.fc-next-button').click(function(){
   setTimeout(function(){ $(".fc-day-grid-event").attr("href",'javascript:void'); }, 1000); 
})
$('.fc-prev-button').click(function(){
   setTimeout(function(){$(".fc-day-grid-event").attr("href",'javascript:void'); }, 1000); 
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
  return [day,mnth,date.getFullYear()].join("/");
}

function convertss(str) {
  var date = new Date(str);
    mnth = ("0" + (date.getMonth() + 1)).slice(-2);
    day = ("0" + date.getDate()).slice(-2);
  return [mnth,day,date.getFullYear()].join("/");
}
$('#addRule').click(function(){
  $('#myModal').show();
});
    $('.dayCheck').click(function(){
       // alert('kails');
      if ($('#anyCheck').is(':checked')) {
            $("#anyCheck").prop('checked', false);
      }
    });
     $('#anyCheck').click(function(){
      // alert('fdgfdg');
      if ($('.dayCheck').is(':checked')) {
            $(".dayCheck").prop('checked', false);
      }
    });
      var click = 0;
    $('#saveRule').click(function(){
     
      var session = $('#fname').val();
      var startDate = $('#startDate').val();
      var endDate = $('#endDate').val();
      var price = $('#sesprice').val();
      if(session == ''){
        toastr.warning('Session name is required');
        return false;
      }
       if(startDate == ''){
        toastr.warning('Start date is required');
        return false;
      }
       if(endDate == ''){
        toastr.warning('End date is required');
        return false;
      }
       if(price == ''){
        toastr.warning('Price is required');
        return false;
      }
      var day ="";
      if ($('#anyCheck').is(':checked')) {
        var day = $('#anyCheck:checked').val();
      }
      var values = [];
      $('.dayCheck:checked').each(function(){
      values.push($(this).val());
      }); 
      if(day == ''){
      var days = values;
      }else{
        var days = day;
      }
      if(days == ''){
         toastr.warning('Check-in is required');
         return false;
      }
      $('.rule').append('<div class="sessionalRule sessionHide'+click+'" style="background-color:#DCDCDC"><p>'+session+'</p><p>Price per night' +price+'</p><p>'+startDate+'-'+endDate+'</p><p>Check-In '+days+' <i class="fa fa-trash" data='+click+' aria-hidden="true"></i><span class="rulEdit" edit-id='+click+'>Edit</span></p></div><input type="hidden" class="rulname'+click+'" value="'+session+'"><input type="hidden" class="rulStartDate'+click+'" value="'+convert(startDate)+'"><input type="hidden" class="rulendDate'+click+'" value="'+convert(endDate)+'"><input type="hidden" class="rulPrice'+click+'" value="'+price+'"><input type="hidden" class="rulDays'+click+'" value="'+days+'">'); 

      var sessionData =  $('#session').val();
      if(sessionData != ''){
      sessionData = sessionData+'&';
      }
      $('#session').val(sessionData+session+'|'+convert(startDate)+'|'+convert(endDate)+'|'+days+'|'+price);
      $('#date').val(convert(endDate));
      $('#price').val(price);
 click++;
    $( '#newsletterform' ).each(function(){
    this.reset();
});
 $('#myModal').hide();
    });
    $('.close').click(function(){
      $( '#newsletterform' ).each(function(){
    this.reset();
});
        $('#myModal').hide();
    });
 
  });

    var input = document.getElementById('autocomplete_area');
    var autocomplete = new google.maps.places.Autocomplete(input,{types: ['geocode']});
    google.maps.event.addListener(autocomplete, 'place_changed', function(){
        var place = autocomplete.getPlace();
        console.log(place);
        lat = place.geometry.location.lat();
        lon = place.geometry.location.lng();
        onPlaceChangedMapPicker(lat, lon);
    });
    $(function() {
        $('#autocomplete_area').keypress(function(e) {
            if(e.keyCode == 13) {
                console.log(map);
                console.log(marker);
                // onPlaceChangedMapPicker(45.0941315, -93.35634049999999);
                // initMapPicker([45.0941315, -93.35634049999999]);
            }
        });

        $('#listingForm').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                return false;
            }
        });
    });  
</script>

<script>
    $('#listingForm').ajaxForm({
        data: {
            'short_term_available_date' : function() {
                return $('#multi-date-select').multiDatesPicker('value');    
            }
        },
        dataType: 'json',
        beforeSubmit: function() {
            event.preventDefault();
            $('.fa-spinner').prop('display', 'inline');
            $('#submitBtn').prop('disabled', 'disabled');
        },
        success: function(arg) {
            toastr[arg.type](arg.text);
            $('.fa-spinner').prop('display', 'block');
            $('#submitBtn').removeAttr('disabled');
            if (arg.type == 'success') {
                window.location.href = '<?php echo site_url('property'); ?>';
            }
        }
    });
</script>
<script>
    $(".datepicker").datepicker({
        dateFormat: "yy-mm-dd",
        autoclose: true
    });
</script>
<script>
    function available_status_change(ele) {
        $('#available_date').val($.datepicker.formatDate('yy-mm-dd', new Date()));
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
            if(property_val == 'short term rent') {
                $('#multi-date').removeClass('d-none');
            }
            else {
                $('#multi-date').addClass('d-none');
            }
        });

        // check any selected user id
        getArr = JSON.parse('<?php echo json_encode($_GET); ?>');
        if(getArr.userid_for) {
            $('select[name="user_id"]').trigger('change');
        }
    });

    function attribute_desc(el) {
        var ph = $(el).find(':selected').data('desc') || 'Value';
        $(el).parents('div[id^=row_]').find('[name="value[]"]').attr('placeholder', ph);
    }

    function customTimeSet(elem){
        if($(elem).val() == 'custom'){
            $('#custom_div').show();
        } else {
            $('#custom_div').hide();
        }
    }

    $('select[name="user_id"]').on('change', function() {
        var pref = $('select[name="user_id"]').find('option:selected').data('pref');
        console.log(pref);
        reset_time(pref);
    });

    function reset_time(pref) {
        $('input[name="phone"], input[name="email"], input[name="sunday"], input[name="monday"], input[name="tuesday"], input[name="wednesday"], input[name="thursday"], input[name="friday"], input[name="saturday"]').prop('checked', false);
        $('select[name="time"]').val("");
        $('input[name="start_time"], input[name="end_time"]').val('');
        $('select[name="time"]').trigger("change");

        if(pref.contact_type) {
            contact_type_arr = pref.contact_type.split(',');
            $.each(contact_type_arr, function(i, v) {
                if($.inArray(v, contact_type_arr) > -1)
                    $('input[name="'+v+'"]').prop('checked', true);
            });
        }
        
        if(pref.day_of_the_weak) {
            day_of_the_weak_arr = pref.day_of_the_weak.split(',');
            $.each(day_of_the_weak_arr, function(i, v) {
                if($.inArray(v, day_of_the_weak_arr) > -1)
                    $('input[name="'+v+'"]').prop('checked', true);
            });
        }

        if(pref.from_time) {
            $('input[name="start_time"]').val(pref.from_time);
        }
        if(pref.to_time) {
            $('input[name="end_time"]').val(pref.to_time);
        }

        if(pref.time_of_day) {
            $('select[name="time"]').val(pref.time_of_day);
            $('select[name="time"]').trigger('change');
        }
        
    }
</script>

