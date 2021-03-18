<?php

use danolez\lib\Security\Encoding;
use Demae\Auth\Models\Shop\Order;

$ordered = false;
$shippingFee = (intval($this->orderData->getAmount()) >= intval($settings->getFreeDeliveryPrice()) ? 0 : intval($settings->getShippingFee()));
?><div class="" style="background: #F5F8F7;height:100%;">
    <div class="container m-0 p-0 justify-content-center" style="width: 100%;">
        <div class="row col-12 mb-3 pt-4 back-btn">
            <a href="shop">
                <i class="mdi mdi-arrow-left-bold ml-md-5 ml-3"></i>
                <span style="font-size: 14px;" trn="back-home"> Back to Home</span></a>
        </div>
        <?php if (!is_null($commerceController_error)) { ?>
            <div class="alert alert-danger text-center col-lg-9 col-md-10 col-sm-12 mt-4" role="alert" style="margin: auto;">
                <strong style="font-size:12px;" trn="<?php echo $commerceController_error->{"trn"} ?>"><?php echo $commerceController_error->{0}; ?></strong>
            </div>
        <?php } else if (!is_null($commerceController_result)) {
            $ordered = true; ?>
            <script>
                webToast.Success({
                    status: dictionary['successful'][lang],
                    message: dictionary['order-placed'][lang],
                    delay: 5000
                });
                if (window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.href);
                }
            </script>
            <?php if ($_POST["delivery_option"] == OrderColumn::HOME_DELIVERY) { ?>
                <?php
                ?><script>
                    window.location.href = 'track';
                </script>
            <?php } else {
                $order = !empty($this->track->orders) ? $this->track->orders[count($this->track->orders) - 1] : new Order();
                include 'app/Views/shop/order.php';
            } ?>
            <?php
        }
        if (!$ordered) {
            if (!isEmpty($settings->getTakeOut()) || !isEmpty($settings->getHomeDelivery())) { ?>
                <div class="mt-5 contact justify-content-center ml-md-5 ml-2">
                    <form action="" method="post" role="form" class="php-email-form" style="background-color: #F5F8F7;" novalidate>
                        <div class="m-0 p-0 row col-12 justify-content-center">
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <h3 trn="delivery-type">Delivery Type</h3>
                                <?php if (!isEmpty($settings->getHomeDelivery())) { ?>
                                    <h6 trn="choose-home-takeout">Choose between home delivery and take out</h6>

                                    <div class="row col-12 mt-4">
                                        <div class="form-check col-10 ">
                                            <input class="form-check-input mt-3" type="radio" name="delivery_option" value="<?php echo OrderColumn::HOME_DELIVERY ?>" checked>
                                            <label class="form-check-label font-weight-bold ml-3" trn="home-or-office">
                                                Home or office delivery
                                            </label>
                                            <p class="ml-3" trn="fill-in-address">Fill in delivery address</p>
                                        </div>
                                        <div class="col-2 mt-3 text-right">
                                            <h4><?php echo  $settings->getCurrency() . number_format($shippingFee); ?></h4>
                                        </div>
                                    </div>
                                    <data hidden id="operationalTime" data-value="<?php echo base64_encode(json_encode($this->getOperationalTime())); ?>"></data>
                                    <input id="deliveryInfo" type="hidden" data-delivery-time="<?php echo base64_encode($settings->getDeliveryTime()); ?>" data-delivery-range="<?php echo base64_encode($settings->getDeliveryTimeRange()); ?>">
                                    <div class="btn btn-sm btn-success ml-5" id="show-reservation" trn="reservation">Reservation</div>
                                    <div class="m-0 p-0 row mt-2 justify-content-center" style="display: none;">
                                        <div class="col-lg-11 col-sm-12">
                                            <div class="form-row">
                                                <div class="col col-sm-6">
                                                    <label class="text-muted" trn="date">Date</label>
                                                    <input autocomplete="off" onkeydown="return false" name="delivery-date" required data-toggle="datepicker" class="form-control" />
                                                </div>

                                                <div class="col col-sm-6">
                                                    <label class="text-muted" trn="time">Time</label>
                                                    <input type="" onkeydown="return false" name="delivery-time" required data-toggle="timepicker" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                                if (!isEmpty($settings->getTakeOut())) { ?>
                                    <div class="row col-12  mt-2">
                                        <div class="form-check col-10">
                                            <input class="form-check-input mt-3" type="radio" name="delivery_option" value="<?php echo OrderColumn::TAKE_OUT ?>">
                                            <label class="form-check-label font-weight-bold ml-3" trn="takeout">
                                                Takeout
                                            </label>
                                            <p class="ml-3" trn="schedule-pickup">Schedule a convenient time for pickup</p>
                                        </div>
                                        <div class="col-2 mt-3 text-right">
                                            <h4><?php echo $settings->getCurrency() . number_format(0); ?></h4>
                                        </div>
                                    </div>
                                    <div class="m-0 p-0 row mt-2 justify-content-center" id="takeout-time" style="display:none">
                                        <div class="col-lg-11 col-sm-12">
                                            <div class="form-row">
                                                <div class="col col-sm-6">
                                                    <label class="text-muted" trn="date">Date</label>
                                                    <input autocomplete="off" onkeydown="return false" name="takeout-date" required data-toggle="datepicker" class="form-control" />
                                                </div>

                                                <div class="col col-sm-6">
                                                    <label class="text-muted" trn="time">Time</label>
                                                    <input type="" onkeydown="return false" name="takeout-time" required data-toggle="timepicker" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <hr>
                                <h3 class="mt-5" trn="address-location">Address Location</h3>
                                <?php if (!isEmpty($settings->getHomeDelivery())) { ?>
                                    <h6 class="delivery-info" trn="enter-info">Enter in your information</h6>
                                    <h6 class="take-out-info" style="display: none;" trn="ordered-branch">Here is the locations of the branch you ordered from</h6>
                                <?php } else { ?>
                                    <h6 trn="ordered-branch">Here is the locations of the branch you ordered from</h6>
                                <?php }
                                if (!is_null($this->session->get(self::USER_ID))) { ?>
                                    <?php foreach ($this->addresses as $address) { ?>
                                        <div class="alert alert-dark col-12 ml-2" style="background-color: white;" role="alert">
                                            <input class="form-check-input" style="top: -3px;left:26px;" type="radio" name="checkout-address" value="<?php echo $address->getId(); ?>" />
                                            <span class="ml-2 take-out-info" style="display:<?php echo (isEmpty($settings->getHomeDelivery())) ? 'block' : 'none' ?>"><?php echo '<strong>' . $address->getFirstName() . '</strong>&nbsp;&nbsp; ' . $address->getLastName() . ' ' .  $address->getPhoneNumber() . '　' . $address->getEmail(); ?></span>
                                            <span class="ml-2 delivery-info"><?php echo $address->getAddress() . ' ' . $address->getStreet() . ' ' . $address->getbuilding(); ?></span>
                                        </div>
                                    <?php } ?>
                                    <div class="alert alert-dark col-12 ml-2" style="background-color: white; height:auto;" role="alert">
                                        <input data-id="use-new-address" class="form-check-input" style="top: -3px;left:26px;" type="radio" value="" id="use-new-info" name="checkout-address" />
                                        <span class="ml-2" trn='use-different-info'>Use Different Information</span>
                                    </div>
                                <?php } ?>

                                <div class="alert alert-dark col-12 ml-2 take-out-info" style="background-color: white; display:<?php echo (isEmpty($settings->getHomeDelivery())) ? 'block' : 'none' ?>" role="alert">
                                    <span class="ml-2" trn="pickup-address">Pickup Address</span><br>
                                    <?php echo $this->branch->getLocation(); ?><br>
                                    <?php echo $this->branch->getAddress(); ?>
                                </div>
                                <div class="mt-5" id="new-checkout-address" style="display: <?php echo (!is_null($this->session->get(self::USER_ID))) ? 'none' : 'block' ?>;">
                                    <div class="col-lg-12 col-sm-12">

                                        <?php if (!isEmpty($settings->getHomeDelivery())) { ?>
                                            <div class="delivery-info">
                                                <div class="form-row mt-4">
                                                    <div class="form-group col-md-6">
                                                        <input type="text" name="zip" id="postalCode" required class="form-control" trn="zip" placeholder="Zip">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <input type="text" name="city" id="locality" required class="form-control" trn="city" placeholder="City">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <input type="text" name="state" id="adminDistrict" class="form-control" trn="state" placeholder="State">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <input type="text" name="address" id="formattedAddress" required class="form-control" trn="address" placeholder="Address">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <input type="text" name="street" class="form-control" required trn="street" placeholder="Street ○-○○">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <input type="text" name="building" id="formattedAddress" class="form-control" trn="building" placeholder="Building Name, Room Number">
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="form-row">
                                            <div class="col col-sm-6">
                                                <input type="text" name="fname" trn="fname" required class="form-control" placeholder="First name">
                                            </div>
                                            <div class="col col-sm-6">
                                                <input type="text" name="lname" trn="lname" required class="form-control" placeholder="Last name">
                                            </div>
                                        </div>
                                        <div class="form-row mt-4">
                                            <div class="col col-sm-6">
                                                <input type="text" name="phone" trn="phone-nuumber" required class="form-control" placeholder="Phone Number">
                                            </div>
                                            <div class="col col-sm-6">
                                                <input type="text" name="email" trn="email" required required class="form-control" placeholder="Email">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="mt-5" trn="payment-details">Payment details</h3>
                                <h6><span trn="amount">Amount</span> : <b><?php echo $settings->getCurrency() . number_format($this->orderData->getAmount() + $shippingFee); ?></b>(<span trn="tax-included"></span>)</h6><br>
                                <h6><span trn="we-accept">We accept</span> : </h6>

                                <?php if (in_array('<i class="icofont-cash-on-delivery-alt"></i>', $settings->getPaymentMethods())) { ?>

                                    <div class="form-check col-10 mt-2">
                                        <input class="form-check-input mt-3" type="radio" name="payment_option" value="cash" checked>
                                        <label class="form-check-label font-weight-bold ml-3" trn="pay-with-cash">
                                            Pay with cash
                                        </label>
                                        <p class="ml-4" trn="pay-on-delivery">You will be paying on delivery</p>
                                    </div>
                                <?php }
                                $cards = $settings->getPaymentMethods();
                                $key = array_search('<i class="icofont-cash-on-delivery-alt"></i>', $cards);
                                if (false !== $key) {
                                    unset($cards[$key]);
                                }
                                if (in_array('<i class="icofont-mastercard"></i>', $settings->getPaymentMethods())) { ?>

                                    <div class="form-check col-10 mt-4">
                                        <input class="form-check-input mt-3" type="radio" name="payment_option" value="card">
                                        <label class="form-check-label font-weight-bold ml-3" trn="pay-with-card">
                                            Pay with credit card
                                        </label>
                                        <p class="ml-4" style="font-size:32px;"><?php foreach ($cards as $payment) echo $payment . ' '; ?></p>
                                    </div>
                                <?php } ?>
                                <div id="saved-cards" style="display: none;">
                                    <?php if (!is_null($this->session->get(self::USER_ID))) { ?>
                                        <data hidden id="card-saved" value="<?php echo count($this->payment); ?>"></data>
                                        <?php foreach ($this->payment as $creditCard) { ?> <div class="alert alert-dark col-12 ml-2" style="background-color: white;" role="alert">
                                                <input class="form-check-input" style="top: -3px;left:26px;" type="radio" name="checkout-payment" value="<?php echo $creditCard->getId(); ?>" />
                                                <i class="ml-2 icofont-<?php echo  $creditCard->cardType; ?>" style="font-size: 24px;"></i>
                                                <a style="position: absolute;" class=" ml-1"><?php echo wordwrap($creditCard->cardNumber, 4, " ", true) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ?></a>
                                            </div>
                                        <?php } ?>
                                        <div class="alert alert-dark col-12 ml-2" style="background-color: white;" role="alert">
                                            <input data-id="use-new-payment" class="form-check-input" style="top: -3px;left:26px;" type="radio" value="" id="use-new-card" name="checkout-payment" />
                                            <span class="ml-2" trn="use-different-card">Use Different Card</span>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div id="new-checkout-payment" style="display:none">
                                    <div class="card-wrapper mt-3"></div>
                                    <div class="form-container active">
                                        <div class="creditcardform mt-4">
                                            <div class="form-row">
                                                <div class="col">
                                                    <input type="text" name="number" trn="card-number" required class="form-control" placeholder="Card Number">
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="expiry" trn="expiry-date" required class="form-control" placeholder="Expiry Date">
                                                </div>
                                            </div>
                                            <div class="form-row mt-4">
                                                <div class="col">
                                                    <input type="text" name="name" trn="card-name" required class="form-control" placeholder="Card Holder Name">
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="cvc" required class="form-control" placeholder="CVV">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="deliveryTime" value="<?php echo ($settings->getDeliveryTime() . '-' . $settings->getDeliveryTimeRange()); ?>" />
                                <div class="m-0 p-0 row col-12 justify-content-center mt-5 mb-5">
                                    <button type="submit" name="place-order" id="checkout" class="btn btn-sm btn-danger add-to-cart col-10"><span trn="place-order">Place Order</span><span class="mdi mdi-arrow-right-bold ml-2"></span></button>
                                    <?php if (is_null($this->session->get(self::USER_ID))) { ?>
                                        <p class="mt-3"><a href="profile"><span class="text-danger" trn="sign-up">Sign up</span></a><span trn="to-save-info">&nbsp;&nbsp;&nbsp;to save Address & billing information</span> </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                    if (!is_null($commerceController_error)) {
                        keepFormValues($_POST);
                    }
                    ?>
                </div>
            <?php } ?>
    </div>
</div>
<?php if (!isEmpty($settings->getHomeDelivery())) { ?>
    <script>
        const deliveryTimeToast = new Toasted({
            position: "bottom-right",
            // 'top-right', 'top-center', 'top-left', 'bottom-right', 'bottom-center', 'bottom-left'
            fitToScreen: true,
            // alive, material, bootstrap, colombo, venice, and bulma
            theme: "venice",
        })
        <?php
                if (intval($settings->getDeliveryTimeRange()) > 0)
                    $deliveryTimeDisplay  = intval($settings->getDeliveryTime()) . " ~ " . (intval($settings->getDeliveryTime()) + intval($settings->getDeliveryTimeRange()));
                else $deliveryTimeDisplay  = intval($settings->getDeliveryTime());
        ?>
        deliveryTimeToast.show('<?php echo  $deliveryTimeDisplay; ?> ' + dictionary['minutes'][lang]);
    </script>
    <data id="delivery-time-display" value="<?php echo $settings->getDeliveryTime(); ?>" hidden><?php echo  $deliveryTimeDisplay; ?><span trn="minutes"></span></data>
<?php }
        } ?>