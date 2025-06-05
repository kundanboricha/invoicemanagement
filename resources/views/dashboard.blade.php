@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-3">Dashboard</h2>

        @if(auth()->user()->isAdmin())
            <div class="alert alert-info">
                Welcome, <strong>Admin</strong>! You can manage the system.
            </div>
            <a href="{{ route('products.import') }}" class="btn btn-secondary">Import Products</a>
            <a href="{{ route('invoices.index') }}" class="btn btn-primary me-2">Manage Invoices</a>
        @else
            <div class="alert alert-success">
                Welcome, <strong>User</strong>! You can view your invoices and available products.
            </div>
            <a href="{{ route('invoices.index') }}" class="btn btn-primary me-2">My Invoices</a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">View Products</a>
        @endif
    </div>
@endsection
