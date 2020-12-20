<div class="row ml-2" data-aos="fade-up">
    <div class="col-md-12 col-lg-8 mt-4 ml-2">
        <div class="list-product-card">

            <!-- PRODUCT DETAILS -->
            <div class="product-list-details row col-12" style="margin:0; padding:0">
                <form action="" method="post" role="form" class="php-email-form" style="background-color: #fefefe;">
                    <img class="grid-product-card-img-top" width="100%" src="assets/images/shop/food.png">
                    <div class="container">
                        <h5 class="font-weight-bold text-dark mt-4 mb-2">Beef Rose lemon steak</h5>
                        <span class="text-muted font-weight-normal" style="font-size: 14px ;"> The best steak garished with some lemon trust it to leave your mouth slightly sour.</span>
                        <p class="mt-2"><span class="badge pt-2 pb-2 pr-2 pl-2 price-tag">¥200</span>
                            <?php if ($settings->getDisplayRating()) { ?>
                                <i class="mdi mdi-star-circle rating-icon"></i>
                                <span class="rating-text">3.0</span>
                            <?php } ?>
                            <?php if ($settings->getDisplayOrderCount()) { ?>
                                <i class="mdi mdi-account-group rating-icon" style="color: #666666;"></i>
                                <span class="rating-text" style="color: #666666;">300</span>
                            <?php } ?>
                        </p>
                        <hr>
                        <h5 class="text-dark mt-2 mb-2">Options</h5>
                        <!-- START OPTIONS -->
                        <div class="accordion" id="accordionExample">
                            <div>
                                <div class="modal-option-header row col-12 pl-3 pb-2 pt-2" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <span class="text-left col-8"> Drinks </span> <i class="mdi mdi-chevron-right text-right text-muted col-4"></i>
                                </div>
                                <div id="collapseOne" class="collapse pl-4 pt-2" data-parent="#accordionExample">
                                    <!-- MULTIPLE -->
                                    <div class="row col-12">
                                        <div class="col-4 text-left"><span>Coca cola</span></div>
                                        <div class="col-4 text-center"><span class="badge price-tag">¥200</span></div>
                                        <div class="col-4 qty text-right">
                                            <i class="mdi mdi-minus-circle"></i>
                                            <input type="number" class="count" name="qty" value="1">
                                            <i class="mdi mdi-plus-circle"></i>
                                        </div>
                                    </div>

                                    <!-- SINGLE -->
                                    <div class="row col-12">
                                        <div class="col-4 text-left"><span>Onions</span></div>
                                        <div class="col-4 text-center"><span class="badge price-tag">¥200</span></div>
                                        <div class="col-4 qty text-right">
                                            <input class="form-check-input" type="checkbox" id="gridCheck">
                                        </div>
                                    </div>
                                    <!-- FREE -->
                                    <div class="row col-12 mt-2">
                                        <div class="col-6 text-left"><span>Onions</span></div>
                                        <div class="col-6 qty text-right">
                                            <input class="form-check-input" type="checkbox" id="gridCheck">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END OPTIONS -->
                        <!-- ADDITIONAL NOTE -->
                        <div class="modal-option-header row col-12 pl-3 pb-3 pt-3" style="border:none">
                            <span class="text-left col-8"> Additional Notes </span>
                        </div>
                        <textarea placeholder="Add a note (e.g extra pepper, salty etc.)" rows="3" style="width: 100%;"></textarea>
                        <!-- ENF NOTE -->
                        <div class="dropdown-divider"></div>
                    </div>
                    <div class="product-list-details-price container">
                        <div class="text-left ml-2 row">
                            <div class="col-3 text-start">
                                <span class="badge total-price" style="color:white">¥200</span>
                            </div>
                            <div class="col-4 text-right">
                                <button type="button" class="btn btn-sm btn-outline-dark add-to-cart col-12"><span>Add to cart</span><span class="mdi mdi-cart-plus ml-2"></span></button>
                            </div>
                            <div class="col-5 text-right pr-2" style="padding: 0;">
                                <button type="button" class="btn btn-sm btn-dark add-to-cart col-11"><span>Order now</span><span class="mdi mdi-arrow-right-bold ml-2"></span></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- END PRODUCT DETAILS -->

            <div class="product-list-summary row col-12">
                <img class="list-product-card-img-top col-lg-5 col-md-6" src="assets/images/shop/food.png">

                <!-- AVAILABILITY INFO -->
                <?php ?>
                <div class="list-product-img-info">
                    <span>Sold out </span>
                </div>
                <?php ?>
                <!-- END AVAIL. INFO -->

                <div class="list-product-card-block col-lg-7 col-md-6">
                    <h4 class="list-product-card-title mt-3">Beef Rose Lemon Steak</h4>
                    <div class="list-product-card-text">The best steak garished with some lemon trust it to leave your mouth slightly sour. </div>
                    <div class="row mt-3">
                        <div class="col-6 justify-content-between">
                            <span class="badge pt-2 pb-2 pr-2 pl-2 price-tag">¥200</span>
                            <?php if (($settings->getDisplayRating())) { ?>
                                <i class="mdi mdi-star-circle rating-icon"></i>
                                <span class="rating-text">3.0</span>
                            <?php } ?>
                        </div>
                        <div class="col-6 text-right"><button type="button" class="btn btn-sm btn-outline-danger" style="padding:6px 12px !important; border-radius:4px;">Add<span class="mdi mdi-cart-plus ml-2"></span></button></div>
                    </div>
                </div>
                <i class="ri-heart-line list-product-fav" id="sasdf"></i>
                <!-- PROMOTIONAL INFO -->
                <?php ?>
                <?php ?>
                <!-- END PROMOTIONAL INFO -->
            </div>
        </div>
    </div>
</div>