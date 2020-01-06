<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/top', [
    'title' => 'Update configurations'
]);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
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
                        <?php echo form_open(site_url('website/configs/update'), array('id' => 'page-edit')); ?>
                        <div class="dashboard-list">
                            <h3 class="heading">Website Configuration</h3>
                            <div class="dashboard-message contact-2 bdr clearfix">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="title" class="col-form-label">Website Title</label>
                                            <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title" class="col-form-label">Logo</label>
                                            <input type="file" id="logo" name="userfile" />
                                        </div>
                                    </div>
                                    <div class="col-md-6" title="Current Logo">
                                        <div class="form-group">
                                            <img src="/uploads/<?php echo $logo; ?>" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="title" class="col-form-label">Footer Description</label>
                                            <textarea class="form-control" name="footer_desc" rows="5"><?php echo $footer_desc; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="browse_submit">
                                <div class="clearfix"></div>
                                <button type="submit" id="submitBtn" class=" float-left view-all"><i class="fa fa-spinner fa-spin" style="display: none;"></i> Update</button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('common/bottom'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>

<script>
    $('#page-edit').submit(function() {
        $('#page-edit').ajaxSubmit({
            type: 'POST',
            dataType: 'JSON',
            success: function(arg) {
                toastr[arg.type](arg.text);

                $('#submitBtn').prop('disabled', false);
                $('#submitBtn i').hide();
            },
            error: function() {
                $('#submitBtn').prop('disabled', false);
                $('#submitBtn i').hide();
            },
            beforeSubmit: function() {
                $('#submitBtn').prop('disabled', true);
                $('#submitBtn i').show();
            }
        });
        return false;
    });
</script>