<?php

use danolez\lib\Security\Encoding;
?>
<!-- Modal -->
<div class="modal fade" id="categoriesModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-1">
            <div class="modal-header p-1">
                <h5 class="modal-title position-absolute" trn="categories" id="staticBackdropLabel">Categories</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="all-category-modal">
                <?php foreach ($productCategories ?? [] as $category) { ?>
                    <div class="alert alert-primary p-2 m-1" role="alert">
                        <?php echo $category->getName(); ?>
                        <div class="float-right">
                            <i class="icofont-ui-edit hover click "></i>
                            <i class="icofont-ui-delete hover click ml-3 async" data-page="delete-category" data-id='<?php echo ($category->getId()); ?>'></i>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="modal-footer p-1 justify-content-center">
                <button type="button" class="btn btn-secondary" trn="close" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" data-toggle="modal" data-page="add-product-category" data-target="#addCategoryModal" data-id="<?php echo Encoding::encode(json_encode(array($this->admin->getId(), $this->admin->getUserName()))) ?>"> <i class='bx bx-plus'></i><span trn="add-cat">Add Category</span></button>
            </div>
        </div>
    </div>
</div>