@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="container">
    <h2>Certificate List</h2>
    <a href="{{ route('certificates.create') }}" class="btn btn-primary mb-3">Create New Certificate</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($certificates as $certificate)
            <tr>
                <td>{{ $certificate->id }}</td>
                <td>{{ $certificate->title }}</td>
                <td>{{ $certificate->description }}</td>
                <td>

                    {{-- <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->category_name }}" width="50"> --}}

                    @if($certificate->image)
                    <img src="{{ getAssetUrl($certificate->image,'uploads/certificates') }}" alt="{{$certificate->title }}" width="50">

                    @else
                    No Image
                    @endif
                </td>
                <td>
                    <a href="{{ route('certificates.edit', $certificate->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('certificates.destroy', $certificate->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('js')
@endpush
