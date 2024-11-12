<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  // Display a listing of the videos
  public function index()
  {
      $videos = Video::all();
      return response()->json($videos, 200);
  }

  // Store a newly created video
  public function store(Request $request)
  {
      $request->validate([
          'title' => 'required|string|max:255',
          'description' => 'nullable|string',
          'video_path' => 'required|file|mimes:mp4,avi,mov|max:50000', // Max size 50MB for example
      ]);

      $data = $request->all();

      // Handle video file upload
      if ($request->hasFile('video_path')) {
          $data['video_path'] = $request->file('video_path')->store('videos', 'public');
      }

      $video = Video::create($data);

      return response()->json(['message' => 'Video created successfully', 'video' => $video], 201);
  }

  // Display the specified video
  public function show($id)
  {
      $video = Video::findOrFail($id);
      return response()->json($video, 200);
  }

  // Update the specified video
  public function update(Request $request, $id)
  {
      $video = Video::findOrFail($id);

      $request->validate([
          'title' => 'required|string|max:255',
          'description' => 'nullable|string',
          'video_path' => 'nullable|file|mimes:mp4,avi,mov|max:50000',
      ]);

      $data = $request->all();

      // Handle video file upload
      if ($request->hasFile('video_path')) {
          if ($video->video_path) {
              Storage::disk('public')->delete($video->video_path); // Delete old video
          }
          $data['video_path'] = $request->file('video_path')->store('videos', 'public');
      }

      $video->update($data);

      return response()->json(['message' => 'Video updated successfully', 'video' => $video], 200);
  }

  // Remove the specified video
  public function destroy($id)
  {
      $video = Video::findOrFail($id);

      if ($video->video_path) {
          Storage::disk('public')->delete($video->video_path); // Delete associated video file
      }

      $video->delete();

      return response()->json(['message' => 'Video deleted successfully'], 200);
  }
}
