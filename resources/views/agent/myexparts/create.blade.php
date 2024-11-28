@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="container">
    <h1>Add New Expert</h1>

    <form action="{{ route('myexparts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <!-- Profile Image -->
        <div class="form-group">
            <label for="profile_image">Profile Image</label>
            <input type="file" name="profile_image" id="profile_image" class="form-control" required>
        </div>

        <!-- Expert Year -->
        <div class="form-group">
            <label for="expartyear">Expert Year</label>
            <input type="number" name="expartyear" id="expartyear" class="form-control" required>
        </div>

        <!-- Gender -->
        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>

        <!-- Mobile -->
        <div class="form-group">
            <label for="mobile">Mobile</label>
            <input type="text" name="mobile" id="mobile" class="form-control" required>
        </div>

        <!-- Certificate Images -->
        <div class="form-group">
            <label for="certificate_images">Certificate Images</label>
            <input type="file" name="certificate_images[]" id="certificate_images" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary">Add Expert</button>
    </form>
</div>
@endsection

@push('js')
@endpush
