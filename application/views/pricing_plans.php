<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/layout/top', [
    'title' => 'Pricing Plans'
]);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<div class="sub-banner overview-bgi">
</div>
<div class="pricing-table bg-grea">
    <div class="container">
        <div class="main-title text-center">
            <p>Find your perfect plan</p>
            <h1>Pricing Plans</h1>
        </div>
        <div class="row justify-content-md-center">
            <?php foreach ($packages as $key => $package) : ?>
                <div class="col-md-5 col-lg-4">
                    <?php echo form_open('pricing/subscribe', 'class="subscribeForm"'); ?>
                    <div class="item">
                        <input type="hidden" name="package_id" value="<?php echo $package['id'] ?>">
                        <!-- <div class="ribbon">Best Value</div> -->
                        <div class="heading">
                            <h3>For <?php echo $package['name'] ?> </h3>
                        </div>
                        <?php
                        $desc = strlen($package['description']);
                        if ($desc > 60) {
                            $text = substr($package['description'], 0, 60) . '...';
                        } else {
                            $text = $package['description'];
                        } ?>
                        <p><?php echo $text; ?></p>
                        <div class="features">
                            <h4><span class="feature">Validity</span> : <span class="value"><?php echo $package['validity'] ?> Days</span></h4>
                        </div>
                        <div class="price">
                            <h4>$<?php echo $package['price'] ?></h4>
                        </div>
                        <!-- <button class="btn btn-block btn-primary" type="submit" <?php $package_id = $package['id'];
                                                                                // if (in_array($package_id, $package_ids)) {
                                                                                    //echo '>Extend Subscription';
                                                                                // } else {
                                                                                    // echo '>Subscribe';
                                                                                // } ?></button> -->

                            <button class="btn btn-block btn-primary" type="submit" <?php 
                                                                                if ($package['subscribed_button_active'] == false) {
                                                                                    echo '>Extend Subscription';
                                                                                } else {
                                                                                    echo '>Subscribe';
                                                                                } ?></button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="clearfix"></div>
        <div class="clearfix">
            <?php if (!empty($package_ids)) { ?>
<a class="view-all  mt-5" style="display:none;" href="<?php echo site_url('subscription') ?>">SKIP <i class="fa fa-angle-double-right"></i></a>
            <?php } else { ?>
                <button class="view-all  mt-5" style="display:none;"  onclick="skip_subscription()">SKIP <i class="fa fa-angle-double-right"></i></button>
            <?php } ?>
        </div>
    </div>
</div>
<?php $this->load->view('common/layout/bottom'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    // $('.subscribeForm').ajaxForm({
    //     dataType: 'json',
    //     beforeSubmit: function() {
    //         event.preventDefault();
    //         $('.btn-block').prop('disabled', 'disabled');
    //     },
    //     success: function(arg) {
    //         toastr[arg.type](arg.text);
    //         $('.btn-block').removeAttr('disabled');
    //         if (arg.type == 'success') {
    //             window.location.href = "<?php echo site_url('subscription') ?>"
    //         }
    //     }
    // });

    function skip_subscription() {
        $.ajax({
            url: "<?php echo site_url('pricing/update_subscribe_flag') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            success: function(arg) {
                window.location.href = "<?php echo site_url('dashboard') ?>"
            }
        });
    }
</script>
