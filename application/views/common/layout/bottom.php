<div class="footer-sec">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-12">
                <div class="footer-link">
                    <img src="/uploads/<?php echo CFG_LOGO; ?>" alt="logo">
                    <br />

                    <p><?php echo html_escape(CFG_FOOTER_DESC); ?></p>

                </div>
            </div>
            <div class="col-lg-3 col-12">
                <?php
                $footer_useful = get_menu('useful');
                ?>
                <div class="foot footer-menu">
                    <h3>
                        Useful Links
                    </h3>
                    <ul>
                        <?php foreach ($footer_useful as $menu) : ?>
                            <li>
                                <a href="<?php echo site_url($menu['url']); ?>"><?php echo $menu['title']; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <input type="hidden" class="loggedId" value="<?php echo e($_SESSION['id']); ?>">

            <div class="col-lg-4 col-12">
                <div class="foot footer-email">
                    <h3>News & Update </h3>
                    <form class="form-inline" action="#" method="GET">
                        <input type="text" class="form-control mb-sm-0" id="inlineFormInputName3" placeholder="Email Address">
                        <button type="submit" class="btn"><img src="<?php echo site_url('assets/images/email.png'); ?>"></button>
                    </form>
                </div>
            </div>
            <div class="col-lg-12 col-12">
                <div class="copy-right">
                    <p>© Copyright 2020. All rights reserved <a href="/"><?php echo html_escape(CFG_TITLE); ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('common/scripts'); ?>
</body>

</html>