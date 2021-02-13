 <!-- FAVORITES -->
 <div id="#fav" style="display:block">
     <?php

        use danolez\lib\Res\Orientation;

        if (count($this->favProducts) < 1) { ?>
         <div class="alert alert-danger" role="alert" data-aos="fade-up" data-aos-easing="ease-in-back">
             <h4 class="alert-heading"><span trn="no-favorites">You do not have any favourites yet</span></h4>
             <div class="row col-12" style="padding: 0;">
                 <p class="col-lg-8 col-sm-6" trn="add-favorite-instruct">You can add your favorite menu by clicking on the<i class="ri-heart-line"></i> icon at the top right corner of the food card</p>
                 <div class="col-lg-4 col-sm-6 text-right">
                     <button type="button" class="btn btn-sm btn-danger"><span trn="home">Home</span></button>
                 </div>
             </div>
         </div>
     <?php } else { ?>
         <div class="row" data-aos="fade-left" data-aos-easing="ease-in-back">
             <?php foreach ($this->favProducts as $product) {
                    if ($settings->getProductDisplayOrientation() == Orientation::GRID) {
                        include 'app/Views/shop/product-grid.php';
                    } else {
                        include 'app/Views/shop/product-list.php';
                    }
                } ?>
         </div>
     <?php } ?>
 </div>
 <!-- END FAVORITES -->