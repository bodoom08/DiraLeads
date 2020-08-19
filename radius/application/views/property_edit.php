<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/top', [
    'title' => 'Property Edit'
]);
?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="<?php echo site_url('../assets/css/jquery-ui.multidatespicker.css') ?>">

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
                            <?php extract($property); ?>
                            <h3 class="heading">Property Details - <span style="font-size: 13px;"><?php echo 'ID: '.$property_details['id'].', '. $property_user_details['name'].', Email: '.$property_user_details['email']; ?></span></h3>
                            <div class="dashboard-message contact-2 bdr clearfix">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <?php echo form_open_multipart('property/update', 'id="updateForm" class=""'); ?>
                                        <div class="basic_information">
                                            <?php extract($property); ?>
                                            <div class="clearfix">
                                                <label class="radio-main"> Sell
                                                    <input type="radio" name="property" value="sale" <?php echo $property_details['for'] == 'sale' ? 'checked' : '' ?>>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="radio-main">Rent
                                                    <input type="radio" name="property" value="rent" <?php echo $property_details['for'] == 'rent' ? 'checked' : '' ?>>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="radio-main">Short term Rental
                                                    <input type="radio" name="property" value="short term rent" <?php echo $property_details['for'] == 'short term rent' ? 'checked' : '' ?>>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <input type="hidden" name="property_id" value="<?php echo $property_details['id'] ?>">
                                            <div class="">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <div class="row">
                                                            <div class="col-md-4 d-none">
                                                                <div class="form-group">
                                                                    <input type="text" placeholder="House No" class="form-control" name="house_no" value="<?php echo $property_details['house_number'] ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <input type="text" placeholder="Street" class="form-control" name="street" required value="<?php echo $property_details['street'] ?>">
                                                                </div>
                                                            </div>
                                                            <div class=" col-md-4 ">
                                                                <div class="form-group">
                                                                    <select name="area_id" class="form-control" required>
                                                                        <option value="">Select Area</option>
                                                                        <?php foreach ($areas as $key => $value) : ?>
                                                                            <option value="<?php echo $value['id'] ?>" <?php echo $property_details['area_id'] == $value['id'] ? 'selected' : '' ?>><?php echo $value['title'] ?></option> <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <select class="form-control" name="property_type" required>
                                                                        <option>Property Types</option>
                                                                        <option value="house" <?php echo $property_details['type'] == 'house' ? 'selected' : '' ?>>House</option>
                                                                        <option value="apartment" <?php echo $property_details['type'] == 'apartment' ? 'selected' : '' ?>>Apartment</option>
                                                                        <option value="duplex" <?php echo $property_details['type'] == 'duplex' ? 'selected' : '' ?>>Duplex</option>
                                                                        <option value="office" <?php echo $property_details['type'] == 'office' ? 'selected' : '' ?>>Office</option>
                                                                        <option value="other" <?php echo $property_details['type'] == 'other' ? 'selected' : '' ?>>Others</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <input type="text" placeholder="Price (USD)" class="form-control" name="price" value="<?php echo $property_details['price'] ?>" required>
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
                                                            <!-- <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <input type="text" placeholder="Date Available" class="form-control datepicker" name="available_date" id="available_date" value="<?php //echo $property_details['available_date'] ?>" required>
                                                                    <code><small>
                                                                            <a id="available" href="javascript:(0);" onclick="available_status_change(this);"> Available Now</a>
                                                                        </small></code>
                                                                </div>
                                                            </div> -->
                                                            <div class="col-md-4 ">
                                                                <div class="form-check">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <textarea class="form-control" placeholder="Property Description" name="property_desc" rows="1"><?php echo $property_details['description'] ?></textarea>
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
                                                    <h4 class="inner-title mb-3 ">Upload Photo </h4>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="browse_submit">
                                                                <span>Add Photos</span>
                                                                <label class="file">
                                                                    <input type="file" id="upload_file" onchange="preview_image();" name="userfile[]" aria-label="File browser example" multiple>
                                                                    <span class="file-custom"></span>
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
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4 class="inner-title mb-3 " style="padding-left: 0px;">How People can Contact me ?</h4>
                                                        <?php
                                                            $contact_type_arr = explode(',', $property_details['contact_type']);
                                                            $day_of_the_weak_arr = explode(',', $property_details['day_of_the_weak']);
                                                        ?>
                                                        <div class="custom-control custom-checkbox custom-control-inline">
                                                            <input type="checkbox" class="custom-control-input" id="phone" name="phone" value="on" <?php echo in_array('phone', $contact_type_arr) ? 'checked' : '';?>>
                                                            <label class="custom-control-label" for="phone">Phone</label>
                                                        </div>

                                                        <!-- Default inline 2-->
                                                        <div class="custom-control custom-checkbox custom-control-inline">
                                                            <input type="checkbox" class="custom-control-input" id="email" name="email" value="on" <?php echo in_array('email', $contact_type_arr) ? 'checked' : '';?>>
                                                            <label class="custom-control-label" for="email">Email</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4 class="inner-title mb-3 " style="padding-left: 0px;">Day of Week</h4>
                                                        <div class="custom-control custom-checkbox custom-control-inline">
                                                            <input type="checkbox" class="custom-control-input" id="sunday" name="sunday" value="on" <?php echo in_array('sunday', $day_of_the_weak_arr) ? 'checked' : '';?>>
                                                            <label class="custom-control-label" for="sunday">Sunday</label>
                                                        </div>

                                                        <!-- Default inline 2-->
                                                        <div class="custom-control custom-checkbox custom-control-inline">
                                                            <input type="checkbox" class="custom-control-input" id="monday" name="monday" value="on" <?php echo in_array('monday', $day_of_the_weak_arr) ? 'checked' : '';?>>
                                                            <label class="custom-control-label" for="monday">Monday</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox custom-control-inline">
                                                            <input type="checkbox" class="custom-control-input" id="tuesday" name="tuesday" value="on" <?php echo in_array('tuesday', $day_of_the_weak_arr) ? 'checked' : '';?>>
                                                            <label class="custom-control-label" for="tuesday">Tuesday</label>
                                                        </div>

                                                        <!-- Default inline 2-->
                                                        <div class="custom-control custom-checkbox custom-control-inline">
                                                            <input type="checkbox" class="custom-control-input" id="wednesday" name="wednesday" value="on" <?php echo in_array('wednesday', $day_of_the_weak_arr) ? 'checked' : '';?>>
                                                            <label class="custom-control-label" for="wednesday">Wednesday</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox custom-control-inline">
                                                            <input type="checkbox" class="custom-control-input" id="thursday" name="thursday" value="on" <?php echo in_array('thursday', $day_of_the_weak_arr) ? 'checked' : '';?>>
                                                            <label class="custom-control-label" for="thursday">Thursday</label>
                                                        </div>

                                                        <!-- Default inline 2-->
                                                        <div class="custom-control custom-checkbox custom-control-inline">
                                                            <input type="checkbox" class="custom-control-input" id="friday" name="friday" value="on" <?php echo in_array('friday', $day_of_the_weak_arr) ? 'checked' : '';?>>
                                                            <label class="custom-control-label" for="friday">Friday</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox custom-control-inline">
                                                            <input type="checkbox" class="custom-control-input" id="saturday" name="saturday" value="on" <?php echo in_array('saturday', $day_of_the_weak_arr) ? 'checked' : '';?>>
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
                                                                    <option value="24" <?php echo ($property_details['time_of_day'] == '24') ? 'selected' : ''; ?>>24 Hrs</option>
                                                                    <option value="custom" <?php echo ($property_details['time_of_day'] == 'custom') ? 'selected' : ''; ?> >Custom Time</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group" id="custom_div" style="display: none;">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <input type="time" class="form-control" placeholder="Start Time" name="start_time" value="<?php echo (!empty($property_details['from_time'])) ? date("H:i", strtotime($property_details['from_time'])) : ''; ?>">                                                                        
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input type="time" class="form-control" placeholder="End Time" name="end_time" value="<?php echo (!empty($property_details['to_time'])) ? date("H:i", strtotime($property_details['to_time'])) : ''; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="browse_submit">
                                                    <div class="clearfix"></div>
                                                    <button type="submit" id="updateBtn" class=" float-left view-all"><i class="fa fa-spinner fa-spin" style="display: none;"></i> Update property</button>
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
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $('#updateForm').ajaxForm({
        data: {
            'short_term_available_date' : function() {
                return $('#multi-date-select').multiDatesPicker('value');    
            }
        },
        dataType: 'json',
        beforeSubmit: function() {
            event.preventDefault();
            $('.fa-spinner').prop('display', 'inline');
            $('#updateBtn').prop('disabled', 'disabled');
        },
        success: function(arg) {
            $('#updateBtn').removeAttr('disabled');
            toastr[arg.type](arg.text);
            $('.fa-spinner').prop('display', 'block');
            if (arg.type == 'success') {
                window.location.href = '<?php echo site_url('property'); ?>';
            }
        }
    });
