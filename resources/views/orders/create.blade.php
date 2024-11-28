@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="container">
    <h1>Create Order</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <!-- User ID (Assuming the user is selected from a dropdown) -->
        <div class="form-group">
            <label for="agent_id">User:</label>
            <select name="agent_id" class="form-control" required>
                <option value="">Select User</option>
                @foreach ($serviceProducts as $serviceProduct)
                    <option value="{{ $serviceProduct->agent_id }}">{{ $serviceProduct->agent_id }}</option>
                @endforeach
            </select>
        </div>

        <!-- Date -->
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <!-- Status -->
        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" class="form-control" required>
                <option value="pending">Pending</option>
                <option value="accepted">Accepted</option>
                <option value="declined">Declined</option>
            </select>
        </div>

        <!-- Service Product -->
        <div class="form-group">
            <label for="service_product_id">Service Product:</label>
            <select name="service_product_id" class="form-control" required>
                <option value="">Select Service Product</option>
                @foreach ($serviceProducts as $serviceProduct)
                    <option value="{{ $serviceProduct->id }}">{{ $serviceProduct->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Product Quantity -->
        <div class="form-group">
            <label for="product_quantity">Product Quantity:</label>
            <input type="number" name="product_quantity" class="form-control" min="1" required>
        </div>

        <!-- Service Quantity -->
        <div class="form-group">
            <label for="service_quantity">Service Quantity:</label>
            <input type="number" name="service_quantity" class="form-control" min="1" required>
        </div>

        <!-- Product Price -->
        <div class="form-group">
            <label for="product_price">Product Price:</label>
            <input type="number" name="product_price" class="form-control" step="0.01" required>
        </div>

        <!-- Service Price -->
        <div class="form-group">
            <label for="service_price">Service Price:</label>
            <input type="number" name="service_price" class="form-control" step="0.01" required>
        </div>

        <!-- Appointment Slot -->
        <div class="form-group">
            <label for="selected_slot">Appointment Slot:</label>
            <select name="selected_slot" class="form-control" required>
                <option value="">Select Slot</option>
                @foreach ($appointmentSlots as $slot)
                    <option value="{{ $slot->id }}">{{ $slot->time }} - {{ $slot->myslot->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success">Create Order</button>
    </form>
</div>
@endsection

@push('js')
@endpush
