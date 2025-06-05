@extends('layouts.app')

@section('content')
<h2>Edit Invoice</h2>

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

<form method="POST" action="{{ route('invoices.update', $invoice) }}">
    @csrf
    @method('PUT')

    <!-- Customer -->
    <div class="mb-3">
        <label>Customer</label>
        <select name="customer_id" class="form-control" required>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}"
                    {{ old('customer_id', $invoice->customer_id) == $customer->id ? 'selected' : '' }}>
                    {{ $customer->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Invoice Date -->
    <div class="mb-3">
        <label>Invoice Date</label>
        <input type="date" name="invoice_date" class="form-control"
               value="{{ old('invoice_date', $invoice->invoice_date) }}" required>
    </div>

    <!-- Items Table -->
    <table class="table" id="items-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Type</th>
                <th>Price</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @php
                $oldItems = old('items', $invoice->items->toArray());
            @endphp

            @foreach ($oldItems as $i => $item)
                <tr>
                    <td>
                        <select name="items[{{ $i }}][product_id]" class="form-control product-select">
                            <option value="" disabled selected>Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    data-single="{{ $product->single_price }}"
                                    data-bulk="{{ $product->bulk_price }}"
                                    {{ $item['product_id'] == $product->id ? 'selected' : '' }}>
                                    {{ $product->part_number }} - {{ $product->color }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="items[{{ $i }}][quantity]" class="form-control"
                               value="{{ $item['quantity'] ?? 1 }}" required>
                    </td>
                    <td>
                        <select name="items[{{ $i }}][price_type]" class="form-control price-type-select">
                            <option value="single" {{ ($item['price_type'] ?? '') == 'single' ? 'selected' : '' }}>Single</option>
                            <option value="bulk" {{ ($item['price_type'] ?? '') == 'bulk' ? 'selected' : '' }}>Bulk</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" step="0.01" name="items[{{ $i }}][price_per_unit]"
                               class="form-control price-input"
                               value="{{ $item['price_per_unit'] ?? '' }}" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger remove-row">X</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button type="button" id="add-item" class="btn btn-secondary mb-3">Add Product</button>

    <!-- Total Amount -->
    <div class="mb-3">
        <label>Total Amount</label>
        <input type="number" step="0.01" name="total_amount"
               value="{{ old('total_amount', $invoice->total_amount) }}"
               class="form-control" required>
    </div>

    <button class="btn btn-success">Update Invoice</button>
</form>
@endsection

@section('scripts')
<script>
    let index = {{ count(old('items', $invoice->items)) }};

    // Add row
    $('#add-item').on('click', function () {
        const row = `
        <tr>
            <td>
                <select name="items[${index}][product_id]" class="form-control product-select">
                    <option value="" disabled selected>Select Product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}"
                                data-single="{{ $product->single_price }}"
                                data-bulk="{{ $product->bulk_price }}">
                            {{ $product->part_number }} - {{ $product->color }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="items[${index}][quantity]" class="form-control" value="1" required></td>
            <td>
                <select name="items[${index}][price_type]" class="form-control price-type-select">
                    <option value="single">Single</option>
                    <option value="bulk">Bulk</option>
                </select>
            </td>
            <td><input type="number" step="0.01" name="items[${index}][price_per_unit]" class="form-control price-input" required></td>
            <td><button type="button" class="btn btn-danger remove-row">X</button></td>
        </tr>`;
        $('#items-table tbody').append(row);
        index++;
    });

    // Remove row
    $(document).on('click', '.remove-row', function () {
        $(this).closest('tr').remove();
    });

    // Auto-fill price
    $(document).on('change', '.product-select, .price-type-select', function () {
        const row = $(this).closest('tr');
        const selectedProduct = row.find('.product-select option:selected');
        const priceType = row.find('.price-type-select').val();
        const price = priceType === 'bulk'
            ? selectedProduct.data('bulk')
            : selectedProduct.data('single');
        if (price) {
            row.find('.price-input').val(price);
        }
    });
</script>
@endsection
