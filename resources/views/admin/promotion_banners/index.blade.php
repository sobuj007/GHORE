@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="row">
    <div class="col-md-12">
        <a href="{{ route('promotion_banners.create') }}" class="btn btn-primary mb-3">Add New Promotion Banner</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Link</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($promotionBanners as $promotionBanner)
                    <tr>
                        <td>{{ $promotionBanner->title }}</td>
                        <td>{{ $promotionBanner->description }}</td>
                        <td>
                            @if ($promotionBanner->image)
                            <img src="{{ getAssetUrl($promotionBanner->image,'uploads/ads') }}" alt="{{ $promotionBanner->name }}" width="50">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>
                            @if ($promotionBanner->link)
                                <a href="{{ $promotionBanner->link }}" target="_blank">{{ $promotionBanner->link }}</a>
                            @else
                                No Link
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('promotion_banners.edit', $promotionBanner->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('promotion_banners.destroy', $promotionBanner->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('js')
@endpush
