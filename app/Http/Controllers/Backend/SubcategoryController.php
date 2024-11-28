<?php

namespace App\Http\Controllers\Backend;

use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class SubcategoryController extends Controller
{
    public function index()
    {

        $subcategories= Subcategory::all();
        return view('admin.subcategory.index',compact('subcategories'));
    }
    public function create()
    {

        $category= Category::all();
        return view('admin.subcategory.create',compact('category'));
    }

    public function store(Request $request)
    {


        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable',
        ]);

        $image=null;
        if(!empty($request->file('image'))){
            $image=getImageName($request->file('image')->getClientOriginalName());
            $request->file('image')->storeAs('subcategory',$image);
        }



        Subcategory::create([
            'category_id'=>$request->category_id,
            'name'=>$request->name,
            'image'=>$image
        ]);

        return redirect()->route('subcategory.index')->with('success',"Subcategory Created Successfuly");
    }

    public function edit(SubCategory $subcategory)

    {
        $categorys = Category::all();

        return view('admin.subcategory.edit',compact('subcategory','categorys'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'category_id' => 'sometimes|required|exists:categories,id',
            'name' => 'sometimes|required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $image=$subcategory->image;
        if(!empty($request->file('image'))){
            $image=getImageName($request->file('image')->getClientOriginalName());
            $request->file('image')->storeAs('subcategory',$image);
        }


        $subcategory->update([
            'category_id'=>$request->category_id,
            'name'=>$request->name,
            'image'=>$image
        ]);

        return redirect()->route('category.index')->with('success',"category Created Successfuly");

    }

    public function destroy(Subcategory $subcategory)
    {

        $subcategory->delete();
         return redirect()->route('subcategory.index')->with('success',"Subcategory Deleted Successfuly");;
    }
}
