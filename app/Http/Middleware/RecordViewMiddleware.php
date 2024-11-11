<?php

namespace App\Http\Middleware;

use App\Models\View;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordViewMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the IP has already registered a view today
        $existingView = View::where('ip_address', $request->ip())
            ->whereDate('created_at', Carbon::today())
            ->exists();

        if (!$existingView) {
            View::create([
                'user' => auth()->id() ?? 'ناشناس',
                'ip_address' => $request->ip(),
            ]);
        }

        // Proceed to the next middleware or controller
        return $next($request);
    }
}
