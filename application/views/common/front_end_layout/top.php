<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title><?php echo html_escape($title); ?> | <?php echo html_escape(CFG_TITLE); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="assets/favicon.png" />
    <?php $this->load->view('common/styles'); ?>
    <link rel="stylesheet" type="text/css" href="assets/css/styles.min.css">
</head>

<body>
    <div class="my-header">

        <nav class="navbar navbar-expand-xl navbar-light container-fluid <?php if (current_url() == base_url('profile')) {
                                                                                echo 'costom_profile';
                                                                            } ?>">
            <a class="navbar-brand" href="<?php echo site_url(); ?>"><img src="<?php echo site_url() ?>uploads/<?php echo  CFG_LOGO ?>"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Why DiraLeads <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/renters">The Renter's View</a>
                            <a class="dropdown-item" href="/owners">The Owner's Perch</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/properties">View Rentals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/rental">List Your Rental</a>
                    </li>
                </ul>

                <style>
                    .dropdown-menu a {
                        color: #000 !important;
                    }
                </style>
                <ul class="navbar-nav offcanvas-navbar position-relative">
                    <div class="dropdown btns">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo site_url() ?>/assets/img/avatar/user.png" width="20" alt="avatar">
                            Hi, <?php echo explode(' ', $_SESSION['name'])[0] ?>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?php echo site_url('dashboard'); ?>">Dashboard</a>
                            <a class="dropdown-item" href="<?php echo site_url('my_rentals'); ?>">My Rentals</a>
                            <a class="dropdown-item" href="<?php echo site_url('profile'); ?>">My profile</a>
                            <a class="dropdown-item" href="<?php echo site_url('login/logout'); ?>">Logout</a>
                        </div>
                    </div>
                    <li class="nav-item  position-relative d-none">
                        <a class="nav-link" href="<?php echo site_url('login/logout'); ?>">
                            Logout
                        </a>
                    </li>
                </ul>

            </div>
        </nav>
    </div>