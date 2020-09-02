<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/top', [
    'title' => 'User: ' . $user->name
]);
?>
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
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card text-center">
                                    <div class="card-header">
                                        User Details
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?php echo $user->name; ?>
                                            <?php if ($user->status == 'inactive') { ?>
                                                <span class="badge badge-danger">Inactive</span>
                                            <?php } ?>
                                        </h5>
                                        <p class="card-text">
                                            <ul>
                                                <li><b>Mobile :</b> <a href="tel:<?php echo $user->mobile; ?>"><?php echo $user->mobile; ?></a></li>
                                                <li><b>Email :</b> <a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a></li>
                                                <li><b>Registered :</b> <?php echo $user->created_at; ?></li>
                                                <li>
                                                    <b>Subscriptions :</b>
                                                    <?php
                                                    if ($user->packages) {
                                                        echo '<span class="badge badge-primary">' . str_replace(',', '</span> <span class="badge badge-primary">', $user->packages) . '</span>';
                                                    } else {
                                                        echo '<span class="badge badge-secondary">N/A</span>';
                                                    }
                                                    ?>
                                                </li>
                                            </ul>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card text-center">
                                    <div class="card-header">
                                        <!-- Properties (<a href="<?php //echo site_url('users/property_add?email=' . $user->email) ?>">+ Add</a>) -->
                                        Properties (<a style="color: blue; text-decoration: underline;" href="<?php echo site_url('property/add_property?userid_for=' . $user->id) ?>">+ Add</a>) | 
                                        Packages (<a style="color: blue; text-decoration: underline;" href="<?php echo site_url('pricing/custom_pricing?userid_for=' . $user->id) ?>">+ Subscribe</a>)
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="manage-table">
                                                <tbody>
                                                    <?php if (empty($properties)) { ?>
                                                        <tr class="responsive-table">
                                                            <h4 style="text-align: center;">Sorry, No Property Available!</h4>
                                                        </tr>
                                                    <?php } else { ?>
                                                        <?php foreach ($properties as $key => $value) : ?>
                                                            <tr class="responsive-table">
                                                                <td class="listing-photoo">
                                                                    <input type="hidden" name="user_property_id" value="<?php echo $value['id'] ?>">
                                                                    <img src="<?php echo '/uploads/' . $value['image'] ?>" alt="listing-photo" class="img-fluid">
                                                                </td>
                                                                <td class="title-container">
                                                                    <h2><a href="#">For <?php echo ucfirst($value['for']); ?></a></h2>
                                                                    <h5 class="d-none d-xl-block d-lg-block d-md-block"><i class="flaticon-pin"></i> <?php echo  $value['house_number'] ?>, <?php echo $value['street'] ?> </h5>
                                                                    <h6 class="table-property-price">$<?php echo $value['price'] ?> / monthly</h6>
                                                                </td>
                                                                <?php if ($value['number']) : ?>
                                                                    <td class="text-<?php echo ($value['status'] == 'active' ? 'success' : 'warning'); ?>"><?php echo ($value['status'] == 'active' ? '' : 'Paused'); ?></td>
                                                                <?php else : ?>
                                                                    <td class="text-danger" title="Number allocation failed at the time of your submission. Please contact admin to allocate a number for this property">Contact Admin !</td>
                                                                <?php endif; ?>
                                                                <td class="expire-date"><?php echo $value['available_date'] ?></td>
                                                                <!-- <td class="action">
                                                                    <a href="javascript:(0);" onclick="edit(<?php echo $value['id'] ?>);"><i class="fa fa-pencil"></i> Edit</a>
                                                                    <a href="javascript:(0);" onclick="change_status(<?php echo $value['id'] ?>);"><i class="fa  <?php echo ($value['status'] == 'active' ? 'fa-eye-slash' : 'fa-eye'); ?>"></i> <?php echo ($value['status'] == 'active' ? 'Pause' : 'Resume'); ?></a>
                                                                    <a href="javascript:(0);" onclick="del(<?php echo $value['id'] ?>);" class="delete"><i class="fa fa-remove"></i> Delete</a>
                                                                </td> -->
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="sub-banner-2 text-center">© Copyright 2020. All rights reserved</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('common/bottom'); ?>