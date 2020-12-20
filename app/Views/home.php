<?php

use danolez\lib\Res\Orientation\Orientation;
use Demae\Auth\Models\Shop\Product\Product;

include 'app/Views/shop/slider.php';
$verticalMenu = ($settings->getMenuDisplayOrientation() == Orientation::VERTICAL);
$verticalInfo = ($settings->getInfoDisplayOrientation() == Orientation::VERTICAL); ?>

<button id="cart-fab" type="button" data-toggle="modal" data-target="#cart">
    <img src="assets/images/shop/cart.svg" alt="cart" width="46" height="46">
</button>
<!-- FOOD LIST SECTION -->
<section>
    <!-- HORIZONTAL MENU -->
    <?php if ($slider == 3) { ?>
        <div class="row col-12" style="margin:-10px auto 2rem;">
        <?php } else { ?>
            <div class="row col-12 mt-lg-5">
            <?php } ?>
            <?php if (!$verticalMenu) {
                if ($slider == 0 || $slider == 1) { ?>
                    <ul class="nav nav-pills-h mb-2">
                        <li class="nav-item"><a class="de-nav-link active" href="" data-toggle="tab">All</a></li>
                        <li class="nav-item"><a class="de-nav-link" href="" data-toggle="tab">Menu 1</a></li>
                        <li class="nav-item"><a class="de-nav-link" href="" data-toggle="tab">Menu 2</a></li>
                        <li class="nav-item"><a class="de-nav-link" href="" data-toggle="tab">Menu 1</a></li>
                        <li class="nav-item"><a class="de-nav-link" href="" data-toggle="tab">Menu 2</a></li>
                    </ul>
            </div>

        <?php } else { ?>
            <div class="col-lg-8 col-md-6 col-sm-4" style="margin-bottom: 2em;">
                <ul class="nav nav-pills-h nav-slider-2">
                    <li class="nav-item"><a class="de-nav-link active" href="" data-toggle="tab">All</a></li>
                    <li class="nav-item"><a class="de-nav-link" href="" data-toggle="tab">Menu 1</a></li>
                    <li class="nav-item"><a class="de-nav-link" href="" data-toggle="tab">Menu 2</a></li>
                    <li class="nav-item"><a class="de-nav-link" href="" data-toggle="tab">Menu 3</a></li>
                    <li class="nav-item"><a class="de-nav-link" href="" data-toggle="tab">Menu 4</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-sm-4 col-md-6" style="margin-bottom: 3em;margin-top:-2.7em;">
                <div class="row col-12 justify-content-center mt-5">
                    <div class="search-m-bar col-12" style="border:2px #eee solid">
                        <input class="search-s-_input" type="text" name="" placeholder="Search...">
                        <a class="search-s-_icon" style="margin-top: -2px;margin-right: -2px;"><i class="ri-search-2-line"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END HORIZONTAL MENU -->
    <?php } ?>
    <div class="row col-12">
        <?php if ($verticalInfo) { ?>
            <div class="col-lg-3 col-sm-4 col-md-4 justify-content-end" style="margin-top:<?php echo ($settings->getSliderType() == 2) ? "-10px" : "10px"; ?>">
                <div class="card" data-aos="zoom-in-up">
                    <div class="card-body">
                        <h5 class="card-title" trn="opening-hours">Opening Hours </h5>
                        <h6 class="card-subtitle mb-4 text-muted mt-2">Mon to Sat 10am - 8pm</h6>
                        <h5 class="card-title" trn="order-conditions">Order conditions</h5>
                        <p class="card-text"><span trn="min-order"> Min. order</span> <b> <?php echo $settings->getCurrency() . $settings->getMinOrder(); ?></b></span><br><?php echo $settings->getShippingFee() > 0 ? $settings->getCurrency() . $settings->getShippingFee() : '<span trn="free-shipping">Free shipping</span>' ?> </p>
                        <h5 class="card-title" trn="delivery-areas">Delivery Areas</h5>
                        <p class="card-text mb-4"><?php foreach ($settings->getDeliveryAreas() as $area) echo $area . ', '; ?></p>

                    </div>
                </div>
            </div>

        <?php }
            } else { ?>
        <div class="row col-12">
            <div class="col-lg-3 col-sm-4 col-md-4 " style="margin-top:<?php echo ($settings->getSliderType() == 2) ? "-10px" : "10px"; ?>">
                <?php if ($slider == 2 || $slider == 3) { ?>
                    <div class="search-m-bar col-12 mb-4" style="border:2px #eee solid">
                        <input class="search-s-_input" type="text" name="" placeholder="Search...">
                        <a class="search-s-_icon sd-nmt" style="margin-right: -2px;"><i class="ri-search-2-line"></i></a>
                    </div>
                <?php }  ?>
                <div data-aos="zoom-in-right">
                    <div class="">
                        <h5 class="vmenu-title">Branches</h5>
                        <div class="dropdown-divider"></div>
                        <div class="nav flex-column nav-pills-v" aria-orientation="vertical" style="text-transform: uppercase;">
                            <a class="de-nav-link active" data-toggle="pill" href="#v-pills-home" aria-selected="true">Home</a>
                            <a class="de-nav-link" data-toggle="pill" href="#v-pills-profile" role="tab">Profile</a>
                            <a class="de-nav-link" data-toggle="pill" href="#v-pills-messages" role="tab">Messages</a>
                            <a class="de-nav-link" data-toggle="pill" href="#v-pills-settings" role="tab">Settings</a>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="nav flex-column nav-pills-v" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="de-nav-link active" data-toggle="pill" href="#v-pills-home" aria-selected="true">Home</a>
                            <a class="de-nav-link" data-toggle="pill" href="#v-pills-profile" role="tab">Profile</a>
                            <a class="de-nav-link" data-toggle="pill" href="#v-pills-messages" role="tab">Messages</a>
                            <a class="de-nav-link" data-toggle="pill" href="#v-pills-settings" role="tab">Settings</a>
                        </div>
                    </div>
                </div>

                <?php
                if ($verticalInfo) { ?>
                    <div class="card" data-aos="zoom-in-up">
                        <div class="card-body">
                            <h5 class="card-title" trn="opening-hours">Opening Hours </h5>
                            <h6 class="card-subtitle mb-4 text-muted mt-2">Mon to Sat 10am - 8pm</h6>
                            <h5 class="card-title" trn="order-conditions">Order conditions</h5>
                            <p class="card-text"><span trn="min-order"> Min. order</span> <b> <?php echo $settings->getCurrency() . $settings->getMinOrder(); ?></b></span><br><?php echo $settings->getShippingFee() > 0 ? $settings->getCurrency() . $settings->getShippingFee() : '<span trn="free-shipping">Free shipping</span>' ?> </p>
                            <h5 class="card-title" trn="delivery-areas">Delivery Areas</h5>
                            <p class="card-text mb-4"><?php foreach ($settings->getDeliveryAreas() as $area) echo $area . ', '; ?></p>

                        </div>
                    </div>
                <?php }  ?>
            </div>
        <?php } ?>

        <div class="tab-content d-flex <?php echo ($verticalMenu || $verticalInfo) ? 'col-lg-9 col-sm-8 col-md-8' : 'col-12'; ?> ">
            <div class="row" data-aos="fade-left">
                <?php
                if ($settings->getProductDisplayOrientation() == Orientation::LIST) {
                    echo '<div class="accordion" id="listAccordion">';
                }
                for ($i = 0; $i < count($products) + 3; $i++) { //foreach($products as $product)                        
                    $product = new Product();
                    $product->setDisplayImage('assets/images/shop/food.png');
                    $product->setAvailability(0);
                    $product->setName('Beef Rose Lemon Steak');
                    $product->setDescription('The best steak garished with some lemon trust it to leave your mouth slightly sour.');
                    $product->setPrice(200);
                    $product->setRatings(3.0);
                    if ($settings->getProductDisplayOrientation() == Orientation::GRID) {
                        include 'app/Views/shop/product-grid.php';
                    } else {
                        include 'app/Views/shop/product-list.php';
                    }
                }
                if ($settings->getProductDisplayOrientation() == Orientation::LIST) {
                    echo '</div>';
                } ?>
            </div>
        </div>
        </div>
    </div>


