<!-- Modal -->
<div class="modal fade" id="addCardModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-1">
            <div class="modal-header p-1">
                <h5 class="modal-title position-absolute" trn="" id="staticBackdropLabel">Add Credit Card</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="card-wrapper mt-3"></div>
                    <div class="form-container active">
                        <div class="creditcardform mt-4">
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
                        </div>
                    </div>
                    <!-- <div class="alert alert-danger mb-3 text-center" id="error-alert-add" style="display:none" role="alert">
                    <strong> Enter category name</strong>
                </div>
                <div class="mb-3">
                    <label for="category-name" class="col-form-label">Category Name:</label>
                    <input type="text" class="form-control" id="category-name">
                </div>
                <div class="mb-3">
                    <label for="category-description" class="col-form-label">Short Description:</label>
                    <textarea class="form-control" id="category-description"></textarea>
                </div> -->
                </div>
                <div class="modal-footer p-1 justify-content-center">
                    <button type="button" class="btn btn-secondary" trn="close" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="add-card" class="btn btn-primary" trn="add" id="add-btn">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>