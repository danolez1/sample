<?php

use danolez\lib\Security\Encoding; ?>
<div data-id="<?php echo $cartItem->getId() ?>">
    <div class="pt-3 pb-3">
        <div class="row col-12">
            <i class="mdi mdi-delete delete-btn delete-btn-danger" data-page="delete-cart-item" data-id="<?php echo Encoding::encode(json_encode(array($cartItem->getId(), is_null($this->user) ? $this->session->get(self::GUEST) : $this->user->getId()))); ?>" style="margin-top: -8px; margin-right:-8px"></i>
            <div class="col-lg-1 col-md-1 col-sm-1 text-left pr-3">
                <h5 class="span-circle" style="background-color:#05C776;">x<?php echo  intval($cartItem->getQuantity()); ?></h5>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-5 text-left pl-4 mt-1">
                <h4 class="order-sub-title font-weight-bold"><?php echo  $cartItem->getProductDetails(); ?></h4>
                <div style="font-size:14px">
                    <span class="text-muted"><?php foreach (fromDbJson($cartItem->getProductOptions()) as $option) echo unicode2html($option->name ). ' <strong> X' . $option->amount . '</strong> ・'; ?></span><br>
                    <!-- Fanta Onions <strong>X3</strong>・Ketup <strong>X1</strong> -->
                    <span class="text-muted"><span>Note</span>: "<?php echo $cartItem->getAdditionalNote(); ?>" </span>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 text-lg-center text-sm-right">
                <span class="order-sub-title font-weight-bold ml-2"><?php echo $settings->getCurrency() . number_format(intval($cartItem->getAmount()) * intval($cartItem->getQuantity())); ?></span>
                <div class="qty text-right">
                    <i class="mdi mdi-minus-circle" data-id="<?php echo Encoding::encode(json_encode(array($cartItem->getId(), is_null($this->user) ? $this->session->get(self::GUEST) : $this->user->getId()))); ?>"></i>
                    <input type="number" class="count" name="qty" value="<?php echo intval($cartItem->getQuantity()); ?>">
                    <i class="mdi mdi-plus-circle" data-id="<?php echo Encoding::encode(json_encode(array($cartItem->getId(), is_null($this->user) ? $this->session->get(self::GUEST) : $this->user->getId()))); ?>"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row-hr"></div>
</div>