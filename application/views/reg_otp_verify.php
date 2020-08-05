<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/layout/top', [
    'title' => 'Verify Registration'
]);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<div class="contact-section overview-bgi">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="form-content-box">

                    <div class="details">

                        <h6 class="mb-20">Verify Registration</h6>
                        <?php echo form_open('register/verify_otp', 'id="regVerifyForm" class=""'); ?>
                        <div class="form-group">
                            <code>Please enter OTP sent to <b><span id="verifyEmailID"><?php echo urldecode($_GET['email']); ?></span></b></code>
                        </div>
                        <div class="form-group">
                            <input type="number" maxlength="6" name="reg_verify_otp" value="<?php if($_GET['otp']){ echo $_GET['otp']; } ?>" class="input-text" placeholder="Verification OTP">
                        </div>
                        <div class="checkbox">
                            <a href="login" class="link-not-important pull-right"><i class="fa fa-sign-in"></i> Login</a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" class="btn-md button-theme btn-block">Verify</button>
                        </div>
                        <?php echo form_close(); ?>
                        <div class="form-group mb-0">
                            <button class="btn-md btn-info btn-block" id="resendOTP" onclick="resendOTP('<?php echo urldecode($_GET['email']); ?>')">Resend</button>
                        </div>
                    </div>

                    <div class="footer">
                        <span>Don't have an account? <a href="<?php echo site_url('register'); ?>">Register here</a></span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php $this->load->view('common/layout/bottom'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $('#regVerifyForm').ajaxForm({
        dataType: 'json',
        beforeSubmit:  function(formData, jqForm, options) {
            formData.push({ name: 'email', value: '<?php echo urldecode($_GET['email']); ?>' });
        },
        success: function(arg) {
            toastr[arg.type](arg.text);
            if(arg.type == 'success') {
                setTimeout(() => {
                    window.location.href= '<?php echo site_url('profile') ?>';
                }, 2000);
            }
        }
    });

    function resendOTP($email) {
        $('#resendOTP').prop('disabled', true);
        $.ajax({
            url: '<?php echo site_url('register/resend_verify_otp') ?>',
            method: 'POST',
            data: {
                email: '<?php echo urldecode($_GET['email']); ?>',
                <?php echo $this->security->get_csrf_token_name(); ?> : '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            success: function(arg){
                // console.log(data)
                arg = JSON.parse(arg);
                toastr[arg.type](arg.text);
            },
            error: function(error) {
                console.log(error)
            },
            complete: function() {
                $('#resendOTP').prop('disabled', false);
            }
        })
        // console.log($email);
    }
</script>