@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
    <div class="row">
        <h1>User Profiles</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($profile == null)
            <a href="{{ route('usercommonprofile.create') }}" class="btn btn-primary mb-3">Add Profile</a>
        @endif


        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Image</th>
                    <th>Address</th>
                    <th>Mobile Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                @if ($profile)

                    <tr>
                        <td>{{ auth()->user()->name }}</td>
                        <td>
                            @if ($profile->img)
                                <img src="{{ getAssetUrl($profile->img, 'uploads/profile') }}"
                                    alt="{{ $profile->img }}" width="50">
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $profile->address }}</td>
                        <td>{{ $profile->mobilenumber }}</td>
                        <td>
                            <a href="{{ route('usercommonprofile.edit') }}" class="btn btn-warning">Edit</a>
                            {{-- <form action="{{ route('usercommonprofile.distroy', $profile->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form> --}}

                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="4">No Profile Found</td>

                    </tr>

                @endif
            </tbody>
        </table>
    </div>
@endsection

@push('js')
@endpush
