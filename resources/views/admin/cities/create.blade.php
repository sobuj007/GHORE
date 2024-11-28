@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="col-md-8 mx-auto">
    <h1>Add New City</h1>
    <form action="{{ route('cities.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">City Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Create City</button>
    </form>
</div>
</div>
@endsection

@push('js')
@endpush
