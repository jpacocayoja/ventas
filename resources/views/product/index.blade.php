@extends('layouts.app')
@section('title', 'Product Management')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4 shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Product </h4>
                    <button type="button" class="btn btn-light" id="openCreateModal" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        <i class="bi bi-database-add"></i> Add
                    </button>
                </div>
                <div class="card-body">
                    <table id="myTable" class="display">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Purchase Price</th>
                                <th>Sale Price</th>
                                <th>Quantity</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('product.create')
    @include('product.edit')


</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        var table = $('#myTable').DataTable({
            "ajax": {
                "url": "{{ route('getallProduct') }}",
                "type": "GET",
                "dataType": "json",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "dataSrc": function (response) {
                    if (response.status === 200) {
                        return response.products;
                    } else {
                        return [];
                    }
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "purchase_price" },
                { "data": "sale_price" },
                { "data": "quantity" },
                { "data": "category_name" },
                {
                    "data": null,
                    "render": function (data, type, row) {
                        return '<a href="#" class="btn btn-sm btn-success edit-btn" ' +'data-id="'+ data.id +'" ' +'data-name="'+ data.name +'" ' +'data-purchase_price="'+ data.purchase_price +'" ' +'data-sale_price="'+ data.sale_price +'" ' +'data-quantity="'+ data.quantity +'" ' +'data-category_id="'+ data.category_id +'" ' +'data-category_name="'+ data.category_name +'">' +'Edit</a> ' +'<a href="#" class="btn btn-sm btn-danger delete-btn" ' +'data-id="'+ data.id +'">' +'Delete</a>';
                    }
                }
            ]
        });

        $('#exampleModal').on('show.bs.modal', function () {
            $.ajax({
                url: "{{ route('getallCategory') }}",
                type: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.status === 200) {
                        let categorySelect = $("#category_id");
                        categorySelect.empty(); 
                        /* categorySelect.append('<option value="" disabled selected>Select a category</option>'); */
                        response.category.forEach(category => {
                            categorySelect.append(`<option value="${category.id}">${category.name}</option>`);
                        });
                    }
                },
                error: function (xhr) {
                    console.error("Error fetching categories:", xhr);
                }
            });
        });

        $('#myTable tbody').on('click', '.edit-btn', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let purchasePrice = $(this).data('purchase_price');
            let salePrice = $(this).data('sale_price');
            let quantity = $(this).data('quantity');
            let categoryId = $(this).data('category_id');

            $('#edit-id').val(id);
            $('#edit-name').val(name);
            $('#edit-purchase_price').val(purchasePrice);
            $('#edit-sale_price').val(salePrice);
            $('#edit-quantity').val(quantity);

            $.ajax({
                url: "{{ route('getallCategory') }}", 
                type: "GET",
                success: function (response) {
                    if (response.status === 200) {
                        let categorySelect = $('#edit-category_id');
                        categorySelect.empty(); // Limpia las opciones previas

                        response.category.forEach(category => {
                            categorySelect.append(new Option(category.name, category.id));
                        });
                        categorySelect.val(categoryId);
                    }
                }
            });
            $('#editModal').modal('show'); // Abre el modal de edición
        });


        $('#product-form').submit(function (e) {
            e.preventDefault();
            const productdata = new FormData(this);

            $.ajax({
                url: '{{ route('storeProduct') }}',
                method: 'post',
                data: productdata,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == 200) {
                        alert("Saved successfully");
                        $('#product-form')[0].reset();
                        $('#exampleModal').modal('hide');
                        $('#myTable').DataTable().ajax.reload();
                    }
                }
            });
        });

    });


    $('#edit-form').submit(function (e) {
        e.preventDefault();
        const productdata = new FormData(this);

        $.ajax({
            url: '{{ route('updateProduct') }}',
            method: 'POST',
            data: productdata,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status === 200) {
                    alert(response.message);
                    $('#edit-form')[0].reset();
                    $('#editModal').modal('hide');
                    $('#myTable').DataTable().ajax.reload();
                } else {
                    alert(response.message);
                }
            }
        });
    });
    
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');

        if (confirm('Are you sure you want to delete this employee?')) {
            $.ajax({
                url: '{{ route('deleteProduct') }}',
                type: 'DELETE',
                data: {id: id},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response); 
                    if (response.status === 200) {
                        alert(response.message); 
                        $('#myTable').DataTable().ajax.reload(); 
                    } else {
                        alert(response.message); 
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr); 
                    alert('Error: ' + error); 
                }
            });
        }
    });

</script>
@endsection