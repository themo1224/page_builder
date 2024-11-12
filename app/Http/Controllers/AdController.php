<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ads = Ad::all();
        return response()->json($ads, 200);
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // If an image is uploaded, store it and save the path
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('ads', 'public');
        }

        $ad = Ad::create($data);

        return response()->json(['message' => 'Ad created successfully', 'ad' => $ad], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ad = Ad::findOrFail($id);
        return response()->json($ad, 200);
    }


    /**
     * Update the specified resource in storage.
     */
 // Update an existing ad
    public function update(Request $request, $id)
    {
        $ad = Ad::findOrFail($id);

        $data = $request->all();

        // Handle the image file upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($ad->image) {
                Storage::disk('public')->delete($ad->image);
            }

            // Store the new image
            $data['image'] = $request->file('image')->store('ads', 'public');
        }

        $ad->update($data);

        return response()->json(['message' => 'Ad updated successfully', 'ad' => $ad], 200);
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ad = Ad::findOrFail($id);

        // Delete the image file if it exists
        if ($ad->image) {
            Storage::disk('public')->delete($ad->image);
        }

        $ad->delete();

        return response()->json(['message' => 'Ad deleted successfully'], 200);
    }
}
