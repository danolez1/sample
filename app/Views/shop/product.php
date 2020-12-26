<!-- Modal -->
<div class="modal fade" id="productModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <img class="product-img" src="<?php

                                                use danolez\lib\Security\Encoding\Encoding;
                                                use Demae\Controller\ShopController\HomeController;

                                                echo $settings->getImagePlaceholder(); ?>" id="product-modal-img">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" method="post" role="form" class="php-email-form" style="background-color: #fefefe;">
                <div class="modal-body">
                    <div>
                        <h5 class="font-weight-bold text-dark mt-4 mb-2" id="product-modal-name">Beef Rose lemon steak</h5>
                        <span class="text-muted font-weight-normal" id="product-modal-description" style="font-size: 14px ;"> The best steak garished with some lemon trust it to leave your mouth slightly sour.</span>
                        <p class="mt-2"><span class="badge pt-2 pb-2 pr-2 pl-2 price-tag"><?php //echo $settings->getCurrency(); 
                                                                                            ?><span id="product-modal-price"></span></span>
                            <input type="hidden" name="product-details" />
                            <input type="hidden" name="session" value="<?php echo $this->user != null ? Encoding::encode(json_encode(array($this->user->getEmail(), $this->user->getId())), HomeController::VALUE_ENCODE_ITERTATION) : $this->session->get(self::GUEST); ?>" />
                            <input type="hidden" name="product-modal-total" value="" />
                            <?php if ($settings->getDisplayRating()) { ?>
                                <i class="mdi mdi-star-circle rating-icon"></i>
                                <span class="rating-text" id="product-modal-ratings">3.0</span>
                            <?php }
                            if ($settings->getDisplayOrderCount()) { ?>
                                <i class="mdi mdi-account-group rating-icon" style="color: #666666;"></i>
                                <span class="rating-text" id="product-modal-orderCount" style="color: #666666;">300</span>
                            <?php } ?>
                        </p>
                    </div>
                    <h6 class="font-weight-bold text-dark mt-2 mb-2">Options</h6>
                </div>
                <!-- START OPTIONS -->
                <div id="option-display">







                </div>
                <!-- END OPTIONS -->
                <!-- ADDITIONAL NOTE -->
                <div class="modal-option-header row col-12 pl-3 pb-3 pt-3" style="border:none">
                    <span class="text-left col-8"> Additional Notes </span>
                </div>
                <textarea name="product-modal-note" placeholder="Add a note (e.g extra pepper, salty etc.)" rows="3" style="width: 100%;"></textarea>
                <!-- ENF NOTE -->
                <div class="dropdown-divider"></div>
                <div class="modal-footer">
                    <span>Total</span><br>
                    <div class="row col-12 text-left ml-2 align-self-center align-items-center" style="padding: 0">
                        <div class="col-4 text-start mx-auto" style="padding: 0;">
                            <span class="badge total-price align-baseline"><?php //echo $settings->getCurrency(); 
                                                                            ?><span id="product-modal-total-price">200</span></span>
                        </div>
                        <div class="col-4 text-right" style="padding: 0;">
                            <button type="button" class="btn btn-sm btn-outline-danger add-to-cart col-11 cart-order" data-page="add-to-cart"><span>Add to cart</span><span class="mdi mdi-cart-plus ml-2"></span></button>
                        </div>
                        <div class="col-4 text-right pr-2" style="padding: 0;">
                            <button type="button" class="btn btn-sm btn-danger add-to-cart col-11 cart-order" data-page="order-now"><span>Order now</span><span class="mdi mdi-arrow-right-bold ml-2"></span></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>