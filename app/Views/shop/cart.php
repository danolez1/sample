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

                for ($i = 0; $i < count($cart) + 3; $i++) { //foreach($cart as $cartItem)  
                    $cartItem = new CartItem();
                    $product = new Product(); //id input
                    // amount, name, note
                    $product->setName('Beef Rose lemon steak');
                    $productOption = new ProductOption();
                    // name x amount,
                    $cartItem->setQuantity(5);
                    include 'app/Views/shop/cart_item.php';
                } ?>


                <div class="modal-footer modal-footer-fixed">
                    <span>Total</span><br>
                    <div class="row col-12 text-left ml-2" style="padding: 0">
                        <div class="col-4 text-start" style="padding: 0;">
                            <span class="badge total-price">¥200</span>
                        </div>
                        <div class="col-8 text-right pr-2" style="padding: 0;">
                            <button type="button" class="btn btn-sm btn-success add-to-cart col-11"><span>Check Out</span><span class="mdi mdi-arrow-right-bold ml-2"></span></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>