</script>
<script>
    $(".datepicker").datepicker({
        dateFormat: "dd/mm/yy",
        autoclose: true
    });
</script>
<script>
    function available_status_change(ele) {
        $('#available_date').val($.datepicker.formatDate('dd/mm/yy', new Date()));
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

        $datearr = '<?php echo $property['property_details']['short_term_available_date']; ?>';
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
            $('#image_preview').append("<div class='thumbnails_box mb_30 col-lg-2 col-md-4 col-6'><img src='" + URL.createObjectURL(event.target.files[i]) + "' width='100%' alt='' title='" + event.target.files[i].name + "'><i class='fa fa-window-close remove' onclick='removethis(this);'></i></div>");
        }
    }

    function removethis(ele) {
        $(ele).parent(".thumbnails_box").remove();
        var total_file = document.getElementById("upload_file").files.length;
        for (var i = 0; i < total_file; i++) {
            if (document.getElementById("upload_file").files[i].name === $(ele).parent(".thumbnails_box").find('img').attr('title')) {
                document.getElementById("upload_file").files.splice(i, 1);
                break;
            }
        }
    }
</script>
<script>
    var editData = <?php echo json_encode($property_attributes); ?>;
    editData.forEach(function(row, index) {
        $('[name="attribute_id[]"]:last').val(row.attribute_id);
        $('[name="value[]"]:last').val(row.value);
        if (editData.length !== (index + 1)) {
            $('#add').click();
        }
    });
</script>
<script>
    var editImage = <?php echo json_encode($property_images); ?>;
    editImage.forEach(function(row, index) {
        $('#image_preview').append("<div class='thumbnails_box mb_30 col-lg-2 col-md-4 col-6'><img src='" + '<?php echo site_url("../uploads/"); ?>' + row.path + "' width='100%' alt='' title='" + row.path + "'><i class='fa fa-window-close remove' onclick='removethis(this);'></i></div>");
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
</script>
