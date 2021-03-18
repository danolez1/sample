<?php

use danolez\lib\Security\Encoding;
use Demae\Auth\Models\Shop\Product;

?>
<div class="modal right fade" id="cart" data-id="<?php echo Encoding::encode(is_null($this->user) ? $this->session->get(self::GUEST) : $this->user->getId()); ?>" tabindex="-1" role="dialog" aria-labelledby="right_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" trn="cart2">Cart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row-hr mt-4"></div>
            <form method="post" action="">
                <div id="cart-items">
                    <?php
                    $total = 0;
                    foreach ($this->cart as $cartItem) {
                        include 'app/Views/shop/cart_item.php';
                        $total = $total + (intval($cartItem->getAmount()) * intval($cartItem->getQuantity()));
                    } ?>
                </div>
                <div class="modal-footer modal-footer-fixed pb-1">
                    <span trn="total">Total</span><br>
                    <div class="row col-12 text-left ml-2" style="padding: 0">
                        <div class="col-5 text-start" style="padding: 0;">
                            <span class="badge total-price" id="cart-total"><?php echo $settings->getCurrency() . number_format($total); ?></span>
                            <?php if ($settings->getShowTax()) { ?> <div style="font-size: 12px;font-weight:500;"><span trn="tax">Tax</span> : <span id="tax"><?php echo $settings->getCurrency() . number_format($total * Product::TAX) ?></span></div><?php } ?>
                        </div>
                        <div class="col-7 text-right pr-2" style="padding: 0;">
                            <button type="button" class="btn btn-sm btn-success col-11" id="cart-checkout"><span trn="checkout">Check Out</span><span class="mdi mdi-arrow-right-bold ml-2"></span></button>
                        </div>
                    </div>

                    <div class="row p-0 m-0 justify-content-center col-12" style="font-size: 12px;">
                        <strong> <?php echo  $settings->getCurrency() . number_format(intval($settings->getFreeDeliveryPrice()));?></strong><span>&nbsp;</span> <span trn="free-shipping1"> above free shipping</span>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>