<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/layout/top', [
    'title' => 'Make Payment'
]);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<div class="sub-banner overview-bgi">
</div>
<div class="subscribe-main ">
    <div class="container">
        <div class="subscribe-form payment-info">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php if(isset($last_errors)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo '<p><strong>'.$last_errors['error'].'</strong></p>'; ?>
                                <?php echo '<p>Error Code: <strong>'.$last_errors['errorcode'].'</strong></p>'; ?>
                                <?php
                                    // echo '<pre>';
                                    // print_r($last_errors);
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php if(array_key_exists('type', $selected_pkg) && ($selected_pkg['type'] == 'error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <p><?php echo $selected_pkg['text']; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if(array_key_exists('package_details', $selected_pkg)): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="mb-3 text-center mb-30">Selected Package</h4>
                            <div class="card">
                                <div class="card-body">
                                    <div class="item text-center">
                                        <div class="heading">
                                            <h3><?php echo $selected_pkg['package_details']['name']; ?></h3>
                                            <?php if($subscribe_info->action == 'modify') { ?>
                                                <span class="badge badge-secondary">Modify</span>
                                            <?php } ?>
                                            <?php if($subscribe_info->action == 'renew') { ?>
                                                <span class="badge badge-secondary">Renew</span>
                                            <?php } ?>
                                        </div>
                                        <p>No of area: <?php echo $selected_pkg['package_details']['no_of_area']; ?></p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="features">
                                                    <h4><span title="Validity" class="value"><?php echo $selected_pkg['package_details']['no_of_days']; ?> Days</span></h4>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="price">
                                                    <h4>$ <?php echo $selected_pkg['package_details']['price']; ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                            <?php
                                                    $date = new DateTime();
                                                    $date->add(date_interval_create_from_date_string($selected_pkg['package_details']['no_of_days'] . ' days'));

                                                    if(!empty($subscribed_package->end_date)) {
                                                        $date = DateTime::createFromFormat('Y-m-d', $subscribed_package->end_date);
                                                        $fromdate = DateTime::createFromFormat('Y-m-d', $subscribed_package->end_date);
                                                        $date->modify('+'.$subscribe_info->days_select_noof.'days');
                                                        $fromdate->modify('+1 days');
                                                    }
                                                    if($subscribe_info->action == 'modify') {
                                                        $date = DateTime::createFromFormat('Y-m-d', $subscribed_package->end_date);
                                                        $fromdate = DateTime::createFromFormat('Y-m-d', $subscribed_package->start_date);
                                                    }
                                                    if($subscribe_info->action == 'renew') {
                                                        if(strtotime($subscribed_package->end_date) >= strtotime(date('Y-m-d'))) {
                                                            $start_date = new DateTime($subscribed_package->end_date);
                                                            $start_date->modify('+1 days');
                                                            $fromdate = $start_date;
                                                            $todate = $start_date->format('Y-m-d');
                                                            $todate = new DateTime($todate);
                                                            $todate->modify('+'.$selected_pkg['package_details']['no_of_days'].' days');
                                                        }
                                                        else {
                                                            $start_date = new DateTime(date('Y-m-d'));
                                                            $fromdate = $start_date;
                                                            $todate = $start_date->format('Y-m-d');
                                                            $todate = new DateTime($todate);
                                                            $todate->modify('+'.$selected_pkg['package_details']['no_of_days'].' days');

                                                        }                                                        
                                                    }
                                                ?>
                                                <?php if($subscribe_info->action == 'renew') { ?>
                                                    <small class="text-muted">You are already subscribed for this package, This Package will valid <br /> from <span style="color:#ff214f;"><?php echo $fromdate->format('jS M Y'); ?></span> till <span style="color:#ff214f;"><?php echo $todate->format('jS M Y'); ?></span></small> <small><a href="<?php echo site_url('pricing/custom_pricing'); ?>">(Change)</a></small>
                                                <?php } else if($subscribe_info->action == 'modify') { ?>
                                                    <small class="text-muted">You are already subscribed for this package, This Package will valid <br /> from <span style="color:#ff214f;"><?php echo $fromdate->format('jS M Y'); ?></span> till <span style="color:#ff214f;"><?php echo $date->format('jS M Y'); ?></span></small> <small><a href="<?php echo site_url('pricing/custom_pricing'); ?>">(Change)</a></small>
                                                <?php } else if(!empty($subscribed_package->end_date)) { ?>
                                                    <small class="text-muted">You are already subscribed for this package, This Package will valid <br /> from <span style="color:#ff214f;"><?php echo $fromdate->format('jS M Y'); ?></span> till <span style="color:#ff214f;"><?php echo $date->format('jS M Y'); ?></span></small> <small><a href="<?php echo site_url('pricing/custom_pricing'); ?>">(Change)</a></small>

                                                <?php } else { ?>
                                                    <small class="text-muted">This Package will valid till <span style="color:#ff214f;"><?php echo $date->format('jS M Y'); ?></span></small> <small><a href="<?php echo site_url('pricing/custom_pricing'); ?>">(Change)</a></small>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>

                <?php if(array_key_exists('type', $selected_pkg) && ($selected_pkg['type'] == 'success')): ?>
                <form class="needs-validation mt-4" action="<?php echo site_url('pricing/pay_package'); ?>" method="post">
                    <input type="hidden" name="subscribe_info" value='<?php echo $selected_pkg['package_info']; ?>' >
                    <input type="hidden" name="subscribe_pref_info" value='<?php echo $subscribe_pref_info; ?>' >
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="mb-3 text-center mb-30">Payment Information</h4>
                            <!-- <div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="pref1" name="pref1" value="pref1">
                                    <label class="custom-control-label" for="pref1">Contact the lister</label>
                                </div>
                            </div>

                            <div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="pref2" name="pref2" value="pref2">
                                    <label class="custom-control-label" for="pref2">Receive daily listings of all properties within your interest</label>
                                </div>
                            </div>


                            <div style="margin-bottom:10px;">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="pref3" name="pref3" value="pref3">
                                    <label class="custom-control-label" for="pref3">Get instant notification when something that matches your preferences gets listed, or price drops etc</label>
                                </div>
                            </div>
                            -->

                            <div class="card">
                                <div class="card-body p-4">
                                    <ul class="nav bg-light col-md-4 nav-pills rounded nav-fill mb-3" role="tablist">
                                        <li class="nav-item ">
                                            <a class="nav-link active" data-toggle="pill" href="#nav-tab-card">
                                                <i class="fa fa-credit-card"></i> Credit Card</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="nav-tab-card">
                                            <div class="form-group">
                                                <label for="username">Full name (on the card)</label>
                                                <input type="text" class="form-control" name="name" placeholder="" required="">
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="form-group">
                                                        <label for="username">Street</label>
                                                        <input type="text" class="form-control" name="street" placeholder="" required="">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="username">Zip</label>
                                                        <input type="text" class="form-control" name="zip" placeholder="" required="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cardNumber">Card number</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="cardNumber" placeholder="">
                                                    <div class="input-group-append">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="form-group">
                                                        <label><span class="hidden-xs">Expiration</span> </label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" placeholder="MM" name="mm">
                                                            <input type="number" class="form-control" placeholder="YY" name="yy">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label data-toggle="tooltip" title="" data-original-title="3 digits code on back side of the card">CVV <i class="fa fa-question-circle"></i></label>
                                                        <input type="number" name="cvv2" class="form-control" required="">
                                                    </div>

                                                </div>
                                            </div>

                                            <button class="btn btn-primary btn-block" type="submit">Pay $ <?php echo $selected_pkg['package_details']['price']; ?></button>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('common/layout/bottom'); ?>
