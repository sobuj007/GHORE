@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="container">
    <h1>Edit Store Profile</h1>

    <form action="{{ route('storeprofile.update', $storeProfile->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Store Name -->
        <div class="form-group">
            <label for="storename">Store Name</label>
            <input type="text" name="storename" id="storename" class="form-control" value="{{ $storeProfile->storename }}" required>
        </div>

        <!-- Cover Image -->
        <div class="form-group">
            <label for="coverImage">Cover Image</label>
            <input type="file" name="coverImage" id="coverImage" class="form-control">
            @if ($storeProfile->coverImage)
                {{-- <img src="{{ asset('storage/' . $storeProfile->coverImage) }}" alt="Cover Image" width="100"> --}}

                {{-- <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->category_name }}" width="50"> --}}
                <img src="{{ getAssetUrl($storeProfile->coverImage,'uploads/storeImages') }}" alt="{{ $storeProfile->storename }}" width="50">
            @else
                No Image
            @endif

        </div>

        <!-- Trade Licence -->
        <div class="form-group">
            <label for="tradelicence">Trade Licence</label>
            <input type="text" name="tradelicence" id="tradelicence" class="form-control" value="{{ $storeProfile->tradelicence }}">
        </div>

        <!-- Address -->
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ $storeProfile->address }}" required>
        </div>

        <!-- Mobile -->
        <div class="form-group">
            <label for="mobile">Mobile</label>
            <input type="text" name="mobile" id="mobile" class="form-control" value="{{ $storeProfile->mobile }}" required>
        </div>

        <!-- Logo -->
        <div class="form-group">
            <label for="logo">Logo</label>
            <input type="file" name="logo" id="logo" class="form-control">

            @if ($storeProfile->logo)
           <img src="{{ getAssetUrl($storeProfile->logo,'uploads/storeImages') }}" alt="{{ $storeProfile->storename }}" width="50">
        @else
            No Image
        @endif
        </div>

        <!-- City -->
        <div class="form-group">
            <label for="city_id">City</label>
            <select name="city_id" id="city_id" class="form-control" required>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ $storeProfile->city_id == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Locations -->
        <div class="form-group">
            <label for="location_ids">Locations</label>
            <div id="locations-wrapper">
                @foreach($locations as $location)
                    <div>
                        <label>
                            <input type="checkbox" name="location_ids[]" value="{{ $location->id }}" {{ in_array($location->id, json_decode($storeProfile->location_ids, true)) ? 'checked' : '' }}>
                            {{ $location->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- NID -->
        <div class="form-group">
            <label for="nid">NID</label>
            <input type="text" name="nid" id="nid" class="form-control" value="{{ $storeProfile->nid }}">
        </div>

        <!-- Company Type (Dropdown) -->
        <div class="form-group">
            <label for="company_type">Company Type</label>
            <select name="company_type" id="company_type" class="form-control" required>
                <option value="individual" {{ $storeProfile->company_type == 'individual' ? 'selected' : '' }}>Individual</option>
                <option value="corporate" {{ $storeProfile->company_type == 'corporate' ? 'selected' : '' }}>Corporate</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection

@push('js')
<script>
       $(document).ready(function () {
    $('#city_id').change(function () {
        var city_id = $(this).val();

        $.ajax({
            url: '/agent/get-locations/' + city_id,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#locations-wrapper').empty();

                $.each(data, function (index, location) {
                    $('#locations-wrapper').append(
                        '<div><label><input type="checkbox" name="location_ids[]" value="' + location.id + '"> ' + location.name + '</label></div>'
                    );
                });
            },
            error: function () {
                console.error('Failed to load locations');
            }
        });
    });
});
</script>
@endpush
