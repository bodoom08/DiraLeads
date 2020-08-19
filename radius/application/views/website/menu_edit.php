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
                        <?php echo form_open('', array('id' => 'page-edit')); ?>
                        <div class="dashboard-list">
                            <h3 class="heading">Menu Edit</h3>
                            <div class="dashboard-message contact-2 bdr clearfix">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="banner_type" class="col-form-label">Menu Position</label>
                                            <select class="form-control" name="menu_position" id="menu_position">
                                                <?php foreach ($positions as $position) : ?>
                                                    <option value="<?php echo $position->id; ?>"><?php echo $position->description; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="title" class="col-form-label">Menu Title</label>
                                            <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="slug" class="col-form-label">URL</label>
                                            <input type="text" class="form-control" id="url" name="url" value="<?php echo $url; ?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="banner_type" class="col-form-label">Opens In</label>
                                            <select class="form-control" name="opens_in" id="opens_in">
                                                <option value="same">Same Tab</option>
                                                <option value="_blank">New Tab</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="browse_submit">
                                <div class="clearfix"></div>
                                <button type="submit" id="submitBtn" class=" float-left view-all"><i class="fa fa-spinner fa-spin" style="display: none;"></i> Save</button>
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
    $('#menu_position').val(<?php echo $menu_position_id; ?>);
    $('#opens_in').val(`<?php echo $tab_option; ?>`);

    $('#page-edit').submit(function() {
        $('#page-edit').ajaxSubmit({
            type: 'PUT',
            dataType: 'JSON',
            success: function(arg) {
                toastr[arg.type](arg.text);
                if (arg.type == 'success') {
                    location.href = `<?php echo site_url('website/menus'); ?>`;
                }
            }
        });
        return false;
    });
</script>