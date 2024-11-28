@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="row">
    <h1>Create User Profile</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('usercommonprofile.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

         {{--<div class="form-group">
            <label for="user_id">User</label>
            <input type="text" name="user_id" id="" value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div> --}}

        <div class="mb-3">

                <label for="image" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="image" name="img">

        </div>

        <div class="mb-3">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" class="form-control" >
        </div>

        <div class="mb-3">
            <label for="mobilenumber">Mobile Number</label>
            <input type="int" name="mobilenumber" id="mobilenumber" class="form-control" >
        </div>

        <button type="submit" class="btn btn-primary  mt-3">Save Profile</button>
    </form>
</div>
@endsection

@push('js')
@endpush
