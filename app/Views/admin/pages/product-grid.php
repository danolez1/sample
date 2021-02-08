<?php

use danolez\lib\Security\Encoding;
use Demae\Auth\Models\Shop\Product;
use Demae\Auth\Models\Shop\Setting;

?>

<div class="col-sm-6 col-12 col-lg-4 p-2 m-0 col-md-4 mt-4 grid-product-card-wrap ">
    <div class="grid-product-card" style="min-width: 230px !important;">
        <img class="grid-product-card-img-top" src="<?php echo isEmpty($product->getDisplayImage()) ? Setting::getInstance()->getImagePlaceholder() : $product->getDisplayImage(); ?>">
        <!-- AVAILABILITY INFO -->

        <?php if ($product->getAvailability() == Product::SOLD_OUT) { ?>
            <div class="grid-product-img-info">
                <span><?php echo $product->availabilityText(); ?> </span>
            </div>
        <?php } ?>
        <!-- END AVAIL. INFO -->
        <div class="grid-product-card-block">
            <h4 class="grid-product-card-title mt-3"><?php echo $product->getName() ?></h4>
            <div class="grid-product-card-text"><?php echo $product->getDescription() ?> </div>
            <div style="position: absolute;bottom: 0;left:0; right:0;">
                <div class="row mt-1 p-0 ml-2 pl-2 col-12">
                    <span class="badge pt-2 pb-2 pr-2 pl-2 price-tag"><?php echo Setting::getInstance()->getCurrency() . number_format($product->getPrice()); ?></span>
                    <i class="mdi mdi-star-circle rating-icon text-info pt-1 ml-3"></i>
                    <span class="rating-text text-info pt-1"><?php echo round($product->getRatings(), 2) . '.0'; ?></span>
                </div>
                <div class="row p-2 pl-3 pr-3 pb-3" data-id="<?php echo $product->getId(); ?>">
                    <div class="col-6 dropup">
                        <button class="btn btn-sm btn-success dropdown-toggle tx-12" data-id="<?php echo Encoding::encode(json_encode(array($this->admin->getId(), $this->admin->getUserName(), $product->getId()))); ?>" data-async="product-status" trn="<?php echo $product->getStatusInfo()[0]['trn']; ?>" data="<?php echo $product->getStatusInfo()[0]['data']; ?>" color="<?php echo $product->getStatusInfo()[0]['color']; ?>" style="color:white;" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $product->getStatusInfo()[0][0]; ?></button>
                        <div class="dropdown-menu p-0">
                            <a class="dropdown-item" trn="<?php echo $product->getStatusInfo()[1]['trn']; ?>" data="<?php echo $product->getStatusInfo()[1]['data']; ?>" color="<?php echo $product->getStatusInfo()[1]['color']; ?>" href="javascript:;"><?php echo $product->getStatusInfo()[1][0]; ?></a>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <i class="edit-product icofont-ui-edit hover click mr-2 text-info border border-info p-2 rounded-circle"></i>
                        <i class="async icofont-ui-delete hover click text-danger border border-danger p-2 rounded-circle" data-id="<?php echo Encoding::encode(json_encode(array($product->getId(), $this->admin->getId(), $this->admin->getUsername()))) ?>" data-page="delete-product"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>