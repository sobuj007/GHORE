@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="row">
    <h1>Edit User</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="subscription">Subscription</label>
            <select name="subscription" id="subscription" class="form-control">
                <option value="Free" {{ old('subscription', $user->subscription) == 'Free' ? 'selected' : '' }}>Free</option>
                <option value="Premium" {{ old('subscription', $user->subscription) == 'Premium' ? 'selected' : '' }}>Premium</option>
                <option value="Silver" {{ old('subscription', $user->subscription) == 'Silver' ? 'selected' : '' }}>Premium</option>
                <option value="Gold" {{ old('subscription', $user->subscription) == 'Golf' ? 'selected' : '' }}>Premium</option>
                <!-- Add more options as needed -->
            </select>
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control">
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="agent" {{ old('role', $user->role) == 'agent' ? 'selected' : '' }}>Agent</option>
                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>

        <div class="form-group">
            <label for="is_blocked">Blocked</label>
            <input type="checkbox" name="is_blocked" id="is_blocked" {{ old('is_blocked', $user->is_blocked) ? 'checked' : '' }}>
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection

@push('js')
@endpush
