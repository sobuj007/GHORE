@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <h1>Add New Category</h1>

    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="category_name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <div class="mb-3">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="unisex">Unisex</option>
            </select>
        </div>
            <div class="mb-3">
            <label for="cat_description" class="form-label">Category Description</label>
            <input type="textarea" class="form-control" id="cat_description" name="cat_description" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Category</button>
    </form>
    </div>
</div>
@endsection

@push('js')
@endpush
