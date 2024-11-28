@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="container">
    <h1>Create Service Product</h1>
    <form action="{{ route('serviceproducts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <div class="form-group">
            <label for="product_price">Product Price</label>
            <input type="number" name="product_price" id="product_price" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="service_price">Service Price</label>
            <input type="number" name="service_price" id="service_price" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="both">Both</option>
            </select>
        </div>
        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="subcategory_id">Subcategory</label>
            <select name="subcategory_id" id="subcategory_id" class="form-control" required>
                <!-- Options will be populated via AJAX -->
            </select>
        </div>
        <div class="form-group">
            <label for="bodypart_id">Body Part</label>
            <select name="bodypart_id" id="bodypart_id" class="form-control" required>
                <!-- Options will be populated via AJAX -->
            </select>
        </div>
        <div class="form-group">
            <label for="city_id">City</label>
            <select name="city_id" id="city_id" class="form-control" required>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="location_ids">Locations</label>
            <div id="location_ids">
                <!-- Checkboxes will be populated via AJAX -->
            </div>
        </div>
        <div class="form-group">
            <label for="available_slot_id">Available Slot</label>
            <select name="available_slot_id" id="available_slot_id" class="form-control" required>
                @foreach($slots as $slot)
                    <option value="{{ $slot->id }}">{{ $slot->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="appointment_slot_ids">Appointment Slots</label>
            <div id="appointment_slot_ids">
                <!-- Checkboxes will be populated via AJAX -->
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection

@push('js')
{{-- <script>
    $(document).ready(function() {
        // Load subcategories based on selected category
        $('#category_id').on('change', function() {
            var categoryId = $(this).val();
            $.ajax({
                url: '{{ route("getSubcategories") }}',
                type: 'GET',
                data: { category_id: categoryId },
                success: function(data) {
                    $('#subcategory_id').empty().append('<option value="">Select Subcategory</option>');
                    $.each(data, function(key, value) {
                        $('#subcategory_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                }
            });
        });

        // Load body parts based on selected subcategory
        $('#subcategory_id').on('change', function() {
            var subcategoryId = $(this).val();
            $.ajax({
                url: '{{ route("getBodyParts") }}',
                type: 'GET',
                data: { subcategory_id: subcategoryId },
                success: function(data) {
                    $('#bodypart_id').empty().append('<option value="">Select Body Part</option>');
                    $.each(data, function(key, value) {
                        $('#bodypart_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                }
            });
        });

        // Load locations based on selected city
        $('#city_id').on('change', function() {
            var cityId = $(this).val();
            $.ajax({
                url: '{{ route("getLocations") }}',
                type: 'GET',
                data: { city_id: cityId },
                success: function(data) {
                    $('#location_ids').empty();
                    $.each(data, function(key, value) {
                        $('#location_ids').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                }
            });
        });

        // Load appointment slots based on selected available slot
        $('#available_slot_id').on('change', function() {
            var slotId = $(this).val();
            $.ajax({
                url: '{{ route("getAppointmentSlots") }}',
                type: 'GET',
                data: { slot_id: slotId },
                success: function(data) {
                    $('#appointment_slot_ids').empty();
                    $.each(data, function(key, value) {
                        $('#appointment_slot_ids').append('<option value="'+ value.id +'">'+ value.time +'</option>');
                    });
                }
            });
        });
    });
</script> --}}
<script>
    $(document).ready(function() {
        $('#category_id').change(function() {
            var categoryId = $(this).val();
            $.ajax({
                url: "{{ route('agents.subcategories') }}",
                type: "GET",
                data: { category_id: categoryId },
                success: function(data) {
                    $('#subcategory_id').empty();
                    $.each(data, function(index, subcategory) {
                        $('#subcategory_id').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                    });
                }
            });
        });

        $('#subcategory_id').change(function() {
            var subcategoryId = $(this).val();
            $.ajax({
                url: "{{ route('agents.bodyparts') }}",
                type: "GET",
                data: { subcategory_id: subcategoryId },
                success: function(data) {
                    $('#bodypart_id').empty();
                    $.each(data, function(index, bodyPart) {
                        $('#bodypart_id').append('<option value="' + bodyPart.id + '">' + bodyPart.name + '</option>');
                    });
                }
            });
        });

        $('#city_id').change(function() {
            var cityId = $(this).val();
            $.ajax({
                url: "{{ route('agents.locations') }}",
                type: "GET",
                data: { city_id: cityId },
                success: function(data) {
                    $('#location_ids').empty();
                    $.each(data, function(index, location) {
                        $('#location_ids').append('<div><input type="checkbox" name="location_ids[]" value="' + location.id + '"> ' + location.name + '</div>');
                    });
                }
            });
        });

        $('#available_slot_id').change(function() {
            var slotId = $(this).val();
            $.ajax({
                url: "{{ route('agents.appointmentslots') }}",
                type: "GET",
                data: { slot_id: slotId },
                success: function(data) {
                    $('#appointment_slot_ids').empty();
                    $.each(data, function(index, appointmentSlot) {
                        $('#appointment_slot_ids').append('<div><input type="checkbox" name="appointment_slot_ids[]" value="' + appointmentSlot.id + '"> ' + appointmentSlot.time + '</div>');
                    });
                }
            });
        });
    });
    </script>
@endpush
