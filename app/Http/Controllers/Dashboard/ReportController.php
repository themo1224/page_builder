<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function viewReport()
    {
        // Today's views
        $todayViews = View::whereDate('created_at', Carbon::today())->count();

        // This month's views
        $monthViews = View::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // All-time views
        $allTimeViews = View::count();

        return response()->json([
            'today' => $todayViews,
            'this_month' => $monthViews,
            'all_time' => $allTimeViews,
        ]);
    }
}
