<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title><?php echo isset($title) && html_escape($title) != 'Home' ? html_escape($title) . ' | ' . html_escape(RADIUS) : html_escape(RADIUS); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <?php $this->load->view('common/styles'); ?>
</head>

<body>
    <header class="main-header header-2 fixed-header">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="<?php echo site_url(); ?>">
                    <img src="/uploads/<?php echo CFG_LOGO; ?>" alt="Diraleads Logo" height="75"><sup style="color: #ff214f"><small>RADIUS</small></sup>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto d-lg-none d-xl-none">
                        <li class="nav-item dropdown active">
                            <a href="dashboard.html" class="nav-link">Dashboard</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="messages.html" class="nav-link">Messages</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="bookings.html" class="nav-link">Bookings</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="my-properties.html" class="nav-link">My Properties</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="my-invoices.html" class="nav-link">My Invoices</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="favorited-properties.html" class="nav-link">Favorited Properties</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="submit-property.html" class="nav-link">Submit Property</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="<?php echo site_url('profile'); ?>" class="nav-link">My Profile</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="<?php echo site_url('login/logout'); ?>" class="nav-link">Logout</a>
                        </li>
                    </ul>
                    <div class="navbar-buttons ml-auto d-none d-xl-block d-lg-block">
                        <ul>
                            <li>
                                <div class="dropdown btns">
                                    <a class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="/assets/img/avatar/user.png" alt="avatar">
                                        Hello , <?php echo $_SESSION['name']; ?>
                                    </a>
                                    <div class="dropdown-menu">
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