<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title><?php echo html_escape($title); ?> | <?php echo html_escape(CFG_TITLE); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="assets/favicon.png" />
    <?php $this->load->view('common/styles'); ?>
</head>

<body>
    <header class="main-header header-2 fixed-header">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="/">
                    <img style="width: 146px;" src="uploads/<?php echo CFG_LOGO; ?>" alt="logo">
                </a>

                


                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto d-lg-none d-xl-none">
                        <li class="nav-item dropdown active">
                            <a href="<?php echo site_url('dashboard'); ?>" class="nav-link">Dashboard</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="<?php echo site_url('messages'); ?>" class="nav-link">Messages</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="<?php echo site_url('my_properties'); ?>" class="nav-link">My Properties</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="<?php echo site_url('invoices'); ?>" class="nav-link">My Invoices</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="<?php echo site_url('preferences'); ?>" class="nav-link">Preferences</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="<?php echo site_url('property'); ?>" class="nav-link">Submit Property</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="<?php echo site_url('profile'); ?>" class="nav-link">My Profile</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="<?php echo site_url('login/logout'); ?>" class="nav-link">Logout</a>
                        </li>
                    </ul>
                    <div class="navbar-buttons ml-auto d-none d-xl-block d-lg-block">
                        <ul class="clearfix">
                            <li style="margin-top: 7%;">
<button class="btn btn-primary" onclick="window.location.href='<?php echo site_url('/'); ?>';"><i class="fa fa-home"></i> Back to Home Page</button>
                            </li>
                            <li>
                                <div class="dropdown btns">
                                    <a class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="/assets/img/avatar/user.png" alt="avatar">
                                        Hi, <?php echo $_SESSION['name']; ?>
                                    </a>
<div class="dropdown-menu" style="float:right;">
                                        <a class="dropdown-item" href="<?php echo site_url('dashboard'); ?>">Dashboard</a>
                                        <a class="dropdown-item" href="<?php echo site_url('my_properties'); ?>">My Properties</a>
                                        <a class="dropdown-item" href="<?php echo site_url('subscription/user'); ?>">My Subscriptions</a>
                                        <a class="dropdown-item" href="<?php echo site_url('profile'); ?>">My profile</a>
                                        <a class="dropdown-item" href="<?php echo site_url('login/logout'); ?>">Logout</a>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
