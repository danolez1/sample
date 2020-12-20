 <!-- PAYMENT -->
 <div id="#payment" style="display:none">
     <div class="row col-12 mb-3">
         <h5 class="col-lg-8 col-sm-12 text-left">Save your payment information for faster future transactions.</h5>
     </div>
     <div class="row col-12">
         <?php for ($i = 0; $i < count($this->payment); $i++) {
                $creditCard = $this->payment[$i];
                include 'app/Views/profile/card_item.php';
            } ?>
         <div class="card ml-1 mr-1 mb-2 card-hover" id="add_card" style="padding-top:1em">
             <div class="card-body text-center">
                 <i class='bx bx-plus'></i>
                 <h6 class="card-subtitle text-muted" trn="add-card">Add New Card</h6>
             </div>
         </div>
     </div>

     <div id="payment_form" class="contact col-12 text-left mt-3" style="padding: 0;display:<?php echo (($showAddCard)) ? 'block' : 'none' ?>;">
         <div class="col-lg-9 col-sm-12 col-12 mb-4">
             <?php if (!is_null($saveCard_error)) { ?>
                 <div class="alert alert-danger text-center col-lg-6 col-md-6 col-sm-12" role="alert" style="margin: auto;">
                     <strong style="font-size:12px;" trn="<?php echo $saveCard_error->{"trn"} ?>"><?php echo $saveCard_error->{0}; ?></strong>
                 </div>
             <?php } else if (!is_null($saveCard_result)) {?>
                 <div class="alert alert-success alert-dismissible fade show col-lg-9 col-md-10 col-sm-12" style="margin: auto;" role="alert">
                     <strong trn="card-added"> Card Successfull Added</strong>
                     <button type="button" class="close" data-dismiss="alert" id="close-card-success" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
             <?php } ?>
             <div class="card-wrapper mt-3"></div>
             <div class="form-container active">
                 <form action="" method="post" role="form" class="php-email-form creditcardform mt-4" style="background-color: #fefefe;">
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
                     <div class="row col-12 mt-2 mb-5">
                         <div class="col-4"></div>
                         <div class="col-sm-4 col-8 text-sm-center justify-content-center text-lg-left mt-5 mb-5" style="margin-left: -10px;">
                             <button type="submit" name="save-card" class="btn btn-demae-success col-12">Save</button>
                         </div>
                         <div class="col-lg-4 col-md-0  col-0"></div>
                     </div>
                 </form>
                 <?php if (!is_null($saveCard_error)) {
                        keepFormValues($_POST);
                    } ?>
             </div>
         </div>
     </div>
 </div>
 <!-- END PAYMENT -->