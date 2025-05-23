@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Incidents</h2>

    <a href="{{ route('user.incidents.create') }}" class="btn btn-primary mb-3">Report New Incident</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Submitted At</th>
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
                </tr>
            @empty
                <tr>
                    <td colspan="5">No incidents submitted yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
