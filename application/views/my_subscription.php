<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/front_end_layout/top', [
    'title' => 'My Subscription'
]);
?>
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
                        <div class="pricing-table bg-grea">
                                <div class="row justify-content-md-center">
                                    <?php if (empty($current)) { ?>
                                        <h4>Sorry, No Subscription Available!</h4>
                                    <?php } else { ?>
                                        <?php $upcoming = []; foreach ($current as $package) {
                                                if(strtotime($package['start_date']) > time()) {
                                                    $upcoming[] = $package;
                                                    continue;
                                                }
                                            ?>
                                            <div class="col-md-5 col-lg-4">
                                                <div class="item">
                                                    <input type="hidden" name="package_id[]" value="<?php echo $package['package_id'] ?>">
                                                    <div class="heading">
                                                        <h4>For <?php echo ucfirst($package['package_name']); ?> </h4>
                                                    </div>
                                                    <div class="features">
                                                        <h4><span class="feature">Validity</span> : <span class="value"><?php echo $package['validity'] ?> Days</span></h4>
                                                        <h4><span class="feature">Start</span> : <span class="value"><?php echo date('j<\s\u\p>S</\s\u\p> M Y', strtotime($package['start_date'])) ?></span></h4>
                                                        <h4><span class="feature">End</span> : <span class="value"><?php echo date('j<\s\u\p>S</\s\u\p> M Y', strtotime($package['end_date'])) ?></span></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <div class="row mb-5">
                                    <?php if (empty($current)) { ?>
                                        <button class="view-all  mt-5" onclick="subscription()">Subscribe</button>
                                    <?php  } else { ?>
                                        <button class="view-all  mt-5" onclick="subscription()">Subscribe More</button>
                                    <?php } ?>
                                </div>
                                <?php if(isset($upcoming) && count($upcoming) > 0): ?>
                                <div class="row">
                                    <div id="faq" class="col-md-12 faq-accordion">
                                        <div class="card m-b-0">
                                            <div class="card-header">
                                                <a class="card-title collapsed" data-toggle="collapse" data-parent="#faq" href="#collapse7" aria-expanded="false">
                                                    Upcoming Subscriptions
                                                </a>
                                            </div>
                                            <div id="collapse7" class="card-block collapse" style="">
                                                <div class="foq-info">
                                                    <?php foreach ($upcoming as $package) { ?>
                                                        <div class="col-lg-3 col-sm-6">
                                                            <div class="item">
                                                                <div class="heading">
                                                                    <h5>For <?php echo ucfirst($package['package_name']); ?> </h5>
                                                                </div>
                                                                <div class="features">
                                                                    <h6><span class="feature">Validity</span> : <span class="value"><?php echo $package['validity'] ?> Days</span></h6>
                                                                    <h6><span class="feature">Start</span> : <span class="value"><?php echo date('j<\s\u\p>S</\s\u\p> M Y', strtotime($package['start_date'])) ?></span></h6>
                                                                    <h6><span class="feature">End</span> : <span class="value"><?php echo date('j<\s\u\p>S</\s\u\p> M Y', strtotime($package['end_date'])) ?></span></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            
                        </div>
                        <p class="sub-banner-2 text-center">© Copyright 2019. All rights reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('common/front_end_layout/bottom'); ?>
<script>
    // function more_subscription() {
    //     var package_ids = $('[name="package_id[]"]').map(function() {
    //         return $(this).val();
    //     }).get();
    //     var form = document.createElement("form");
    //     var element1 = document.createElement("input");
    //     var element2 = document.createElement("input");
    //     form.method = "POST";
    //     form.action = "<?php echo site_url('pricing'); ?>";
    //     element1.value = package_ids;
    //     element1.name = "package_ids";
    //     form.appendChild(element1);
    //     element2.value = '<?php echo $this->security->get_csrf_hash() ?>';
    //     element2.name = "<?php echo $this->security->get_csrf_token_name() ?>";
    //     form.appendChild(element2);
    //     document.body.appendChild(form);
    //     form.submit();
    // }

    function subscription() {
        window.location.href = '<?php echo site_url('pricing'); ?>';
    }
</script>