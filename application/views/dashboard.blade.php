@extends('common.panel')

@section('content')

 <?php
$attrs = [
    'name'=> 'modify_package_form',
    'method' => 'POST'
];
echo form_open_multipart('pricing/manage_subscribed_package_custom', $attrs);
?>

    <input type="hidden" id="csrfToken" name="package_table_id">
    <input type="hidden" name="action">
</form>


<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6">
        <div class="ui-item bg-success">
            <div class="left">
                <h4>{{$active_listing}}</h4>
                <p>Active Listings</p>
            </div>
            <div class="right">
                <i class="fa fa-map-marker"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6">
        <div class="ui-item bg-warning">
            <div class="left">
                <h4>{{$subscribed_for_packages}}</h4>
                <p>Subscribed Packages</p>
            </div>
            <div class="right">
                <i class="fa fa-archive"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6">
        <div class="ui-item bg-active">
            <div class="left">
                <h4>{{$no_of_views}}</h4>
                <p>No of Property Views</p>
            </div>
            <div class="right">
                <i class="fa fa-eye"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6">
        <div class="ui-item bg-dark">
            <div class="left">
                <h4>{{$bookmarked}}</h4>
                <p>Bookmarked</p>
            </div>
            <div class="right">
                <i class="fa fa-heart-o"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="dash-title-new">
            <h4>Favourites</h4>
        </div>
    </div>
</div>

<div class="dn-items row"></div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="dash-title-new">
            <h4>My Property List</h4>
        </div>
    </div>
    <div class="col-md-12 col-lg-12">
        <div class="item-table">
            <table class="table">

                <?php if (empty($my_properties)) { ?>
                    <div class="col-lg-12 text-center mt-5 dashboard_fav">
                        <p><i class="fa fa-search" aria-hidden="true"></i></p>
                        <h5 class="text-head">No rentals listed</h5>
                        <p>List your Rental <a href="/rental">Here</a></p>
                    </div>
                <?php } else { ?>
                    <style>
                        .soldout {
                            opacity: 0.5;
                        }
                    </style>
                    <?php foreach ($my_properties as $key => $value) : ?>
                        <?php if ($key < 4) { ?>
                            <tr class="<?php echo ($value['sold'] == 'true') ? 'soldout' : ''; ?> ">
                                <td style="width: 150px">
                                    <div class="img-sec-tb">
                                        <input type="hidden" name="user_property_id" value="<?php echo $value['id'] ?>">
                                        <img class="img-whp" src="<?php echo ($value['images'] == '') ? 'assets/img/empty_property_image.jpg' : base_url('uploads/') . $value['images'] ?>" alt="listing-photo">
                                </td>
                                <td>
                                    <div class="rent-tb">
                                        <ul>
                                            <li>
                                                <h5>For <?php echo ucfirst($value['for']); ?></h5>
                                            </li>
                                            <li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $value['street'] ?></li>
                                            <li>$<?php echo $value['price'] ?>/Monthly</li>
                                        </ul>
                                    </div>
                                </td>

                                <td><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo $value['available_date'] ?></td>
                                <td>
                                    <div class="service-tb">
                                        <?php if ($value['sold'] != 'true') { ?>
                                            <ul>
                                                <li><a href="javascript:(0);" onclick="edit(<?php echo $value['id'] ?>);"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a></li>


                            <td><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo $value['available_date'] ?></td>
                            <td>
                                <div class="service-tb">
                                <?php if($value['sold'] != 'true') { ?>
                                    <ul>
                                        <li><a href="javascript:(0);" onclick="edit(<?php echo $value['id'] ?>);"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a></li>
                                        <li><a href="javascript:(0);" onclick="change_status(<?php echo $value['id'] ?>);"><i class="fa <?php echo ($value['status'] == 'active' ? 'fa-eye-slash' : 'fa-eye'); ?>" aria-hidden="true"></i> <?php echo ($value['status'] == 'active' ? 'Pause' : 'Resume'); ?></a></li>
                                                        <li><a href="javascript:(0);" onclick="del(<?php echo $value['id'] ?>);"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
                                                <!-- <li><a href="javascript:(0);" onclick="soldout(<?php echo $value['id'] ?>);"><i class="fa fa-ban" aria-hidden="true"></i> Sold Out</a></li> -->
                                                <li><a href="javascript:(0);" onclick="edit_pricing(<?php echo $value['id'] ?>);"><i class="fa fa-calendar" aria-hidden="true"></i> Pricing & availability</a></li>
                                            </ul>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                    <?php }
                    endforeach; ?>
                <?php } ?>
                </tbody>
            </table>
            <?php if (!empty($my_properties)) { ?>
                <div class="tabl-btn-sec">
                    <a href="/my_rentals">View All</a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
@endsection


<?php
$CI = &get_instance();
$users = $CI->db
    ->where('id', $_SESSION['id'])
    ->where('notification_pref_alert', 'active')
    ->get('users')
    ->row();

$allSubs = $CI->db
    ->where('user_id', $_SESSION['id'])
    ->group_start()
    ->where('start_date<=', date('Y-m-d'))
    ->or_where('end_date>=', date('Y-m-d'))
    ->group_end()
    ->get('user_packages')
    ->row();
if ($users && $allSubs) {
    if (($users->notification_email == 'inactive') && ($users->notification_phone == 'inactive') && ($users->notification_fax == 'inactive'))
        $show_pref_alert = 'active';
    else
        $show_pref_alert = 'inactive';
} else
    $show_pref_alert = 'inactive';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $session_id = "<?php echo $_SESSION['id']; ?>";
    $show_pref_alert = "<?php echo $show_pref_alert; ?>";
    console.log($show_pref_alert);

    $(function() {
        if ($show_pref_alert == 'active') {
            $('.dashboard-content').prepend(`<div class="alert alert-primary alert-dismissible fade show mt-3" id="notification-section" role="alert">
                <div class="row align-items-center">
                    <div class="col-md col-sm col-lg-1">                        
                        <span class="fa-stack fa-2x">
                            <i class="fa fa-bell fa-stack-2x"></i>
                        </span>
                    </div>
                    <div class="col-md-10 col-sm-10 col-lg-11">
                        <p style="text-align: left;" class="notify-text">
                        It seems that you have not set the notification preferences, in order to get the notification on property upload, please set the notification <button style="font-size: 14px" class="btn btn-link" onclick="window.location.href='<?php echo site_url('preferences'); ?>'">Set Notifiation Pref.</button> <button class="btn btn-link"  style="font-size: 14px"  onclick="dismissAlert()" >Dont show again</button></p>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>                        
            </div>`);
        }


    });

    function dismissAlert() {
        if (confirm("Are you sure want to perform this action")) {
            $.ajax({
                url: '<?php echo site_url('profile/notification_pref_status_update') ?>',
                type: "POST",
                data: {
                    id: $session_id,
                    <?php echo $CI->security->get_csrf_token_name(); ?>: '<?php echo $CI->security->get_csrf_hash(); ?>'
                },
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.type == 'success') {
                        alert('Notification pref dismissed');
                        location.reload();
                    }
                },
                error: function(error) {
                    console.log(error);
                },
                complete: function() {
                    console.log('complete');
                }
            })
        }
    }
</script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> -->
<script>
    $(function() {
        var formData = new FormData();

        // alert($("input[name=csrf_token]").val());
        formData.append('csrf_token', $("input[name=csrf_token]").val());
        $.ajax({
            url: '<?php echo site_url("favourites/json_dashboard_data"); ?>',
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data);
                // alert(data);
                $('.dn-items').append(data);
            },
            error: function(error) {
                console.log(error);
            },
            complete: function(data) {
                console.log(data);
            }
        })
        // window.DT = $('#preferences-table').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: "<?php // echo site_url('favourites/json'); 
                        ?>"
        // });
    });
