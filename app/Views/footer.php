<?php if ($settings->getFooterType() == 1) { ?>
    <div class="content-wrapper" style="background:#F9FFFF">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <a href="shop">
                        <div class="text-center"><?php echo $settings->getMobileLogo(); ?></div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 d-flex justify-content-center footer-link pt-3 pt-sm-4 pb-sm-3">
                    <a href="shop">
                        <p trn="home">Home</p>
                    </a>
                    <a data-toggle="modal" data-target="#cart">
                        <p trn="cart">Cart</p>
                    </a>
                    <?php if (!is_null($this->session->get(self::USER_ID))) { ?>
                        <a href="profile">
                            <p trn="lprofile">Profile</p>
                        </a>
                    <?php } else { ?>
                        <a href="auth">
                            <p><span trn="llogin">Login</span></p>
                        </a>
                    <?php } ?>


                    <a href="contact-us">
                        <p trn="contact-us">Contact Us</p>
                    </a>
                </div>
            </div>
            <footer class="border-top">
                <div class="row">
                    <p class="col-lg-10 col-sm-6  text-start pt-4">© 2020 <a href="<?php echo $settings->getWebsiteUrl(); ?>"><?php echo $settings->getStoreName(); ?></a> by <a href="https://demae-system.com">CLB Solutions.</a> All rights reserved.</p>
                    <div class="col-2  pt-4 sd-fnm" id="contact-details-section">
                        <?php if (isset($settings->getSocials()->facebook)) { ?>
                            <a href="<?php echo $settings->getSocials()->facebook; ?>"><span class="mdi mdi-facebook"></span></a>
                        <?php } ?>
                        <?php if (isset($settings->getSocials()->instagram)) { ?>
                            <a href="<?php echo $settings->getSocials()->instagram; ?>"><span class="mdi mdi-instagram"></span></a>
                        <?php } ?>
                        <?php if (isset($settings->getSocials()->twitter)) { ?>
                            <a href="<?php echo $settings->getSocials()->twitter; ?>"><span class="mdi mdi-twitter"></span></a>
                        <?php } ?>
                    </div>
                </div>
            </footer>
        </div>
    </div>
<?php } else if ($settings->getFooterType() == 0) { ?>
    <div class="content-wrapper" style="background:#F9FFFF;">
        <div class="container">
            <section class="contact-details" id="contact-details-section" style="padding: 30px 0;">
                <div class="row text-center text-md-left mb-2">
                    <div class="col-sm-12 col-md-4 col-lg-2">
                        <a href="shop">
                            <div class="mt-3"><?php echo $settings->getMobileLogo();  ?></div>
                        </a>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 d-flex justify-content-center footer-link pt-3 pt-sm-4 pb-sm-3">
                        <a href="shop">
                            <p><span trn="home">Home</span></p>
                        </a>
                        <a data-toggle="modal" data-target="#cart">
                            <p><span trn="cart">Cart</span></p>
                        </a>
                        <?php if (!is_null($this->session->get(self::USER_ID))) { ?>
                            <a href="profile">
                                <p><span trn="lprofile">Profile</span></p>
                            </a>
                        <?php } else { ?>
                            <a href="auth">
                                <p><span trn="llogin">Login</span></p>
                            </a>
                        <?php } ?>
                        <a href="contact-us">
                            <p><span trn="contact-us">Contact Us</span></p>
                        </a>
                    </div>
                    <div class="col-sm-12 col-md-6 mt-md-5 mt-sm-0 mt-lg-0 col-lg-3">
                        <h5 class="pb-2 text-dark" trn="contact">Contact</h5>
                        <p class="text-muted"><?php echo $settings->getPhoneNumber(); ?></p>
                    </div>
                    <div class="col-sm-12 col-md-6 mt-md-5 mt-sm-0 mt-lg-0 col-lg-3">
                        <h5 class="pb-2 text-dark" trn="address">Address</h5>
                        <p class="text-muted"><?php echo $settings->getAddressName(); ?></p>
                        <p class="text-muted"><?php echo $settings->getAddress(); ?></p>
                    </div>
                </div>
            </section>
            <footer class="border-top">
                <div class="row col-12">
                    <p class="col-lg-10 col-sm-6  text-start pt-4">© 2020 <a href="<?php echo $settings->getWebsiteUrl(); ?>"><?php echo $settings->getStoreName(); ?></a> by <a href="https://demae-system.com">CLB Solutions.</a> All rights reserved.</p>
                    <div class="col-lg-2 col-sm-6 text-end contact-details d-flex justify-content-center justify-content-md-end  pt-4" id="contact-details-section">
                        <?php if (isset($settings->getSocials()->facebook)) { ?>
                            <a href="<?php echo $settings->getSocials()->facebook; ?>"><span class="mdi mdi-facebook"></span></a>
                        <?php } ?>
                        <?php if (isset($settings->getSocials()->instagram)) { ?>
                            <a href="<?php echo $settings->getSocials()->instagram; ?>"><span class="mdi mdi-instagram"></span></a>
                        <?php } ?>
                        <?php if (isset($settings->getSocials()->twitter)) { ?>
                            <a href="<?php echo $settings->getSocials()->twitter; ?>"><span class="mdi mdi-twitter"></span></a>
                        <?php } ?>
                    </div>
                </div>
            </footer>
        </div>
    </div>
<?php } ?>
<script src="assets/vendors/bootstrap/bootstrap.min.js"></script>
<script src="assets/vendors/owl-carousel/js/owl.carousel.min.js"></script>
<script src="assets/vendors/aos/js/aos.js"></script>
<script src="assets/js/jquery-spinner.min.js"></script>
<script src="assets/js/mcx-dialog.min.js"></script>
<script src="assets/js/date-picker.js"></script>
<script src="assets/js/jquery.timepicker.min.js"></script>
<script src="assets/js/jquery.card.js"></script>
<script src="assets/js/shop.js?<?php echo time(); ?>"></script>
<script src="assets/js/404.js"></script>
<script src="assets/js/translator.js"></script>
<?php echo $settings->getScripts(); ?>
</body>

</html>