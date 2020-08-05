<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/top', [
    'title' => 'Widgets'
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
                                        <h5>Widgets</h5>
                                    </div>
                                </div>
                            </div>
                            <table id="pages-table" class="table table-condensed" width="100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Last Update</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($widgets as $widget) : ?>
                                        <tr>
                                            <td><?php echo $widget->name; ?></td>
                                            <td><?php echo $widget->updated_at; ?></td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button type="button" class="btn btn-info" title="Edit Widget" onclick="location.href+='/edit/<?php echo $widget->name; ?>'">Edit</button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <p class="sub-banner-2 text-center">© Copyright 2019. All rights reserved</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('common/bottom'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<!-- include summernote css/js -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>
<script>
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
                url: "<?php echo site_url('website/pages/changeStatus'); ?>",
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
            location.href = `<?php echo site_url('website/pages/edit') ?>/${id}`;
        }
    }

    function del(id) {
        if (confirm("Are You sure to perform this action?")) {
            $.ajax({
                url: "<?php echo site_url('website/pages/index') ?>/" + id,
                type: 'DELETE',
                dataType: 'json',
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