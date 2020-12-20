<!-- Modal -->
<div class="modal fade" id="productModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <img class="product-img" src="assets/images/shop/food.png">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" method="post" role="form" class="php-email-form" style="background-color: #fefefe;">
                <div class="modal-body">
                    <div>
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
                    </div>
                    <h6 class="font-weight-bold text-dark mt-2 mb-2">Options</h6>
                </div>
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
                            <div class="row col-12" style="margin-top: 2px;">
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
                <div class="modal-footer">
                    <span>Total</span><br>
                    <div class="row col-12 text-left ml-2" style="padding: 0">
                        <div class="col-3 text-start" style="padding: 0;">
                            <span class="badge total-price">¥200</span>
                        </div>
                        <div class="col-4 text-right" style="padding: 0;">
                            <button type="button" class="btn btn-sm btn-outline-danger add-to-cart col-12"><span>Add to cart</span><span class="mdi mdi-cart-plus ml-2"></span></button>
                        </div>
                        <div class="col-5 text-right pr-2" style="padding: 0;">
                            <button type="button" class="btn btn-sm btn-danger add-to-cart col-11"><span>Order now</span><span class="mdi mdi-arrow-right-bold ml-2"></span></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>