<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/layout/top', [
    'title' => 'Registration'
]);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://www.jqueryscript.net/demo/Country-Calling-Code-Picker-jQuery-Ccpicker/css/jquery.ccpicker.css">
<style>
    .select2-container--default .select2-selection--single{
        height:45px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 43px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {    
        top: 9px;   
    }
</style>
<div class="contact-section overview-bgi">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">


                <div class="form-content-box">

                    <div class="details">

                        <h6 class="mb-20">Create an account</h6>

                        <?php echo form_open('register/user_register', 'id="registerForm" class=""'); ?>
                        <div class="form-group">
                            <input type="text" name="name" class="input-text" placeholder="Full Name">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="input-text" placeholder="Email Address">
                            <div class="infoarea"></div>
                        </div>
                        <div class="form-group country-code">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="">Country Code<code>*</code></label><br/>
                                    <input type="text" id="country" name="country" class="phone-field" style="border: 0;opacity: 0;visibility: hidden;">
                                    <!-- <select name="country" class="form-control input-select" id="country" style="width: 100% !important;height:45px !important;"> -->
                                        <!-- <option value="">Select Country Code</option> -->
                                        <?php //foreach($countries as $country) { ?>
                                            <!-- <option value="<?php //echo '+'.$country->phonecode; ?>"><?php //echo $country->nicename.'(+'.$country->phonecode.')'; ?></option> -->
                                        <?php //} ?>
                                    <!-- </select> -->
                                </div>
                                <div class="col-lg-8">
                                    <input type="number" name="mobile" class="input-text" placeholder="Mobile Number">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="input-text" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <input type="password" name="confirm_Password" class="input-text" placeholder="Confirm Password">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">Accept Terms & Conditions <i style="cursor: pointer;" class="fa fa-external-link" onclick="window.open('/terms')"></i></label>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn-md button-theme btn-block" id="register_submit">Signup</button>
                        </div>
                        <?php echo form_close(); ?>

                        <!-- <ul class="social-list clearfix">
                            <li><a href="#" class="facebook-bg"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#" class="twitter-bg"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#" class="google-bg"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="#" class="linkedin-bg"><i class="fa fa-linkedin"></i></a></li>
                        </ul> -->
                    </div>

                    <div class="footer">
                        <span>Already a member? <a href="<?php echo site_url('login'); ?>">Login here</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php $this->load->view('common/layout/bottom'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script src="https://www.jqueryscript.net/demo/Country-Calling-Code-Picker-jQuery-Ccpicker/js/jquery.ccpicker.js"></script>
<script>
    $(function() {
        $("#country").CcPicker({
            "countryCode":"us",
            dataUrl:"<?php echo site_url('register/country_json'); ?>"
        });
        $("#country").on("countrySelect", function(e, i){
            // alert(i.countryName + " " + i.phoneCode);
        });
    });

    // $('#country').select2();
    $('#registerForm').ajaxForm({
        dataType: 'json',
        beforeSubmit: function() {
            event.preventDefault();
            if(!$('#customCheck1').is(':checked')) {
                toastr.warning('Accept Terms & Conditions');
                return false;
            } else {
                $('#register_submit').prop('disabled', 'disabled');
            }
        },
        success: function(arg) {
            toastr[arg.type](arg.text);
            $('#register_submit').removeAttr('disabled');
            if (arg.type == 'success') {
                window.location.href = "<?php echo site_url(''. isset($_GET['continue']) ? 'login?continue='.urlencode($_GET['continue']) : 'login') ?>"
            }
            if(arg.type== 'warning') {
                $('.infoarea').html('');
                $('.infoarea').html(`<code>${arg.text}</code>`);
            }
            if(arg.type== 'info') {
                setTimeout(() => {
                    email = $('input[name="email"]').val();
                    window.location.href = "<?php echo site_url('/') ?>register/verify/?email="+email;
                }, 3000);
            }
        },
        error: function() {
            $('#register_submit').removeAttr('disabled');
        }
    });
</script> 