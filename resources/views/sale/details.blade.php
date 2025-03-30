<!-- Modal para ver detalles de la venta -->
<div class="modal fade" id="saleDetailModal" tabindex="-1" aria-labelledby="saleDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saleDetailModalLabel">Sale Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Sale ID: <span id="sale-id"></span></h5>
                <h5>Date: <span id="sale-date"></span></h5>
                <h5>Total: $<span id="sale-total"></span></h5>

                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="sale-details-body">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
