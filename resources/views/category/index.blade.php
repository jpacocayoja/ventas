@extends('layouts.app')
@section('title', 'Category Management')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4 shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Category </h4>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="bi bi-database-add"></i> Add
                    </button>
                </div>
                <div class="card-body">
                    <table id="myTable" class="display">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('category.create')
    @include('category.edit')


</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        var table = $('#myTable').DataTable({
            "ajax": {
                "url": "{{ route('getallCategory') }}",
                "type": "GET",
                "dataType": "json",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "dataSrc": function (response) {
                    if (response.status === 200) {
                        return response.category;
                    } else {
                        return [];
                    }
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "description" },
                {
                    "data": null,
                    "render": function (data, type, row) {
                        return '<a href="#" class="btn btn-sm btn-success edit-btn" data-id="'+data.id+'" data-name="'+data.name+'" data-description="'+data.description+'">Edit</a> ' +'<a href="#" class="btn btn-sm btn-danger delete-btn" data-id="'+data.id+'">Delete</a>';


                    }
                }
            ]
        });

        $('#myTable tbody').on('click', '.edit-btn', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var description = $(this).data('description');
            console.log("ID:", id, "Name:", name, "Description:", description); // DEBUG
            $('#edit-id').val(id);
            $('#edit-name').val(name);
            $('#edit-description').val(description);
            $('#editModal').modal('show');
        });


        $('#employee-form').submit(function (e) {
            e.preventDefault();
            const employeedata = new FormData(this);

            $.ajax({
                url: '{{ route('storeCategory') }}',
                method: 'post',
                data: employeedata,
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
                        $('#employee-form')[0].reset();
                        $('#exampleModal').modal('hide');
                        $('#myTable').DataTable().ajax.reload();
                    }
                }
            });
        });

    });


    $('#edit-form').submit(function (e) {
        e.preventDefault();
        const categorydata = new FormData(this);

        $.ajax({
            url: '{{ route('updateCategory') }}',
            method: 'POST',
            data: categorydata,
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
                url: '{{ route('deleteCategory') }}',
                type: 'DELETE',
                data: {id: id},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response); // Debugging: log the response
                    if (response.status === 200) {
                        alert(response.message); // Show success message
                        $('#myTable').DataTable().ajax.reload(); // Reload the table data
                    } else {
                        alert(response.message); // Show error message
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr); // Debugging: log the error
                    alert('Error: ' + error); // Show generic error message
                }
            });
        }
    });

</script>
@endsection