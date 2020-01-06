<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/top', [
    'title' => 'Properties'
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
                        <div class="table-design bg-light">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <h5><?php
                                            if(constant('IS_AGENT')) {
                                                echo 'Properties (Pending listing)';
                                            } else {
                                                echo 'Records';
                                            }
                                        ?></h5>
                                    </div>
                                    <div class="pull-right mb-3">
                                        <span class="btn btn-primary" onclick="table_refresh();"><i class="fa fa-refresh"></i> Refresh</span>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table id="property-table" class="table table-btn table-sm small table-striped nowrap dt-responsive" width="100%">
                                <thead>
                                    <tr>
                                        <th>Owner</th>
                                        <th>For</th>
                                        <th>Property Type</th>
                                        <th>Area</th>
                                        <th>Price</th>
                                        <th>Available Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                    <p class="sub-banner-2 text-center">© Copyright 2019. All rights reserved</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('common/bottom'); ?>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $(function() {
        window.DT = $('#property-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo site_url('property/json') ?>"
        });
    });

    function changeStatus(property_id) {
        if (confirm("Are You sure to perform this action?")) {
            $.ajax({
                url: "<?php echo site_url('property/changeStatus'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    property_id: property_id,
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function(arg) {
                    toastr[arg.type](arg.text);
                    if (arg.type == 'success') {
                        DT.ajax.reload();
                    }
                }
            });
        }
    }

    function table_refresh() {
        DT.ajax.reload();
    }

    function resolveDID(id) {
        $.ajax({
            url: "<?php echo site_url('property/resolve_did'); ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            success: function(arg) {
                toastr[arg.type](arg.text);
                if (arg.type == 'success') {
                    DT.ajax.reload();
                }
            }
        });
    }
</script>