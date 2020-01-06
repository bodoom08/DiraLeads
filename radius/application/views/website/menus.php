<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/top', [
    'title' => 'Menus'
]);
?>
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
                                        <h5>All Menus</h5>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo site_url('website/menus/new'); ?>" class="btn btn-primary btn-round btn-sm m-2">New Menu</a>
                                    </div>
                                </div>
                            </div>
                            <?php foreach ($data as $row) : ?>
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <h5><?php echo $row['description']; ?></h5>
                                    </div>
                                    <table class="table table-bordered table-striped table-sm" width="100%">
                                        <thead>
                                            <tr>
                                            <th>Title</th>
                                            <th>URL</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php if (isset($row['menus'])) : ?>
                                            <tbody data-posid="<?php echo $row['id']; ?>">
                                                <?php foreach ($row['menus'] as $menu) : ?>
                                                    <tr data-id="<?php echo $menu['id']; ?>">
                                                        <td><?php echo $menu['title']; ?></td>
                                                        <td><?php echo $menu['url']; ?></td>
                                                        <td><?php echo ucfirst($menu['status']); ?></td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <button class="btn btn-info menu-up" title="Move up"><i class="fa fa-arrow-up"></i></button>
                                                                <button class="btn btn-info menu-down" title="Move down"><i class="fa fa-arrow-down"></i></button>
                                                                <button class="btn btn-secondary" onclick="edit(<?php echo $menu['id']; ?>)" title="Edit"><i class="fa fa-edit"></i></button>
                                                                <button class="btn btn-danger" onclick="del(<?php echo $menu['id']; ?>)" title="Delete"><i class="fa fa-trash-o"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        <?php endif; ?>
                                    </table>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <p class="sub-banner-2 text-center">© Copyright 2019. All rights reserved</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('common/bottom'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
    $('.menu-up').click(function() {
        var currTr = $(this).parents('tr');
        currTr.insertBefore(currTr.prev());
        updatePosition(currTr.parents('tbody'))
    });

    $('.menu-down').click(function() {
        var currTr = $(this).parents('tr');
        currTr.insertAfter(currTr.next());
        updatePosition(currTr.parents('tbody'))
    });

    function updatePosition(tbody) {
        var posId = tbody.data('posid');
        var menus = tbody.children().map((i, tr) => $(tr).data('id'));

        $.ajax({
            type: 'patch',
            url: `<?php echo site_url('website/menus/update_pos'); ?>/${posId}`,
            dataType: 'json',
            data: {
                menuIds: menus.get()
            },
            success: function(arg) {
                toastr[arg.type](arg.text);
            }
        });
    }
</script>

<script>
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
            location.href = `<?php echo site_url('website/menus/edit') ?>/${id}`;
        }
    }

    function del(id) {
        if (confirm("Are You sure to perform this action?")) {
            $.ajax({
                url: "<?php echo site_url('website/menus/index') ?>/" + id,
                type: 'DELETE',
                dataType: 'json',
                success: function(arg) {
                    toastr[arg.type](arg.text);
                    if (arg.type == 'success') {
                        location.reload();
                    }
                }
            });
        }
    }
</script>