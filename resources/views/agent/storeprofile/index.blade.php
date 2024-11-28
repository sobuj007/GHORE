@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="row">
    <h1>Store Profiles</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($profile == null)
    <a href="{{ route('storeprofile.create') }}" class="btn btn-primary mb-3">My Store</a>
@endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Store Name</th>
                <th>City</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if ($profile)
                <tr>
                    <td>{{ $profile->id }}</td>
                    <td>{{ $profile->storename }}</td>
                    <td>{{ $profile->city->name }}</td>
                    <td>
                        <a href="{{ route('storeprofile.show', $profile->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('storeprofile.edit', $profile->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('storeprofile.destroy', $profile->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
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
