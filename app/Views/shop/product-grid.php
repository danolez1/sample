<?php include 'app/Views/shop/product.php'; ?>
<div class="col-sm-6 col-12 col-lg-4 p-2 m-0 col-md-4 mt-4 grid-product-card-wrap ">
    <div class="grid-product-card" style="min-width: 230px !important;">
        <!-- PROMOTIONAL INFO -->
        <?php ?>
        <?php ?>
        <!-- END PROMOTIONAL INFO -->
        <i class="ri-heart-line grid-product-fav" data-id="<?php echo $product->getId(); ?>"></i>
        <img class="grid-product-card-img-top" src="<?php echo isEmpty($product->getDisplayImage()) ? $settings->getImagePlaceholder() : $product->getDisplayImage(); ?>">
        <?php if (intval($product->getAvailability()) != 1) { ?>
            <div class="grid-product-img-info">
                <span><?php echo $product->availabilityText(); ?> </span>
            </div>
        <?php } ?>
        <div class="grid-product-card-block">
            <h4 class="grid-product-card-title mt-3 hover-underline" <?php echo (intval($product->getAvailability()) == 1) ? 'data-toggle="modal" data-target="#productModal"' : '';  ?>><?php echo $product->getName() ?></h4>
            <input type="hidden" data-branches='<?php echo  $product->getBranchId(); ?>' data-categories='<?php echo  $product->getCategory(); ?>' data-content='<?php echo  $product->getDetails(); ?>'>
            <div class="grid-product-card-text"><?php echo $product->getDescription() ?> </div>
            <div class="row mt-3 col-12 justify-content-between p-0 m-0" style="position: absolute;bottom: 0;left:0; right:0;">
                <div class="col-6 m-0 p-2 pl-3 pr-3 pb-3">
                    <?php if ($settings->getDisplayRating()) { ?>
                        <div class="col-6 p-0 m-0" style="font-size:10px;">
                            <i class="mdi mdi-star-circle rating-icon"></i>
                            <span class="rating-text"><?php printf('%0.1f', $product->getRatings()); ?></span>
                        </div>
                    <?php } ?>
                    <div class="col-6 p-0 m-0">
                        <span class="badge price-tag"><?php echo $settings->getCurrency() . number_format($product->getPrice()); ?></span>
                    </div>

                </div>
                <div class="col-6 text-right p-2  pl-3 pr-3 m-0">
                    <button type="button" <?php echo (intval($product->getAvailability()) == 1) ? 'data-toggle="modal" data-target="#productModal"' : '';  ?> class="btn btn-sm btn-outline-danger add-to-cart"><span trn="add-to-cart">Add</span><span class="mdi mdi-cart-plus ml-2"></span></button>
                </div>
            </div>
        </div>
    </div>
</div>