<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\User;
use Illuminate\Http\Request;

class IncidentManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Incident::query()->with('user');

        // Filtering
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('category') && $request->category !== '') {
            $query->where('category', $request->category);
        }

        if ($request->has('priority') && $request->priority !== '') {
            $query->where('priority', $request->priority);
        }

        // Sorting
        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by, $request->get('sort_order', 'asc'));
        } else {
            $query->latest();
        }

        $incidents = $query->paginate(15);
        $admins = User::role('Admin')->get();

        return view('incidents.admin.index', compact('incidents', 'admins'));
    }

    public function updateStatus(Request $request, Incident $incident)
    {
        $request->validate([
            'status' => 'required|in:Open,In Progress,Resolved',
        ]);

        $incident->update(['status' => $request->status]);

        return back()->with('success', 'Status updated.');
    }

    public function assign(Request $request, Incident $incident)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $incident->update(['assigned_to' => $request->assigned_to]);

        return back()->with('success', 'Incident assigned.');
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'incident_ids' => 'required|array',
            'status' => 'required|in:Open,In Progress,Resolved',
        ]);

        Incident::whereIn('id', $request->incident_ids)->update(['status' => $request->status]);

        return back()->with('success', 'Incidents updated.');
    }
}
