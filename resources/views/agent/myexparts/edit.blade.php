@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="container">
    <h1>Edit Expert</h1>

    <form action="{{ route('myexparts.update', $myexpart->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $myexpart->name) }}" required>
        </div>

        <!-- Profile Image -->
        <div class="form-group">
            <label for="profile_image">Profile Image</label>
            <input type="file" name="profile_image" id="profile_image" class="form-control">
            @if ($myexpart->profile_image)
                <img src="{{ asset('storage/' . $myexpart->profile_image) }}" alt="{{ $myexpart->name }}" width="100">
            @endif
        </div>

        <!-- Expert Year -->
        <div class="form-group">
            <label for="expartyear">Expert Year</label>
            <input type="number" name="expartyear" id="expartyear" class="form-control" value="{{ old('expartyear', $myexpart->expartyear) }}" required>
        </div>

        <!-- Gender -->
        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control" required>
                <option value="male" {{ old('gender', $myexpart->gender) == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender', $myexpart->gender) == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ old('gender', $myexpart->gender) == 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <!-- Mobile -->
        <div class="form-group">
            <label for="mobile">Mobile</label>
            <input type="text" name="mobile" id="mobile" class="form-control" value="{{ old('mobile', $myexpart->mobile) }}" required>
        </div>

        <!-- Certificate Images -->
        <div class="form-group">
            <label for="certificate_images">Certificate Images (Optional)</label>
            <input type="file" name="certificate_images[]" id="certificate_images" class="form-control" multiple>
            @if ($myexpart->certificate_images)
                <div class="mt-2">
                    @foreach (json_decode($myexpart->certificate_images, true) as $image)
                        <img src="{{ asset('storage/' . $image) }}" alt="Certificate Image" width="100" class="mr-2">
                    @endforeach
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Expert</button>
    </form>
</div>
@endsection

@push('js')
@endpush
