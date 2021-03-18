<style>
    .carousel-control-prev-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='red' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E");
    }

    .carousel-control-next-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='red' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E");
    }
</style>
<div style="background: #F5F8F7;">
    <div class="row col-12 justify-content-center pt-4">
        <h3 trn="track-delivery">Track Delivery</h3>
    </div>
    <hr>


    <div id="demo" class="carousel slide" data-ride="carousel">

        <!-- Indicators -->
        <ul class="carousel-indicators">
            <?php for ($i = 0; $i < count($this->track->whole ?? []); $i++) { ?>
                <li data-target="#demo" data-slide-to="<?php echo $i; ?>" style="background-color: red;color:red;"></li>
            <?php } ?>
        </ul>

        <!-- The slideshow -->
        <div class="carousel-inner">
            <?php
            $first = 0;
            foreach ($this->track->whole as $data) {
                $order = $data['order'];
                $this->track->delivery = $data['delivery'];
                $stats = [];
                $first++;
                if ($this->track->delivery) $stats = (fromDbJson($this->track->delivery->getStatus())) ?>
                <div class="carousel-item <?php echo $first == 1 ? "active" : '' ?>">
                    <section id="home" class="home">
                        <div class="container-fluid">
                            <?php // include 'app/Views/shop/order.php'; 
                            ?>
                            <div class="row col-12 align-middle">
                                <div class="col-6 pr-4 mt-4 pt-4">
                                    <input type="hidden" name="track-id" data-id="<?php echo count($stats); ?>" value="<?php echo base64_encode($order->getId()); ?>" />
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
                </div>
            <?php } ?>
        </div>
        <!-- Left and right controls -->
        <a class="carousel-control-prev" style="color:black;" href="#demo" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#demo" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>

    </div>

    <div class="row col-12 justify-content-center pt-4 pb-5">
        <a href="shop">
            <button type="button" class="btn btn-sm btn-danger add-to-cart"><span>Continue Shopping</span><span class="mdi mdi-cart-plus ml-2"></span></button>
        </a>
    </div>
</div>