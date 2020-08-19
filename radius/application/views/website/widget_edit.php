<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/top', [
    'title' => 'Widget: ' . $name . ' Edit'
]);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<div class="dashboard">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12 col-pad">
                <div class="dashboard-nav d-none d-xl-block d-lg-block">
                    <?php $this->load->view('common/sidebar'); ?>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 col-sm-12 col-pad">
                <div class="content-area5">
                    <div class="dashboard-content">
                        <form id="widget-edit">
                            <div class="dashboard-list">
                                <h3 class="heading"><?php echo 'Widget: ' . $name . ' Edit'; ?></h3>
                                <div class="dashboard-message contact-2 bdr clearfix">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="content" class="col-form-label">HTML</label>
                                                <div id="html">
                                                    <?php echo html_entity_decode($html); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="browse_submit">
                                    <div class="clearfix"></div>
                                    <button type="submit" id="submitBtn" class=" float-left view-all"><i class="fa fa-spinner fa-spin" style="display: none;"></i> Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('common/bottom'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<!-- include summernote css/js -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>

<script>
    $('#html').summernote();
</script>

<script>
    $('#widget-edit').submit(function() {
        $('#widget-edit').ajaxSubmit({
            type: 'PUT',
            dataType: 'JSON',
            data: {
                html: $('#html').summernote('code')
            },
            success: function(arg) {
                toastr[arg.type](arg.text);
                if (arg.type == 'success') {
                    location.href = `<?php echo site_url('website/widgets'); ?>`;
                }
            }
        });
        return false;
    });
</script>