<!-- Modal -->
<?php

use danolez\lib\Security\Encoding;
use Demae\Controller\HomeController;
?>
<div class="modal fade" id="productModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header p-0 m-0" style="overflow: hidden;padding-left:-2px;">
                <img class="product-img" src="<?php echo $settings->getImagePlaceholder(); ?>" data-placeholder="<?php echo $settings->getImagePlaceholder(); ?>" id="product-modal-img">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute;z-index:1000; right:0;margin-right:.07em;margin-top:.07em; top:0;color:#FA1616;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" method="post" role="form" class="php-email-form" style="background-color: #fefefe;">
                <div class="modal-body">
                    <div>
                        <h5 class="font-weight-bold text-dark mt-4 mb-2" id="product-modal-name"></h5>
                        <span class="text-muted font-weight-normal" id="product-modal-description" style="font-size: 14px ;"></span>
                        <p class="mt-2"><span class="badge pt-2 pb-2 pr-2 pl-2 price-tag"><?php //echo $settings->getCurrency(); 
                                                                                            ?><span id="product-modal-price"></span></span>
                            <input type="hidden" name="product-details" />
                            <input type="hidden" name="session" value="<?php echo $this->user != null ?  $this->user->getId() : $this->session->get(self::GUEST); ?>" />
                            <input type="hidden" name="product-modal-total" value="" />
                            <?php if ($settings->getDisplayRating()) { ?>
                                <i class="mdi mdi-star-circle rating-icon"></i>
                                <span class="rating-text" id="product-modal-ratings">3.0</span>
                            <?php }
                            if ($settings->getDisplayOrderCount()) { ?>
                                <i class="mdi mdi-account-group rating-icon" style="color: #666666;"></i>
                                <span class="rating-text" id="product-modal-orderCount" style="color: #666666;"></span>
                            <?php } ?>
                        </p>
                    </div>
                    <h6 class="font-weight-bold text-dark mt-2 mb-2" trn="options">Options</h6>
                </div>
                <!-- START OPTIONS -->
                <div id="option-display"></div>
                <!-- END OPTIONS -->
                <!-- ADDITIONAL NOTE -->
                <div class="modal-option-header row col-12 pl-3 pb-3 pt-3" style="border:none">
                    <span class="text-left col-8" trn="additional-note">Additional Notes</span>
                </div>
                <textarea name="product-modal-note" trn="extra-note" placeholder="Add a note (e.g extra pepper, salty etc.)" maxlength="120" rows="3" style="width: 100%;"></textarea>
                <!-- ENF NOTE -->
                <div class="dropdown-divider"></div>
                <div class="modal-footer">
                    <span trn="total">Total</span><br>
                    <div class="row col-12 text-left ml-2 align-self-center align-items-center" style="padding: 0">
                        <div class="col-4 text-start mx-auto" style="padding: 0;">
                            <span class="badge total-price align-baseline"><span id="product-modal-total-price"></span></span>
                        </div>
                        <div class="col-4 text-right" style="padding: 0;">
                            <button type="button" class="btn btn-sm btn-outline-danger add-to-cart col-11 cart-order" data-page="add-to-cart"><span trn="add-to-cart">Add to cart</span><span class="mdi mdi-cart-plus ml-2"></span></button>
                        </div>
                        <div class="col-4 text-right pr-2" style="padding: 0;">
                            <button type="button" class="btn btn-sm btn-danger add-to-cart col-11 cart-order" data-page="order-now"><span trn="order-now">Order now</span><span class="mdi mdi-arrow-right-bold ml-2"></span></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>