<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $policy = PrivacyPolicy::select('title')->get();
        return response()->json($policy);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            $policy = PrivacyPolicy::create($request->all());

            return response()->json(['message' => 'Privacy policy created successfully', 'policy' => $policy], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create privacy policy', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PrivacyPolicy $privacyPolicy)
    {
        try {
            return response()->json($privacyPolicy, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve privacy policy.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrivacyPolicy $privacyPolicy)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            $privacyPolicy->update($request->all());

            return response()->json([
                'message' => 'Privacy policy updated successfully.',
                'policy' => $privacyPolicy,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update privacy policy.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrivacyPolicy $privacyPolicy)
    {
        try {
            $privacyPolicy->delete();

            return response()->json([
                'message' => 'Privacy policy deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete privacy policy.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
