<?php

use Demae\Auth\Models\Shop\Product\Product;

?>
<div class="card">
    <div class="card-body">
        <!-- if grid or list -->
        <div class="row tab-content d-flex col-12">
            <?php
            $product = new Product();
            $product->setDisplayImage('assets/images/shop/food.png');
            $product->setAvailability(0);
            $product->setName('Beef Rose Lemon Steak');
            $product->setDescription('The best steak garished with some lemon trust it to leave your mouth slightly sour.');
            $product->setPrice(200);
            $product->setRatings(3.0);

            include 'app/Views/admin/pages/product-grid.php'; ?>
        </div>
    </div>
</div>