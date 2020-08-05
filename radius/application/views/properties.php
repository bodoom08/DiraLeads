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
                            <!-- <form action="" method="GET"> -->
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="property_id" placeholder="Search By Property ID" autocomplete="off" value="<?php echo (isset($_GET['property_id'])) ? $_GET['property_id'] : ''; ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-primary" type="submit" onclick="dt_reload()"><i class="fa fa-search"></i> Search </button>
                                    </div>
                                </div>
                            <!-- </form> -->
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
<span class="btn btn-primary" onclick="window.location.href='<?php echo site_url('property/add_property'); ?>'"><i class="fa fa-plus"></i> Add </span>
                                        <span class="btn btn-primary" onclick="table_refresh();"><i class="fa fa-refresh"></i> Refresh</span>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table id="property-table" class="table table-btn table-sm small table-striped nowrap dt-responsive" width="100%">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Owner</th>
                                        <th>For</th>
                                        <th>Property ID</th>
                                        <th>Property Type</th>
                                        <th>Area</th>
                                        <th>Price</th>
                                        <th>Available Date</th>
                                        <th>Status</th>
                                        <th>Created/Edited By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                    <p class="sub-banner-2 text-center">© Copyright <?php echo date('Y'); ?>. All rights reserved</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('common/bottom'); ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $(function() {
        window.DT = $('#property-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo site_url('property/json') ?>",
                data: function(d) {
                   d.property_id = $('input[name="property_id"]').val()
                }
            }
            
        });
    });

    function dt_reload() {
        window.DT.ajax.reload();
    }

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

    function editProperty(property_id){
        var form = document.createElement("form");
        var element1 = document.createElement("input");
        var element2 = document.createElement("input");
        form.method = "POST";
        form.action = "<?php echo site_url('property/edit'); ?>";
        element1.value = property_id;
        element1.name = "property_id";
        form.appendChild(element1);
        element2.value = '<?php echo $this->security->get_csrf_hash() ?>';
        element2.name = "<?php echo $this->security->get_csrf_token_name() ?>";
        form.appendChild(element2);
        document.body.appendChild(form);
        form.submit();
    }
</script>
