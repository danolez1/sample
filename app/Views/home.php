<?php

use danolez\lib\Res\Orientation;
use Demae\Auth\Models\Shop\Branch;
use Demae\Auth\Models\Shop\Product;

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
        <div class="row col-12 m-0 " style="margin:10px auto 2rem;">
        <?php } else { ?>
            <div class="row col-12 mt-lg-5 m-0 ">
            <?php } ?>
            <?php if (!$verticalMenu) {
                if ($slider == 0 || $slider == 1) { ?>
                    <ul class="nav nav-pills-h mb-2" id="menu">
                        <li class="nav-item category-pill"><a class="de-nav-link active" data-toggle="tab">All</a></li>
                        <?php foreach ($productCategories as $category) { ?>
                            <li class="nav-item category-pill" data-id="<?php echo $category->getId(); ?>"><a href="#<?php echo  $category->getName(); ?>" class="de-nav-link" data-toggle="tab"> <?php echo  $category->getName(); ?></a></li>
                        <?php } ?>
                    </ul>
            </div>

        <?php } else { ?>
            <div class="col-lg-8 col-md-6 col-sm-6" style="margin-bottom: 2em;margin-top: 2em;" id="menu">
                <ul class="nav nav-pills-h nav-slider-2">
                    <li class="nav-item category-pill"><a class="de-nav-link active" href="#all" data-toggle="tab">All</a></li>
                    <?php foreach ($productCategories as $category) { ?>
                        <li class="nav-item category-pill" data-id="<?php echo $category->getId(); ?>"><a href="#<?php echo  $category->getName(); ?>" onclick="javascript:;" class="de-nav-link" data-toggle="tab"> <?php echo  $category->getName(); ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-lg-4 col-sm-6 col-md-6" style="margin-bottom: 3em;margin-top:-.4em;">
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
    <div class="row col-12 p-0 m-0">
        <?php if ($verticalInfo) { ?>
            <div class="col-lg-3 col-sm-4 col-md-4 justify-content-end" style="margin-top:10px;">
                <div class="card" data-aos="zoom-in-up">
                    <div class="card-body">
                        <h5 class="card-title" trn="opening-hours">Opening Hours </h5>
                        <h6 class="card-subtitle mb-4 text-muted mt-2">Mon to Sat 10am - 8pm</h6>
                        <h5 class="card-title" trn="order-conditions">Order conditions</h5>
                        <p class="card-text"><span trn="min-order"> Min. order</span> <b> <?php echo $settings->getCurrency() . number_format($settings->getMinOrder()); ?></b></span>
                            <br> <span trn="shipping-fee">Shipping Fee : </span><?php echo $settings->getCurrency() . number_format(intval($settings->getShippingFee())) . ' (' . $settings->getCurrency() . number_format(intval($settings->getFreeDeliveryPrice())) . ' <span trn="free-shipping">above free shipping</span>)' ?> </p>
                        <h5 class="card-title mt-3 mt-lg-0 mt-md-0 font-weight-bold" trn="branch-selected">Branch selected</h5>
                        <p class="card-text mb-4"><?php echo ($this->branch instanceof Branch) ? $this->branch->getName() : ''; ?> </p>
                        <h5 class="card-title" trn="delivery-areas">Delivery Areas</h5>
                        <p class="card-text mb-4"><?php echo $settings->getDeliveryAreas(); ?></p>

                    </div>
                </div>
            </div>

        <?php }
            } else { ?>
        <div class="row col-12">
            <div class="col-lg-3 col-sm-4 col-md-4 mt-3" style="margin-top:25px !important">
                <?php if ($slider == 2 || $slider == 3) { ?>
                    <div class="search-m-bar col-12 mb-4" style="border:2px #eee solid">
                        <input class="search-s-_input" type="text" name="" placeholder="Search...">
                        <a class="search-s-_icon sd-nmt" style="margin-right: -2px;"><i class="ri-search-2-line"></i></a>
                    </div>
                <?php }  ?>
                <div data-aos="zoom-in-right">
                    <div class="mt-2">
                        <h5 class="vmenu-title">Menu</h5>
                        <div class="dropdown-divider"></div>
                        <div class="nav flex-column nav-pills-v" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="de-nav-link active category-pill" href="#all" data-toggle="pill" aria-selected="true">All</a>
                            <?php foreach ($productCategories as $category) { ?>
                                <a href="#<?php echo  $category->getName(); ?>" class="de-nav-link category-pill" data-id="<?php echo $category->getId(); ?>" data-toggle="pill" aria-selected="true"><?php echo  $category->getName(); ?></a>
                            <?php } ?>

                        </div>
                    </div>
                </div>

                <?php
                if ($verticalInfo) { ?>
                    <div class="card mt-5" data-aos="zoom-in-up">
                        <div class="card-body">
                            <h5 class="card-title" trn="opening-hours">Opening Hours </h5>
                            <h6 class="card-subtitle mb-4 text-muted mt-2">Mon to Sat 10am - 8pm</h6>
                            <h5 class="card-title" trn="order-conditions">Order conditions</h5>
                            <p class="card-text"><span trn="min-order"> Min. order</span><b><?php echo $settings->getCurrency() . number_format($settings->getMinOrder()); ?>～</b></span>
                                <br> <span trn="shipping-fee">Shipping Fee : </span><?php echo $settings->getCurrency() . number_format(intval($settings->getShippingFee())) . ' (' . $settings->getCurrency() . number_format(intval($settings->getFreeDeliveryPrice())) . ' <span trn="free-shipping">above free shipping</span>)' ?> </p>
                            <h5 class="card-title mt-3 mt-lg-0 mt-md-0 font-weight-bold" trn="branch-selected">Branch selected</h5>
                            <p class="card-text mb-4"><?php echo ($this->branch instanceof Branch) ? $this->branch->getName() : ''; ?> </p>
                            <h5 class="card-title" trn="delivery-areas">Delivery Areas</h5>
                            <p class="card-text mb-4"><?php echo $settings->getDeliveryAreas(); ?></p>

                        </div>
                    </div>
                <?php }  ?>
            </div>
        <?php } ?>


        <div class="tab-content d-flex justify-content-center <?php echo ($verticalMenu || $verticalInfo) ? 'col-lg-9 col-sm-8 col-md-8' : 'col-12'; ?> m-0 p-0">
            <div class="row d-flex m-0 p-0 justify-content-start " data-aos="fade-left" style="width: 96%;">
                <?php
                if ($settings->getProductDisplayOrientation() == Orientation::LIST) {
                    echo '<div class="accordion" id="listAccordion">';
                }
                foreach ($this->products as $product) {
                    $branches = (fromDbJson($product->getBranchId()));
                    if ($this->branch != null) {
                        if (in_array($this->branch->getId(), $branches ?? [])) {
                            if ($settings->getProductDisplayOrientation() == Orientation::GRID) {
                                include 'app/Views/shop/product-grid.php';
                            } else {
                                include 'app/Views/shop/product-list.php';
                            }
                        }
                        if ($settings->getProductDisplayOrientation() == Orientation::LIST) {
                            echo '</div>';
                        }
                    }
                } ?>
            </div>
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
    <section >
        <div class="card ml-4 mr-4" data-aos="zoom-in-up">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-sm-4">
                        <h5 class="card-title font-weight-bold" trn="opening-hours">Opening Hours</h5>
                        <h6 class="card-subtitle mb-4 text-muted mt-2">Mon to Sat 10am - 8pm</h6>
                        <h5 class="card-title font-weight-bold" trn="order-conditions">Order conditions</h5>
                        <p class="card-text"><span trn="min-order"> Min. order</span> <b> <?php echo $settings->getCurrency() . number_format($settings->getMinOrder()); ?></b></span>
                            <br> <span trn="shipping-fee">Shipping Fee : </span><?php echo ' <strong>' . $settings->getCurrency() . number_format(intval($settings->getShippingFee())) . '</strong> (<strong>' . $settings->getCurrency() . number_format(intval($settings->getFreeDeliveryPrice())) . '</strong> <span trn="free-shipping">above free shipping</span>)' ?> </p>
                    </div>
                    <div class="col-lg-6 col-sm-4">
                        <h5 class="card-title mt-3 mt-lg-0 mt-md-0 font-weight-bold" trn="branch-selected">Branch selected</h5>
                        <p class="card-text mb-4"><?php echo ($this->branch instanceof Branch) ? $this->branch->getName() : ''; ?> </p>

                        <h5 class="card-title mt-3 mt-lg-0 mt-md-0 font-weight-bold" trn="delivery-areas">Delivery Areas</h5>
                        <p class="card-text mb-4"><?php echo $settings->getDeliveryAreas(); ?> </p>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <h5 class="card-title font-weight-bold" trn="we-accept">We Accept </h5>
                        <div style="font-size:48px;"><?php foreach ($settings->getPaymentMethods() as $payment) echo $payment . ' '; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<!-- END HORIZONTAL DETAILS -->