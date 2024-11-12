<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function getSettings()
    {
        $settings = Setting::first(); // Assuming there's a single row for settings
        return response()->json($settings);
    }

    // Method to update settings (for admin or backend)
    public function updateSettings(Request $request)
    {

        $request->validate([
            'about_us_text' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $settings = Setting::firstOrNew([]); // Retrieve or create a new settings instance

        // Update settings attributes
        $settings->about_us_text = $request->about_us_text;
        $settings->phone_number = $request->phone_number;
        $settings->email = $request->email;
        $settings->address = $request->address;

        // If a logo is uploaded, store it and save the path
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $settings->logo = $path;
        }

        $settings->save();

        return response()->json(['message' => 'Settings updated successfully', 'settings' => $settings]);
    }
}
