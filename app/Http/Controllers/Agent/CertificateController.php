<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::where('agent_id', Auth::id())->get();
        return view('agent.certificates.index', compact('certificates'));
    }

    public function create()
    {
        return view('agent.certificates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = getImageName($request->file('image')->getClientOriginalName());
            $request->file('image')->storeAs('certificates', $imagePath);
        }

        Certificate::create([
            'agent_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('certificates.index')->with('success', 'Certificate created successfully.');
    }



    public function edit(Certificate $certificate)
    {
        return view('agent.certificates.edit', compact('certificate'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $certificate->image;
        if ($request->hasFile('image')) {
            $imagePath = getImageName($request->file('image')->getClientOriginalName());
            $request->file('image')->storeAs('certificates', $imagePath);
        }


        $certificate->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('certificates.index')->with('success', 'Certificate updated successfully.');
    }

    public function destroy(Certificate $certificate)
    {
        $certificate=Certificate::find($certificate);

        $certificate->delete();

        return redirect()->route('certificates.index')->with('success', 'Certificate deleted successfully.');
    }

}
