@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Incidents</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('incidents.create') }}" class="btn btn-primary mb-3">Report New Incident</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Reported On</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($incidents as $incident)
            <tr>
                <td>{{ $incident->title }}</td>
                <td>{{ $incident->category }}</td>
                <td>{{ $incident->priority }}</td>
                <td>{{ $incident->status }}</td>
                <td>{{ $incident->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('incidents.show', $incident) }}" class="btn btn-sm btn-info">View</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">No incidents found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $incidents->links() }}
</div>
@endsection
