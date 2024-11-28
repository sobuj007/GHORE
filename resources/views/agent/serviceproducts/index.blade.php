@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="container">
    <h1>Service Products</h1>
    <a href="{{ route('serviceproducts.create') }}" class="btn btn-primary">Add New Service Product</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Product Price</th>
                <th>Service Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($serviceProducts as $serviceProduct)
                <tr>
                    <td>{{ $serviceProduct->name }}</td>
                    <td>{{ $serviceProduct->description }}</td>
                    <td>${{ $serviceProduct->product_price }}</td>
                    <td>${{ $serviceProduct->service_price }}</td>
                    <td>
                        <a href="{{ route('serviceproducts.edit', $serviceProduct->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('serviceproducts.destroy', $serviceProduct) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('js')
@endpush
