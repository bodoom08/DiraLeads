<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/top', [
    'title' => 'Users'
]);
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
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
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-primary m-2" data-toggle="modal" data-target="#addModal">+ Add User</button>
                                        <span class="btn btn-primary" onclick="table_refresh();"><i class="fa fa-refresh"></i> Refresh</span>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="users-table" class="table small table-striped dt-responsive" width="100%">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-center">Property Stats</th>
                                            <th colspan="4" class="text-center">Personal Information</th>
                                            <th rowspan="2" class="text-center">Actions</th>
                                        </tr>
                                        <tr>
                                            <th>User ID</th>
                                            <th>Packages</th>
                                            <th>Calls</th>
                                            <th>Posts</th>

                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
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

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo form_open('users/add_user', 'id="addForm" class=""'); ?>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="col-form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required />
                </div>
                <div class="form-group">
                    <label for="email" class="col-form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" />
                </div>
                <div class="form-group">
                    <label for="country" class="col-form-label">Country Code</label>
                    <select name="country" class="form-control input-select" id="country" style="width: 100% !important;height:45px !important;">
                        <option value="">Select Country Code</option>
                        <?php foreach ($countries as $country) { ?>
                            <option value="<?php echo '+' . $country->phonecode; ?>"><?php echo $country->nicename . '(+' . $country->phonecode . ')'; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mobile" class="col-form-label">Mobile</label>
                    <input type="number" class="form-control" id="mobile" name="mobile" required />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="addBtn" class="btn btn-primary">Add</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo form_open('users/update', 'id="editForm" class=""'); ?>
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="col-form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required />
                </div>
                <div class="form-group">
                    <label for="email" class="col-form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" />
                </div>
                <div class="form-group">
                    <label for="country" class="col-form-label">Country Code</label>
                    <select name="country_ed" class="form-control input-select" id="country_ed" style="width: 100% !important;height:45px !important;">
                        <option value="">Select Country Code</option>
                        <?php foreach ($countries as $country) { ?>
                            <option value="<?php echo '+' . $country->phonecode; ?>"><?php echo $country->nicename . '(+' . $country->phonecode . ')'; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mobile" class="col-form-label">Mobile</label>
                    <input type="number" class="form-control" id="mobile" name="mobile" required />
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

<div class="modal fade" id="verifyUserModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo form_open('users/verify', 'id="verifyUserForm" class=""'); ?>
            <div class="modal-header">
                <h5 class="modal-title">Verify User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="userid">
                    <label for="name" class="col-form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required />
                </div>
                <div class="form-group">
                    <label for="email" class="col-form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="cnf_password" name="cnf_password" required />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="verifyBtn" class="btn btn-primary">Verify User</button>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script>
    $(function() {
        // $('#country').select2();
        window.DT = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: "<?php echo site_url('users/json'); ?>"
        });
    });

    $('#addForm, #editForm, #verifyUserForm').ajaxForm({
        dataType: 'json',
        beforeSubmit: function() {
            event.preventDefault();
            $('#addBtn, #editBtn, #verifyBtn').prop('disabled', 'disabled');
        },
        success: function(arg) {
            toastr[arg.type](arg.text);
            if (arg.type == 'success') {
                $('#addForm, #editForm, #verifyUserForm')[0].reset();
                $('#addModal, #editModal, #verifyUserModal').modal('hide');
                DT.ajax.reload();
            }
        },
        complete: function() {
            $('#addBtn, #editBtn, #verifyBtn').removeAttr('disabled');
        }
    });

    function changeStatus(id) {
        if (confirm("Are You sure to perform this action?")) {
            $.ajax({
                url: "<?php echo site_url('users/changeStatus'); ?>",
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
    }

    $('#editModal').on('hidden.bs.modal', function() {
        $('#editForm [name="id"]').remove();
    });

    function edit(id) {
        if (confirm("Are You sure to perform this action?")) {
            $('#editForm')[0].reset();
            $.ajax({
                url: "<?php echo site_url('users/edit') ?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function(arg) {
                    // var values = arg.for.split(",");
                    // $("#for").find('[value="' + values.join('"], [value="') + '"]').prop("checked", true);
                    $.each(arg, function(i, row) {
                        var elem = $('#editForm [name="' + i + '"]');
                        elem.val(row);
                    });
                    $('#editForm').append(`<input type="hidden" name="id" value="${id}" />`);
                    $('#country_ed').val(arg.country_code);
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
                url: "<?php echo site_url('users/del') ?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    users_id: id,
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

    var userid = '';

    function verifyUser(id) {
        userid = id;
        $('input[name="userid"]').val(id);
        $('#verifyUserModal').modal('show');

    }

    function resendVerify(id) {
        if (confirm("Are You sure to perform this action?")) {
            $.ajax({
                url: "<?php echo site_url('users/resendVerifyEmail') ?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    users_id: id,
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
</script>