<div style="background: #F5F8F7;">
    <div class="container">
        <div class="row col-12 mb-3 pt-4 back-btn">
            <a href="shop">
                <i class="mdi mdi-arrow-left-bold ml-2"></i>
                <span style="font-size: 14px;" trn="back-home"> Back to Home</span></a>
        </div>

        <div class="contact justify-content-center">
            <form action="" method="post" role="form" class="php-email-form" style="background-color: #F5F8F7;">
                <div class="row col-12 justify-content-center">
                    <div class="col-lg-8 col-md-8 col-sm-12">
                        <h3>Delivery Type</h3>
                        <h6>Chose between home delivery or eat in resturant </h6>

                        <div class="row col-12 mt-4">
                            <div class="form-check col-10 ">
                                <input class="form-check-input mt-3" type="radio" name="delivery_option" value="option1" checked>
                                <label class="form-check-label font-weight-bold ml-3">
                                    Home or office delivery
                                </label>
                                <p class="ml-3">Fill in your addres and we will deliver to your home</p>
                            </div>
                            <div class="col-2 mt-3 text-right">
                                <h4>$2</h4>
                            </div>
                        </div>

                        <div class="row col-12  mt-2">
                            <div class="form-check col-10">
                                <input class="form-check-input mt-3" type="radio" name="delivery_option" value="option1" checked>
                                <label class="form-check-label font-weight-bold ml-3">
                                    Takeout
                                </label>
                                <p class="ml-3">Shedule your delivery to a time convineint for you</p>
                            </div>
                            <div class="col-2 mt-3 text-right">
                                <h4>$2</h4>
                            </div>
                        </div>
                        <div class=" row mt-2 justify-content-center">
                            <div class="col-lg-11 col-sm-12">
                                <div class="form-row">
                                    <div class="col col-sm-6">
                                        <label class="text-muted">Date</label>
                                        <select id="inputState" class="form-control">
                                            <option selected>Choose...</option>
                                            <option>...</option>
                                        </select>
                                    </div>

                                    <div class="col col-sm-6">
                                        <label class="text-muted">Time</label>
                                        <select id="inputState" class="form-control">
                                            <option selected>Choose...</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=" row mt-2 justify-content-center">
                            <div class="col-lg-11 col-sm-12">
                                <div class="form-row">
                                    <div class="col col-sm-6">
                                        <label class="text-muted">Date</label>
                                        <select id="inputState" class="form-control">
                                            <option selected>Choose...</option>
                                            <option>...</option>
                                        </select>
                                    </div>

                                    <div class="col col-sm-6">
                                        <label class="text-muted">Time</label>
                                        <select id="inputState" class="form-control">
                                            <option selected>Choose...</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>


                        <h3 class="mt-5">Address Location</h3>
                        <h6>Chose between home delivery or eat in resturant </h6>
                        <div class="mt-5">
                            <div class="col-lg-12 col-sm-12">
                                <div class="form-row">
                                    <div class="col col-sm-6">
                                        <label class="text-muted">First Name</label>
                                        <input type="text" class="form-control" placeholder="First name">
                                    </div>
                                    <div class="col col-sm-6">
                                        <label class="text-muted">Last Name</label>
                                        <input type="text" class="form-control" placeholder="Last name">
                                    </div>
                                </div>
                                <div class="form-row mt-4">
                                    <div class="col col-sm-6">
                                        <label class="text-muted">Phone Number</label>
                                        <input type="text" class="form-control" placeholder="Phone Number">
                                    </div>
                                    <div class="col col-sm-6">
                                        <label class="text-muted">Email</label>
                                        <input type="text" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-row mt-3">
                                    <div class="form-group col-md-6">
                                        <label class="text-muted">Zip</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="text-muted">City</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="text-muted">State</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="text-muted">Address</label>
                                        <input type="text" class="form-control" placeholder="Apartment, studio, or floor">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 class="mt-5">Payment details</h3>
                        <h6>We accept : </h6>

                        <?php if (in_array('<i class="icofont-cash-on-delivery-alt"></i>', $settings->getPaymentMethods())) { ?>

                            <div class="form-check col-10 mt-4">
                                <input class="form-check-input mt-3" type="radio" name="payment_option" value="option1" checked>
                                <label class="form-check-label font-weight-bold ml-3">
                                    Pay cash on delivery
                                </label>
                                <p class="ml-4">You will be paying <b>$690</b> after we deliver your order</p>
                            </div>
                        <?php } ?>
                        <?php if (in_array('<i class="icofont-mastercard"></i>', $settings->getPaymentMethods())) { ?>

                            <div class="form-check col-10 mt-4">
                                <input class="form-check-input mt-3" type="radio" name="payment_option" value="option1" checked>
                                <label class="form-check-label font-weight-bold ml-3">
                                    Pay with credit card
                                </label>
                                <p class="ml-4" style="font-size:32px;"><?php foreach ($settings->getPaymentMethods() as $payment) echo $payment . ' '; ?></p>
                            </div>
                        <?php } ?>



                        <div class="row col-12 justify-content-center mt-5 mb-5">
                            <button type="button" class="btn btn-sm btn-danger add-to-cart col-10"><span>Place Order</span><span class="mdi mdi-arrow-right-bold ml-2"></span></button>
                            <?php if (is_null($this->session->get(self::USER_ID))) { ?>
                                <p class="mt-3"><a href="profile"><span class="text-danger">Sign up</span></a> to save Address & billing information </p>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>