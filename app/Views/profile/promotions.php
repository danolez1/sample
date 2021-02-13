 <!-- PROMOTIONS -->
 <div id="#promotions" style="display:none">

     <div class="row col-lg-8 col-sm-12">
         <?php if (count($promotions ?? []) < 1) { ?>
             <div class="alert alert-danger" role="alert">
                 <h4 class="alert-heading"><span trn="no-promotion">No Promotion at the moment</span></h4>
             </div>
             <?php } else {
                for ($i = 0; $i < count($promotions); $i++) { ?>
                 <div class="card ml-1 mr-2 mb-2 card-hover col-lg-3 col-md-4 col-sm-6">
                     <img src="assets/images/shop/promotions.svg" width="70" class="card-img-top">
                     <div class="card-body">
                         <h5 class="card-title">Black Friday Sales</h5>
                         <p class="card-text">Get 50% off your Third order of the day.</p>
                         <button type="button" class="btn btn-sm btn-danger">Danger</button>
                     </div>
                 </div>
         <?php }
            } ?>
     </div>

 </div>
 <!-- END PROMOTIONS -->