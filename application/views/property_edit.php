<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/front_end_layout/top', [
    'title' => 'List Your Property'
]);

?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<link rel="stylesheet" href="<?php echo site_url('assets/css/jquery-ui.multidatespicker.css') ?>">
<div class="dashboard">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12 col-pad">
                <div class="dashboard-nav d-none d-xl-block d-lg-block">
                    <?php $this->load->view('common/front_end_layout/sidebar'); ?>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 col-sm-12 col-pad">
                <div class="content-area5">
                    <div class="dashboard-content">
                        <div class="dashboard-list">
                            <?php extract($property); ?>
                            <h3 class="heading">Property Details</h3>
                            <div class="dashboard-message contact-2 bdr clearfix">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                    <ul class="nav nav-tabs process-model more-icon-preocess" role="tablist">
                  <li role="presentation1" class="active"><a href="#discover" aria-controls="" role="tab" data-toggle="tab"><i class="fa fa-home" aria-hidden="true"></i>
                    <p>Add a Property</p>
                    </a></li>
                  <li role="presentation2"><a href="#strategy" aria-controls="" role="tab" data-toggle="tab"><i class="fa fa-bed" aria-hidden="true"></i>
                    <p>Amenities</p>
                    </a></li>
                  <li role="presentation3"><a href="#optimization" aria-controls="" role="tab" data-toggle="tab"><i class="fa fa-picture-o" aria-hidden="true"></i>
                    <p>Upload Picture</p>
                    </a></li>
                  <li role="presentation4"><a href="#content" aria-controls="" role="tab" data-toggle="tab"><i class="fa fa-calendar" aria-hidden="true"></i>
                    <p>Dates & Price</p>
                    </a></li>
                </ul>

 <?php echo form_open_multipart('my_rentals/update', 'id="updateForm" class=""'); ?>
 <div class="tab-content">
               
                  <div role="tabpanel" class="tab-pane active" id="discover">
                    <div class="design-process-content">
                        <div class="tabbbing-one">
                            <ul class="row">
                                <li class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Property Type</label>
                                        <select class="form-control" name="property_type" id="exampleFormControlSelect1">
                                          <option value="apartment" <?php echo $property_details['type'] == 'apartment' ? 'selected' : '' ?>>Apartment</option>
                                          <option value="basement" <?php echo $property_details['type'] == 'basement' ? 'selected' : '' ?>>Basement</option>
                                          <option value="house" <?php echo $property_details['type'] == 'house' ? 'selected' : '' ?>>House</option>
                                          <option value="duplex" <?php echo $property_details['type'] == 'duplex' ? 'selected' : '' ?>>Duplex</option>
                                          <option value="villa" <?php echo $property_details['type'] == 'villa' ? 'selected' : '' ?>>Villa</option>
                                        </select>
                                    </div>
                                </li>
                                <li class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Address</label>
                                        <input type="text" id="geoLocation" name="street" rows="2" value="<?php echo $property_details['street'] ?>" class="form-control md-textarea" placeholder="">
                                    </div>
                                </li>
                                <li class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Neighborhood</label>
                                      <select class="form-control" name="area_id" id="exampleFormControlSelect1">
                                        <?php foreach ($areas as $key => $value) : ?>
                                        <option value="<?php echo $value['id'] ?>" <?php echo $property_details['area_id'] == $value['id'] ? 'selected' : '' ?>><?php echo $value['title'] ?></option> <?php endforeach; ?>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                            
                           <!--   <ul class="row">
                             <?php foreach ($attributes as $key => $value) : 
                             if($value['text'] == 'Bedroom' || $value['text'] == 'Bathroom' || $value['text'] == 'Floor' || $value['text'] == 'Basement'){
                              if($value['text'] == 'Floor'){
                                $class = 'floor';
                                $onkey = 'onkeyup="myFunction()"';
                              }elseif($value['text'] == 'Basement'){
                                $class = 'basement';
                                $onkey = 'onkeyup="myFunctionb()"';
                              }else{
                                $onkey = '';
                                $class = '';
                              }

                             ?>
                                <li class="col-lg-3">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1"><?php if($value['text'] == 'Floor'){echo $value['text'].' '.'Number'; }else{ echo $value['text'];} ?></label>
                                        <input type="hidden" name="attribute_id[]" class="<?php echo $class; ?>"  value="<?php echo $value['id'] ?>">
                                        <input type="number" class="att<?php echo $value['text'] ?> <?php echo $class; ?>" id="<?php echo $class; ?>" placeholder="<?php if($value['text'] == 'Floor'){echo $value['text'].' '.'Number'; }else{ echo $value['text'];} ?>" class="form-control" value="" name="value[]" <?php echo $onkey; ?>>
                                    </div>
                                </li>

                                 <?php } endforeach; ?>
                            </ul> -->

                                   <ul class="row">
                                <li class="col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Bedrooms</label>
                                        <input type="hidden" name="attribute_id[]" value="1">
                                        <input type="number" placeholder="Bedrooms" class="form-control attBedroom" name="value[]">
                                    </div>
                                </li>
                                <li class="col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Bathrooms</label>
                                        <input type="hidden" name="attribute_id[]" value="2">
                                        <input type="number" placeholder="Bathrooms" class="form-control attBathroom" name="value[]">
                                    </div>
                                </li>
                                     <li class="col-lg-4">
                                    <div class="form-group">
                                      <label for="exampleFormControlSelect1">Floor Number</label>
                                      <select class="form-control" name="attribute_id[]" id="florbas">
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
                            </ul>

                            <ul class="row">
                                <li class="col-lg-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Discriptions</label>
                                        <textarea type="text" id="message" name="property_desc" rows="2" class="form-control md-textarea" placeholder=""> <?php echo $property_details['description'] ?> </textarea>
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
                    if($property_details['amenities']){
                    $amenities= explode(',',$property_details['amenities']);
                    } ?>
                  <div role="tabpanel" class="tab-pane" id="strategy">
                    <div class="design-process-content">
                        <div class="tabbbing-one two">
                            <ul class="amnity">
                                <li>
                                    <h4>Indoor amenities</h4>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Elevator" id="customCheck2"  <?php if (in_array('Elevator', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck2">Elevator</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Wheelchair Accessible" id="customCheck3"  <?php if (in_array('Wheelchair Accessible', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck3">Wheelchair Accessible</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Air Conditioning" id="customCheck4"  <?php if (in_array('Air Conditioning', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck4">Air Conditioning</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Heating" id="customCheck5"  <?php if (in_array('Heating', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck5">Heating</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Linen and Towels" id="customCheck6"  <?php if (in_array('Linen and Towels', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck6">Linen and Towels</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Washing Machine" id="customCheck7"  <?php if (in_array('Washing Machine', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck7">Washing Machine</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Dryer" id="customCheck8"  <?php if (in_array('Dryer', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck8">Dryer</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Kid-friendly" id="customCheck9"  <?php if (in_array('Kid-friendly', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck9">Kid-friendly</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Crib" id="customCheck10"  <?php if (in_array('Crib', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck10">Crib</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="High Chair" id="customCheck11"  <?php if (in_array('High Chair', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck11">High Chair</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Wi-Fi" id="customCheck12"  <?php if (in_array('Wi-Fi', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck12">Wi-Fi</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Hair dryer" id="customCheck13"  <?php if (in_array('Hair dryer', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck13">Hair dryer</label>
                                    </div>
                                </li>
                                <li>
                                    <h4>Outdoor amenities</h4>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Garden/backyard" id="customCheck14"  <?php if (in_array('Garden/backyard', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck14">Garden/backyard</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Porch/Balcony" id="customCheck15"  <?php if (in_array('Porch/Balcony', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck15">Porch/Balcony</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Parking" id="customCheck16" <?php if (in_array('Parking', $amenities)){echo 'checked';} ?> >
                                      <label class="custom-control-label" for="customCheck16">Parking</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Pool" id="customCheck17"  <?php if (in_array('Pool', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck17">Pool</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Sukkah" id="customCheck18"  <?php if (in_array('Sukkah', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck18">Sukkah</label>
                                    </div>
                                    
                                </li>
                                <li>
                                     <h4>Kitchen Amenities</h4>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Pesach Kitchen" id="customCheck19"  <?php if (in_array('Pesach Kitchen', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck19">Pesach Kitchen</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Refrigerator" id="customCheck20"  <?php if (in_array('Refrigerator', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck20">Refrigerator</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Freezer" id="customCheck21"  <?php if (in_array('Freezer', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck21">Freezer</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Stove" id="customCheck22"  <?php if (in_array('Stove', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck22">Stove</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Oven" id="customCheck23"  <?php if (in_array('Oven', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck23">Oven</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Microwave" id="customCheck24"  <?php if (in_array('Microwave', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck24">Microwave</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Hot-Plate/Plata" id="customCheck25"  <?php if (in_array('Hot-Plate/Plata', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck25">Hot-Plate/Plata</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Shabbos Kettle/Urn" id="customCheck26"  <?php if (in_array('Shabbos Kettle/Urn', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck26">Shabbos Kettle/Urn</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Cooking Utensils" id="customCheck27"  <?php if (in_array('Cooking Utensils', $amenities)){echo 'checked';} ?>>
                                      <label class="custom-control-label" for="customCheck27">Cooking Utensils</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" name="amenities[]" value="Coffee Machine" id="customCheck28"  <?php if (in_array('Coffee Machine', $amenities)){echo 'checked';} ?>>
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
                  </div>
                      <div role="tabpanel" class="tab-pane" id="content">
                        <div class="design-process-content">
                            <div class="tabbbing-one two">
                                <ul class="row">
                                    <li class="col-lg-6">
                                         <div class="form-group">
                                            <label for="exampleFormControlSelect1">Date</label>
                                            <input type="date" id="date" name="date" value="<?php echo $property_details['available_date'] ?>" class="form-control" placeholder="">
                                        </div>
                                    </li>
                                    <li class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Price</label>
                                            <input type="text" id="name" value="<?php echo $property_details['price'] ?>" name="price" class="form-control" placeholder="">
                                        </div>
                                    </li>
                                    
                                </ul>
                                  <input type="hidden" name="property_id" value="<?php echo $property_details['id'] ?>">
                                    <div class="tabing-action">
                                        <ul>
                                            <li class="submitnext"><button id="updateBtn" type="submit">Finish</button>
                                            <!-- <li class="submitnext"><a data-toggle="modal" data-target="#exampleModal">Review</a> -->
                                        </ul>
                                    </div>
                            </div>
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
<?php $this->load->view('common/front_end_layout/bottom'); ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo site_url('assets/js/jquery-ui.multidatespicker.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <script>
      function initMap() {
   
        var input = document.getElementById('geoLocation');

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.setFields(
            ['address_components', 'geometry', 'icon', 'name']);

      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPhDpAUyER52TsCsLFNOOxT_l5-y7e78A&libraries=places&callback=initMap"
        async defer></script>
<script>
    window.removeFileName = [];
    $('#updateForm').ajaxForm({
        data: {
            'short_term_available_date' : function() {
                return $('#multi-date-select').multiDatesPicker('value');    
            }
        },
        dataType: 'json',
        beforeSubmit: function(formData, jqForm, options) {
            event.preventDefault();
            formData.push({ name: 'removeFileName', value: JSON.stringify(removeFileName) });
            $('.fa-spinner').prop('display', 'inline');
            $('#updateBtn').prop('disabled', 'disabled');
        },
        success: function(arg) {
            $('#updateBtn').removeAttr('disabled');
            toastr[arg.type](arg.text);
            $('.fa-spinner').prop('display', 'block');
            if (arg.type == 'success') {
                window.location.href = '<?php echo site_url('my_rentals'); ?>';
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
    var attributes = <?php echo json_encode($attributes) ?>;
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
        $('select[name="time"]').trigger('change');
        // setTimeout(() => {
        // }, 100);

        window.$property_id = '<?php echo $property_details['id']; ?>';

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
        $('input[name="property"]').each(function(i, item) {
            if($(item).prop('checked') == true) {
                $(this).trigger('change');
            }            
        }); 


        //  to set the multi select date value
        // $datearr = ['2019-09-25','2019-09-28','2019-10-05','2019-10-15','2019-09-24'];
        $datearr = '<?php echo $property['property_details']['short_term_available_date']; ?>';
        if($datearr == "") {
            return false;
        }
        $datearr = $datearr.split(',');
        $datearr.map(function(v, i) {
            $datearr[i] = $.trim(v);
        });
        if($datearr.length > 1) {
            $datelist = $datearr.slice(1, $datearr.length);
            $('#multi-date-select').multiDatesPicker('value', $datelist.join(', '));
        }
        $('#multi-date-select').multiDatesPicker('toggleDate', $datearr[0]);
    });

    function attribute_desc(el) {
        var ph = $(el).find(':selected').data('desc') || 'Value';
        $(el).parents('div[id^=row_]').find('[name="value[]"]').attr('placeholder', ph);
    }
</script>
<script>
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

    // function removethis(ele) {
    //     var total_file = document.getElementById("upload_file").files.length;
    //     console.log(total_file);
    //     for (var i = 0; i < total_file; i++) {
    //         if (document.getElementById("upload_file").files[i].name === $(ele).parent(".thumbnails_box").find('img').attr('title')) {
    //             delete document.getElementById("upload_file").files[i];
    //             console.log(document.getElementById("upload_file").files);
    //             console.log(document.getElementById("upload_file").files);
    //             $(ele).parent(".thumbnails_box").remove();
    //             break;
    //         }
    //     }
    // }
</script>
<script>
    var editData = <?php echo json_encode($property_attributes); ?>;
    console.log(editData);
    editData.forEach(function(row, index) {
        // $('.attBedroom').val(row.attribute_id);
        if(row.text == "Bedroom"){
            $('.attBedroom').val(row.value);
        }
        if(row.text == "Bathroom"){
         $('.attBathroom').val(row.value);
     }
         if(row.text == "Floor"){
          var html = '<option value="8">Basement</option><option value="6"'; if(row.value == 1){ html+='selected'; } html+='>1</option><option value="6" '; if(row.value == 2){ html+='selected'; } html+='>2</option><option value="6" '; if(row.value == 3){ html+='selected'; } html+='>3</option><option value="6"';if(row.value == 4){ html+='selected'; }html+='>4</option><option value="6"'; if(row.value == 5){ html+='selected'; } html+='>5</option><option value="6" '; if(row.value == 6){ html+='selected'; } html+='>6</option><option value="6" '; if(row.value == 7){ html+='selected'; } html+='>7</option><option value="6"'; if(row.value == 8){ html+='selected'; } html+='>8</option><option value="6" '; if(row.value == 9){ html+='selected'; } html+='>9</option><option value="6" '; if(row.value == 10){ html+='selected'; } html+='>10+</option>';
          $('.floor').val(row.value);
          $('#florbas').html(html);
      }
        if(row.text == "Basement"){
           var html = '<option value="8" selected>Basement</option><option value="6">1</option><option value="6">2</option><option value="6">3</option><option value="6">4</option><option value="6">5</option><option value="6">6</option><option value="6">7</option><option value="6">8</option><option value="6">9</option><option value="6">10+</option>';
          $('.floor').val(row.value);
         $('#florbas').html(html);
      }
        if (editData.length !== (index + 1)) {
            $('#add').click();
        }
    });
       $(document).on('change','#florbas',function(){
     var val = $(this).val();
       // var text = $(this).text();
       var selectedText = $( "#florbas option:selected" ).text();
     if(val == 8){
       $('.floor').val('1');
     }else{
        $('.floor').val(selectedText);
     }
    })
</script>
<script>
    var editImage = <?php echo json_encode($property_images); ?>;
    editImage.forEach(function(row, index) {
        $('#image_preview').append("<div class='thumbnails_box'><img src='" + '<?php echo site_url('uploads/') ?>' + row.path + "' width='100%' alt='' title='" + row.path + "'><i class='fa fa-window-close remove' onclick=removethis(this);></i></div>");
    });
</script>
<script>
    function customTimeSet(elem){
        if($(elem).val() == 'custom'){
            $('#custom_div').show();
        } else {
            $('#custom_div').hide();
        }
    }
        $(document).ready(function(){
            var date = "<?php echo $_SESSION['forDate']?>";
            if(date != ''){
            $('.more-icon-preocess li:first').removeClass('active');
           
             $('#discover').removeClass('active');
              $('.more-icon-preocess li:nth-child(4)').addClass('active');
            $('#content').addClass('active');
            }
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
            $('.more-icon-preocess li:nth-child(3)').removeClass('active');
            $('.more-icon-preocess li:nth-child(4)').addClass('active');
            $('#optimization').removeClass('active');
            $('#content').addClass('active');
        })
        $(".process-model li").click(function() { 
              $('.process-model li').removeClass('active');
              $(this).addClass('active');
          });
    })
</script>
