@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <h1>Add New Subcategory</h1>

        <form action="{{ route('bodypart.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="subcategory_id" class="form-label">Category</label>
                <select class="form-control" id="subcategory_id" name="subcategory_id" required>
                    <option value="" disabled selected>Select Category</option>
                    @foreach ($subcategory as $subcategory)
                        <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                    @endforeach
                </select>
                @error('subcategory_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Bodypart Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create Subcategory</button>
        </form>
    </div>
</div>
@endsection

@push('js')
@endpush
