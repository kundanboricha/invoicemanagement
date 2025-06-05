@extends('layouts.app')

@section('content')
<h2>Invoices</h2>
<a href="{{ route('invoices.create') }}" class="btn btn-primary mb-3">Create Invoice</a>

<input type="text" id="search" class="form-control mb-3" placeholder="Search by customer name">

<table class="table table-bordered" id="invoice-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($invoices as $invoice)
        <tr>
            <td>{{ $invoice->id }}</td>
            <td>{{ $invoice->customer->name }}</td>
            <td>{{ $invoice->invoice_date }}</td>
            <td>{{ $invoice->total_amount }}</td>
            <td>
                <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger delete-btn">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5">
                <div class="alert alert-warning text-center w-100 mb-0">
                    No invoices available. Please <a href="{{ route('invoices.create') }}" class="alert-link">create an invoice</a>.
                </div>
            </td>
        </tr>
    @endforelse
</tbody>

</table>
@endsection

@section('scripts')
<script>
    // Search
    $('#search').on('keyup', function () {
        let query = $(this).val();
        $.ajax({
            url: "{{ route('invoices.index') }}",
            data: { search: query },
            success: function (data) {
                $('#invoice-table tbody').html($(data).find('tbody').html());
            }
        });
    });

    // Delete confirmation
    $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();

        const form = $(this).closest('form'); 

        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>

@endsection