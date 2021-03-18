<style>
    /* Slide Banners */
    .slider-0-image {
        background: url(<?php echo $settings->getBannerImage() ?>) center center no-repeat;
        background-size: cover;
        height: 400px;
        opacity: 0.75;
        width: 100%;
        z-index: -1;
    }

    .slider-darken::before {
        content: "";
        position: absolute;
        background-size: contain;
        background: #000;
        opacity: 0.5;
        height: 400px;
        width: 100%;
    }
</style>
<?php
$slider = $settings->getSliderType();

if ($slider == 0) { ?>
    <!-- Banner Section 1 -->
    <div class="slider-0-image">
        <div class="slider-darken">
            <?php include 'app/Views/shop/top_info.php'; ?>
            <div class="row col-12 slider-title">
                <div class="col-12 text-center" data-aos="zoom-in-up">
                    <p class="text-white"><?php echo $settings->getBannerTitle(); ?></p>
                </div>
            </div>
            <?php include 'app/Views/shop/search_widget.php'; ?>
        </div>
    </div>
    <?php include 'app/Views/shop/top_info_m.php'; ?>
    <!-- End Banner Section 1 -->


<?php } else if ($slider == 1) { ?>
    <!-- Banner Section 2 -->
    <div class="slider-0-image">
        <div class="slider-darken">
            <?php include 'app/Views/shop/top_info.php'; ?>
            <div class="container-fluid row col-12 pt-3 title2" data-aos="zoom-in-up">
                <div class="col-md-6 col-lg-4 d-flex text-left pt-md-3 pt-sm-5">
                    <h1 class="text-white pl-lg-5 pl-md-1 pt-4"><?php echo $settings->getBannerTitle(); ?></h1>
                </div>
            </div>
            <?php include 'app/Views/shop/search_widget.php'; ?>
        </div>
    </div>
    <?php include 'app/Views/shop/top_info_m.php'; ?>
    <!-- End Banner Section 2 -->
<?php } else if ($slider == 2) { ?>
    <!-- Banner Section 3 -->
    <div class="slider-0-image slider-2">
        <div class="slider-darken">
            <div class="row col-12" style="padding-top:30px;" data-aos="fade-up">
                <div class="col-lg-4 col-md-4 col-sm-6 text-center">
                    <img src="assets/images/shop/delivery_logo.svg" alt="delivery time" width="40">
                    <span class="text-white ml-1" style="font-size: 15px;"><span trn="delivery-time">Delivery time</span> <b class="ml-1 span-circle"><?php echo $settings->getDeliveryTime(); ?></b> <span trn="minutes">min</span></span>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 text-center  mt-2">
                    <h6 class="text-white font-weight-bold"><?php echo $this->available ? '<span trn="opened">Opened</span>' : '<span trn="closed">Closed</span>'; ?></h6>
                </div>
                <div class="col-lg-4  col-md-4 col-sm-6 text-center">
                    <span class="text-white" style="font-size: 15px;"><span trn="min-order"> Min. order</span> <b class="ml-3 mr-3"> <?php echo $settings->getCurrency() . number_format(intval($settings->getMinOrder() ?? 0)); ?></b></span>
                    <a data-toggle="modal" data-target="#cart"> <img src="assets/images/shop/cart.svg" alt="cart" width="40"></a>
                </div>
            </div>
            <div class="container" data-aos="zoom-in-up">
                <div class="row " style="margin-top:6em;">
                    <div class="col-lg-4 justify-content-start slider-3 pt-2 pb-2">
                        <div class="banner-title">
                            <h1 class=" text-danger mt-5 "><span trn=""><?php echo $settings->getBannerTitle(); ?></span></h1>
                        </div>
                        <h6 class="mt-4 font-weight-bold text-dark pb-3" style="line-height: 1.5;"><small>
                                <span trn="Shop Banner Title"><?php echo $settings->getBannerText(); ?></span></small>
                        </h6>
                    </div>
                    <div class="col-lg-4">
                    </div>
                    <div class="col-lg-4"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Banner Section 3 -->
<?php } else if ($slider == 3) { ?>
    <!-- Banner Section 4   style="background:#F9FFFF"-->
    <div class="pt-3 pv-3">
        <div class="container">
            <div class="row">
                <div class="main-banner d-sm-flex justelse ify-content-between">
                    <div data-aos="zoom-in-up" class="col-lg-8 col-sm-6 col-md-7 pl-5">
                        <div class="banner-title pt-5">
                            <h1 class="font-weight-bold text-dark mt-2"><span trn=""><?php echo $settings->getBannerTitle(); ?></span></h1>
                        </div>
                        <h6 class="mt-4 font-weight-bold text-dark pb-3 col-lg-8 col-sm-6" style="line-height: 1.5;"><small>
                                <span trn=""><?php echo $settings->getBannerText(); ?></span></small>
                        </h6>
                    </div>
                    <div class="mt-5 mt-lg-0 col-lg-4  col-sm-6 col-md-5">
                        <img src="<?php echo $settings->getBannerImage() ?>" id="marsmello" class="img-fluid mt-5 mt-lg-0" data-aos="zoom-in-up">
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid pl-3 mt-5">
            <div class="row col-12 d-flex order-bar ml-1" style="padding-top:18px;" data-aos="fade-up">
                <div class="col-lg-4 text-center">
                    <img src="assets/images/shop/delivery_logo.svg" alt="delivery time" width="40">
                    <span class="text-white ml-3" style="font-size: 15px;"> <span trn="delivery-time">Delivery time</span> <b class="ml-2 span-circle"><?php echo $settings->getDeliveryTime(); ?></b><span trn="minutes">min</span></span>
                </div>
                <div class="col-lg-4 text-center  mt-2">
                    <h5 class="text-white font-weight-bold"><?php echo $this->available ? '<span trn="opened">Opened</span>' : '<span trn="closed">Closed</span>'; ?></h5>
                </div>
                <div class="col-lg-4 text-center">
                    <span class="text-white" style="font-size: 15px;"> <span trn="min-order"> Min. order</span> <b class="ml-3 mr-3"> <?php echo $settings->getCurrency() . number_format($settings->getMinOrder()); ?></b></span>
                    <a data-toggle="modal" data-target="#cart"> <img src="assets/images/shop/cart.svg" alt="cart" width="40"></a>
                </div>
            </div>
        </div>
    </div>

    <!-- End Banner  4 -->
<?php } ?>