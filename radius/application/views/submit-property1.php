<?php defined('BASEPATH') or exit('No direct script access allowed');
    
    $this->load->view('common/top', [
                      'title' => 'Properties'
                      ]);
    ?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
  <link rel="stylesheet" href="//unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
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
                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="col-md-7">
                                      <div class="row">
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <input type="text" placeholder="House No" class="form-control" name="house_no" required>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <input type="text" placeholder="Street" class="form-control" name="street" required>
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
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <input type="text" placeholder="Date Available" class="form-control datepicker" name="available_date" id="available_date" required>
                                                  <code><small>
                                                          <a id="available" href="javascript:(0);" onclick="available_status_change(this);"> Available Now</a>
                                                      </small></code>
                                              </div>
                                          </div>
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
          <p class="sub-banner-2 text-center">© Copyright 2020. All rights reserved</p>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('common/bottom'); ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
    var initMapPicker = (latLng) => {
        var mapPicker = L.map('map-picker', {
            center: latLng,
            zoom: 15
        });

        $('#lat_lng').val(`${latLng[0]}|${latLng[1]}`);

        L.tileLayer('https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}{r}.png?lang=en', {
            attribution: 'Map Data &copy; <a href="https://wikimediafoundation.org/wiki/Maps_Terms_of_Use">Wikimedia</a>'
        }).addTo(mapPicker);

        var marker = L.marker(latLng, {
            draggable: true,
            autoPan: true
        }).addTo(mapPicker);

        marker.on('dragend', (e) => {
            var newLatLng = marker.getLatLng()
            $('#lat_lng').val(`${newLatLng.lat}|${newLatLng.lng}`);
        });
    };

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
            initMapPicker([pos.coords.latitude, pos.coords.longitude]);
        });
    } else {
        initMapPicker([40.71427, -74.00597]);
        toastr.info('Geolocation is not supported by this browser. Defaults to New York');
    }
</script>

<script>
    $('#listingForm').ajaxForm({
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
    });

    function attribute_desc(el) {
        var ph = $(el).find(':selected').data('desc') || 'Value';
        $(el).parents('div[id^=row_]').find('[name="value[]"]').attr('placeholder', ph);
    }
</script>

