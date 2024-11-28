@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')

<div class="row">
    <div class="col-md-8 mx-auto">
        <a href="{{ route('locations.create') }}" class="btn btn-primary mb-3">Add New Location</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>City</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($locations as $location)
                <tr>
                    <td>{{ $location->id }}</td>
                    <td>{{ $location->city->name }}</td>
                    <td>{{ $location->name }}</td>
                    <td>
                        <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('locations.destroy', $location->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
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
