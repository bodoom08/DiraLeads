<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$header_menu = get_menu('main');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo isset($title) && html_escape($title) != 'Home' ? html_escape($title) . ' | ' . html_escape(CFG_TITLE) : html_escape(CFG_TITLE); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <!-- <link rel="icon" href="assets/favicon.svg" sizes="any" type="image/svg+xml"> -->
    <link rel="icon" href="assets/favicon.svg" sizes="any" type="image/svg+xml">
    <link rel="icon" type="image/png" href="assets/favicon.png" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css' />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/bootstrap.min.css'); ?>">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css' />
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />

    <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/style.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/styles.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/responsive.css'); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
    <div class="my-header">
        <nav class="navbar navbar-expand-xl navbar-light container-fluid">
            <a class="navbar-brand" href="<?php echo site_url() ?>"><img src="<?php echo  site_url('uploads/diraleads-logo.svg'); ?>"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <!--<?php foreach ($header_menu as $key => $value) { ?>
                            <?php if ($value['parent_menu_id'] == 0) { ?>
                                <li class="nav-item <?php echo $value['url'] == current_url() ? 'active' : '' ?>">
                                   <?php if ($value['title'] == "Properties") { ?>
                                     <a href="<?php echo site_url($value['url']) ?>?for=short%20term%20rent" class="nav-link"> <?php echo $value['title']; ?></a>
                                  <?php } else { ?>
                                    <a href="<?php echo site_url($value['url']) ?>" class="nav-link">
                                        <?php echo $value['title']; ?>
                                    </a>
                                    <?php } ?>
                                </li>
                            <?php
                            } ?>
                        <?php
                        } ?>-->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Why DiraLeads <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/renters" style="font-family:'Raleway', sans-serif;">The Renter's View</a>
                            <a class="dropdown-item" href="/owners" style="font-family:'Raleway', sans-serif;">The Owner's Perch</a>
                        </div>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);">Tour Neighborhoods</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="/properties">View Rentals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="property">List Your Rental</a>
                    </li>
                    <?php if (empty($_SESSION['id'])) { ?>
                        <li class="nav-item login">
                            <a class="nav-link" href="<?php echo site_url('login') ?>">
                                <img src="<?php echo site_url('assets/images/login.png'); ?>"> Login / Signup

                            </a>
                        </li>

                    <?php } ?>
                </ul>
                <?php if (isset($_SESSION['id'])) : ?>
                    <ul class="navbar-nav offcanvas-navbar position-relative">
                        <div class="dropdown btns">
                            <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php echo site_url('/assets/img/avatar/user.png'); ?>" width="20" alt="avatar">
                                Hi, <?php echo explode(' ', $_SESSION['name'])[0]; ?>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?php echo site_url('dashboard'); ?>">Dashboard</a>
                                <a class="dropdown-item" href="<?php echo site_url('my_rentals'); ?>">My Rentals</a>
                                <a class="dropdown-item" href="<?php echo site_url('subscription/user'); ?>">My Subscriptions</a>
                                <a class="dropdown-item" href="<?php echo site_url('profile'); ?>">My profile</a>
                                <a class="dropdown-item" href="<?php echo site_url('login/logout'); ?>">Logout</a>
                            </div>
                        </div>
                    </ul>
                <?php endif; ?>
            </div>
    </div>

    </nav>
    </div>