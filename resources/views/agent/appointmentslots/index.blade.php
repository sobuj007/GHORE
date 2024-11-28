@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="container">
    <h2>Appointment Slots List</h2>
    <a href="{{ route('appointmentslots.create') }}" class="btn btn-primary mb-3">Create New Appointment Slot</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Slot</th>
                <th>Agent</th>
                <th>Time</th>
                <th>Note</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointmentslots as $appointmentslot)
            <tr>
                <td>{{ $appointmentslot->id }}</td>
                <td>{{ $appointmentslot->myslot->title }}</td>
                <td>{{ $appointmentslot->agent->name }}</td>
                <td>{{ $appointmentslot->time }}</td>
                <td>{{ $appointmentslot->note }}</td>
                <td>
                    <a href="{{ route('appointmentslots.edit', $appointmentslot->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('appointmentslots.destroy', $appointmentslot->id) }}" method="POST" style="display:inline-block;">
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
