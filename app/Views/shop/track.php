 <div style="background: #F5F8F7;">
     <div class="row col-12 justify-content-center pt-4">
         <h3 trn="track-delivery">Track Delivery</h3>
     </div>
     <hr>
     <?php $order = ($this->track->order);
        if ($this->track->delivery) $stats = (fromDbJson($this->track->delivery->getStatus())) ?>
     <section id="home" class="home">
         <div class="container-fluid">
             <?php // include 'app/Views/shop/order.php'; 
                ?>
             <div class="row col-12 align-middle">
                 <div class="col-6 pr-4 mt-4 pt-4">
                     <input type="hidden" name="track-id" data-id="<?php echo count($stats); ?>" value="<?php echo ($_COOKIE["cmVjZW50LW9yZGVy"]) ?>" />
                     <ul class="timeline">
                         <?php $tf = "F j, H:i ";
                            if (date("Y") != date("Y", $order->getTimeCreated())) $tf = "F j, Y, H:i"; ?>
                         <li class="row justify-content-between" id="start">
                             <h5 trn="order-sent">Your order has been sent</h5>
                             <p class="float-right"><?php echo date($tf, $order->getTimeCreated()) ?></p>
                         </li>
                         <?php foreach ($stats as $status) {
                                $status = json_decode($status);
                                $stat =  $this->track->delivery->showDeliveryInfo($status->status);
                            ?>
                             <li class="row justify-content-between">
                                 <h5 trn="<?php echo $stat['trn']; ?>"><?php echo $stat[0] ?></h5>
                                 <p class="float-right"><?php echo date($tf, $status->time) ?></p>
                             </li>
                         <?php } ?>
                     </ul>

                 </div>
                 <div class="col-6 text-center">
                     <img src="assets/images/home/delivery_guy.svg" class="img-fluid mt-5 mt-lg-0 col-8" data-aos="zoom-in-up">
                 </div>
             </div>
         </div>
     </section>
     <div class="row col-12 justify-content-center pt-4 pb-5">
         <a href="shop">
             <button type="button" class="btn btn-sm btn-danger add-to-cart"><span>Continue Shopping</span><span class="mdi mdi-cart-plus ml-2"></span></button>
         </a>
     </div>
 </div>