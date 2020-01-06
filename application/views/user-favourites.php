<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/front_end_layout/top', [
    'title' => 'User Favourites'
]);
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<div class="dashboard">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-12 col-sm-12 col-pad">
                <div class="dashboard-nav d-none d-xl-block d-lg-block">
                    <?php $this->load->view('common/front_end_layout/sidebar'); ?>
                </div>
            </div>
            <?php
            $attrs = [
                'name'=> 'modify_package_form',
                'method' => 'POST'
            ];
            echo form_open_multipart('pricing/manage_subscribed_package_custom', $attrs);
            ?>
                <input type="hidden" name="package_table_id">
                <input type="hidden" name="action">
                
            </form>
            <form action="<?php echo site_url('subscription/manage_package_area_info'); ?>" name="modify_package_area_info_form" method="POST">
                <input type="hidden" name="package_table_id">
                <input type="hidden" name="action">
            </form>
            <div class="col-lg-10 col-md-12 col-sm-12 col-pad">
                <div class="content-area5">
                    <div class="dashboard-content">
                        <div class="dashboard-list">
                            <div class="row">
                             <div class="col-md-8">
                             <h3 class="heading" style="border-bottom:0px;"> User Favourites</h3>
                             </div>
                             <div class="col-md-4">
                             <div class="pull-right">
                                    <!-- <button type="button" class="btn btn-primary m-2" data-toggle="modal" data-target="#addModal">+ Add Preference</button> -->
                                </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <hr/>
                            <div class="dashboard-message contact-2 bdr clearfix">
                                <div class="table-responsive">
                                    <table id="preferences-table" class="table small table-striped dt-responsive" width="100%">
                                        <thead>
                                            <tr>                                                
                                                <th>Area</th>
                                                <th>Property Details</th>
                                                <th>Days</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="sub-banner-2 text-center">© Copyright <?php date('Y-m-d'); ?>. All rights reserved</p>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('common/front_end_layout/bottom'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $(function() {
        window.DT = $('#preferences-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo site_url('favourites/json'); ?>"
        });
    });
</script>