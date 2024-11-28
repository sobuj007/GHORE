<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PromotionBanner;

class PromotionBannerController extends Controller
{
    public function index()
    {
        $promotionBanners = PromotionBanner::all();
        return view('admin.promotion_banners.index', compact('promotionBanners'));
    }

    public function create()
    {
        return view('admin.promotion_banners.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|url',
        ]);

        // if ($request->hasFile('image')) {
        //     $data['image'] = $request->file('image')->store('promotion_banners', 'public');
        // }
        $image=$request->image;
        if(!empty($request->file('image'))){
            $image=getImageName($request->file('image')->getClientOriginalName());
            $request->file('image')->storeAs('ads',$image);
        }

        PromotionBanner::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'image'=>$image,
            'link'=>$request->link
        ]);

        return redirect()->route('promotion_banners.index')->with('success', 'Promotion Banner created successfully.');
    }

    public function edit(PromotionBanner $promotionBanner)
    {
        return view('admin.promotion_banners.edit', compact('promotionBanner'));
    }

    public function update(Request $request, PromotionBanner $promotionBanner)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|url',
        ]);

        $image=$promotionBanner->image;
        if(!empty($request->file('image'))){
            $image=getImageName($request->file('image')->getClientOriginalName());
            $request->file('image')->storeAs('ads',$image);
        }

      $promotionBanner->  update([
            'title'=>$request->title,
            'description'=>$request->description,
            'image'=>$image,
            'link'=>$request->link
        ]);

        return redirect()->route('promotion_banners.index')->with('success', 'Promotion Banner updated successfully.');
    }

    public function destroy(PromotionBanner $promotionBanner)
    {
        // if ($promotionBanner->image) {
        //     Storage::disk('public')->delete($promotionBanner->image);
        // }
        $promotionBanner->delete();
        return redirect()->route('promotion_banners.index')->with('success', 'Promotion Banner deleted successfully.');
    }
}
