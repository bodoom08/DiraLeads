<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/layout/top', [
    'title' => 'Pricing Plans'
]);
?>
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
<button class="btn btn-block btn-primary" onclick="location.href='/login?continue=<?php echo urlencode(site_url('/pricing')); ?>'">Subscribe</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<?php $this->load->view('common/layout/bottom'); ?>
