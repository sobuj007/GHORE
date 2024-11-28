@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="container">
    <h2>My Slots</h2>
    <a href="{{ route('myslots.create') }}" class="btn btn-primary mb-3">Create New Slot</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Available Opening</th>
                <th>Offday</th>
                <th>Slot Duration</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($myslots as $myslot)
            <tr>
                <td>{{ $myslot->id }}</td>
                <td>{{ $myslot->title }}</td>
                <td>{{ $myslot->available_opening }}</td>
                <td>{{ $myslot->offday }}</td>
                <td>{{ $myslot->slot_duration }}</td>
                <td>{{ $myslot->active ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('myslots.edit', $myslot->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('myslots.destroy', $myslot->id) }}" method="POST" style="display:inline-block;">
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
