<?php

use Demae\Auth\Models\Shop\Cart\CartItem;
use Demae\Auth\Models\Shop\Product\Product;
use Demae\Auth\Models\Shop\Product\ProductOption; ?>
<div class="modal right fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="right_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row-hr mt-4"></div>
            <form method="post" action="">
                <?php
                $total = 0;
                foreach ($this->cart as $cartItem) {
                    include 'app/Views/shop/cart_item.php';
                    $total = $total + (intval($cartItem->getAmount()) * intval($cartItem->getQuantity()));
                } ?>


                <div class="modal-footer modal-footer-fixed">
                    <span>Total</span><br>
                    <div class="row col-12 text-left ml-2" style="padding: 0">
                        <div class="col-5 text-start" style="padding: 0;">
                            <span class="badge total-price"><?php echo $settings->getCurrency() . number_format($total); ?></span>
                        </div>
                        <div class="col-7 text-right pr-2" style="padding: 0;">
                            <button type="button" class="btn btn-sm btn-success add-to-cart col-11"><span>Check Out</span><span class="mdi mdi-arrow-right-bold ml-2"></span></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>