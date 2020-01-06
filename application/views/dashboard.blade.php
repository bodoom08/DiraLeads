@extends('common.panel')

@section('content')
<div class="alert alert-success alert-2" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Your listing</strong> YOUR LISTING HAS BEEN APPROVED!
</div>
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
<div class="row d-none">
    <div class="col-lg-6 col-md-6">
        <div class="dashboard-list">
            <div class="dashboard-message bdr clearfix ">
                <div class="tab-box-2">
                    <div class="clearfix mb-30 comments-tr">
                        <span>Comments</span>
                        <ul class="nav nav-pills float-right" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Pending</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="true">Approved</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                            <div class="comment">
                                <div class="comment-author">
                                    <a href="#">
                                        <img src="assets/img/avatar/avatar-3.jpg" alt="comments-user">
                                    </a>
                                </div>
                                <div class="comment-content">
                                    <div class="comment-meta">
                                        <h5>Maikel Alisa</h5>
                                        <div class="comment-meta">
                                            8:42 PM 1/28/2017<a href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus tincidunt aliquam. Aliquam gravida massa at sem </p>
                                </div>
                            </div>
                            <div class="comment">
                                <div class="comment-author">
                                    <a href="#"><img src="assets/img/avatar/avatar-1.jpg" alt="comments-user"></a>
                                </div>
                                <div class="comment-content">
                                    <div class="comment-meta">
                                        <h5>
                                            Maikel Alisa
                                        </h5>
                                        <div class="comment-meta">
                                            8:42 PM 1/28/2017<a href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus tincidunt aliquam. Aliquam gravida massa at sem </p>
                                </div>
                            </div>
                            <div class="comment mb-0">
                                <div class="comment-author">
                                    <a href="#">
                                        <img src="assets/img/avatar/avatar-2.jpg" alt="comments-user">
                                    </a>
                                </div>
                                <div class="comment-content">
                                    <div class="comment-meta">
                                        <h5>
                                            Maikel Alisa
                                        </h5>
                                        <div class="comment-meta">
                                            8:42 PM 1/28/2017<a href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus tincidunt aliquam. Aliquam gravida massa at sem </p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade active show" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="comment">
                                <div class="comment-author">
                                    <a href="#">
                                        <img src="assets/img/avatar/avatar-2.jpg" alt="comments-user">
                                    </a>
                                </div>
                                <div class="comment-content">
                                    <div class="comment-meta">
                                        <h5>
                                            Maikel Alisa
                                        </h5>
                                        <div class="comment-meta">
                                            8:42 PM 1/28/2017<a href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus tincidunt aliquam. Aliquam gravida massa at sem </p>
                                </div>
                            </div>
                            <div class="comment">
                                <div class="comment-author">
                                    <a href="#">
                                        <img src="assets/img/avatar/avatar-3.jpg" alt="comments-user">
                                    </a>
                                </div>
                                <div class="comment-content">
                                    <div class="comment-meta">
                                        <h5>
                                            Maikel Alisa
                                        </h5>
                                        <div class="comment-meta">
                                            8:42 PM 1/28/2017<a href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus tincidunt aliquam. Aliquam gravida massa at sem </p>
                                </div>
                            </div>
                            <div class="comment mb-0">
                                <div class="comment-author">
                                    <a href="#">
                                        <img src="assets/img/avatar/avatar-1.jpg" alt="comments-user">
                                    </a>
                                </div>
                                <div class="comment-content">
                                    <div class="comment-meta">
                                        <h5>
                                            Maikel Alisa
                                        </h5>
                                        <div class="comment-meta">
                                            8:42 PM 1/28/2017<a href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus tincidunt aliquam. Aliquam gravida massa at sem </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="dashboard-list">
            <div class="dashboard-message bdr clearfix ">
                <div class="tab-box-2">
                    <div class="clearfix mb-30 comments-tr">
                        <span>Comments</span>
                        <ul class="nav nav-pills float-right" id="pills-tab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="pills-profile-tab2" data-toggle="pill" href="#pills-profile2" role="tab" aria-controls="pills-profile" aria-selected="false">Pending</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-contact-tab2" data-toggle="pill" href="#pills-contact2" role="tab" aria-controls="pills-contact" aria-selected="true">Approved</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="pills-tabContent2">
                        <div class="tab-pane fade" id="pills-contact2" role="tabpanel" aria-labelledby="pills-contact-tab2">
                            <div class="comment">
                                <div class="comment-author">
                                    <a href="#">
                                        <img src="assets/img/avatar/avatar-3.jpg" alt="comments-user">
                                    </a>
                                </div>
                                <div class="comment-content">
                                    <div class="comment-meta">
                                        <h5>Maikel Alisa</h5>
                                        <div class="comment-meta">
                                            8:42 PM 1/28/2017<a href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus tincidunt aliquam. Aliquam gravida massa at sem </p>
                                </div>
                            </div>
                            <div class="comment">
                                <div class="comment-author">
                                    <a href="#"><img src="assets/img/avatar/avatar-1.jpg" alt="comments-user"></a>
                                </div>
                                <div class="comment-content">
                                    <div class="comment-meta">
                                        <h5>
                                            Maikel Alisa
                                        </h5>
                                        <div class="comment-meta">
                                            8:42 PM 1/28/2017<a href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus tincidunt aliquam. Aliquam gravida massa at sem </p>
                                </div>
                            </div>
                            <div class="comment mb-0">
                                <div class="comment-author">
                                    <a href="#">
                                        <img src="assets/img/avatar/avatar-2.jpg" alt="comments-user">
                                    </a>
                                </div>
                                <div class="comment-content">
                                    <div class="comment-meta">
                                        <h5>
                                            Maikel Alisa
                                        </h5>
                                        <div class="comment-meta">
                                            8:42 PM 1/28/2017<a href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus tincidunt aliquam. Aliquam gravida massa at sem </p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade active show" id="pills-profile2" role="tabpanel" aria-labelledby="pills-profile-tab2">
                            <div class="comment">
                                <div class="comment-author">
                                    <a href="#">
                                        <img src="assets/img/avatar/avatar-2.jpg" alt="comments-user">
                                    </a>
                                </div>
                                <div class="comment-content">
                                    <div class="comment-meta">
                                        <h5>
                                            Maikel Alisa
                                        </h5>
                                        <div class="comment-meta">
                                            8:42 PM 1/28/2017<a href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus tincidunt aliquam. Aliquam gravida massa at sem </p>
                                </div>
                            </div>
                            <div class="comment">
                                <div class="comment-author">
                                    <a href="#">
                                        <img src="assets/img/avatar/avatar-3.jpg" alt="comments-user">
                                    </a>
                                </div>
                                <div class="comment-content">
                                    <div class="comment-meta">
                                        <h5>
                                            Maikel Alisa
                                        </h5>
                                        <div class="comment-meta">
                                            8:42 PM 1/28/2017<a href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus tincidunt aliquam. Aliquam gravida massa at sem </p>
                                </div>
                            </div>
                            <div class="comment mb-0">
                                <div class="comment-author">
                                    <a href="#">
                                        <img src="assets/img/avatar/avatar-1.jpg" alt="comments-user">
                                    </a>
                                </div>
                                <div class="comment-content">
                                    <div class="comment-meta">
                                        <h5>
                                            Maikel Alisa
                                        </h5>
                                        <div class="comment-meta">
                                            8:42 PM 1/28/2017<a href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus tincidunt aliquam. Aliquam gravida massa at sem </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<?php
$CI =& get_instance();
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
if($users && $allSubs) {
    if(($users->notification_email == 'inactive') && ($users->notification_phone == 'inactive') && ($users->notification_fax == 'inactive'))
        $show_pref_alert = 'active';
    else
        $show_pref_alert = 'inactive';
    
}
else
    $show_pref_alert = 'inactive';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $session_id = "<?php echo $_SESSION['id']; ?>";
    $show_pref_alert = "<?php echo $show_pref_alert; ?>";
    console.log($show_pref_alert);
    
    $(function() {        
        if($show_pref_alert == 'active') {
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
        if(confirm("Are you sure want to perform this action")) {
            $.ajax({
                url: '<?php echo site_url('profile/notification_pref_status_update') ?>',
                type: "POST",
                data: {
                    id: $session_id,
                    <?php echo $CI->security->get_csrf_token_name(); ?>: '<?php echo $CI->security->get_csrf_hash(); ?>'
                },
                success: function(data) {
                    data = JSON.parse(data);
                    if(data.type == 'success') {
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