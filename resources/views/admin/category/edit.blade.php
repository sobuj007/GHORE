@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <h1>Edit Category</h1>

        <form action="{{ route('category.update',$category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="category_name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="category_name" name="name" value="{{  $category->name }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" value="{{ $category->image}}" class="form-control" id="image" name="image">
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" class="form-control" required>
                    <option value="male" {{ old('gender', $category->gender) == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender', $category->gender) == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="Both" {{ old('gender', $category->gender) == 'unisex' ? 'selected' : '' }}>Both</option>
                </select>
            </div>
             <div class="mb-3">
                <label for="cat_description" class="form-label">Category Description</label>
                <input type="textarea" class="form-control" id="cat_description" name="cat_description" value="{{  $category->cat_description }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update Category</button>
        </form>
    </div>
</div>
@endsection

@push('js')
@endpush
