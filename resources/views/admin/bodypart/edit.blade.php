@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <h1>Edit Body Part</h1>

        <form action="{{ route('bodypart.update', $bodypart->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="subcategory_id" class="form-label">Subcategory</label>
                <select class="form-control" id="subcategory_id" name="subcategory_id" required>
                    <option value="" disabled>Select Subcategory</option>
                    @foreach ($subcategory as $subcategory)
                        <option value="{{ $subcategory->id }}" {{ $bodypart->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                            {{ $subcategory->name }}
                        </option>
                    @endforeach
                </select>
                @error('subcategory_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Body Part Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $bodypart->name }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Body Part</button>
        </form>
    </div>
</div>
@endsection

@push('js')
@endpush
