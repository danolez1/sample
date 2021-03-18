<?php

use danolez\lib\Security\Encoding;
use Demae\Auth\Models\Shop\Administrator;
use Demae\Auth\Models\Shop\Branch;
use Demae\Auth\Models\Shop\Delivery;
use Demae\Auth\Models\Shop\Order;
use Demae\Auth\Models\Shop\Product;
use Demae\Auth\Models\Shop\Setting; ?>
<div class="card">
    <div class="card-body">
        <div class="row col-12 mb-2 m-0 p-0">
            <h6 class="order-title text-muted col-lg-4 pt-1 col-md-4 col-sm-6">Order <?php echo $order->getDisplayId(); ?></h6>
            <h6 class="order-sub-title col-lg-4 col-md-4 col-sm-6 pt-1 text-lg-center text-md-center text-muted">
                <?php echo date('M j Y', intval($order->getTimeCreated())); ?>・<span class="text-danger"><?php echo date('G:i', intval($order->getTimeCreated())); ?></span>
            </h6>
            <div class="col-lg-4 col-md-4 col-sm-6 text-lg-right text-md-right">
                <span class="h6 text-muted ">Status :</span>
                <button class="btn btn-sm btn-light dropdown-toggle tx-12" data-id="<?php echo Encoding::encode(json_encode(array($this->admin->getId(), $this->admin->getUserName(), $order->getId()))); ?>" data-async="order-status" trn="<?php echo $order->getStatusInfo()[0]['trn']; ?>" data="<?php echo $order->getStatusInfo()[0]['data']; ?>" color="<?php echo $order->getStatusInfo()[0]['color']; ?>" style="background-color: <?php echo $order->getStatusInfo()[0]['color']; ?>;color:white;" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $order->getStatusInfo()[0][0]; ?></button>
                <div class="dropdown-menu p-0">
                    <a class="dropdown-item" trn="<?php echo $order->getStatusInfo()[1]['trn']; ?>" data="<?php echo $order->getStatusInfo()[1]['data']; ?>" color="<?php echo $order->getStatusInfo()[1]['color']; ?>"><?php echo $order->getStatusInfo()[1][0]; ?></a>
                    <a class="dropdown-item" trn="<?php echo $order->getStatusInfo()[2]['trn']; ?>" data="<?php echo $order->getStatusInfo()[2]['data']; ?>" color="<?php echo $order->getStatusInfo()[2]['color']; ?>"><?php echo $order->getStatusInfo()[2][0]; ?></a>
                    <a class="dropdown-item" trn="<?php echo $order->getStatusInfo()[3]['trn']; ?>" data="<?php echo $order->getStatusInfo()[3]['data']; ?>" color="<?php echo $order->getStatusInfo()[3]['color']; ?>"><?php echo $order->getStatusInfo()[3][0]; ?></a>
                    <a class="dropdown-item" trn="<?php echo $order->getStatusInfo()[4]['trn']; ?>" data="<?php echo $order->getStatusInfo()[4]['data']; ?>" color="<?php echo $order->getStatusInfo()[4]['color']; ?>"><?php echo $order->getStatusInfo()[4][0]; ?></a>
                </div>
            </div>
        </div>
        <?php $cart = fromDbJson($order->getCart());
        foreach ($cart??[] as $item) {
            $categories = [];
            foreach ($item->productOptions as $option) {
                $category = [];
                $category['id'] = $option->category->id;
                $category['name'] = $option->category->name;
                $category['children'] = Order::getChildren($item->productOptions, $option->category->id);
                $categories[$option->category->name] = ($category);
            }
        ?>
            <h6 class="pl-3 pt-2 pb-2"><?php echo  stripslashes(unicode2html($item->productDetails)); ?> </h6>
            <div class="row col-12">
                <div class="col-lg-2 col-md-6 col-sm-6 h5 font-weight-bold d-lg-block d-none">
                    <?php //asort($categories, SORT_STRING);
                    foreach ($categories as $key => $category) {
                        $category =  (object)$category; ?>
                        <div style="margin-bottom: <?php echo count($category->children) + 1; ?>em;"><?php echo unicode2html($category->name) . "&nbsp;"; ?></div>
                    <?php } ?>
                    <div style="margin-top: 2em;"> Notes </div>
                </div>
                <div class="col-lg-7 mb-1">
                    <?php foreach ($categories as $key => $category) {
                        $category =  (object)$category;
                        foreach ($category->children as $key => $option) {
                            $option = (object) $option; ?>
                            <div class="row col-12" style="margin: 0;padding:0">
                                <div class="col-lg-7 col-md-6 col-sm-6 col-4 h6">
                                    <?php echo stripslashes(stripslashes(unicode2html($option->name))); ?>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-2 col-4 text-left">
                                    <h6 class="text-danger ">x <?php echo $option->quantity; ?></h6>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-4 text-right">
                                    <span class="order-sub-title font-weight-bold ml-2 h6"> <?php echo $this->settings->getCurrency() . number_format(isEmpty($option->price) ? 0 : $option->price); ?></span>
                                </div>
                            </div>
                        <?php } ?>
                        <hr class="dropdown-divider">
                    <?php } ?>
                    <div class="row col-12" style="margin: 0;padding:0">
                        “<?php echo $item->additionalNote; ?>”
                    </div>
                </div>
                <div class="col-lg-1 col-md-6 col-sm-6 col-6 text-right">
                    <h5 class="span-circle" style="background-color:#05C776;">x<?php echo $item->quantity; ?></h5>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-6 text-right">
                    <span class="order-sub-title font-weight-bold ml-2"><?php echo $this->settings->getCurrency() . number_format(intval($item->amount) - intval($item->amount) * Product::TAX); ?></span>
                </div>
            </div>
        <?php } ?>
        <hr class="dropdown-divider">
        <div class="row col-12">
            <div class="col-6">
                <h5 trn="tax">Tax</h5>
            </div>
            <div class="col-6 text-right">
                <span class="order-title" trn=""><?php echo $this->settings->getCurrency() . number_format(intval($order->getAmount()) * Product::TAX); ?></span>
            </div>
        </div>
        <hr class="dropdown-divider">
        <div class="row col-12">
            <div class="col-6">
                <h5 trn="shipping-fee">Shipping</h5>
            </div>
            <div class="col-6 text-right">
                <span class="order-title" trn=""><?php echo $this->settings->getCurrency() . number_format(intval($order->getDeliveryFee())); ?></span>
            </div>
        </div>
        <hr class="dropdown-divider">
        <div class="row col-12">
            <div class="col-6">
                <h5 trn="total-order">Order</h5>
            </div>
            <div class="col-6 text-right">
                <span class="order-title" trn=""><?php echo $this->settings->getCurrency() . number_format(intval($order->getAmount())); ?></span>
            </div>
        </div>
        <hr class="dropdown-divider">
        <div class="row col-12">
            <div class="col-6">
                <h3 trn="total">Total</h3>
            </div>
            <div class="col-6 text-right">
                <span class="h4 font-weight-bold order-title" trn=""> <?php echo $this->settings->getCurrency() . number_format(intval($order->getAmount()) + intval($order->getDeliveryFee())); ?></span>
            </div>
        </div>
        <?php $address = fromDbJson($order->getAddress()); ?>
        <div class="card mt-4" style="background-color: #EFF3F3; border:#EFF3F3;">
            <div class="card-body" style="padding:20px 5px;">
                <div class="row col-12" style="margin: 0;padding:0">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-6 mb-4 mt-2">
                        <h6 class="card-subtitle mb-2 tx-13 order-foot-h" trn="customer">Receiver</h6>
                        <h6 class="card-title font-weight-bold"><?php echo unicode2html($address->firstName . " " . $address->lastName); ?></h6>
                        <h6 class="card-text tx-12 order-foot"><?php echo $address->email; ?></h6>
                        <h6 class="card-text tx-12 order-foot"><?php echo $address->phoneNumber; ?></h6>
                        <?php $branch = new Branch();
                        $branch = $branch->get(null, $order->getBranch());
                        if (!empty($branch))
                            $branch = $branch[0];
                        else $branch = new Branch(); ?>
                        <h6 class="card-text tx-13 mt-4 text-uppercase font-weight-bold text-danger"><?php echo $branch->getName() ?> <span trn="branch"> Branch</span></h6>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-6 mb-4 mt-2">
                        <h6 class="card-subtitle mb-1 tx-13 order-foot-h" trn="delivery-type">Delivery Type</h6>
                        <span class="badge bg-plain text-primary pl-0"><?php echo $order->getDeliveryMethodText()[$_COOKIE['lingo']]; ?></span>
                        <h6 class="card-subtitle mb-1 mt-3 tx-13 order-foot-h" trn="state">Municipality</h6>
                        <span class="badge bg-plain pl-0"><?php echo (unicode2html(str_replace('u', '\u', $address->state))); ?></span>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-6 mb-4 mt-2">
                        <h6 class="card-subtitle mb-1 tx-13 order-foot-h" trn="payment-method">Payment Method</h6>
                        <span class="badge bg-plain text-success pl-0"><?php echo $order->getPaymentMethodText()[$_COOKIE['lingo']]; ?></span>
                        <h6 class="card-subtitle mb-1 mt-3 tx-13 order-foot-h" trn="zip-code">Zip code</h6>
                        <span class="badge bg-plain pl-0"><?php echo $address->zip; ?></span>
                    </div>
                    <div class="col-lg-5 col-md-3  col-sm-6 col-6 mb-4 mt-2">
                        <h6 class="card-subtitle mb-2 tx-13 order-foot-h" trn="delivery-location">Delivery Location</h6>
                        <h6 class="card-title tx-13 font-weight-bold"><?php echo (unicode2html(str_replace('u', '\u', substr($address->address, 9, strlen($address->address))))) . " " . $address->street . " " . $address->building; ?></h6>
                        <span class="badge bg-plain pl-0 text-danger" trn="search-map">Search on map</span>
                        <h6 class="card-text tx-12 order-foot mt-1">
                            <?php $delivery = new Delivery;
                            $delivery = $delivery->get(null, $order->getId()) ?? new Delivery;
                            $admin = new Administrator();
                            $admin->setId($delivery->getCourierId());
                            $admin = $admin->get() ?? new Administrator();
                            ?>
                            <span trn="delivered-by">Delivered by</span> <button class="btn btn-sm btn-outline-primary tx-12 ml-2"><?php echo $admin->getName(); ?></button>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>