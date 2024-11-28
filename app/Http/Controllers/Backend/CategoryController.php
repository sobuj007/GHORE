<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subcategory;

class CategoryController extends Controller
{
    public function index()
    {
        $categories= Category::all();

        return view('admin.category.index',compact('categories'));
    }
    public function create()
    {

        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable',
            'gender' => 'required|string',
            'cat_description' => 'required|string',
        ]);

       $image=null;
        if(!empty($request->file('image'))){
            $image=getImageName($request->file('image')->getClientOriginalName());
            $request->file('image')->storeAs('category',$image);
        }

        // if ($request->hasFile('image')) {
        //     $category->image = $request->file('image')->store('categories', 'public');
        // }

        Category::create([
            'name'=>$request->name,
            'image'=>$image,
            'gender'=>$request->gender,
            'cat_description'=>$request->cat_description
        ]);

        return redirect()->route('category.index')->with('success',"category Created Successfuly");
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit',compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable',
            'gender' => 'required|string',
            'cat_description' => 'required|string',
        ]);

       $image=$category->image;
        if(!empty($request->file('image'))){
            $image=getImageName($request->file('image')->getClientOriginalName());
            $request->file('image')->storeAs('category',$image);
        }

        // if ($request->hasFile('image')) {
        //     $category->image = $request->file('image')->store('categories', 'public');
        // }

        $category->update([
            'name'=>$request->name,
            'image'=>$image,
            'gender'=>$request->gender,
            'cat_description'=>$request->cat_description
        ]);

        return redirect()->route('category.index')->with('success',"category Created Successfuly");
    }

    public function destroy(Category $category)
    {

        $category->delete();
        return redirect()->route('category.index')->with('success',"Subcategory Deleted Successfuly");;

    }}
