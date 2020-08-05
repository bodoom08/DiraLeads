<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/top', [
    'title' => 'Packages'
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
                        <form id="page-edit">
                            <div class="dashboard-list">
                                <h3 class="heading">Page Details</h3>
                                <div class="dashboard-message contact-2 bdr clearfix">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="title" class="col-form-label">Page Title</label>
                                                <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="slug" class="col-form-label">Slug</label>
                                                <input type="text" class="form-control" id="slug" name="slug" value="<?php echo $slug; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="banner_type" class="col-form-label">Banner Type</label>
                                                <select class="form-control" name="banner_type" id="banner_type">
                                                    <option value="main">Main Banner</option>
                                                    <option value="sub">Small Banner</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="content" class="col-form-label">Content</label>
                                                <div id="content">
                                                    <?php echo html_entity_decode($content); ?>
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
    $('#banner_type').val(`<?php echo $banner_type; ?>`);
    $('#content').summernote();
</script>

<script>
    $('#page-edit').submit(function() {
        $('#page-edit').ajaxSubmit({
            type: 'PUT',
            dataType: 'JSON',
            data: {
                content: $('#content').summernote('code')
            },
            success: function(arg) {
                toastr[arg.type](arg.text);
                if (arg.type == 'success') {
                    location.href = `<?php echo site_url('website/pages'); ?>`;
                }
            }
        });
        return false;
    });
</script>