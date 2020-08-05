<?php defined('BASEPATH') or exit('No direct script access allowed');
    
    $this->load->view('common/top', [
                      'title' => 'Properties'
                      ]);
    ?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
  <link rel="stylesheet" href="//unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
    <link rel="stylesheet" href="<?php echo site_url('../assets/css/jquery-ui.multidatespicker.css') ?>">
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
                        <?php echo form_open_multipart('property/property_listing', 'id="listingForm" class=""'); ?>
                        <div class="basic_information">
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

