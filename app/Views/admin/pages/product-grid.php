<?php// include 'app/Views/shop/product.php'; ?>
<div class="col-sm-6 col-lg-4 mt-4">
    <div class="grid-product-card">
        <img class="grid-product-card-img-top" src="<?php echo $product->getDisplayImage() ?>" data-toggle="modal" data-target="#productModal">
        <!-- AVAILABILITY INFO -->
        <?php if ($product->getAvailability() > 0) { ?>
            <div class="grid-product-img-info">
                <span><?php echo $product->availabilityText(); ?> </span>
            </div>
        <?php } ?>
        <!-- END AVAIL. INFO -->
        <div class="grid-product-card-block" <?php echo !($product->getAvailability() > 0) ? 'data-toggle="modal" data-target="#productModal"' : '';  ?>>
            <h4 class="grid-product-card-title mt-3"><?php echo $product->getName() ?></h4>
            <div class="grid-product-card-text"><?php echo $product->getDescription() ?> </div>
            <div class="row mt-3">
                <div class="col-6 justify-content-between">
                    <span class="badge pt-2 pb-2 pr-2 pl-2 price-tag"><?php $product->getPrice(); ?></span>

                    <i class="mdi mdi-star-circle rating-icon"></i>
                    <span class="rating-text"><?php echo round($product->getRatings(), 2) . '.0'; ?></span>

                </div>
                <div class="col-6 text-right">
                    <button type="button" class="btn btn-sm btn-outline-danger add-to-cart"><span trn="add-to-cart">Add</span><span class="mdi mdi-cart-plus ml-2"></span></button>
                </div>
            </div>
        </div>
    </div>
</div>