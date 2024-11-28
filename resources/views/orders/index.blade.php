@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<h1>Orders</h1>
<a href="{{ route('orders.create') }}" class="btn btn-primary">Create Order</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Agent</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->agent->name }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->date }}</td>
                <td>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info">View</a>
                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

@push('js')
@endpush
