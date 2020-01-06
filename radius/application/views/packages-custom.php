<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/top', [
    'title' => 'Packages'
]);
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
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
                                        <h5>Records</h5>
                                    </div>
                                    <div class="pull-right mb-3">
                                        <span class="btn btn-primary" onclick='window.location.href="/radius/pricing/custom_pricing"'><i class="fa fa-box"></i>+ Subscribed package</span>
                                        <span class="btn btn-primary" onclick="table_refresh();"><i class="fa fa-refresh"></i> Refresh</span>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table id="package-table" class="table small table-sm table-striped table-bordered dt-responsive" width="100%">
                                <thead>
                                    <tr>
                                        <th>Package Name</th>
                                        <th>User Name</th>
                                        <th>Details</th>
                                        <th>Price</th>
                                        <th>Validity</th>                             
                                        <th>Description</th>
                                        <th>No Of Area</th>
                                        <th>No Of Days</th>
                                        <th>Status</th>                                      
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
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?php echo form_open('package/update', 'id="updateForm" class=""'); ?>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <strong><span>For - </span><span id="for"></span></strong>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="id">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="col-form-label">
                               
                            </label>                            
                            <input type="text" class="form-control" id="name" name="name" />
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-form-label">Price</label>
                            <input type="text" class="form-control numeric" id="price" name="price" />
                        </div>
                        <div class="form-group">
                            <label for="validity" class="col-form-label">Validity Period(days)</label>
                            <input type="text" class="form-control numeric" id="validity" name="validity" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description" class="col-form-label">Description</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <!-- <div class="form-group">
                            <strong><span>For - </span><span id="for"></span></strong>
                        </div> -->
                        <div class="form-group">
                            <label for="description" class="col-form-label">No Of Location Select</label>
                            <input type="text" required class="form-control numeric_not_zero" id="no_of_location_select" name="no_of_location_select" placeholder="No Of Location Select" />
                        </div>
                        <div class="form-group">
                            <label for="Alert Type">Notification Alert type</label>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="phone_alert" name="phone_alert" value="on" >
                                <label class="custom-control-label" for="phone_alert">Phone</label>
                            </div>

                            <!-- Default inline 2-->
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="email_alert" name="email_alert" value="on" >
                                <label class="custom-control-label" for="email_alert">Email</label>
                            </div>

                            <!-- Default inline 2-->
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="fax_alert" name="fax_alert" value="on" >
                                <label class="custom-control-label" for="fax_alert">Fax</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="updateBtn" class="btn btn-primary">Update</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<?php $this->load->view('common/bottom'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $(function() {
        window.DT = $('#package-table').DataTable({
            processing: true,
            serverSide: true,
            "ordering": false,
            ajax: "<?php echo site_url('package/json_custom_package'); ?>"
        });
    });

    $('#updateForm').ajaxForm({
        dataType: 'json',
        beforeSubmit: function() {
            event.preventDefault();
            $('#updateBtn').prop('disabled', 'disabled');
        },
        success: function(arg) {
            $('#updateBtn').removeAttr('disabled');
            toastr[arg.type](arg.text);
            if (arg.type == 'success') {
                $('#updateForm')[0].reset();
                $('#editModal').modal('toggle');
                DT.ajax.reload();
            }
        }
    });

    function changeStatus(package_id) {
        if (confirm("Are You sure to perform this action?")) {
            $.ajax({
                url: "<?php echo site_url('package/changeStatus'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    package_id: package_id,
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

    function edit(id) {
        if (confirm("Are You sure to perform this action?")) {
            $('#updateForm')[0].reset();
            $.ajax({
                url: "<?php echo site_url('package/edit') ?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function(arg) {                    
                    // var values = arg.for.split(",");
                    // $("#for").find('[value="' + values.join('"], [value="') + '"]').prop("checked", true);
                    $('input[name="email_alert"], input[name="phone_alert"], input[name="fax_alert"]').prop('checked', false);
                    $.each(arg, function(i, row) {
                        var elem = $('#updateForm [name="' + i + '"]');
                        elem.val(row);
                        if((i == "email_alert") && row == "true")
                            $('input[name="email_alert"]').prop('checked', true);
                            

                        if((i == "phone_alert") && row == "true")
                            $('input[name="phone_alert"]').prop('checked', true);

                        if((i == "fax_alert") && row == "true")
                            $('input[name="fax_alert"]').prop('checked', true);
                            
                    });
                    $('#for').html(arg.for.substr(0, 1).toUpperCase() + arg.for.substr(1));
                    $('#editModal').modal('show');
                }
            });
        } else {
            $("#editModal .close").click();
        }
    }

    function del(id) {
        if (confirm("Are You sure to perform this action?")) {
            $.ajax({
                url: "<?php echo site_url('package/del') ?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    package_id: id,
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

    $('.numeric').keypress(function (e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
    });
    $('.numeric_not_zero').keypress(function (e) {
        if (String.fromCharCode(e.keyCode).match(/[^1-9]/g)) return false;
    });
</script>