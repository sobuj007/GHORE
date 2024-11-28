@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <h1>Add New Location</h1>
        <form action="{{ route('locations.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="city_id" class="form-label">City</label>
                <select class="form-control" id="city_id" name="city_id" required>
                    <option value="" disabled selected>Select City</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
                @error('city_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Location Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Create Location</button>
        </form>
    </div>
</div>
@endsection

@push('js')
@endpush
