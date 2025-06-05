@extends('layouts.app')

@section('content')
<h2>Import Products</h2>

<form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label>CSV File</label>
        <input type="file" name="csv" class="form-control" >
         @error('csv')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    </div>
    <button class="btn btn-primary">Import</button>
</form>
@endsection
