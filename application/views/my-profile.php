<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/front_end_layout/top', [
    'title' => 'My Profile'
]);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/styleM.css">

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
                            <h3 class="heading">My Profile</h3>
                            <div class="dashboard-message contact-2 bdr clearfix">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 d-none">
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
                                        <div class="col-lg-12 col-md-12">
                                            <div class="row">
											<div class="col-lg-8 col-ld-8"  style="border-right:#eee 1px solid;">
											 
                                                        <label>User ID : <?php echo $userinfo->id; ?></label>
                                                       
                                                   
											<div class="row">
											
                                                 <div class="col-lg-4 col-md-4">
                                                    <div class="form-group name">
                                                        <label>First Name</label>
                                                        <input type="text" name="fname" class="form-control" placeholder="Enter First Name" value="<?php echo $userinfo->first_name; ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="form-group name">
                                                        <label>Surname</label>
                                                        <input type="text" name="sname" class="form-control" placeholder="Enter Surname" value="<?php echo $userinfo->last_name; ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="form-group name">
                                                        <label>Display Name</label>
                                                        <input type="text" name="name" class="form-control" placeholder="Enter Name" value="<?php echo $_SESSION['name']; ?>" disabled>
                                                    </div>
                                                </div>
                                               <!--  <div class="col-lg-6 col-md-6">
                                                    <div class="form-group name">
                                                           
                                                                <label>Country Code</label>
                                                                <select name="country" class="form-control input-select" id="country" style="width: 100% !important;height:45px !important;" disabled>
                                                                    <option value="">Select Country Code</option>
                                                                    <?php foreach($countries as $country) { ?>
                                                                        <option value="<?php echo '+'.$country->phonecode; ?>" <?php echo ($userinfo->country_code == '+'.$country->phonecode) ? 'selected' : ''; ?>><?php echo $country->nicename.'(+'.$country->phonecode.')'; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                           
                                                    </div>
                                                </div> -->
                                                <div class="col-lg-6 col-md-6">
                                                                <label>Phone Number</label>
                                                                <input type="text" class="form-control" placeholder="Phone" name="mobile" value="<?php echo $userinfo->country_code.' '.$_SESSION['mobile'] ?>" disabled>
                                                            </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group number">
                                                        <label>Email</label>
                                                        <input type="email" class="form-control" readonly placeholder="Email" name="email" value="<?php echo $_SESSION['email'] ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
													
                                                    <div class="form-group number">
                                                        <label>Address</label>
                                                        <input type="text" class="form-control" placeholder="Address" name="address" value="<?php echo $userinfo->address ?>" autocomplete="off" disabled>
                                                    </div>
                                                </div>
                                                <?php
                                                        if($userinfo->language){
                                                            $languag= explode(',',$userinfo->language);
                                                        }?>
                                                       
                                                     
                                             <div class="col-lg-6 col-md-6">
                                                    <div class="form-group number">
                                                        <label>Language</label>
														<div class="row">
														<div class="custom-control custom-checkbox col-md-4">
														  <input type="checkbox" <?php if (in_array('English', $languag)){echo 'checked';} ?> class="custom-control-input" id="customCheck1" disabled>
														  <label class="custom-control-label" for="customCheck1">English</label>
														</div>
														<div class="custom-control custom-checkbox col-md-4">
														  <input type="checkbox"  <?php if (in_array('Yiddish', $languag)){echo 'checked';} ?> class="custom-control-input" id="customCheck2" disabled>
														  <label class="custom-control-label" for="customCheck2">Yiddish</label>
														</div>
														<div class="custom-control custom-checkbox col-md-4">
														  <input type="checkbox" <?php if (in_array('Hebrew', $languag)){echo 'checked';} ?> class="custom-control-input" id="customCheck3" disabled>
														  <label class="custom-control-label" for="customCheck3">Hebrew</label>
														</div>
                                                   </div>
                                                </div>
												</div>
											
                                                <div class="col-lg-6 col-md-6">
                                                
											</div>
                                         <div class="col-lg-16 col-md-6 text-center">
                                                    <div class="form-group number">
                                                        <button type="submit" data-toggle="modal" data-target="#squarespaceModal" class="btn btn-sm button-theme updateP" style="margin-top: 30px;">Edit Profile</button>
                                                    </div>
                                                    </div>
                                                    </div>
                                            </div>
											<div class="col-lg-4 col-ld-4">
											<h2 class="headings">Password Change</h2>
									<form action="<?php echo site_url('profile/update'); ?>" method="post" name="password_update">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group name">
                                                <label>Current Password</label>
                                                <input type="password" name="current_pass" class="form-control" placeholder="Current Password">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group email">
                                                <label>New Password</label>
                                                <input type="password" name="password" class="form-control" placeholder="New Password">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group subject">
                                                <label>Confirm New Password</label>
                                                <input type="password" name="conf_password" class="form-control" placeholder="Confirm New Password">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 sendme text-center">
                                            <div class="form-group subject">
                                                <label></label>
                                                <div class="send-btn">
                                                    <button type="submit" class="btn btn-sm button-theme">Update Password</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
											</div>
                                            
    <style>
    .pac-container {
        z-index: 99999 !important;
    }
</style>
											<div class="modal custm-modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
					 <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		</div>
		<div class="modal-body">
			
            <!-- content goes here -->
	<form action="<?php echo site_url('profile/update_userprofile'); ?>" name="update_userprofile" method="post" style="display:flex;">
<div class="col-lg-3 col-md-3 d-none">
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
<div class="col-lg-12 col-md-12">
<div class="row">
<div class="col-lg-6 col-md-6">
<div class="form-group name">
<label>First Name</label>
<input type="text" name="fname" class="form-control" placeholder="Enter First Name" value="<?php echo $userinfo->first_name; ?>">
</div>
</div>
<div class="col-lg-6 col-md-6">
<div class="form-group name">
<label>Surname</label>
<input type="text" name="sname" class="form-control" placeholder="Enter Surname" value="<?php echo $userinfo->last_name; ?>">
</div>
</div>
<div class="col-lg-6 col-md-6">
<div class="form-group name">
<label>Display Name</label>
<input type="text" name="name" class="form-control" placeholder="Enter Name" value="<?php echo $_SESSION['name']; ?>">
</div>
</div>

<div class="col-lg-6 col-md-6">

<div class="form-group number">
<label>Address</label>
<input type="text" class="form-control" id="geoLocation" placeholder="Address" name="address" value="<?php echo $userinfo->address ?>" autocomplete="off">
</div>
</div>
<?php
if($userinfo->language){
$languag= explode(',',$userinfo->language);
}?>

<input type="hidden" class="form-control" placeholder="Phone" name="mobile" value="<?php echo $_SESSION['mobile'] ?>">

<div class="col-lg-12 col-md-12">
<div class="form-group number">
<label>Language</label>
<div class="row">
<div class="custom-control custom-checkbox">
<input type="checkbox" name="language[]" value="English" <?php if (in_array('English', $languag)){echo 'checked';} ?> class="custom-control-input" id="customCheck1">
<label class="custom-control-label" for="customCheck1">English</label>
</div>
<div class="custom-control custom-checkbox">
<input type="checkbox" name="language[]" value="Yiddish" <?php if (in_array('Yiddish', $languag)){echo 'checked';} ?> class="custom-control-input" id="customCheck2">
<label class="custom-control-label" for="customCheck2">Yiddish</label>
</div>
<div class="custom-control custom-checkbox">
<input type="checkbox" name="language[]" value="Hebrew" <?php if (in_array('Hebrew', $languag)){echo 'checked';} ?> class="custom-control-input" id="customCheck3">
<label class="custom-control-label" for="customCheck3">Hebrew</label>
</div>
</div>
</div>
</div>
<div class="col-lg-12 col-md-12 text-center">
<div class="form-group number">
<button type="submit" class="btn btn-sm button-theme" style="margin-top: 30px;">Update Profile</button>

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
                                         
                                        </div>
                                    </div>
                                    
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

<script src="assets/js/init.js" type="text/javascript" charset="utf-8"></script>
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
        var popup = "<?php echo $_SESSION['popup'] ?>";
        // alert(popup);
        if(popup != ''){
            $('.updateP').trigger('click');
        }
        <?php unset($_SESSION['popup']); ?>
        $('select[name="time"]').trigger('change');
    });

    function customTimeSet(elem){
        if($(elem).val() == 'custom'){
            $('#custom_div').show();
        } else {
            $('#custom_div').hide();
        }
    }

$(".dropdown dt a").on('click', function() {
  $(".dropdown dd ul").slideToggle('fast');
});

$(".dropdown dd ul li a").on('click', function() {
  $(".dropdown dd ul").hide();
});

function getSelectedValue(id) {
  return $("#" + id).find("dt a span.value").html();
}

$(document).bind('click', function(e) {
  var $clicked = $(e.target);
  if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
});

$('.mutliSelect input[type="checkbox"]').on('click', function() {

  var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
    title = $(this).val() + ",";

  if ($(this).is(':checked')) {
    var html = '<span title="' + title + '">' + title + '</span>';
    $('.multiSel').append(html);
    $(".hida").hide();
  } else {
    $('span[title="' + title + '"]').remove();
    var ret = $(".hida");
    $('.dropdown dt a').append(ret);

  }
});
</script>

