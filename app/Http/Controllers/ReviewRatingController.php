<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ReviewRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewRatingController extends Controller
{
    public function showAgentReviews()
    {
        // Get the ID of the currently authenticated agent
        $agent_id = Auth::id();

        // Fetch all reviews related to the specific agent
        $reviews = ReviewRating::where('agent_id', $agent_id)->get();

        // Return view with the reviews data
        return view('agent.reviews.index', compact('reviews'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'serviceproduct_id' => 'nullable|exists:serviceproducts,id',
            'agent_id' => 'nullable|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'reviewername' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $reviewRating = ReviewRating::create([
            'user_id' => auth()->id(),
            'reviewername' => $request->reviewername,
            'image' => $request->file('image') ? $request->file('image')->store('reviews', 'public') : null,
            'serviceproduct_id' => $request->serviceproduct_id,
            'agent_id' => $request->agent_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Review added successfully.');
    }

    public function destroy(ReviewRating $reviewRating)
    {
        $this->authorize('delete', $reviewRating);

        $reviewRating->delete();

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}
