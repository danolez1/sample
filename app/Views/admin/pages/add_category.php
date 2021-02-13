<!-- Modal -->
<div class="modal fade" id="addCategoryModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-1">
            <div class="modal-header p-1">
                <h5 class="modal-title position-absolute" trn="add-category" id="staticBackdropLabel">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger mb-3 text-center" id="error-alert-add" style="display:none" role="alert">
                    <strong trn="enter-category-name">Enter category name</strong>
                </div>
                <div class="mb-3">
                    <label for="category-name" class="col-form-label" trn="category-name">Category Name</label>:
                    <input type="text" class="form-control" id="category-name">
                </div>
                <div class="mb-3">
                    <label for="category-description" class="col-form-label" trn="short-description">Short Description</label>:
                    <textarea class="form-control" id="category-description"></textarea>
                </div>
            </div>
            <div class="modal-footer p-1 justify-content-center">
                <button type="button" class="btn btn-secondary" trn="close" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" trn="add" id="add-btn">Add</button>
            </div>
        </div>
    </div>
</div>