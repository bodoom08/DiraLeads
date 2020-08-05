<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/layout/top', [
    'title' => 'Login'
]);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<div class="contact-section overview-bgi">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="form-content-box">

                    <div class="details">

                        <h6 class="mb-20">Recover your account</h6>
                        <?php echo form_open('login/forgot', 'id="passwordForm" class=""'); ?>
                        <div class="form-group">
                            <input type="email" name="email" class="input-text" placeholder="Email Address" required>
                        </div>
                        <div class="checkbox">
                            <!-- <div class="ez-checkbox pull-left">
                                <label>
                                    <input type="checkbox" class="ez-hide">
                                    Remember me
                                </label>
                            </div> -->
                            <a href="login" class="link-not-important pull-right"><i class="fa fa-sign-in"></i> Login</a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn-md button-theme btn-block">Reset</button>
                        </div>
                        <?php echo form_close(); ?>
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
    $('#passwordForm').ajaxForm({
        dataType: 'json',
        success: function(arg) {
            toastr[arg.type](arg.text);
        }
    });
</script>