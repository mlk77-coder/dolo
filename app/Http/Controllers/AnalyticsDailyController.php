<?php

namespace App\Http\Controllers;

use App\Models\AnalyticsDaily;
use Illuminate\Http\Request;

class AnalyticsDailyController extends Controller
{
    public function index(Request $request)
    {
        $query = AnalyticsDaily::query();

        if ($request->filled('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }

        $analytics = $query->orderBy('date', 'desc')->paginate(15);

        return view('pages.analytics-daily.index', compact('analytics'));
    }
}

