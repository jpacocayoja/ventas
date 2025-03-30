<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="employee-form" method="post">
                    <div class="row">
                        <div class="col-lg">
                            <label>Name</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg">
                            <label>Description</label>
                            <textarea id="description" name="description" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="employee-form">Save</button>
            </div>
        </div>
    </div>
</div>