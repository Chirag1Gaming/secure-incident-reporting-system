@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Incidents</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filters --}}
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <select name="status" class="form-control">
                <option value="">-- Status --</option>
                <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
                <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="category" class="form-control">
                <option value="">-- Category --</option>
                <option value="Phishing" {{ request('category') == 'Phishing' ? 'selected' : '' }}>Phishing</option>
                <option value="Malware" {{ request('category') == 'Malware' ? 'selected' : '' }}>Malware</option>
                <option value="Unauthorized Access" {{ request('category') == 'Unauthorized Access' ? 'selected' : '' }}>Unauthorized Access</option>
                <option value="Ransomware" {{ request('category') == 'Ransomware' ? 'selected' : '' }}>Ransomware</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="priority" class="form-control">
                <option value="">-- Priority --</option>
                <option value="Low" {{ request('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                <option value="Medium" {{ request('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                <option value="High" {{ request('priority') == 'High' ? 'selected' : '' }}>High</option>
            </select>
        </div>
        <div class="col-md-3 d-flex">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    {{-- Bulk Update Form --}}
    <form method="POST" action="{{ route('admin.incidents.bulkUpdate') }}">
        @csrf

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th><input type="checkbox" id="check-all"></th>
                        <th>Title</th>
                        <th>User</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($incidents as $incident)
                        <tr>
                            <td><input type="checkbox" name="incident_ids[]" value="{{ $incident->id }}"></td>
                            <td>{{ $incident->title }}</td>
                            <td>{{ $incident->user->name }}</td>
                            <td>{{ $incident->category }}</td>
                            <td>{{ $incident->priority }}</td>
                            <td>{{ $incident->status }}</td>
                            <td>{{ $incident->assigned_to ? $incident->assignedTo->name : 'Unassigned' }}</td>
                            <td>{{ $incident->created_at->format('Y-m-d') }}</td>
                            <td>
                                {{-- Update Status --}}
                                <form method="POST" action="{{ route('admin.incidents.updateStatus', $incident->id) }}" class="d-inline">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                        <option value="Open" {{ $incident->status == 'Open' ? 'selected' : '' }}>Open</option>
                                        <option value="In Progress" {{ $incident->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="Resolved" {{ $incident->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                    </select>
                                </form>

                                {{-- Assign Admin --}}
                                <form method="POST" action="{{ route('admin.incidents.assign', $incident->id) }}" class="mt-2">
                                    @csrf
                                    <select name="assigned_to" onchange="this.form.submit()" class="form-select form-select-sm">
                                        <option value="">-- Assign --</option>
                                        @foreach($admins as $admin)
                                            <option value="{{ $admin->id }}" {{ $incident->assigned_to == $admin->id ? 'selected' : '' }}>
                                                {{ $admin->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center">No incidents found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Bulk Status Update --}}
        <div class="row g-2 mt-3">
            <div class="col-md-4">
                <select name="status" class="form-select" required>
                    <option value="">-- Bulk Change Status --</option>
                    <option value="Open">Open</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Resolved">Resolved</option>
                </select>
            </div>
            <div class="col-md-4">
                <button class="btn btn-success" type="submit">Update Selected</button>
            </div>
        </div>
    </form>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $incidents->withQueryString()->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('check-all').addEventListener('change', function () {
        let checkboxes = document.querySelectorAll('input[name="incident_ids[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>
@endpush
