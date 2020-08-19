<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/top', [
    'title' => 'Backup DB'
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
                <div class="text-center">
                    <?php
                    $attributes = [
                        'method' => 'POST',
                        'id' => 'dbbkupform'
                    ];
                    echo form_open('database/dobkup', $attributes); ?>
                    <!-- <button type="submit" class="btn btn-primary mt-5"><i class="fa fa-database"></i> Backup Database</button> -->
                    <?php echo form_close();  ?>

                    <h4 class="mt-5">Database Backup List</h4>

                    <table class="table table-stripped table-bordered mt-5">
                        <thead>
                            <tr>
                                <td>Date</td>
                                <td>Filename</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($map as $key => $value) { ?>
                                <?php
                                    $filename = explode('.', $value);
                                    $datetime = explode('_', $filename[0]);
                                ?>
                                <tr>
                                    <td>
                                        <?php echo date('dS F Y', strtotime($datetime[1])); ?>
                                    </td>
                                    <td>
                                        <?php echo $value; ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-primary" title="Download" href="<?php echo site_url('/').'dbbkup/'.$value; ?>" download>Download</a>
                                        <button type="button" class="btn btn-outline-danger" title="Delete file" onclick="deletefile('<?php echo $value; ?>')">Delete</button>
                                    </td>
                                </tr>                                
                            <?php } ?>
                        </tbody>
                    </table>
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
                    <input type="text" class="form-control" id="name" name="name" required/>
                </div>
                <div class="form-group">
                    <label for="email" class="col-form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required/>
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
                    <input type="text" class="form-control" id="name" name="name" required/>
                </div>
                <div class="form-group">
                    <label for="email" class="col-form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required readonly/>
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

<?php $this->load->view('common/bottom'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $(function() {
        window.DT = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: "<?php echo site_url('users/json'); ?>"
        });
    });

    $('#addForm, #editForm').ajaxForm({
        dataType: 'json',
        beforeSubmit: function() {
            event.preventDefault();
            $('#addBtn, #editBtn').prop('disabled', 'disabled');
        },
        success: function(arg) {
            toastr[arg.type](arg.text);
            if (arg.type == 'success') {
                $('#addForm, #editForm')[0].reset();
                $('#addModal, #editModal').modal('hide');
                DT.ajax.reload();
            }
        },
        complete: function() {
            $('#addBtn, #editBtn').removeAttr('disabled');
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
                    $('#editModal').modal('show');
                }
            });
        } else {
            $("#editModal .close").click();
        }
    }

    function deletefile(filename) {
        if (confirm("Are You sure to perform this action?")) {
            $.ajax({
                url: "<?php echo site_url('database/deletefile') ?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    filename: filename,
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function(arg) {
                    toastr[arg.type](arg.text);
                    if (arg.type == 'success') {
                        DT.ajax.reload();
                        location.reload();
                    }
                }
            });
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
</script>
