 <!-- FAVORITES -->
 <div id="#fav" style="display:block">
     <?php

        use danolez\lib\Res\Orientation\Orientation;
        use Demae\Auth\Models\Shop\Product\Product;

        if (count($favorites) < 1) { ?>
         <div class="alert alert-danger" role="alert" data-aos="fade-up" data-aos-easing="ease-in-back">
             <h4 class="alert-heading"><span trn="">You do not have any favourites yet </span></h4>
             <div class="row col-12" style="padding: 0;">
                 <p class="col-lg-8 col-sm-6">You can make a menu your favorite by clicling on the <i class="ri-heart-line"></i> icon at the top right corner of the food card</p>
                 <div class="col-lg-4 col-sm-6 text-right">
                     <button type="button" class="btn btn-sm btn-danger"><span trn="">Home</span></button>
                 </div>
             </div>
         </div>
     <?php } else { ?>
         <div class="row" data-aos="fade-left" data-aos-easing="ease-in-back">
             <?php for ($i = 0; $i < count($favorites); $i++) {
                    $product = new Product();
                    $product->setDisplayImage('assets/images/shop/food.png');
                    $product->setAvailability(0);
                    $product->setName('Beef Rose Lemon Steak');
                    $product->setDescription('The best steak garished with some lemon trust it to leave your mouth slightly sour.');
                    $product->setPrice(200);
                    $product->setRatings(3.0);
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