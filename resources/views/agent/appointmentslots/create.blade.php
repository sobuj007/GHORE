@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="container">
    <h2>Create Appointment Slot</h2>

    <form action="{{ route('appointmentslots.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="slot_id">Slot</label>
            <select name="slot_id" id="slot_id" class="form-control" required>
                <option value="">Select Slot</option>
                @foreach($myslots as $slot)
                    <option value="{{ $slot->id }}" {{ old('slot_id') == $slot->id ? 'selected' : '' }}>{{ $slot->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="time">Time</label>
            <input type="time" name="time" id="time" class="form-control" value="{{ old('time') }}" required>
        </div>

        <div class="form-group">
            <label for="note">Note</label>
            <textarea name="note" id="note" class="form-control">{{ old('note') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Create Appointment Slot</button>
    </form>
</div>
@endsection

@push('js')
@endpush
