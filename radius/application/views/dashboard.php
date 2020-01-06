<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/top', [
    'title' => 'Dashboard'
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
                        <div class="dashboard-header clearfix">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <h4>Hello , <?php echo $_SESSION['name']; ?></h4>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="breadcrumb-nav">
                                        <ul>
                                            <li>
                                                <a href="index.html">Index</a>
                                            </li>
                                            <li>
                                                <a href="#" class="active">Dashboard</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-success alert-2" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <strong>Your listing</strong> YOUR LISTING HAS BEEN APPROVED!
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="ui-item bg-success">
                                    <div class="left">
                                        <!-- <h4>242</h4>
                                        <p>Active Listings</p> -->
                                        <h4><?php echo sizeof($users); ?></h4>
                                        <p>No Of Users</p>
                                    </div>
                                    <div class="right">
                                        <!-- <i class="fa fa-map-marker"></i> -->
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="ui-item bg-warning">
                                    <div class="left">
<h4><?php echo sizeof($no_of_properties); ?></h4>
                                        <p>Listed Properties</p>
                                    </div>
                                    <div class="right">
                                        <i class="fa fa-eye"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="ui-item bg-active">
                                    <div class="left">
                                        <h4><?php echo $no_of_bookmarked->total_count; ?></h4>
                                        <p>Bookmarked</p>
                                    </div>
                                    <div class="right">
                                        <i class="fa fa-heart-o"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="ui-item bg-dark">
                                    <div class="left">
                                        <h4><?php echo sizeof($no_of_subscribers); ?></h4>
                                        <p>Subscribers</p>
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
                                                                <img src="/assets/img/avatar/avatar-3.jpg" alt="comments-user">
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
                                                            <a href="#"><img src="/assets/img/avatar/avatar-1.jpg" alt="comments-user"></a>
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
                                                                <img src="/assets/img/avatar/avatar-2.jpg" alt="comments-user">
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
                                                                <img src="/assets/img/avatar/avatar-2.jpg" alt="comments-user">
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
                                                                <img src="/assets/img/avatar/avatar-3.jpg" alt="comments-user">
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
                                                                <img src="/assets/img/avatar/avatar-1.jpg" alt="comments-user">
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
                                                                <img src="/assets/img/avatar/avatar-3.jpg" alt="comments-user">
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
                                                            <a href="#"><img src="/assets/img/avatar/avatar-1.jpg" alt="comments-user"></a>
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
                                                                <img src="/assets/img/avatar/avatar-2.jpg" alt="comments-user">
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
                                                                <img src="/assets/img/avatar/avatar-2.jpg" alt="comments-user">
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
                                                                <img src="/assets/img/avatar/avatar-3.jpg" alt="comments-user">
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
                                                                <img src="/assets/img/avatar/avatar-1.jpg" alt="comments-user">
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
                    </div>
                    <p class="sub-banner-2 text-center">© Copyright 2019. All rights reserved</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('common/bottom'); ?>
