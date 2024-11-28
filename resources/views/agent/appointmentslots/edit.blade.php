@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="container">
    <h2>Edit Appointment Slot</h2>
    <form action="{{ route('appointmentslots.update', $appointmentslot->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="slot_id">Slot</label>
            <select name="slot_id" id="slot_id" class="form-control">
                @foreach($myslots as $myslot)
                    <option value="{{ $myslot->id }}" {{ $appointmentslot->slot_id == $myslot->id ? 'selected' : '' }}>{{ $myslot->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="agent_id">Agent</label>
            <select name="agent_id" id="agent_id" class="form-control">
                @foreach($agents as $agent)
                    <option value="{{ $agent->id }}" {{ $appointmentslot->agent_id == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="time">Time</label>
            <input type="time" name="time" id="time" class="form-control" value="{{ old('time', $appointmentslot->time) }}">
        </div>

        <div class="form-group">
            <label for="note">Note</label>
            <textarea name="note" id="note" class="form-control">{{ old('note', $appointmentslot->note) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection

@push('js')
@endpush
