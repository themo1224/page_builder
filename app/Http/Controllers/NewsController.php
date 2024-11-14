<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::paginate(8);
        return response()->json($news, 200);
    }


    // Store a newly created news item
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news = News::create($data);

        return response()->json(['message' => 'News created successfully', 'news' => $news], 201);
    }

    // Display the specified news item
    public function show($id)
    {
        $news = News::findOrFail($id);
        return response()->json($news, 200);
    }

    // Update the specified news item
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'image' => 'nullable|image|mimes:jpg,jpeg,png|max:3048',
        // ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image); // Delete old image
            }
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        return response()->json(['message' => 'News updated successfully', 'news' => $news], 200);
    }

    // Remove the specified news item
    public function destroy($id)
    {
        $news = News::findOrFail($id);

        if ($news->image) {
            Storage::disk('public')->delete($news->image); // Delete associated image
        }

        $news->delete();

        return response()->json(['message' => 'News deleted successfully'], 200);
    }
}
