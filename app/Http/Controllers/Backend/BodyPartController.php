<?php

namespace App\Http\Controllers\Backend;


use App\Models\BodyPart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subcategory;

class BodyPartController extends Controller
{
    public function index()
    {
        $bodyparts=BodyPart::all();
        return view('admin.bodypart.index',compact('bodyparts'));
    }
    public function create()
    {
        $subcategory=Subcategory::all();
        return view('admin.bodypart.create',compact('subcategory'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'subcategory_id' => 'required|exists:subcategories,id',
            'name' => 'required|string|max:255',
        ]);

       BodyPart::create([
            'subcategory_id'=>$request->subcategory_id,
            'name'=>$request->name,

        ]);

        return redirect()->route('bodypart.index')->with('Success','Created Successful');
    }

    public function edit(BodyPart $bodypart)
    { $subcategory=Subcategory::all();
        return view('admin.bodypart.edit',compact('subcategory','bodypart'));
    }

    public function update(Request $request, BodyPart $bodypart)
    {
        $request->validate([
            'subcategory_id' => 'sometimes|required|exists:subcategories,id',
            'name' => 'sometimes|required|string|max:255',
        ]);

        $bodypart->update([
            'subcategory_id'=>$request->subcategory_id,
            'name'=>$request->name
        ]);

        return redirect()->route('bodypart.index')->with('success',"category Created Successfuly");

    }

    public function destroy(BodyPart $bodypart)
    {
        $bodypart->delete();
        return redirect()->route('subcategory.index')->with('success',"Subcategory Deleted Successfuly");;

    }
}
