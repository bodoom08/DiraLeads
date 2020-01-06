<footer class="footer">
    <div class="container footer-inner">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="footer-item clearfix">
                    <img style="max-height: 75px;" src="/uploads/<?php echo CFG_LOGO; ?>" alt="logo">
                    <div class="text">
                        <p><?php echo html_escape(CFG_FOOTER_DESC); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
            <?php
                $footer_useful = get_menu('useful');
            ?>
                <div class="footer-item">
                    <h4>
                        Useful Links
                    </h4>
                    <ul class="links">
                        <?php foreach($footer_useful as $menu): ?>
                        <li>
                            <a href="<?php echo $menu['url']; ?>"><?php echo $menu['title']; ?></a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
            <?php
                $footer_quick = get_menu('quick');
            ?>
                <div class="footer-item">
                    <h4>
                        Quick Links
                    </h4>
                    <ul class="links">
                        <?php foreach($footer_quick as $menu): ?>
                        <li>
                            <a href="<?php echo $menu['url']; ?>"><?php echo $menu['title']; ?></a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="footer-item clearfix">
                    <h4>News & Update</h4>
                    <div class="f-border"></div>
                    <div class="Subscribe-box">
                        <form class="form-inline" action="#" method="GET">
                            <input type="text" class="form-control mb-sm-0" id="inlineFormInputName3" placeholder="Email Address">
                            <button type="submit" class="btn"><i class="fa fa-paper-plane"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="sub-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <p class="copy">© Copyright 2019. All rights reserved <a href="/"><?php echo html_escape(CFG_TITLE); ?></a></p>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('common/scripts'); ?>
</body>

</html>
