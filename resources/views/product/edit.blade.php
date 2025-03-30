<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-form" method="post">
                    <input type="hidden" id="edit-id" name="id">
                    
                    <div class="row mb-3">
                        <div class="col-lg">
                            <label for="edit-name">Name</label>
                            <input type="text" id="edit-name" name="name" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg">
                            <label for="edit-purchase_price">Purchase Price</label>
                            <input type="number" id="edit-purchase_price" name="purchase_price" class="form-control" required>
                        </div>
                        <div class="col-lg">
                            <label for="edit-sale_price">Sale Price</label>
                            <input type="number" id="edit-sale_price" name="sale_price" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg">
                            <label for="edit-quantity">Quantity</label>
                            <input type="number" id="edit-quantity" name="quantity" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg">
                            <label for="edit-category_id">Category</label>
                            <select id="edit-category_id" name="category_id" class="form-control" required>
                                <option value="" disabled selected>Loading...</option>
                            </select>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="edit-form">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
