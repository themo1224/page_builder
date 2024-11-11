<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(Request $request)
    {
        // Return the authenticated user's information
        $user = $request->user()->load('site'); // Load site information with the user
        return response()->json($user);
    }
}
