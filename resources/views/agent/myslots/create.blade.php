@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="container">
    <h2>Create My Slot</h2>

    <form action="{{ route('myslots.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="available_opening">Available Opening(3:00 PM to 7:00 PM)</label>
            <input type="text" name="available_opening" id="available_opening" class="form-control" value="{{ old('available_opening') }}" required>
        </div>

        <div class="form-group">
            <label for="offday">Offday</label>
            <input type="text" name="offday" id="offday" class="form-control" value="{{ old('offday') }}" required>
        </div>

        <div class="form-group">
            <label for="slot_duration">Slot Duration (in minutes)</label>
            <input type="number" name="slot_duration" id="slot_duration" class="form-control" value="{{ old('slot_duration') }}" required>
        </div>

        <div class="form-group">
            <label for="active">Active</label>
            <select name="active" id="active" class="form-control">
                <option value="1" {{ old('active') == 1 ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('active') == 0 ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create Slot</button>
    </form>
</div>
@endsection

@push('js')
@endpush
