<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="product-form" method="post">
                    <div class="row mb-3">
                        <div class="col-lg">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg">
                            <label for="purchase_price">Purchase Price</label>
                            <input type="number" id="purchase_price" name="purchase_price" class="form-control"
                                required>
                        </div>
                        <div class="col-lg">
                            <label for="sale_price">Sale Price</label>
                            <input type="number" id="sale_price" name="sale_price" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg">
                            <label for="quantity">Quantity</label>
                            <input type="number" id="quantity" name="quantity" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg">
                            <label for="category_id">Category</label>
                            <select id="category_id" name="category_id" class="form-control" required>
                             {{--    <option value="" disabled selected>Loading...</option> --}}
                            </select>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="product-form">Save</button>
            </div>
        </div>
    </div>
</div>