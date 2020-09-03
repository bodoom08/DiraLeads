<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/front_end_layout/top', [
    'title' => 'My Properties'
]);
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />

<style>

</style>


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
                        <div class="dashboard-list">

                            <div class="col-md-12 subs-sec">
                                <h3 class="heading" style="border-bottom:0px;"> My Rentals</h3>
                                <a class="new-rental-button" href="<?php echo site_url('/rental'); ?>">Add New Rental</a>
                                <a class="new-rental-plus" href="<?php echo site_url('/rental'); ?>">Add Rental</a>
                            </div>
                            <div class="explore-content-box new">
                                <div class="container-fluid">
                                    <div class="inner-content-box">
                                        <div class="row">

                                            <?php if (empty($my_properties)) { ?>

                                                <div class="col-lg-12 text-center mt-5 dashboard_fav">
                                                    <p><i class="fa fa-search" aria-hidden="true"></i></p>
                                                    <h5 class="text-head">No rentals listed</h5>
                                                    <p>List your Rental <a href="/rental">Here</a></p>
                                                </div>
                                            <?php } else { ?>
                                                <style>
                                                    .soldout {
                                                        opacity: 0.5;
                                                    }
                                                </style>

                                                <?php foreach ($my_properties as $key => $value) : ?>
                                                    <div class="col-md-4 col-lg-4">
                                                        <div class="item">
                                                            <div class="feat_property">
                                                                <div class="thumb <?php echo ($value['status'] == 'inactive' ? 'resume_prop' : ''); ?>">
                                                                    <input type="hidden" name="user_property_id" value="<?php echo $value['id'] ?>">
                                                                    <img class="img-whp" src="<?php echo ($value['images'] == '') ? 'assets/img/empty_property_image.jpg' : base_url('uploads/') . $value['images'] ?>" alt="listing-photo">
                                                                </div>

                                                                <div class="details">
                                                                    <div class="tc_content">
                                                                        <h4 class="<?php echo ($value['status'] == 'inactive' ? 'resume_prop' : ''); ?>">For <?php echo ucfirst($value['for']); ?></h4>
                                                                        <p><span class="flaticon-placeholder <?php echo ($value['status'] == 'inactive' ? 'resume_prop' : ''); ?>"><i class="fa fa-map-marker" aria-hidden="true"></i></span> <?php echo $value['street'] ?></p>
                                                                        <!-- <p><span class="flaticon-placeholder <?php echo ($value['status'] == 'inactive' ? 'resume_prop' : ''); ?>"><i class="fa fa-phone" aria-hidden="true"></i></span> <?php echo $value['number'] ?></p> -->
                                                                        <ul class="prop_details <?php echo ($value['status'] == 'inactive' ? 'resume_prop' : ''); ?>">
                                                                            <li class="list-inline-item"><a href="#"><span> <i class="fa fa-phone" aria-hidden="true"></i></span><?php echo $value['number'] ?? 'N/A'; ?></a><a href="#"><span> <i class="fa fa-bed" aria-hidden="true"></i></span><?php echo $value['bedrooms'] ?? 0; ?></a><a href="#"><span> <i class="fa fa-bath" aria-hidden="true"></i></span><?php echo $value['bathrooms'] ?? 0; ?></a></li>
                                                                        </ul>
                                                                        <?php if ($value['is_annual'] == 'true') { ?>
                                                                            <ul class="prop_details <?php echo ($value['status'] == 'inactive' ? 'resume_prop' : ''); ?>">
                                                                                <li class="list-inline-item"><a href="#"><span> <i class="fa fa-money" aria-hidden="true"></i></span><?php echo $value['days_price'] ? 'Daily: $' . $value['days_price'] . ' ' : 'Daily: $0 ' ?><?php echo $value['weekend_price'] ? 'Weekend: $' . $value['weekend_price'] . ' ' : 'Weekend: $0 ' ?>
                                                                                        <!-- <?php echo $value['weekly_price'] ? 'Weekly: $' . $value['weekly_price'] . ' ' : '' ?><?php echo $value['monthly_price'] ? 'Monthly: $' . $value['monthly_price'] : '' ?> --></a></li>
                                                                            </ul>
                                                                        <?php } ?>
                                                                        <ul class="prop_details <?php echo ($value['status'] == 'inactive' ? 'resume_prop' : ''); ?>">
                                                                            <li class="list-inline-item"><a href="#"><span> <i class="fa fa-calendar" aria-hidden="true"></i></span>Created: <?php echo $value['created_at']; ?></a></li>
                                                                        </ul>
                                                                        <ul class="prop_details <?php echo ($value['status'] == 'inactive' ? 'resume_prop' : ''); ?>">
                                                                            <li class="list-inline-item"><a href="#"><span> <i class="fa fa-calendar" aria-hidden="true"></i></span>Updated: <?php echo $value['updated_at']; ?></a></li>
                                                                        </ul>
                                                                        <?php if ($value['sold'] != 'true') { ?>
                                                                            <ul class="action-sec">
                                                                                <li class="<?php echo ($value['status'] == 'inactive' ? 'resume_prop' : ''); ?>"><a href="javascript:(0);" onclick="edit(<?php echo $value['id'] ?>);"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a></li>

                                                                                <li><a href="javascript:(0);" onclick="change_status(<?php echo $value['id'] ?>);"><i class="fa <?php echo ($value['status'] == 'inactive' ? 'fa-eye-slash' : 'fa-eye'); ?>" aria-hidden="true"></i> <?php echo ($value['status'] == 'active' ? 'Pause' : 'Resume'); ?></a></li>

                                                                                <li class="<?php echo ($value['status'] == 'inactive' ? 'resume_prop' : ''); ?>"><a href="javascript:(0);" onclick="del(<?php echo $value['id'] ?>);"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
                                                                                <li class="<?php echo ($value['status'] == 'inactive' ? 'resume_prop' : ''); ?>"><a href="javascript:(0);" onclick="editDate(<?php echo $value['id'] ?>);"> Availability & Pricing</a></li>
                                                                                <!--  <li><a href="javascript:(0);" onclick="soldout(<?php echo $value['id'] ?>);"><i class="fa fa-ban" aria-hidden="true"></i> Sold Out</a></li> -->
                                                                            </ul>
                                                                        <?php } ?>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php } ?>


                                        </div>
                                        <div class="pagination-box hidden-mb-45 text-center">
                                            <nav aria-label="Page navigation example">
                                                <?php echo isset($this->pagination) ? $this->pagination->create_links() : ''; ?>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="sub-banner-2 text-center">© <?php echo date('Y'); ?> Diraleads. Trademarks and brands are the property of their respective owners.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('common/front_end_layout/bottom'); ?>


    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(".datepicker").datepicker({
            dateFormat: "dd/mm/yy",
            autoclose: true
        });
    </script>
    <script>
        function edit(user_property_id) {
            var form = document.createElement("form");
            var element1 = document.createElement("input");
            var element2 = document.createElement("input");
            form.method = "POST";
            form.action = "<?php echo site_url('my_rentals/edit'); ?>";
            element1.value = user_property_id;
            element1.name = "user_property_id";
            form.appendChild(element1);
            element2.value = '<?php echo $this->security->get_csrf_hash() ?>';
            element2.name = "<?php echo $this->security->get_csrf_token_name() ?>";
            form.appendChild(element2);
            document.body.appendChild(form);
            form.submit();
        }

        function editDate(user_property_id) {
            var form = document.createElement("form");
            var element1 = document.createElement("input");
            var element2 = document.createElement("input");
            var element3 = document.createElement("input");
            form.method = "POST";
            form.action = "<?php echo site_url('my_rentals/edit'); ?>";
            element1.value = user_property_id;
            element1.name = "user_property_id";
            form.appendChild(element1);
            element2.value = '<?php echo $this->security->get_csrf_hash() ?>';
            element2.name = "<?php echo $this->security->get_csrf_token_name() ?>";
            form.appendChild(element2);
            element3.value = 'dateCheck';
            element3.name = "forDate";
            form.appendChild(element3);
            document.body.appendChild(form);
            form.submit();
        }

        function del(property_id) {
            if (confirm("Are you sure you want to delete your Rental?")) {
                $.ajax({
                    url: "<?php echo site_url('my_properties/del'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        property_id: property_id,
                        <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    success: function(arg) {
                        toastr[arg.type](arg.text);
                        if (arg.type == 'success') {
                            window.location.reload();
                        }
                    }
                });
            }
        }

        function change_status(property_id) {
            $.ajax({
                url: "<?php echo site_url('my_properties/change_status'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    property_id: property_id,
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function(arg) {
                    toastr[arg.type](arg.text);
                    if (arg.type == 'success') {
                        window.location.reload();
                    }
                }
            });

        }

        function soldout(property_id) {
            if (confirm("Are You sure to perform this action? This action can not be undone.")) {
                $.ajax({
                    url: "<?php echo site_url('my_properties/mark_sold'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        property_id: property_id,
                        <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    success: function(arg) {
                        toastr[arg.type](arg.text);
                        if (arg.type == 'success') {
                            window.location.reload();
                        }
                    }
                });
            }
        }
    </script>