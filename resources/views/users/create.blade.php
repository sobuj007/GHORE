@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<h1>Create New Order</h1>

<form action="{{ route('orders.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="agent_id">Agent ID</label>
        <input type="text" name="agent_id" id="agent_id" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="date">Order Date</label>
        <input type="date" name="date" id="date" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="products">Products</label>
        @foreach($serviceProducts as $product)
            <div class="form-group">
                <label>{{ $product->name }}</label>
                <input type="hidden" name="products[{{ $product->id }}][service_product_id]" value="{{ $product->id }}">
                <input type="number" name="products[{{ $product->id }}][product_quantity]" placeholder="Product Quantity" class="form-control">
                <input type="number" name="products[{{ $product->id }}][product_price]" placeholder="Product Price" class="form-control">
                <input type="number" name="products[{{ $product->id }}][service_quantity]" placeholder="Service Quantity" class="form-control">
                <input type="number" name="products[{{ $product->id }}][service_price]" placeholder="Service Price" class="form-control">

                <label for="selected_slot">Select Slot</label>
                <select name="products[{{ $product->id }}][selected_slot]" class="form-control">
                    <option value="">Choose Slot</option>
                    @foreach($slots as $slot)
                        <option value="{{ $slot->id }}">{{ $slot->time }}</option>
                    @endforeach
                </select>
            </div>
        @endforeach
    </div>

    <button type="submit" class="btn btn-primary">Create Order</button>
</form>
@endsection


@push('js')
@endpush
