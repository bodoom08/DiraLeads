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
                                        <!-- <span class="btn btn-primary" onclick='window.location.href="/radius/pricing/custom_pricing"'><i class="fa fa-box"></i>+ Subscribed package</span> -->
                                        <span class="btn btn-primary" onclick="showAddPackageModal();"><i class="fa fa-box"></i>+ Subscribed package</span>
                                        <span class="btn btn-primary" onclick="table_refresh();"><i class="fa fa-refresh"></i> Refresh</span>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="package-table" class="table small table-sm table-striped table-bordered dt-responsive" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>UserId</th>
                                            <th>Email</th>
                                            <th>Area</th>
                                            <th>Date From</th>                             
                                            <th>Date To</th>
                                            <th>Bedroom</th>
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
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?php echo form_open('package/insert', 'id="addForm" class=""')?>
                <div class="modal-header">
                    <h5 class="modal-title">Add New Subscriber</h5>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="subscriber_id">User Id:</label>
                        <select class="form-control" id="subscriber_id" name="subscriber" required>
                            <option value=''>Select User Id</option>
                            <?php foreach($users as $user) {?>
                                <option value="<?php echo $user['id'].'|'.$user['email']?>"><?php echo $user['id'].' - '.$user['name']?></option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-8">
                            <div class="form-group">
                                <label for="area_id">Area:</label>
                                <select class="form-control" id="area_id" name="area" required>
                                    <option value=''>Select Area</option>
                                <?php foreach($areas as $area) {?>
                                    <option value="<?php echo $area['id']?>"><?php echo $area['title']?></option>
                                <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="num_bedrooms">Bedrooms: </label>
                                <input type="number" min="0" class="form-control" id="num_bedrooms" name="bedroom" required/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="date_from">Date From:</label>
                                <input type="date" class="form-control" id="date_from" name="date_from" required/>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="date_to"> Date To:</label>
                                <input type="date" class="form-control" id="date_to" name="date_to" required/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" id="submitBtn">Submit</button>
                </div>
            <?php echo form_close()?>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?php echo form_open('package/updateSubscriber', 'id="updateForm" class=""')?>
                <input type="hidden" id="hid_subscriber" name="subscriber_id" />

                <div class="modal-header">
                    <h5 class="modal-title">Edit a Subscriber</h5>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_subscriber_id">User Id:</label>
                        <select class="form-control" id="edit_subscriber_id" name="subscriber" required>
                            <option value=''>Select User Id</option>
                            <?php foreach($users as $user) {?>
                                <option value="<?php echo $user['id'].'|'.$user['email']?>"><?php echo $user['id'].' - '.$user['name']?></option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-8">
                            <div class="form-group">
                                <label for="edit_area_id">Area:</label>
                                <select class="form-control" id="edit_area_id" name="area" required>
                                    <option value=''>Select Area</option>
                                <?php foreach($areas as $area) {?>
                                    <option value="<?php echo $area['id']?>"><?php echo $area['title']?></option>
                                <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="edit_num_bedrooms">Bedrooms: </label>
                                <input type="number" min="0" class="form-control" id="edit_num_bedrooms" name="bedroom" required/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="edit_date_from">Date From:</label>
                                <input type="date" class="form-control" id="edit_date_from" name="date_from" required/>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="edit_date_to"> Date To:</label>
                                <input type="date" class="form-control" id="edit_date_to" name="date_to" required/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" id="updateBtn">Update</button>
                </div>
            <?php echo form_close()?>
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
            ordering: false,
            ajax: "<?php echo site_url('package/getSubscribers'); ?>"
        });
    });

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

<script>
    function showAddPackageModal() {
        $('#addModal').modal('show');
    }

    $('#addForm').ajaxForm({
        dataType: 'json',
        beforeSubmit: function() {
            event.preventDefault();
            $('#submitBtn').prop('disabled', 'disabled');
        },
        success: function (arg) {
            $('#submitBtn').removeAttr('disabled');
            toastr[arg.type](arg.text);
            if (arg.type == 'success') {
                $('#addForm')[0].reset();
                $('#addModal').modal('toggle');
                DT.ajax.reload();
            }
        }
    });

    $('#updateForm').ajaxForm({
        dataType: 'json',
        beforeSubmit: function () {
            event.preventDefault();
            $('#updateBtn').prop('disabled', 'disabled');
        },
        success: function (res) {
            $('#updateBtn').removeAttr('disabled');
            toastr[res.type](res.text);
            if (res.type == 'success') {
                $('#updateForm')[0].reset();
                $('#editModal').modal('toggle');
                DT.ajax.reload();
            }
        }
    })

    function onEditSubscriber(id) {
        $.ajax({
            url: `/radius/package/getSubscriberDetail?id=${id}`,
            method: 'GET',
            success: function (res) {
                const response = JSON.parse(res);

                if (response.type == 'success') {
                    const subscriber = response.text;
                    console.log("Subscriber: ", subscriber);

                    document.getElementById('edit_subscriber_id').value = `${subscriber.user_id}|${subscriber.email_id}`;
                    document.getElementById('edit_area_id').value = subscriber.area_id;
                    document.getElementById('edit_date_from').value = subscriber.date_from;
                    document.getElementById('edit_date_to').value = subscriber.date_to;
                    document.getElementById('edit_num_bedrooms').value = subscriber.bedroom;
                    document.getElementById('hid_subscriber').value = subscriber.id;

                    $('#editModal').modal('show');
                } else {
                    toastr[response.type](response.text);
                }
            },
            fail: function (err) {
                toastr.error('Something is going wrong');
                console.log("Error: ", err);
            }
        });
    }

    function onRemoveSubscriber(id) {
        if (!confirm('Are you sure to remove?')) return;

        $.ajax({
            url: `/radius/package/removeSubscriber?id=${id}`,
            method: 'GET',
            success: function (res) {
                const response = JSON.parse(res);
                toastr[response.type](response.text);
                DT.ajax.reload();
            },
            fail: function (err) {
                toastr.error('Something is going wrong');
                console.log("Error: ", err);
            }
        })
    }
</script>