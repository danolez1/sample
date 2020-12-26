<div class="row col-12 pt-4 top-notice" data-aos="fade-up">
    <div class="col-4 text-center">
        <img src="assets/images/shop/delivery_logo.svg" alt="delivery time">
        <span class="text-white ml-2" style="font-size: 14px;"><span trn="delivery-time">Delivery time</span> <b class="ml-2 span-circle"> <?php echo $settings->getDeliveryTime(); ?></b> <b><span trn="minutes">min</span></b></span>
    </div>
    <div class="col-4 text-center mt-2">
        <h4 class="text-white font-weight-bold"><?php echo $available ? '<span trn="opened">Opened</span>' : '<span trn="closed">Closed</span>'; ?></h4>
    </div>
    <div class="col-4 text-center">
        <span class="text-white" style="font-size: 14px;"> <span trn="min-order"> Min. order</span> <b class="ml-2 mr-3"> <?php echo $settings->getCurrency() . number_format($settings->getMinOrder()); ?></b></span>
        <a type="button" data-toggle="modal" data-target="#cart"> <img src="assets/images/shop/cart.svg" alt="cart" width="46" height="46"></a>
    </div>
</div>