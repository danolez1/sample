<div class="top-notice-m justify-content-center" data-aos="fade-up">
    <div class="row col-md-12 pt-1">
        <img src="assets/images/shop/delivery_logo.svg" class="top-notice-icon" alt="delivery time" width="45">
        <span class="mt-1"> <span trn="delivery-time">Delivery time</span> <b class="ml-1 span-circle"><?php echo $settings->getDeliveryTime(); ?></b> <b><span trn="minutes">min</span></b></span>
    </div>
    <div class="row col-md-12 pt-1">
        <div class=" row col-8">
            <i class="icofont-clock-time mt-1" style="font-size: 24px; margin:0 1.2em;"></i>
            <h6 class="mt-1"><?php echo $this->available ? '<span trn="opened">Opened</span>' : '<span trn="closed">Closed</span>'; ?></h6>
        </div>
        <div class="col-4 text-right">
            <button class="btn btn-sm btn-danger"><?php echo $this->available ? '<span trn="opened">Opened</span>' : '<span trn="closed">Closed</span>'; ?></button>
        </div>
    </div>
    <div class="row col-md-12 pt-1">
        <div class="row col-12">
            <a data-toggle="modal" data-target="#cart"> <img src="assets/images/shop/cart.svg" class="top-notice-icon" alt="cart"></a>
            <span class="mt-1"> <span trn="min-order"> Min. order</span> <b class="ml-1"> <?php echo $settings->getCurrency() . number_format($settings->getMinOrder()); ?></b></span>
        </div>

    </div>
</div>