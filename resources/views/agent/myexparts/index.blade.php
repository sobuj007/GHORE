@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="row">
    <h1>My Experts</h1>
    <a href="{{ route('myexparts.create') }}" class="btn btn-primary mb-3">Add New Expert</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Profile Image</th>
                <th>Expert Year</th>
                <th>Gender</th>
                <th>Mobile</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($experts as $expert)
                <tr>
                    <td>{{ $expert->name }}</td>
                    <td>
                        {{-- <img src="{{ asset('storage/' . $expert->profile_image) }}" alt="{{ $expert->name }}" width="50"> --}}
                        @if ($expert->profile_image)
                        {{-- <img src="{{ asset('storage/' . $storeProfile->coverImage) }}" alt="Cover Image" width="100"> --}}

                        {{-- <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->category_name }}" width="50"> --}}
                        <img src="{{ getAssetUrl($expert->profile_image,'uploads/exparts') }}" alt="{{ $expert->name }}" width="50">
                    @else
                        No Image
                    @endif
                    </td>
                    <td>{{ $expert->expartyear }}</td>
                    <td>{{ ucfirst($expert->gender) }}</td>
                    <td>{{ $expert->mobile }}</td>
                    <td>
                        <a href="{{ route('myexparts.edit', $expert->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('myexparts.destroy', $expert->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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
