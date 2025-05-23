<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Notifications\IncidentStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class IncidentController extends Controller
{
    public function index()
    {
        $user = Auth::user();


        Gate::authorize('viewAny', Incident::class);
        if ($user->hasRole('User')) {
            $incidents = Incident::where('user_id', $user->id)->latest()->paginate(10);
        } else if ($user->hasAnyRole(['Admin', 'Super Admin'])) {
            $incidents = Incident::latest()->paginate(20);
        } else {
            abort(403);
        }

        return view('incidents.index', compact('incidents'));
    }

    public function create()
    {
        return view('incidents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'priority' => 'required|string',
            'evidence' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $incident = new Incident();
        $incident->title = $request->title;
        $incident->description = $request->description;
        $incident->category = $request->category;
        $incident->priority = $request->priority;
        $incident->status = 'Open'; // default status

        // assign the authenticated user's ID here:
        $incident->user_id = Auth::id();

        if ($request->hasFile('evidence')) {
            $path = $request->file('evidence')->store('evidences', 'public');
            $incident->evidence_path = $path;
        }

        $incident->save();

        $incident->user->notify(new IncidentStatusUpdated($incident));

        return redirect()->route('incidents.index')->with('success', 'Incident reported successfully!');
    }

    public function show(Incident $incident)
    {
        $this->authorize('view', $incident); // policy protects access

        return view('incidents.show', compact('incident'));
    }
}
