<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
    $header_menu = get_menu('main');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo html_escape($title); ?> | <?php echo html_escape(CFG_TITLE); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <!-- <link rel="icon" href="assets/favicon.svg" sizes="any" type="image/svg+xml"> -->
    <link rel="icon" type="image/png" href="assets/favicon.png" />
    <?php $this->load->view('common/styles'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        
    <script>
        // $.ajaxSetup({
        //     beforeSend:function(jqXHR, Obj){
        //         var value = "; " + document.cookie;
        //         var parts = value.split("; csrf_cookie=");
        //         if(parts.length == 2)   
        //         Obj.data += '&csrf_token='+parts.pop().split(";").shift();
        //     }
        // });
    </script>
</head>

<body>

    <header class="main-header header-transparent sticky-header">
        <nav class="navbar navbar-expand-lg demo-2">
            <div class="container navbar-container">
                <a class="navbar-brand" href="/">
                    <img style="width: 146px;" src="uploads/<?php echo CFG_LOGO; ?>" alt="logo">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars iconbar"></i>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <?php foreach ($header_menu as $key => $value) { ?>
                            <?php if ($value['parent_menu_id'] == 0) { ?>
                                <li class="nav-item <?php echo $value['url'] == current_url() ? 'active' : 'dropdown position-relative' ?>">
                                    <a href="<?php echo $value['url'] ?>" class="nav-link">
                                        <?php echo $value['title']; ?>
                                    </a>
                                </li>
                            <?php
                        } ?>
                        <?php
                    } ?>
                    </ul>
                    <?php if($_SESSION['id']): ?>
                        <ul class="navbar-nav offcanvas-navbar position-relative">
                            <li class="nav-item ">
                                <h6>Hi, <?php echo explode(' ', $_SESSION['name'])[0]; ?></h6>
                            </li>
                            <li class="nav-item  position-relative">
                                <a class="nav-link" href="<?php echo site_url('login/logout'); ?>">
                                    Logout
                                </a>
                            </li>
                        </ul>
                    <?php else: ?>
                        <ul class="navbar-nav offcanvas-navbar position-relative">
                            <li class="nav-item  position-relative">
                                <a class="nav-link" href="<?php echo site_url('login'); ?>">
                                    Login
                                </a>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>

        </nav>
    </header>
