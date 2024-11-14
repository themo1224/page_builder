<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PeopleController extends Controller
{
    // Display a listing of all people
    public function index()
    {
        $people = People::all();
        return response()->json($people, 200);
    }

    // Store a newly created person
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'role_name' => 'required|string|max:255',
                'photo' => '',
            ]);

            $data = $request->all();


            // Handle photo upload
            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('people_photos', 'public');
            }

            $person = People::create($data);

            return response()->json(['message' => 'Person created successfully', 'person' => $person], 201);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error creating person: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'message' => 'Failed to create person.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Display the specified person
    public function show($id)
    {
        $person = People::findOrFail($id);
        return response()->json($person, 200);
    }

    // Update an existing person
    public function update(Request $request, $id)
    {
        $person = People::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'role_name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($person->photo) {
                Storage::disk('public')->delete($person->photo); // Delete old photo
            }
            $data['photo'] = $request->file('photo')->store('people_photos', 'public');
        }

        $person->update($data);

        return response()->json(['message' => 'Person updated successfully', 'person' => $person], 200);
    }

    // Remove the specified person
    public function destroy($id)
    {
        $person = People::findOrFail($id);

        // Delete associated photo if it exists
        if ($person->photo) {
            Storage::disk('public')->delete($person->photo);
        }

        $person->delete();

        return response()->json(['message' => 'Person deleted successfully'], 200);
    }
}
