@extends('layouts.app')

@section('content')
<h2>Create Invoice</h2>

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Validation Error:</strong>
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('invoices.store') }}">
    @csrf

    <!-- Customer -->
    <div class="mb-3">
        <label>Customer</label>
        <select name="customer_id" class="form-control">
    <option value="" disabled {{ old('customer_id') ? '' : 'selected' }}>Select Customer</option>
    @foreach ($customers as $customer)
        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
            {{ $customer->name }}
        </option>
    @endforeach
</select>


    </div>

    <!-- Invoice Date -->
    <div class="mb-3">
        <label>Date</label>
<input type="date" name="invoice_date" class="form-control" value="{{ old('invoice_date') }}">
    </div>

    <!-- Items Table -->
    <table class="table" id="items-table">
        <thead>
            <tr>
                <th>Category</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Price Type</th>
                <th>Price</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select class="form-control category-select">
                        <option value="" selected disabled>Select Category</option>

                        @foreach ($products->groupBy('part_type') as $category => $group)
                        <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="items[0][product_id]" class="form-control product-select">
                        <option value="" selected disabled>Select Products</option>

                        @foreach ($products as $product)
                        <option data-category="{{ $product->part_type }}"
                            data-single="{{ $product->single_price }}"
                            data-bulk="{{ $product->bulk_price }}"
                            value="{{ $product->id }}">
                            {{ $product->part_number }} ({{ $product->color }})
                        </option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" name="items[0][quantity]" class="form-control" value="1"></td>
                <td>
                    <select name="items[0][price_type]" class="form-control price-type-select">
                        <option value="" selected disabled>Select PriceType</option>
                        <option value="single">Single</option>
                        <option value="bulk">Bulk</option>
                    </select>
                </td>
                <td><input type="text" name="items[0][price_per_unit]" class="form-control price-input"></td>
                <td><button type="button" class="btn btn-danger remove-row">X</button></td>
            </tr>
        </tbody>
    </table>

    <button type="button" class="btn btn-secondary mb-3" id="add-item">Add Product</button>

    <!-- Total -->
    <div class="mb-3">
        <label>Total Amount</label>
<input type="number" step="0.01" name="total_amount" class="form-control" value="{{ old('total_amount') }}">
    </div>

    <button class="btn btn-success">Save Invoice</button>
</form>
@endsection

@section('scripts')
<script>
    let index = 1;

    $('#add-item').on('click', function() {
        let row = $('#items-table tbody tr:first').clone();
        row.find('select, input').each(function() {
            let name = $(this).attr('name');
            if (name) {
                name = name.replace(/\d+/, index);
                $(this).attr('name', name);
            }
            $(this).val('');
        });
        $('#items-table tbody').append(row);
        index++;
    });

    // Remove row
    $(document).on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
    });

    // Auto-fill price
    $(document).on('change', '.product-select, .price-type-select', function() {
        const row = $(this).closest('tr');
        const product = row.find('.product-select option:selected');
        const type = row.find('.price-type-select').val();
        const price = type === 'bulk' ? product.data('bulk') : product.data('single');
        row.find('.price-input').val(price);
    });
</script>
@endsection