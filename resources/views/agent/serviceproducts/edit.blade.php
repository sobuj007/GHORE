@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="container">
    <h1>Edit Service Product</h1>
    <form action="{{ route('serviceproducts.update', $serviceproduct) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $serviceproduct->name) }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $serviceproduct->description) }}</textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($serviceproduct->image)
                <img src="{{ asset('storage/' . $serviceproduct->image) }}" alt="Current Image" style="width:100px;height:100px;">
            @endif
        </div>
        <div class="form-group">
            <label for="product_price">Product Price</label>
            <input type="number" name="product_price" id="product_price" class="form-control" value="{{ old('product_price', $serviceproduct->product_price) }}" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="service_price">Service Price</label>
            <input type="number" name="service_price" id="service_price" class="form-control" value="{{ old('service_price', $serviceproduct->service_price) }}" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control" required>
                <option value="male" {{ old('gender', $serviceproduct->gender) == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender', $serviceproduct->gender) == 'female' ? 'selected' : '' }}>Female</option>
                <option value="unisex" {{ old('gender', $serviceproduct->gender) == 'unisex' ? 'selected' : '' }}>Unisex</option>
            </select>
        </div>
        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $serviceproduct->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                    <option value="{{ $city->id }}" {{ old('city_id', $serviceproduct->city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
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
                    <option value="{{ $slot->id }}" {{ old('available_slot_id', $serviceproduct->available_slot_id) == $slot->id ? 'selected' : '' }}>{{ $slot->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="appointment_slot_ids">Appointment Slots</label>
            <div id="appointment_slot_ids">
                <!-- Checkboxes will be populated via AJAX -->
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        var categoryId = $('#category_id').val();
        var subcategoryId = "{{ old('subcategory_id', $serviceproduct->subcategory_id) }}";
        var cityId = $('#city_id').val();
        var slotId = $('#available_slot_id').val();

        // Handle null relationships
        var selectedLocations = @json(old('location_ids', $serviceproduct->locations ? $serviceproduct->locations->pluck('id')->toArray() : []));
        var selectedAppointmentSlots = @json(old('appointment_slot_ids', $serviceproduct->appointmentSlots ? $serviceproduct->appointmentSlots->pluck('id')->toArray() : []));

        function updateSubcategories() {
            $.ajax({
                url: "{{ route('agents.subcategories') }}",
                type: "GET",
                data: { category_id: categoryId },
                success: function(data) {
                    $('#subcategory_id').empty();
                    $.each(data, function(index, subcategory) {
                        $('#subcategory_id').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                    });
                    $('#subcategory_id').val(subcategoryId).trigger('change');
                }
            });
        }

        function updateBodyParts() {
            $.ajax({
                url: "{{ route('agents.bodyparts') }}",
                type: "GET",
                data: { subcategory_id: subcategoryId },
                success: function(data) {
                    $('#bodypart_id').empty();
                    $.each(data, function(index, bodyPart) {
                        $('#bodypart_id').append('<option value="' + bodyPart.id + '">' + bodyPart.name + '</option>');
                    });
                    $('#bodypart_id').val("{{ old('bodypart_id', $serviceproduct->bodypart_id) }}");
                }
            });
        }

        function updateLocations() {
            $.ajax({
                url: "{{ route('agents.locations') }}",
                type: "GET",
                data: { city_id: cityId },
                success: function(data) {
                    $('#location_ids').empty();
                    $.each(data, function(index, location) {
                        var checked = selectedLocations.includes(location.id) ? 'checked' : '';
                        $('#location_ids').append('<div><input type="checkbox" name="location_ids[]" value="' + location.id + '" ' + checked + '> ' + location.name + '</div>');
                    });
                }
            });
        }

        function updateAppointmentSlots() {
            $.ajax({
                url: "{{ route('agents.appointmentslots') }}",
                type: "GET",
                data: { slot_id: slotId },
                success: function(data) {
                    $('#appointment_slot_ids').empty();
                    $.each(data, function(index, appointmentSlot) {
                        var checked = selectedAppointmentSlots.includes(appointmentSlot.id) ? 'checked' : '';
                        $('#appointment_slot_ids').append('<div><input type="checkbox" name="appointment_slot_ids[]" value="' + appointmentSlot.id + '" ' + checked + '> ' + appointmentSlot.time + '</div>');
                    });
                }
            });
        }

        $('#category_id').change(function() {
            categoryId = $(this).val();
            updateSubcategories();
        });

        $('#subcategory_id').change(function() {
            subcategoryId = $(this).val();
            updateBodyParts();
        });

        $('#city_id').change(function() {
            cityId = $(this).val();
            updateLocations();
        });

        $('#available_slot_id').change(function() {
            slotId = $(this).val();
            updateAppointmentSlots();
        });

        // Initialize the form with existing values
        updateSubcategories();
        updateLocations();
        updateAppointmentSlots();
    });
</script>
@endpush
