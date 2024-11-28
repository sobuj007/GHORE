@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <h1>Bodypart</h1>
        <a href="{{ route('bodypart.create') }}" class="btn btn-primary">Add Subcategory</a>

        @if (session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Subcategory</th>

                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bodyparts as $bodypart)
                    <tr>
                        <td>{{ $bodypart->id }}</td>
                        <td>{{ $bodypart->subcategory->name }}</td>
                        <td>{{ $bodypart->name }}</td>
                        <td>
                            @if($bodypart->image)

                            <img src="{{ getAssetUrl($bodypart->image,'uploads/bodypart') }}" alt="{{ $bodypart->name }}" width="50">

                             @else
                                No Image
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('bodypart.edit', $bodypart->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('bodypart.destroy', $bodypart->id) }}" method="POST" style="display:inline;">
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
