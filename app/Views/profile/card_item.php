<?php

use danolez\lib\Security\Encoding; ?>
<div class="card ml-1 mr-1 mb-2 p-0 card-hover col-lg-3 col-md-4 col-sm-6" style="z-index: 1;">
    <i class="mdi mdi-delete delete-card delete-btn" data-toggle="modal" data-target="#confirmationModal" data-page="payment" data-id="<?php echo Encoding::encode(json_encode(array($this->user->getId(), $creditCard->getId()))); ?>">
    </i>
    <div class="card-body m-0 ">
        <h5 class="card-title">
            <i class="icofont-<?php echo  $creditCard->cardType; ?>" style="font-size: 36px;margin-left:-5px;"></i>
            <a style="position: absolute;" class="mt-2 ml-1"><?php echo $creditCard->cardName; ?></a>
        </h5>
        <h6 class="card-text text-muted"><?php echo wordwrap($creditCard->cardNumber, 4, " ", true) ?></h6>
        <h6 class="card-text"><?php echo $creditCard->expiryDate; ?></h6>
    </div>
</div>