</section>
<!-- END FOOD LIST SECTION -->
<!-- PAGINATION SECTION -->
<!-- <section>
    <div class="row ">
        <nav aria-label="..." class="mx-auto">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item active"><a class="page-link" href="#">2 <span class="sr-only">(current)</span></a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</section> -->
<!-- END PAGINATION SECTION -->
<!-- HORIZONTAL DETAILS -->
<?php if (!$verticalInfo) { ?>
    <section>
        <div class="card ml-5 mr-5" data-aos="zoom-in-up">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-sm-4">
                        <h5 class="card-title font-weight-bold" trn="opening-hours">Opening Hours</h5>
                        <h6 class="card-subtitle mb-4 text-muted mt-2">Mon to Sat 10am - 8pm</h6>
                        <h5 class="card-title font-weight-bold" trn="order-conditions">Order conditions</h5>
                        <p class="card-text"><span trn="min-order"> Min. order</span> <b> <?php echo $settings->getCurrency() . $settings->getMinOrder(); ?></b></span><br><?php echo $settings->getShippingFee() > 0 ? $settings->getCurrency() . $settings->getShippingFee() : '<span trn="free-shipping">Free shipping</span>' ?> </p>
                    </div>
                    <div class="col-lg-6 col-sm-4">
                        <h5 class="card-title mt-3 mt-lg-0 mt-md-0 font-weight-bold" trn="delivery-areas">Delivery Areas</h5>
                        <p class="card-text mb-4"><?php foreach ($settings->getDeliveryAreas() as $area) echo $area . ', '; ?> </p>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <h5 class="card-title font-weight-bold" trn="we-accept">We Accept </h5>
                        <div style="font-size:48px;"><?php foreach ($settings->getPaymentMethods() as $payment) echo $payment . ' '; ?></div>
                        <!-- <img class="img-fluid" src="assets/images/shop/mastercard.svg" height="48"><img class="img-fluid ml-4" src="assets/images/shop/amex.svg" height="48"><br>
                        <img class="img-fluid mt-4" src="assets/images/shop/stripe.svg" height="32"><img class="img-fluid ml-4 mt-4" src="assets/images/shop/visa.svg" height="32"> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<!-- END HORIZONTAL DETAILS -->