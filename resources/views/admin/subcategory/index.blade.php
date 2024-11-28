@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <h1>Subcategories</h1>
        <a href="{{ route('subcategory.create') }}" class="btn btn-primary">Add Subcategory</a>

        @if (session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subcategories as $subcategory)
                    <tr>
                        <td>{{ $subcategory->id }}</td>
                        <td>{{ $subcategory->category->name }}</td>
                        <td>{{ $subcategory->name }}</td>
                        <td>
                            @if($subcategory->image)
                            <img src="{{ getAssetUrl($subcategory->image,'uploads/subcategory') }}" alt="{{ $subcategory->subcategory_name }}" width="50">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('subcategory.edit', $subcategory->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('subcategory.destroy', $subcategory->id) }}" method="POST" style="display:inline;">
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
</div>
@endsection

@push('js')
@endpush
