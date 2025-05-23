@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Admin Dashboard</h2>

    <div class="mb-4">
        <h4>Analytics</h4>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <h5>Total Incidents</h5>
                    <h3>{{ $totalIncidents }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <h5>Open vs Resolved</h5>
                    <canvas id="statusPieChart"></canvas>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <h5>Most Common Categories</h5>
                    <canvas id="categoryBarChart"></canvas>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <h5>Avg Resolution Time (hrs)</h5>
                    <h3>{{ number_format($avgResolution ?? 0, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <h4>Incident Filters</h4>
    <form method="GET" class="mb-3">
        <div class="row g-2">
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
                    <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    <option value="Phishing" {{ request('category') == 'Phishing' ? 'selected' : '' }}>Phishing</option>
                    <option value="Malware" {{ request('category') == 'Malware' ? 'selected' : '' }}>Malware</option>
                    <option value="Ransomware" {{ request('category') == 'Ransomware' ? 'selected' : '' }}>Ransomware</option>
                    <option value="Unauthorized Access" {{ request('category') == 'Unauthorized Access' ? 'selected' : '' }}>Unauthorized Access</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Clear</a>
            </div>
        </div>
    </form>

    <h4>Incidents</h4>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAll"></th>
                <th>Title</th>
                <th>User</th>
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
                <td><input type="checkbox" class="incident-checkbox" value="{{ $incident->id }}"></td>
                <td>{{ $incident->title }}</td>
                <td>{{ $incident->user->name }}</td>
                <td>{{ $incident->category }}</td>
                <td>{{ $incident->priority }}</td>
                <td>{{ $incident->status }}</td>
                <td>{{ $incident->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('incidents.show', $incident) }}" class="btn btn-sm btn-info">View</a>
                    <!-- Add more admin actions here -->
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center">No incidents found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $incidents->withQueryString()->links() }}
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const statusCounts = @json($statusCounts);
    const categoryCounts = @json($categoriesCounts);

    // Pie chart for status
    const ctxPie = document.getElementById('statusPieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: Object.keys(statusCounts),
            datasets: [{
                label: 'Incidents by Status',
                data: Object.values(statusCounts),
                backgroundColor: ['#f6c23e', '#4e73df', '#1cc88a'],
            }]
        }
    });

    // Bar chart for categories
    const ctxBar = document.getElementById('categoryBarChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: Object.keys(categoryCounts),
            datasets: [{
                label: 'Incidents by Category',
                data: Object.values(categoryCounts),
                backgroundColor: '#36b9cc',
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Select/Deselect all checkboxes
    document.getElementById('selectAll').addEventListener('change', function(){
        document.querySelectorAll('.incident-checkbox').forEach(cb => cb.checked = this.checked);
    });
</script>
@endsection
