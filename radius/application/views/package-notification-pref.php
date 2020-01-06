<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/layout/top', [
    'title' => 'Pricing Plans'
]);
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@8/dist/sweetalert2.min.css" id="theme-styles">
<link rel="stylesheet" href="/assets/css/bootstrap-multiselect.css">
<link rel="stylesheet" href="/assets/css/jquery-ui.multidatespicker.css">
<div class="sub-banner overview-bgi">
</div>
<div class="pricing-table bg-grea">
    <div class="container">
        <div class="main-title text-center">
            <h1>Notification Preference</h1>
            <!-- <h1>Configurable Pricing Plans</h1> -->
        </div>
        <div class="row justify-content-md-center">
            <div class="col-lg-6 col-lg-offset-3">
                <?php
                    $arr = [
                        'class' => 'subscribeForm',
                        'name' => 'subscribeForm',
                        'id' => 'subscribeForm'
                    ];
                    echo form_open('pricing/subscribe_custom', $arr); ?>
                    <input type="hidden" name="subscribe_info"  value='<?php echo $subscribe_info; ?>'/>
                    <input type="hidden" name="subscribe_pref_info">
                <?php echo form_close(); ?>
                <form action="<?php echo site_url('pricing/update_package_notification_pref'); ?>" method="post" name="profile_time_pref" style="margin-left: 30px;" class="">
                    <?php
                        // echo '<pre>';
                        // print_r($subscribe_info);
                    ?>

                    <?php
                        $subscribe_info_arr = json_decode($subscribe_info);
                        for($i = 0; $i<$subscribe_info_arr->area_select_noof; $i++) :
                        $selected[]['selected'] = []; 
                    ?>
                        <div class="accordion mb-5" id="prefAccordion">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne_<?php echo $i+1; ?>" aria-expanded="true" aria-controls="collapseOne_<?php echo $i+1; ?>">
                                            Area <?php echo $i+1; ?>
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseOne_<?php echo $i+1; ?>" class="collapse show" aria-labelledby="headingOne" data-parent="#prefAccordion">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <h4 class="mb-3 " style="padding-left: 0px;"><i>Property Types</i></h4>
                                                <?php
                                                    $types_arr = explode(',', $user_package_pref[$i]->types);
                                                    $area_ids = explode(',', $user_package_pref[$i]->area_ids);
                                                ?>
                                                <select class="form-control custom-select multiselect" name="types_<?php echo $i; ?>[]" multiple="multiple">
                                                    <option <?php echo in_array('House', $types_arr) ? 'selected' : ''; ?>>House</option>
                                                    <option <?php echo in_array('Apartment', $types_arr) ? 'selected' : ''; ?>>Apartment</option>
                                                    <option <?php echo in_array('Duplex', $types_arr) ? 'selected' : ''; ?>>Duplex</option>
                                                    <option <?php echo in_array('Office', $types_arr) ? 'selected' : ''; ?>>Office</option>
                                                    <option <?php echo in_array('Other', $types_arr) ? 'selected' : ''; ?>>Other</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <h4 class="mb-3 " style="padding-left: 0px;"><i>Area</i></h4>                   
                                                <select name="area_<?php echo $i; ?>" class="form-control custom-select">
                                                    <option value="" selected disabled>Select Area Name</option>
                                                    <?php foreach ($areas as $key => $value) : ?>
                                                        <option value="<?php echo $value['id'] ?>" <?php echo in_array($value['id'], $area_ids) ? 'selected' : ''; ?>><?php echo $value['title'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <h4 class="mb-3 " style="padding-left: 0px;"><i>Minimum Price ($)</i></h4>
                                                <input type="number" class="form-control numericOnly" name="price_min_<?php echo $i; ?>" autocomplete="off" placeholder="Min Price" value="<?php echo $user_package_pref[$i]->price_min; ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <h4 class="mb-3 " style="padding-left: 0px;"><i>Maximum Price ($)</i></h4>
                                                <input type="text" class="form-control numericOnly" name="price_max_<?php echo $i; ?>" autocomplete="off" placeholder="Max Price" value="<?php echo $user_package_pref[$i]->price_max; ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="upload_media mt-2" id="dynamic_field_<?php echo $i; ?>" data-row="<?php echo $i; ?>">
                                                    <h4 class="inner-title mb-3 ">Property Attribute </h4>
                                                    <div class="row" id="row_1">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <select name="attribute_id_<?php echo $i; ?>[]" id="attribute_1" class="form-control" onchange="attribute_desc(this)">
                                                                    <?php foreach ($attributes as $key => $value): ?>
                                                                        <option value="<?php echo $value['id'] ?>" data-desc="<?php echo $value['description']; ?>"><?php echo $value['text'] ?></option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="text" placeholder="Description" class="form-control" name="value_<?php echo $i; ?>[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <button class="btn btn-success btn-xs addProp" id="add" type="button" title="Add Attribute"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php
                        endfor;
                    ?>

                    <div class="row d-none">
                        <div class="col-md-12">
                            <h4 class="mb-3 " style="padding-left: 0px;"><i>Notification type</i></h4>
                            <div class="row align-items-center justify-content-center">
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="phone" name="phone" <?php echo ($user_pref->notification_phone == 'active') ? 'checked="checked"': ''; ?>>
                                        <label class="custom-control-label" for="phone">Phone No</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <?php if ($user_pref->notification_phone == 'active') { ?>
                                        <input type="text" class="form-control numericOnly" maxlength="10" id="phone_no_checked" name="phone_no_checked" value="<?php echo $user_pref->notification_phone_no; ?>" placeholder="Enter Phone no">
                                    <?php } else { ?>
                                        <input type="text" class="form-control numericOnly" maxlength="10" id="phone_no_checked" name="phone_no_checked" readonly placeholder="Enter Phone no">
                                    <?php } ?>

                                </div>
                            </div>

                            <div class="row align-items-center justify-content-center mt-3">
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="email" name="email"
                                        <?php echo ($user_pref->notification_email == 'active') ? 'checked="checked"': ''; ?>>
                                        <label class="custom-control-label" for="email">Email ID </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <?php if ($user_pref->notification_fax == 'active') { ?>
                                        <input type="email" class="form-control" id="email_checked" name="email_checked" value="<?php echo $user_pref->notification_email_id; ?>" placeholder="Enter Email ID">
                                    <?php } else { ?>
                                        <input type="email" class="form-control" id="email_checked" name="email_checked" readonly placeholder="Enter Email ID">
                                    <?php } ?>
                                    
                                </div>
                            </div>

                            <div class="row align-items-center justify-content-center mt-3">
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="fax" name="fax" <?php echo ($user_pref->notification_fax == 'active') ? 'checked="checked"': ''; ?>>
                                        <label class="custom-control-label" for="fax">Fax No</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <?php if ($user_pref->notification_fax == 'active') { ?>
                                        <input type="fax" class="form-control numericOnly" id="fax_checked" name="fax_checked" value="<?php echo $user_pref->notification_fax_no; ?>" placeholder="Enter Fax No">
                                    <?php } else { ?>
                                        <input type="fax" class="form-control numericOnly" id="fax_checked" name="fax_checked" readonly placeholder="Enter Fax No">
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                    </div>                  

                    <div class="row d-none">
                        <div class="col-md-12">
                            <h4 class="inner-title mb-3 mt-3" style="padding-left: 0px;">Frequence</h4>
                            <div class="clearfix">
                                <label class="radio-main"> Daily
                                    <input type="radio" checked="checked" name="frequence" value="daily" <?php echo ($user_pref->notification_frequence == 'daily') ? 'checked' : ''; ?>>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="radio-main">Weakly
                                    <input type="radio" name="frequence" value="weakly" <?php echo ($user_pref->notification_frequence == 'weakly') ? 'checked' : ''; ?>>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="radio-main">Monthly
                                    <input type="radio" name="frequence" value="monthly" <?php echo ($user_pref->notification_frequence == 'monthly') ? 'checked' : ''; ?>>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="radio-main">Annually
                                    <input type="radio" name="frequence" value="annually" <?php echo ($user_pref->notification_frequence == 'annually') ? 'checked' : ''; ?>>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <?php if($subscribe_info_arr->area_select_noof > 0) : ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="send-btn mb-3">
                                <button type="submit" class="btn btn-sm button-theme">Update Notification Preference</button>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
            <div class="col-lg-3 d-none" id="multi-date" style="position: -webkit-sticky; /* Safari */ position: sticky; top: 90px; height: 100%;">
                <div class="col-md-12">
                    <div class="form-group">
                        <code><small style="font-size: 15px;">
                            <b>Listing Notification Date</b>
                            </small></code>
                        <span id="multi-date-select" />
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="clearfix">
            
        </div>
    </div>
</div>
<?php $this->load->view('common/layout/bottom'); ?>


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/assets/js/jquery-ui.multidatespicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<!-- Include the plugin's CSS and JS: -->
<script type="text/javascript" src="/assets/js/bootstrap-multiselect.js"></script>
<script>
    // var $user_packages;
    // $user_packages = JSON.parse('<?php //echo json_encode($user_packages); ?>');

    $(function() {
        $user_package_pref_attrs = JSON.parse('<?php echo json_encode($user_package_pref_attrs); ?>');
        arr_length = $user_package_pref_attrs.length;
        $subscribe_info = JSON.parse('<?php echo $subscribe_info; ?>');
        // console.log($subscribe_info);
        action = $subscribe_info.action;
        row = 0;
        // console.log($user_package_pref_attrs);
        $($user_package_pref_attrs).each(function(k, item) {
            index = 0;
            $(item).each(function(i, v) {
                index++;
                var el_first_button = $(`#dynamic_field_${row} #row_1`).find('button');                   
                var el = $(`#dynamic_field_${row} .row:last-child`);
                $(el).find(`select[name="attribute_id_${row}[]"]`).val(v.attribute_id);
                $(el).find(`input[name="value_${row}[]"]`).val(v.value);
                    if(index < item.length) {
                        $(el_first_button).trigger('click');
                    }
                    else {
                        if(action == 'renew') {
                                $(el_first_button).remove();
                            $('button.btn_remove').remove();
                            $('select').prop('disabled', true);
                            $('input[type="radio"]').prop('disabled', true);
                        }                
                    }
            });
            row++;
        });
        $input_disable = <?php echo $input_disable; ?>;
        if(typeof $input_disable != "undefined" && $input_disable == true) {
            $('select, input, textarea').prop('readonly', true);
            // $('select[name="types[]"]').prop('disabled', true);
            $('input[type="checkbox"]').prop('disabled', true);
        }

        $('.multiselect').multiselect();

        $('#multi-date-select').multiDatesPicker({
            minDate: 0, // today
            // maxDate: 30, // +30 days from today
            dateFormat: "yy-mm-dd",
        });

        if($subscribe_info['pack_name'] == 'short term rent') {
            $('#multi-date').removeClass('d-none');
        }
        else {
            $('#multi-date').addClass('d-none');
        }

        $datearr = $subscribe_info.short_term_available_date;
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

    $('form[name="profile_time_pref"]').ajaxForm({
        data: {
            subscribe_info: '<?php echo $subscribe_info; ?>',
            'short_term_available_date' : function() {
                return $('#multi-date-select').multiDatesPicker('value');    
            },
            <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
        },
        dataType: 'JSON',
        success: function(arg) {
            if(arg.type != "success")
                toastr[arg.type](arg.text);
            if (arg.type == 'success') {
                toastr['success']('We are going to redirect you to the payment gateway, Please wait...');
                $subscribe_info = JSON.parse('<?php echo $subscribe_info; ?>');
                $subscribe_info.short_term_available_date = arg.short_term_available_date;
                $('input[name="subscribe_info"]').val(JSON.stringify($subscribe_info));
                $('input[name="subscribe_pref_info"]').val(JSON.stringify(arg.notify_package_pref));

                setTimeout(() => {
                    $('#subscribeForm').submit();
                }, 2000);
            }
        }
    });


    $(document).on('change', 'input[type="checkbox"]', function(e){
        //do your stuff here
        checkbox = $(e.target);
        if($(checkbox).prop('checked') == true) {
            $(checkbox).closest('.row').find('input[type="text"],input[type="email"],input[type="fax"]').prop('readonly', false).focus();
        }
        else
            $(checkbox).closest('.row').find('input[type="text"],input[type="email"],input[type="fax"]').prop('readonly', true).val('');
    });

    $("body .numericOnly").keypress(function (e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
    });

    function addPref() {
        console.log('Add Pref Button');
    }
</script>

<script>
    var i = 1;
    var attributes = <?php echo json_encode($attributes); ?>;
    var selected_arr = JSON.parse('<?php echo json_encode($selected); ?>');
    // console.log(selected_arr);
    $('body').on('click', '.addProp', function() {
        i++;
        var thisBtn = $(this);
        dynamic_field = $(this).closest('.upload_media');
        row = $(dynamic_field).data('row');
        $(dynamic_field).append(function() {
            selected_arr[row].selected = [];
            selected = selected_arr[row].selected;
            $(dynamic_field).find('[name="attribute_id_'+row+'[]"]').each(function() {
                selected.push(this.value)
            });
            options = '';
            if (attributes.length == selected.length) {
                $(thisBtn).prop('disabled', 'true');
                return '';
            } else {
                $(thisBtn).removeAttr('disabled');
            }
            attribute_id_no = '';
            attributes.forEach(function(attribute) {
                if (selected.indexOf(attribute.id) < 0) {
                    attribute_id_no = attribute.id;
                    options += `<option value="${attribute.id}" data-desc="${attribute.description}">${attribute.text}</option>`;
                }
            });
            if(options == '') {
                return false;
            }
            return `
            <div class="row" id="row_` + i + `">
            <div class="col-md-4">
            <div class="form-group">
            <select name="attribute_id_${row}[]" id="attribute_` + i + `" class="form-control" onchange="attribute_desc(this)">
            ${options}
            </select>
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
            <input type="text" placeholder="Attribute Value" class="form-control" name="value_${row}[]">
            </div>
            </div>
            <div class="col-md-4">
            <button class="btn btn-danger btn-xs btn_remove" id="` + i + `" type="button" title="Dismiss Attribute"><i class="fa fa-times"></i></button>
            </div>
            </div>
            `;
        });
        // $("#attribute_" + i + "").trigger('change');
    });


    $(document).on('click', '.btn_remove', function() {
        // $('#add').removeAttr('disabled');
        var thisBtn = $(this);
        dynamic_field = $(this).closest('.upload_media');
        addPropButton = $(dynamic_field).find('.addProp');
        $(addPropButton).removeAttr('disabled');
        row = $(dynamic_field).data('row');
        var button_id = $(thisBtn).attr("id");
        console.log(selected_arr);
        $('#row_' + button_id + '').remove();
    });

    function attribute_desc(el) {
        var ph = $(el).find(':selected').data('desc') || 'Value';
        $(el).parents('div[id^=row_]').find('[name="value[]"]').attr('placeholder', ph);
    }
</script>

