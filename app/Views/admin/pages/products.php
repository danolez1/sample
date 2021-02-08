<?php

use Demae\Auth\Models\Shop\Product;

?>
<main class="content-wrapper" id="products-main">
    <div class="row col-12">
        <div class="col-lg-8 col-md-8 col-sm-6">
            <h3>Products</h3>
            <p class="mb-4">You can create, edit, delete and change availability status of your products here</p>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 text-center pt-lg-3 pt-sm-3 pt-0">
            <a href="add-product"> <button id="add-staff" type="button" class="btn btn-danger ml-2 h6"> <i class='bx bx-plus'></i> Create New Product </button></a>
        </div>
    </div>

    <div class="card ml-2 mr-2 mt-3 mt-lg-0 mg-md-0" style="background: #EFF3F3;">
        <div class="pt-3 pl-2 pb-3 row d-flex col-12 justify-content-between">
            <div class="col-6">
                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon search-text-field d-none d-md-flex ml-3 ">
                    <i class="material-icons mdc-text-field__icon">search</i>
                    <input class="mdc-text-field__input" id="text-field-hero-input">
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label for="text-field-hero-input" class="mdc-floating-label">Search..</label>
                        </div>
                        <div class="mdc-notched-outline__trailing"></div>
                    </div>
                </div>
            </div>
            <div class="col-6 text-right">
                <span>Sort by :</span>
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Category</button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Branch</a>
                    <a class="dropdown-item" href="#">Price</a>
                    <a class="dropdown-item" href="#">Date Created</a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <!-- if grid or list -->
                <div class="row tab-content d-flex col-12">
                    <?php
                    for ($i = 0; $i < count($this->products); $i++) {
                        $product = $this->products[$i];
                        // $product->setAvailability(0);
                        // $product->setRatings(3.0);
                        $branches = fromDbJson($product->getBranchId());
                        if (in_array($this->admin->getBranchId(), $branches) || $this->admin->getRole() == 1)
                            include 'app/Views/admin/pages/product-grid.php';
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
</main>