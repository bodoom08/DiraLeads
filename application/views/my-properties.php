<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/front_end_layout/top', [
    'title' => 'My Properties'
]);
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
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
                            <h3>My Properties List</h3>
                            <div class="table-responsive">
                            <table class="manage-table">
                                <tbody>
                                    <?php if (empty($my_properties)) { ?>
                                        <tr class="responsive-table">
                                            <h4 style="text-align: center;">Sorry, No Property Available!</h4>
                                        </tr>
                                    <?php } else { ?>
                                        <style>
                                            .soldout {
                                                opacity: 0.5;
                                            }
                                        </style>
                                        <?php foreach ($my_properties as $key => $value) : ?>
                                            <tr class="responsive-table <?php echo ($value['sold'] == 'true') ? 'soldout' : ''; ?> ">
                                                <td class="listing-photoo">
                                                    <input type="hidden" name="user_property_id" value="<?php echo $value['id'] ?>">
                                                    <img src="<?php echo ($value['images'] == '') ? 'assets/img/empty_property_image.jpg' : base_url('uploads/') . $value['images'] ?>" alt="listing-photo" class="img-fluid">
                                                </td>
                                                <td class="title-container">
                                                    <h2><a href="#">For <?php echo ucfirst($value['for']); ?></a></h2>
                                                    <h5 class="d-none d-xl-block d-lg-block d-md-block"><i class="flaticon-pin"></i> <?php echo  $value['house_number'] ?>, <?php echo $value['street'] ?> </h5>
                                                    <h6 class="table-property-price">$<?php echo $value['price'] ?> / monthly</h6>
                                                </td>
                                                <?php if($value['sold'] == 'true'): ?>
                                                    <td class="text-danger"><b>Sold</b></td>
                                                <?php elseif ($value['number']) : ?>
                                                    <td class="text-<?php echo ($value['status'] == 'active' ? 'success' : 'warning'); ?>"><?php echo ($value['status'] == 'active' ? '' : 'Paused'); ?></td>
                                                <?php else : ?>
                                                    <td class="text-danger" title="Number allocation failed at the time of your submission. Please contact admin to allocate a number for this property">Contact Admin !</td>
                                                <?php endif; ?>
                                                <td class="expire-date"><?php echo $value['available_date'] ?></td>
                                                <td class="action">
                                                    <?php if($value['sold'] != 'true') { ?>
                                                    <a href="javascript:(0);" onclick="edit(<?php echo $value['id'] ?>);"><i class="fa fa-pencil"></i> Edit</a>
                                                    <a href="javascript:(0);" onclick="change_status(<?php echo $value['id'] ?>);"><i class="fa  <?php echo ($value['status'] == 'active' ? 'fa-eye-slash' : 'fa-eye'); ?>"></i> <?php echo ($value['status'] == 'active' ? 'Pause' : 'Resume'); ?></a>
                                                    <a href="javascript:(0);" onclick="del(<?php echo $value['id'] ?>);" class="delete"><i class="fa fa-remove"></i> Delete</a>
                                                    <a href="javascript:(0);" onclick="soldout(<?php echo $value['id'] ?>);"><i class="fa fa-ban"></i> Sold Out</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                            <div class="pagination-box hidden-mb-45 text-center">
                                <nav aria-label="Page navigation example">
                                    <?php echo $this->pagination->create_links(); ?>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <p class="sub-banner-2 text-center">© 2019 Diraleads. Trademarks and brands are the property of their respective owners.</p>
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
        form.action = "<?php echo site_url('my_properties/edit'); ?>";
        element1.value = user_property_id;
        element1.name = "user_property_id";
        form.appendChild(element1);
        element2.value = '<?php echo $this->security->get_csrf_hash() ?>';
        element2.name = "<?php echo $this->security->get_csrf_token_name() ?>";
        form.appendChild(element2);
        document.body.appendChild(form);
        form.submit();
    }

    function del(property_id) {
        if (confirm("Are You sure to perform this action?")) {
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
        if (confirm("Are You sure to perform this action?")) {
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