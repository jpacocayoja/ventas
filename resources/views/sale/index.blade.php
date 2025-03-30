@extends('layouts.app')
@section('title', 'Sales Management')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4 shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Sales</h4>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#saleModal">
                        <i class="bi bi-cart-plus"></i> New Sale
                    </button>
                </div>
                <div class="card-body">
                    <table id="salesTable" class="display">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('sale.create')
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        // Inicialización de la tabla de productos disponibles
        var productsTable = $('#productsTable').DataTable({
            "ajax": {
                "url": "{{ route('getallProduct') }}", 
                "type": "GET",
                "dataType": "json",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "dataSrc": function (response) {
                    console.log(response); // Debug: Ver la respuesta en consola
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
                { "data": "sale_price" },
                { "data": "quantity" },
                {
                    "data": null,
                    "render": function (data) {
                        return '<button type="button" class="btn btn-sm btn-success add-product" data-id="'+data.id+'" data-name="'+data.name+'" data-price="'+data.sale_price+'">Add</button>';
                    }
                }
            ]
        });

        var salesTable = $('#salesTable').DataTable({
            "ajax": {
                "url": "{{ route('getallSales') }}",
                "type": "GET",
                "dataType": "json",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "dataSrc": function (response) {
                    console.log(response); // Debug: Ver la respuesta en consola
                    if (response.status === 200) {
                        return response.sales;
                    } else {
                        return [];
                    }
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "sale_date" },
                { "data": "total" },
                {
                    "data": null,
                    "render": function (data) {
                        return '<button type="button" class="btn btn-sm btn-info view-sale" data-id="'+data.id+'">View</button>';
                    }
                }
            ]
        });

        // Función para agregar productos a la tabla de venta
        $(document).on('click', '.add-product', function (e) {
            e.preventDefault(); 
            e.stopPropagation(); 
            
            let id = $(this).data('id');
            let name = $(this).data('name');
            let price = parseFloat($(this).data('price'));
            let quantity = 1;
            let subtotal = price * quantity;

            // Evitar duplicados en la tabla de ventas
            if ($('#selected-products tr[data-id="' + id + '"]').length > 0) {
                alert("Este producto ya fue agregado!");
                return;
            }

            // Crear la nueva fila
            let row = `<tr data-id="${id}">
                        <td>${name}</td>
                        <td>$${price.toFixed(2)}</td>
                        <td><input type="number" class="form-control quantity" value="1" min="1"></td>
                        <td class="subtotal">$${subtotal.toFixed(2)}</td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-product">X</button></td>
                    </tr>`;

            // Agregar la fila a la tabla de productos seleccionados
            $('#selected-products').append(row);
            updateTotal();
        });

        // Actualizar subtotal cuando cambia la cantidad
        $(document).on('input', '.quantity', function () {
            let row = $(this).closest('tr');
            let price = parseFloat(row.find('td:nth-child(2)').text().replace('$', ''));
            let quantity = parseInt($(this).val());
            let subtotal = price * quantity;
            
            // Actualizar el subtotal en la fila
            row.find('.subtotal').text(`$${subtotal.toFixed(2)}`);
            updateTotal();
        });

        // Remover producto de la lista de ventas
        $(document).on('click', '.remove-product', function (e) {
            e.preventDefault(); 
            $(this).closest('tr').remove();
            updateTotal();
        });

        // Función para actualizar el total
        function updateTotal() {
            let total = 0;
            $('.subtotal').each(function () {
                total += parseFloat($(this).text().replace('$', ''));
            });
            $('#total').text(total.toFixed(2));
        }

        // Manejo del botón "Confirm Sale"
        $("#confirm-sale-btn").on("click", function() {
            let products = [];

            // Recoger los productos seleccionados
            $('#selected-products tr').each(function() {
                let id = $(this).data('id');
                let quantity = parseInt($(this).find('.quantity').val());
                // Extraer el subtotal correctamente del texto del elemento
                let subtotal = parseFloat($(this).find('.subtotal').text().replace('$', '').trim());
                
                products.push({ 
                    id: id, 
                    quantity: quantity, 
                    subtotal: subtotal  
                });
            });

            // Verificar que hay productos seleccionados
            if (products.length === 0) {
                alert("No hay productos seleccionados para la venta");
                return;
            }

            let saleData = {
                total: parseFloat($('#total').text()),
                products: products,
            };

            // Enviar los datos por AJAX
            $.ajax({
                url: "{{ route('storeSale') }}",
                method: "POST",
                data: JSON.stringify(saleData),
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert(response.message);  
                    $('#selected-products').empty();  
                    $('#total').text('0.00');  
                    $('#saleModal').modal('hide');  
                    salesTable.ajax.reload(); 
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);  
                }
            });
        });
    });
</script>
@endsection