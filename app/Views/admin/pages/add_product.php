<?php

use danolez\lib\Security\Encoding\Encoding;
use Demae\Auth\Models\Shop\Product\ProductOption;
use Demae\Auth\Models\Shop\Setting\Setting;

include 'app/Views/admin/pages/add_category.php';
$editProduct = !is_null($this->editProduct);
?>
<main class="content-wrapper">
    <h4>Add Product</h4>
    <?php if (!is_null($dashboardController_error)) {
        echo "WTH"; ?>
        <script>
            webToast.Danger({
                status: dictionary['error-occured'][lang],
                message: dictionary<?php echo "['" . $dashboardController_error->{"trn"} . "']['" . $_COOKIE['lingo'] . "']"; ?>,
                delay: 500000000
            });
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
        <?php } else {
        if ($showDashboardController_result) {
        ?> <script>
                webToast.Success({
                    status: dictionary['successful'][lang],
                    message: dictionary['<?php echo ($editProduct) ? 'product-updated' : 'product-created'; ?>'][lang],
                    delay: 15000
                });
                if (window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.href);
                }
                location.reload();
            </script>
    <?php }
    } ?>
    <form enctype="multipart/form-data" method="post" action="" class="php-form">
        <div class="row col-12 mt-3">
            <div class="col-lg-8 col-md-12 col-sm-12 col-12">

                <h5 class="mt-3">Product Image</h5>
                <div class="mt-2 col-12 p-0 m-0 upload-image text-center" style="background-color:#E0E0E0;border:#E0E0E0;" type="button">
                    <label for="browse-product">
                        <input type="hidden" value="<?php echo $editProduct ? isEmpty($this->editProduct->getDisplayImage()) : ''; ?>" name="product-img" />
                        <img id="browse-preview" class="img img-fluid" src="<?php echo $editProduct ? isEmpty($this->editProduct->getDisplayImage()) ? 'assets/images/dashboard/placeholder.svg' : $this->editProduct->getDisplayImage() : 'assets/images/dashboard/placeholder.svg'; ?>" />
                    </label>
                </div>
                <input type="file" id="browse-product" name="browse-product" accept="image/*" style="display: none">

                <div class="mdc-layout-grid m-0 mt-4 p-0">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <h6 class="card-title">Product Information</h6>
                                <div class="template-demo">
                                    <div class="mdc-layout-grid__inner">
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                                            <div class="mdc-text-field">
                                                <input class="mdc-text-field__input" value="<?php echo $editProduct ? $this->editProduct->getName() : '' ?>" required name="product-name" id="text-field-hero-input">
                                                <div class="mdc-line-ripple"></div>
                                                <label for="text-field-hero-input" class="mdc-floating-label">Product Name</label>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined">
                                                <input class="mdc-text-field__input" value="<?php echo $editProduct ? $this->editProduct->getDescription() : '' ?>" name="product-description" id="text-field-hero-input">
                                                <div class=" mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label">Product Description</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                <i class="material-icons mdc-text-field__icon icofont-yen yen"></i>
                                                <input class="mdc-text-field__input" type="number" value="<?php echo $editProduct ? ($this->editProduct->getPrice()) : '' ?>" required name="product-price" id="text-field-hero-input">
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label">Price</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-select  demo-width-class mt-2 p-1" style="width: 25em;" data-mdc-auto-init="MDCSelect">
                                                <input type="hidden" name="product-availability" value="<?php echo ($editProduct) ? (intval($this->editProduct->getAvailability()) == 1)  ? 1 : 0 : 1; ?>">
                                                <i class="mdc-select__dropdown-icon"></i>
                                                <div class="mdc-select__selected-text"></div>
                                                <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                    <ul class="mdc-list" style="width: 15em;">
                                                        <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo ($editProduct) ? (intval($this->editProduct->getAvailability()) == 1)  ? 1 : 0 : 1; ?>" aria-selected="true">
                                                            <?php echo ($editProduct) ? (intval($this->editProduct->getAvailability()) == 1) ? "Yes" : "No" : "Yes"; ?>
                                                        </li>
                                                        <li class="mdc-list-item" data-value="<?php echo ($editProduct) ? (intval($this->editProduct->getAvailability()) == 1)  ? 0 : 1 : 0; ?>">
                                                            <?php echo ($editProduct) ? (intval($this->editProduct->getAvailability()) == 1) ? "No" : "Yes" : "No"; ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <span class="mdc-floating-label">Available</span>
                                                <div class="mdc-line-ripple"></div>
                                            </div>
                                        </div>


                                        <div class="row d-flex p-0 m-0 col-12 mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop col-12">
                                            <div class="col-6 pl-2">
                                                <h5 class="pt-1">Category</h5>
                                            </div>
                                            <div class="col-6"> <a class="btn btn-danger btn-sm tx-14 float-right" style="height: 30px;" data-toggle="modal" data-page="add-product-category" data-target="#addCategoryModal" data-id="<?php echo Encoding::encode(json_encode(array($this->admin->getId(), $this->admin->getUserName()))) ?>">
                                                    <i class='bx bx-plus'></i>Add Category</a>
                                            </div>
                                        </div>

                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop" style="margin-top: -1em;">
                                            <div class="template-demo" id="product-categories-ul">
                                                <?php for ($i = 0; $i < count($productCategories); $i++) { ?>
                                                    <div class="mdc-form-field">
                                                        <div class="mdc-checkbox">
                                                            <input type="checkbox" name="product-category[]" <?php echo $editProduct ? in_array($productCategories[$i]->getId(), fromDbJson($this->editProduct->getCategory())) ? 'checked' : '' : ''; ?> value="<?php echo $productCategories[$i]->getId(); ?>" id="basic-disabled-checkbox" class="mdc-checkbox__native-control" />
                                                            <div class="mdc-checkbox__background">
                                                                <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                                    <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                                                                </svg>
                                                                <div class="mdc-checkbox__mixedmark"></div>
                                                            </div>
                                                        </div>
                                                        <label for="basic-disabled-checkbox" class="mt-2 h6" id="basic-disabled-checkbox-label"><?php echo $productCategories[$i]->getName(); ?></label>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mdc-layout-grid m-0 mt-4 p-0 php-form">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <h6 class="card-title">Product Options</h6>
                                <div class="template-demo">
                                    <div class="mdc-layout-grid__inner">
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-select demo-width-class mt-2 p-1" style="width: 25em;" data-mdc-auto-init="MDCSelect">
                                                <i class="icofont-ui-add add-product-category click hover" data-toggle="modal" data-page="add-option-category" data-target="#addCategoryModal" data-id="<?php echo Encoding::encode(json_encode(array($this->admin->getId(), $this->admin->getUserName()))) ?>" data-placement="top" title="Add Category"></i>
                                                <input type="hidden" name="option-category">
                                                <i class="mdc-select__dropdown-icon"></i>
                                                <div class="mdc-select__selected-text ml-3" id="option-category-name"></div>
                                                <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                    <ul class="mdc-list" style="width: 15em;" id="option-categories-ul">
                                                        <li class="mdc-list-item mdc-list-item--selected p-1" data-value="" aria-selected="true">
                                                        </li>
                                                        <?php for ($i = 0; $i < count($optionsCategories); $i++) { ?>
                                                            <li class="mdc-list-item" data-value="<?php echo $optionsCategories[$i]->getId(); ?>">
                                                                <?php echo $optionsCategories[$i]->getName(); ?>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                                <span class="mdc-floating-label ml-3">Category</span>
                                                <div class="mdc-line-ripple"></div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined ">
                                                <input class="mdc-text-field__input" name="option-name" id="text-field-hero-input">
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label">Name</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-select demo-width-class mt-2 p-1" style="width: 25em;" data-mdc-auto-init="MDCSelect">
                                                <input type="hidden" name="option-availability">
                                                <i class="mdc-select__dropdown-icon"></i>
                                                <div class="mdc-select__selected-text"></div>
                                                <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                    <ul class="mdc-list" style="width: 15em;">
                                                        <li class="mdc-list-item mdc-list-item--selected" data-value="1" aria-selected="true">
                                                            Yes</li>
                                                        <li class="mdc-list-item" data-value="0">
                                                            No
                                                        </li>
                                                    </ul>
                                                </div>
                                                <span class="mdc-floating-label">Available</span>
                                                <div class="mdc-line-ripple"></div>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                <i class="material-icons mdc-text-field__icon icofont-yen yen"></i>
                                                <input class="mdc-text-field__input" type="number" name="option-price" id="text-field-hero-input">
                                                <div class="mdc-notched-outline">
                                                    <div class="mdc-notched-outline__leading"></div>
                                                    <div class="mdc-notched-outline__notch">
                                                        <label for="text-field-hero-input" class="mdc-floating-label">Price</label>
                                                    </div>
                                                    <div class="mdc-notched-outline__trailing"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-select demo-width-class mt-2 p-1" style="width: 25em;" data-mdc-auto-init="MDCSelect">
                                                <input type="hidden" name="option-type">
                                                <i class="mdc-select__dropdown-icon"></i>
                                                <div class="mdc-select__selected-text"></div>
                                                <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                    <ul class="mdc-list" style="width: 15em;">
                                                        <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo ProductOption::SINGLE_ITEM ?>" aria-selected="true">
                                                            Single Item</li>
                                                        <li class="mdc-list-item" data-value="<?php echo ProductOption::MULTIPLE_ITEM ?>">
                                                            Multiple Item
                                                        </li>
                                                    </ul>
                                                </div>
                                                <span class="mdc-floating-label">Option Type</span>
                                                <div class="mdc-line-ripple"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-2 text-right save-changes">
                    <a id="add-option-btn" class="btn btn-danger tx-14">Add</a>
                </div>
                <button type="submit" name="<?php echo $editProduct ? 'update-product' : 'create-product' ?>" class="btn btn-danger mt-3 col-12" trn="<?php echo $editProduct ? 'save' : 'create' ?>"><?php echo $editProduct ? 'Save' : 'Create' ?></button>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-12 mt-5">
                <img id="preview-small" class="img img-fluid text-center" src="<?php echo $editProduct ? isEmpty($this->editProduct->getDisplayImage()) ? 'assets/images/dashboard/placeholder.svg' : $this->editProduct->getDisplayImage() : 'assets/images/dashboard/placeholder.svg'; ?>" />
                <div class="card-footer p-2 save-changes preview-footer">
                    <a class="btn btn-danger btn-sm tx-14">Preview</a>
                </div>

                <div class="card" style="margin-top: 8em;">
                    <div class="card-body">
                        <h5 class="card-title mb-1">Options</h5>
                        <input type="hidden" name="options" value="<?php echo $editProduct ?  toDbJson($this->editProduct->getProductOptions() ?? "") : "" ?>" />
                        <div id="options-input-div">
                            <?php if ($editProduct) {
                                foreach ($this->editProduct->getProductOptions() as $option) {
                                    echo '<span class="badge rounded-pill bg-primary text-light option-span ml-1 mr-1">' . $option->name . '<i class="icofont-close-line" onclick="delOption(this.parentNode.parentNode.childNodes,this.parentNode)"></i></span>';
                                }
                            } ?>
                        </div>

                        <?php if ($this->admin->getRole() == 1) {
                        ?>
                            <h5 class="card-title mb-1 mt-4">Branch</h5>
                            <?php for ($i = 0; $i < count($this->branches); $i++) {
                                $branch = $this->branches[$i];
                            ?>
                                <div class="mdc-form-field">
                                    <div class="mdc-checkbox">
                                        <input type="checkbox" name="product-branch[]" <?php echo $editProduct ? in_array($branch->getId(), fromDbJson($this->editProduct->getBranchId())) ? 'checked' : '' : ''; ?> value="<?php echo $branch->getId(); ?>" id="basic-disabled-checkbox" class="mdc-checkbox__native-control" />
                                        <div class="mdc-checkbox__background">
                                            <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                                            </svg>
                                            <div class="mdc-checkbox__mixedmark"></div>
                                        </div>
                                    </div>
                                    <label for="basic-disabled-checkbox" class="mt-2 h6" id="basic-disabled-checkbox-label"> <?php echo $branch->getName(); ?></label>
                                </div>
                        <?php }
                        } ?>

                    </div>
                </div>
            </div>
    </form>
    <?php if (!is_null($dashboardController_error)) {
        keepFormValues($_POST);
    } ?>
</main>