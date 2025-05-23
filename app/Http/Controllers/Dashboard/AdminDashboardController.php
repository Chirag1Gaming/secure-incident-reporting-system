<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Filters from query string
        $statusFilter = $request->input('status');
        $categoryFilter = $request->input('category');

        // Base query
        $query = Incident::query();

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        if ($categoryFilter) {
            $query->where('category', $categoryFilter);
        }

        $incidents = $query->latest()->paginate(20);

        // Analytics data

        $totalIncidents = Incident::count();

        $statusCounts = Incident::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        $categoriesCounts = Incident::select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->pluck('count', 'category');

        // Average resolution time in hours
        $avgResolution = Incident::whereNotNull('resolved_at')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(HOUR, created_at, resolved_at)) as avg_hours'))
            ->value('avg_hours');
        
        return view('admin.dashboard', compact(
            'incidents',
            'totalIncidents',
            'statusCounts',
            'categoriesCounts',
            'avgResolution',
            'statusFilter',
            'categoryFilter'
        ));
    }
}
