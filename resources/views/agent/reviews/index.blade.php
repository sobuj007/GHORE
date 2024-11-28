@extends('backend.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
<div class="container">
    <h1>Reviews for </h1>

    @if($reviews->isEmpty())
        <p>No reviews yet.</p>
    @else
        @foreach($reviews as $review)
            <div class="review">
                <h4>{{ $review->reviewername }}</h4>
                <p>Rating: {{ $review->rating }}/5</p>
                <p>{{ $review->comment }}</p>
                @if($review->image)
                    <img src="{{ asset('storage/' . $review->image) }}" alt="Review Image" style="width:100px;height:100px;">
                @endif
                <p><small>Reviewed on: {{ $review->created_at->format('d M Y') }}</small></p>
            </div>
            <hr>
        @endforeach
    @endif
</div>
@endsection

@push('js')
@endpush
