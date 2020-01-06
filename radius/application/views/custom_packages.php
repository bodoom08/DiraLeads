<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/top', [
    'title' => 'Areas'
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
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-primary m-2" data-toggle="modal" data-target="#addModal">+ Add Package</button>
                                        <span class="btn btn-primary" onclick="table_refresh();"><i class="fa fa-refresh"></i> Refresh</span>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table id="area-table" class="table small table-striped dt-responsive" width="100%">
                                <thead>
                                    <!-- <tr>
                                        <th colspan="3" class="text-center">Property Stats</th>
                                        <th colspan="4" class="text-center">Personal Information</th>
                                        <th rowspan="2" class="text-center">Actions</th>
                                    </tr> -->
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Actions</th>
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
            <?php echo form_open('custompackage/add_edit_custom_packages', 'id="addForm" class=""'); ?>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Package</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="package_id">
                    <label for="name" class="col-form-label">Package Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required/>
                </div>

                <div class="form-group">
                    <div class="upload_media mt-2" id="dynamic_field">
                        <label for="name" class="col-form-label">Days <span class="text-danger">*</span></label>
                        <div class="row" id="row_1">
                            <div class="col-md-4">
                                <div class="form-group"> 
                                    <div class="form-group">
                                        <input type="text" placeholder="No." class="form-control numeric" name="days_no[]">
                                    </div>                                             
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" placeholder="Price($)" class="form-control numeric" name="days_price[]">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success btn-xs" id="add" type="button" title="Add Attribute"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="upload_media mt-2" id="dynamic_field_area">
                        <label for="name" class="col-form-label">Area <span class="text-danger">*</span></label>
                        <div class="row" id="row_1">
                            <div class="col-md-4">
                                <div class="form-group"> 
                                    <div class="form-group">
                                        <input type="text" placeholder="No." class="form-control numeric" name="area_no[]">
                                    </div>                                             
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" placeholder="Price($)" class="form-control numeric" name="area_price[]">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success btn-xs" id="add_area" type="button" title="Add Attribute"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
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
            <?php echo form_open('areas/update', 'id="editForm" class=""'); ?>
            <div class="modal-header">
                <h5 class="modal-title">Edit Area</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="col-form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Area Title" required/>
                </div>
                <div class="form-group">
                    <label for="mobile" class="col-form-label">Parent Area</label>
                    <select class="form-control" name="area_type" id="area_type">
                        <option value="">None</option>
                        <?php foreach($allareas as $item) : ?>
                            <option value="<?php echo $item['id']; ?>"><?php echo $item['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
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
        window.DT = $('#area-table').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: "<?php echo site_url('custompackage/json'); ?>"
        });
    });

    $('#addForm, #editForm').ajaxForm({
        dataType: 'json',
        beforeSubmit: function() {
            event.preventDefault();
            // $('#addBtn, #editBtn').prop('disabled', 'disabled');
        },
        success: function(arg) {
            if(arg.type != 'success')
                toastr[arg.type](arg.text);
            if (arg.type == 'success') {
                toastr[arg.type](arg.text);
                $('#addForm, #editForm')[0].reset();
                $('#addModal, #editModal').modal('hide');
                DT.ajax.reload();
            }
        },
        complete: function() {
            // $('#addBtn, #editBtn').removeAttr('disabled');
        }
    });
    i = 1;
    $('#add').click(function() {
        i++;
        $('#dynamic_field').append(function() {
            return `
                <div class="row" id="row_` + i + `">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" placeholder="No." class="form-control numeric" name="days_no[]">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" placeholder="Price($)" class="form-control numeric" name="days_price[]">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-danger btn-xs btn_remove" id="` + i + `" type="button" title="Dismiss Attribute"><i class="fa fa-times"></i></button>
                    </div>
                </div>
            `;
        });
    });

    i = 1;
    $('#add_area').click(function() {
        i++;
        $('#dynamic_field_area').append(function() {
            return `
                <div class="row" id="row_` + i + `">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" placeholder="No." class="form-control numeric" name="area_no[]">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" placeholder="Price($)" class="form-control numeric" name="area_price[]">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-danger btn-xs btn_remove" id="` + i + `" type="button" title="Dismiss Attribute"><i class="fa fa-times"></i></button>
                    </div>
                </div>
            `;
        });
    });

    $(document).on('click', '.btn_remove', function() {
        $('#add').removeAttr('disabled');
        var button_id = $(this).attr("id");
        $('#row_' + button_id + '').remove();
    });

    $('body').on('keypress', '.numeric', function (e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
    });

    function edit(id) {
        if (confirm("Are You sure to perform this action?")) {

            $('#addForm')[0].reset();
            $.ajax({
                url: "<?php echo site_url('custompackage/edit') ?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function(arg) {
                    // var values = arg.for.split(",");
                    // $("#for").find('[value="' + values.join('"], [value="') + '"]').prop("checked", true);

                    $('#addForm').find('input[name="package_id"]').val(arg.custom_package_names.id);
                    $('#addForm').find('input[name="name"]').val(arg.custom_package_names.name);
                    arr_length = $(arg.custom_package_days).length;
                    index = 1;
                    $(arg.custom_package_days).each(function(i, v) {
                        index++;
                        var el_first_button = $('#addForm #dynamic_field #row_1').find('button');
                        var el = $('#addForm #dynamic_field .row:last-child');
                        $(el).find('input[name="days_no[]"]').val(v.noof);
                        $(el).find('input[name="days_price[]"]').val(v.price);
                        if(index <= arr_length) {
                            $(el_first_button).trigger('click');
                        }
                    });

                    arr_length = $(arg.custom_package_areas).length;
                    index = 1;
                    $(arg.custom_package_areas).each(function(i, v) {
                        index++;
                        var el_first_button = $('#addForm #dynamic_field_area #row_1').find('button');                        
                        var el = $('#addForm #dynamic_field_area .row:last-child');
                        $(el).find('input[name="area_no[]"]').val(v.noof);
                        $(el).find('input[name="area_price[]"]').val(v.price);
                        if(index <= arr_length) {
                            $(el_first_button).trigger('click');
                        }
                    });

                    $('#exampleModalLabel').text('Edit Package');
                    $('#addBtn').text('Edit');
                    // $('#editForm').find('select[name="area_type"]').val(arg.area);
                    // $('#editForm').append(`<input type="hidden" name="id" value="${arg.id}" />`);
                    $('#addModal').modal('show');
                }
            });
        } else {
            $("#editModal .close").click();
        }
    }
    $('#addModal').on('hidden.bs.modal', function() {
        $('#exampleModalLabel').text('Add Package');
        $('#addBtn').text('Add');
        $(document).find('.btn_remove').trigger('click');
        $('#addForm')[0].reset();
        $('input[name="package_id"]').val('');
    });

    function changeStatus(id) {
        if (confirm("Are You sure to perform this action?")) {
            $.ajax({
                url: "<?php echo site_url('custompackage/changeStatus'); ?>",
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

    function table_refresh() {
        DT.ajax.reload();
    }
</script>
