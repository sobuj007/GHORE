@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="row">
<div class="col-md-8 mx-auto">
    <h1>Edit Location</h1>
    <form action="{{ route('locations.update', $location->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="city_id" class="form-label">City</label>
            <select class="form-control" id="city_id" name="city_id" required>
                <option value="" disabled>Select City</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ $location->city_id == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
            @error('city_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Location Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $location->name }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Location</button>
    </form>
</div>
</div>
@endsection

@push('js')
@endpush
