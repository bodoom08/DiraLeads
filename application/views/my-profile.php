<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/front_end_layout/top', [
    'title' => 'My Profile'
]);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

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
                            <h3 class="heading">Profile Details (User ID: <?php echo $_SESSION['id']; ?>)</h3>
                            <div class="dashboard-message contact-2 bdr clearfix">
                                    <div class="row">
<form action="<?php echo site_url('profile/update_userprofile'); ?>" name="update_userprofile" method="post" style="display:flex;">
                                        <div class="col-lg-3 col-md-3">
                                            <div class="edit-profile-photo">
                                                <img src="assets/img/avatar/user2.jpg" id="profile_pic" alt="profile-photo" class="rounded-circle" width="200" height="200">
                                                <div class="change-photo-btn">
                                                    <div class="photoUpload">
                                                        <span><i class="fa fa-upload"></i></span>
                                                        <input type="file" class="upload" id="files">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group name">
                                                        <label>Name</label>
                                                        <input type="text" name="name" class="form-control" placeholder="Enter Name" value="<?php echo $_SESSION['name']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group subject">
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <label>Country Code</label>
                                                                <select name="country" class="form-control input-select" id="country" style="width: 100% !important;height:45px !important;">
                                                                    <option value="">Select Country Code</option>
                                                                    <?php foreach($countries as $country) { ?>
                                                                        <option value="<?php echo '+'.$country->phonecode; ?>" <?php echo ($userinfo->country_code == '+'.$country->phonecode) ? 'selected' : ''; ?>><?php echo $country->nicename.'(+'.$country->phonecode.')'; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <label>Phone</label>
                                                                <input type="text" class="form-control" placeholder="Phone" name="mobile" value="<?php echo $_SESSION['mobile'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group number">
                                                        <label>Email</label>
                                                        <input type="email" class="form-control" readonly placeholder="Email" name="email" value="<?php echo $_SESSION['email'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group number">
                                                        <button type="submit" class="btn btn-sm button-theme" style="margin-top: 30px;">Update Profile</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                    <hr>
                                    <form action="<?php echo site_url('profile/update'); ?>" method="post" name="password_update">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group name">
                                                <label>Current Password</label>
                                                <input type="password" name="current_pass" class="form-control" placeholder="Current Password">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group email">
                                                <label>New Password</label>
                                                <input type="password" name="password" class="form-control" placeholder="New Password">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group subject">
                                                <label>Confirm New Password</label>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <input type="password" name="conf_password" class="form-control" placeholder="Confirm New Password">
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="send-btn">
                                                            <button type="submit" class="btn btn-sm button-theme">Update Password</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                    <hr>
                                    <form action="<?php echo site_url('profile/update_timepref'); ?>" method="post" name="profile_time_pref" class="d-none">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4 class="inner-title mb-3 " style="padding-left: 0px;"><i>How People Can Contact Me ?</i></h4>
                                                <?php
                                                    $contact_type_arr = explode(',', $_SESSION['contact_type']);
                                                    $day_of_the_weak_arr = explode(',', $_SESSION['day_of_the_weak']);
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
                                                            <option value="24" <?php echo ($_SESSION['time_of_day'] == '24') ? 'selected' : ''; ?>>24 Hrs</option>
                                                            <option value="custom" <?php echo ($_SESSION['time_of_day'] == 'custom') ? 'selected' : ''; ?> >Custom Time</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group" id="custom_div" style="display: none;">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="time" class="form-control" placeholder="Start Time" name="start_time" value="<?php echo (!empty($_SESSION['from_time'])) ? date("H:i", strtotime($_SESSION['from_time'])) : ''; ?>">                                                                        
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="time" class="form-control" placeholder="End Time" name="end_time" value="<?php echo (!empty($_SESSION['to_time'])) ? date("H:i", strtotime($_SESSION['to_time'])) : ''; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="send-btn">
                                                    <button type="submit" class="btn btn-sm button-theme">Update Time Preference</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>
    document.getElementById("files").onchange = function() {
        var reader = new FileReader();

        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("profile_pic").src = e.target.result;
        };

        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    };
    $('#country').select2();
    $('form[name="password_update"]').ajaxForm({
        dataType: 'JSON',
        beforeSubmit:  function(formData, jqForm, options) {
            formData.push({ name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>' });
        },
        success: function(arg) {
            toastr[arg.type](arg.text);
            if (arg.type == 'success') {
                location.reload();
            }
        }
    });

    $('form[name="update_userprofile"]').ajaxForm({
        dataType: 'JSON',
        beforeSubmit:  function(formData, jqForm, options) {
            formData.push({ name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>' });
        },
        success: function(arg) {
            toastr[arg.type](arg.text);
            if (arg.type == 'success') {
                location.reload();
            }
        }
    });

    $('form[name="profile_time_pref"]').ajaxForm({
        dataType: 'JSON',
        beforeSubmit:  function(formData, jqForm, options) {
            formData.push({ name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>' });
        },
        success: function(arg) {
            toastr[arg.type](arg.text);
            if (arg.type == 'success') {
                location.reload();
            }
        }
    });

    $(function() {
        $('select[name="time"]').trigger('change');
    });

    function customTimeSet(elem){
        if($(elem).val() == 'custom'){
            $('#custom_div').show();
        } else {
            $('#custom_div').hide();
        }
    }
</script>
