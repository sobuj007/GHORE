@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="row">
    <h1>Edit User Profile</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('usercommonprofile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="user_id">User</label>
            <input type="text" name="user_id" id="user_id" class="form-control" value="{{ old('name', auth()->user()->name) }}" disabled="true" >
        </div>

        <div class="mb-3">
            <label for="img">Profile Image</label>
            <input type="file" name="img" id="img" class="form-control-file">
            @if(auth()->user()->profile->img)

                <img src="{{ getAssetUrl(auth()->user()->profile->img,'uploads/profile') }}" alt="{{ auth()->user()->profile->img }}" width="50">

            @endif


        </div>

        <div class="mb-3">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', auth()->user()->profile->address) }}">
        </div>

        <div class="mb-3">
            <label for="mobilenumber">Mobile Number</label>
            <input type="text" name="mobilenumber" id="mobilenumber" class="form-control" value="{{ old('mobilenumber', auth()->user()->profile->mobilenumber) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection

@push('js')
@endpush
