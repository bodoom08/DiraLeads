<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/top', [
    'title' => 'Property Edit'
]);
?>
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
                                                            <div class="col-md-4">
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
                                                                        <option value="appartment" <?php echo $property_details['type'] == 'appartment' ? 'selected' : '' ?>>Apartment</option>
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
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <input type="text" placeholder="Date Available" class="form-control datepicker" name="available_date" id="available_date" value="<?php echo $property_details['available_date'] ?>" required>
                                                                    <code><small>
                                                                            <a id="available" href="javascript:(0);" onclick="available_status_change(this);"> Available Now</a>
                                                                        </small></code>
                                                                </div>
                                                            </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $('#updateForm').ajaxForm({
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
        $('#image_preview').append("<div class='thumbnails_box mb_30 col-lg-2 col-md-4 col-6'><img src='" + '<?php echo site_url('uploads/') ?>' + row.path + "' width='100%' alt='' title='" + row.path + "'><i class='fa fa-window-close remove' onclick='removethis(this);'></i></div>");
    });
</script>
