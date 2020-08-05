<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/front_end_layout/top', [
    'title' => 'My Preferences'
]);
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
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
                            <div class="row">
                                <div class="col-lg-12">
                                    <h3 class="heading" style="border-bottom:0px;"> My Preferences</h3>
                                    <p class="text-info pl-4" style="font-size: 15px; width: 100%;">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-square-o fa-stack-2x"></i>
                                        <i class="fa fa-info fa-stack-1x"></i>
                                    </span>&nbsp;&nbsp;N.B- This preference is used, how people would contact you for the property listing when you subscribed for packages.</p>
                                </div>
                            </div>
                            <hr/>
                            <form action="<?php echo site_url('profile/update_package_notification_pref'); ?>" method="post" name="profile_time_pref" style="margin-left: 30px;" class="">
                                <div class="row">
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
                                <div class="row">
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
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="send-btn mb-3">
                                            <button type="submit" class="btn btn-sm button-theme">Update Notification Preference</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <p class="sub-banner-2 text-center">© Copyright <?php echo date('Y'); ?>. All rights reserved</p>
                </div>
            </div>
        </div>
    </div>
</div>



<?php $this->load->view('common/front_end_layout/bottom'); ?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $('form[name="profile_time_pref"]').ajaxForm({
        dataType: 'JSON',
        success: function(arg) {
            if(arg.type != "success")
                toastr[arg.type](arg.text);

            if (arg.type == 'success') {
                toastr['success']('Preference Saved...');
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
</script>