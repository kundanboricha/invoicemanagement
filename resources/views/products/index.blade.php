@extends('layouts.app')

@section('content')
<h2 class="mb-4">Product Catalog</h2>

<div class="row row-cols-1 row-cols-md-3 g-4">
    @forelse ($products as $product)
        <div class="col">
            <div class="card h-100">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('a.webp') }}"
                    class="card-img-top"
                    alt="{{ $product->part_number }}"
                    style="height: 150px; object-fit: cover;">

                <div class="card-body">
                    <h5 class="card-title">{{ $product->part_number }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p><strong>Color:</strong> {{ $product->color }}</p>
                    <p><strong>Single Price:</strong> ${{ $product->single_price }}</p>
                    <p><strong>Bulk Price:</strong> ${{ $product->bulk_price }}</p>
                    <p><strong>Stock:</strong> {{ $product->quantity }}</p>
                </div>
            </div>
        </div>
   @empty
    <div class="col-12">
        <div class="alert alert-warning text-center w-100">
            No products available. Please <a href="{{ route('products.import') }}" class="alert-link">import products</a>.
        </div>
    </div>
@endforelse

</div>

{{-- Pagination --}}
@if ($products->count())
    <div class="mt-4">
        {{ $products->links() }}
    </div>
@endif
@endsection