</script>
<script>
    function edit(user_property_id) {
        var form = document.createElement("form");
        var element1 = document.createElement("input");
        var element2 = document.createElement("input");
        form.method = "POST";
        form.action = "<?php echo site_url('my_properties/edit'); ?>";
        element1.value = user_property_id;
        element1.name = "user_property_id";
        form.appendChild(element1);
        element2.value = $("input[name=csrf_token]").val();
        element2.name = "csrf_token";
        form.appendChild(element2);
        document.body.appendChild(form);
        form.submit();
    }

    function edit_pricing(user_property_id) {
        var form = document.createElement("form");
        var element1 = document.createElement("input");
        var element2 = document.createElement("input");
        var element3 = document.createElement("input");
        form.method = "POST";
        form.action = "<?php echo site_url('my_rentals/edit'); ?>";
        element1.value = user_property_id;
        element1.name = "user_property_id";
        form.appendChild(element1);
        element2.value = $("input[name=csrf_token]").val();
        element2.name = "csrf_token";
        form.appendChild(element2);
        element3.value = 'dateCheck';
        element3.name = "forDate";
        form.appendChild(element3);
        document.body.appendChild(form);
        form.submit();
    }

    function del(property_id) {
        if (confirm("Are You sure to perform this action?")) {
            $.ajax({
                url: "<?php echo site_url('my_properties/del'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    property_id: property_id,
                    'csrf_token': $("input[name=csrf_token]").val()
                },
                success: function(arg) {
                    toastr[arg.type](arg.text);
                    if (arg.type == 'success') {
                        window.location.reload();
                    }
                }
            });
        }
    }

    function change_status(property_id) {
        if (confirm("Are You sure to perform this action?")) {
            $.ajax({
                url: "<?php echo site_url('my_properties/change_status'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    property_id: property_id,
                    'csrf_token': $("input[name=csrf_token]").val()
                },
                success: function(arg) {
                    toastr[arg.type](arg.text);
                    if (arg.type == 'success') {
                        window.location.reload();
                    }
                }
            });
        }
    }

    function soldout(property_id) {
        if (confirm("Are You sure to perform this action? This action can not be undone.")) {
            $.ajax({
                url: "<?php echo site_url('my_properties/mark_sold'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    property_id: property_id,
                    'csrf_token': $("input[name=csrf_token]").val()
                },
                success: function(arg) {
                    toastr[arg.type](arg.text);
                    if (arg.type == 'success') {
                        window.location.reload();
                    }
                }
            });
        }
    }
</script>