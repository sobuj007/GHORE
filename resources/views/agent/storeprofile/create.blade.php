@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="container">
    <h1>Create Store Profile</h1>

    <form action="{{ route('storeprofile.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Store Name -->
        <div class="form-group">
            <label for="storename">Store Name</label>
            <input type="text" name="storename" id="storename" class="form-control" value="{{ old('storename') }}" required>
        </div>

        <!-- Cover Image -->
        <div class="form-group">
            <label for="coverImage">Cover Image</label>
            <input type="file" name="coverImage" id="coverImage" class="form-control">
        </div>

        <!-- Trade Licence -->
        <div class="form-group">
            <label for="tradelicence">Trade Licence</label>
            <input type="text" name="tradelicence" id="tradelicence" class="form-control" value="{{ old('tradelicence') }}">
        </div>

        <!-- Address -->
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}" required>
        </div>

        <!-- Mobile -->
        <div class="form-group">
            <label for="mobile">Mobile</label>
            <input type="text" name="mobile" id="mobile" class="form-control" value="{{ old('mobile') }}" required>
        </div>

        <!-- Logo -->
        <div class="form-group">
            <label for="logo">Logo</label>
            <input type="file" name="logo" id="logo" class="form-control">
        </div>

        <!-- City -->
        <div class="form-group">
            <label for="city_id">City</label>
            <select name="city_id" id="city_id" class="form-control" required>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
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
                            <input type="checkbox" name="location_ids[]" value="{{ $location->id }}" {{ is_array(old('location_ids')) && in_array($location->id, old('location_ids')) ? 'checked' : '' }}>
                            {{ $location->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- NID -->
        <div class="form-group">
            <label for="nid">NID</label>
            <input type="text" name="nid" id="nid" class="form-control" value="{{ old('nid') }}">
        </div>

      <!-- Company Type -->
<div class="form-group">
    <label for="company_type">Company Type</label>
    <select name="company_type" id="company_type" class="form-control" required>
        <option value="individual" {{ old('company_type', $storeProfile->company_type ?? '') == 'individual' ? 'selected' : '' }}>Individual</option>
        <option value="corporate" {{ old('company_type', $storeProfile->company_type ?? '') == 'corporate' ? 'selected' : '' }}>Corporate</option>
    </select>
</div>

        <button type="submit" class="btn btn-primary">Create Profile</button>
    </form>
</div>


@endsection

@push('js')
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script>
        // $(document).ready(function() {



        //     $('#city').change(function() {
        //         var cityId = $(this).val();
        //         if (cityId) {
        //             $.ajax({
        //                 url: '/agent/get-locations/' + cityId,
        //                 type: 'GET',
        //                 success: function(data) {   console.log(data.locations);
        //                     $('#location').empty().append('<option value="">Select Location</option>');
        //                     $.each(data.locations, function(index, location) {
        //                         //$('#location').append('<option value="' + location.id + '">' + location.name + '</option>');

        //                         $('#location').append(`
        //                     <div>
        //                         <label>
        //                             <input class="form-check-input mt-0 md-3" type="checkbox" name="location[]" value="${location.id}" />
        //                             ${location.name}
        //                         </label>
        //                     </div>
        //                 `);


        //                     });
        //                 }
        //             });
        //         } else {
        //             $('#location').empty().append('<option value="">Select Location</option>');
        //         }
        //     });
        // });
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush
