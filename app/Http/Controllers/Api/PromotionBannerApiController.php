<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PromotionBanner;
use App\Http\Controllers\Controller;

class PromotionBannerApiController extends Controller
{
    public function index()
    {
        $promotionBanners = PromotionBanner::all();
        return response()->json([
            'message'=>'Successfuly Geting data',
            'data'=>$promotionBanners]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|url',
        ]);

        $image = null;
        if ($request->hasFile('image')) {
            $image = getImageName($request->file('image')->getClientOriginalName());
            $request->file('image')->storeAs('ads', $image);
        }

        $promotionBanner = PromotionBanner::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $image,
            'link' => $request->link
        ]);

        return response()->json([
            "message"=>"Successfull",
       "data"=> $promotionBanner
    ], 201);
    }

    public function show(PromotionBanner $promotionBanner)
    {
        return response()->json($promotionBanner);
    }

    public function update(Request $request, PromotionBanner $promotionBanner)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|url',
        ]);

        $image = $promotionBanner->image;
        if ($request->hasFile('image')) {
            $image = getImageName($request->file('image')->getClientOriginalName());
            $request->file('image')->storeAs('ads', $image);
        }

        $promotionBanner->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $image,
            'link' => $request->link
        ]);

        return response()->json( [  "message"=>"Successfull",
        "data"=> $promotionBanner]);
    }

    public function destroy(PromotionBanner $promotionBanner)
    {

        $promotionBanner=PromotionBanner::find($promotionBanner);

        $promotionBanner->delete();
        return response()->json(null, 204);
    }
}
