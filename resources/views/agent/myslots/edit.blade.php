@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="container">
    <h2>Edit My Slot</h2>

    <form action="{{ route('myslots.update', $myslot->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $myslot->title }}" required>
        </div>

        <div class="form-group">
            <label for="available_opening">Available Opening</label>
            <input type="text" name="available_opening" id="available_opening" class="form-control" value="{{ $myslot->available_opening }}" required>
        </div>

        <div class="form-group">
            <label for="offday">Offday</label>
            <input type="text" name="offday" id="offday" class="form-control" value="{{ $myslot->offday }}" required>
        </div>

        <div class="form-group">
            <label for="slot_duration">Slot Duration (in minutes)</label>
            <input type="number" name="slot_duration" id="slot_duration" class="form-control" value="{{ $myslot->slot_duration }}" required>
        </div>

        <div class="form-group">
            <label for="active">Active</label>
            <select name="active" id="active" class="form-control">
                <option value="1" {{ $myslot->active == 1 ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ $myslot->active == 0 ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Slot</button>
    </form>
</div>
@endsection

@push('js')
@endpush
