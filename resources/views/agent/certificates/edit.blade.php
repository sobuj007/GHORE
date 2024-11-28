@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="container">
    <h2>Edit Certificate</h2>

    <form action="{{ route('certificates.update', $certificate->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $certificate->title) }}" required>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $certificate->description) }}</textarea>
        </div>

        <!-- Image -->
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
            @if ($certificate->image)
            <img src="{{ getAssetUrl($certificate->image,'uploads/certificates') }}" alt="{{$certificate->title }}" width="50">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection

@push('js')
@endpush
