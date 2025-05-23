@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Audit Logs</h2>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Model</th>
                    <th>Record ID</th>
                    <th>IP Address</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $log->user->name ?? 'System' }}</td>
                        <td><span class="badge bg-info">{{ ucfirst($log->action) }}</span></td>
                        <td>{{ class_basename($log->auditable_type) }}</td>
                        <td>{{ $log->auditable_id }}</td>
                        <td>{{ $log->ip_address }}</td>
                        <td>
                            @if($log->data)
                                <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#logModal{{ $log->id }}">View</button>

                                <!-- Modal -->
                                <div class="modal fade" id="logModal{{ $log->id }}" tabindex="-1">
                                  <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title">Log Data (ID: {{ $log->id }})</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                      </div>
                                      <div class="modal-body">
                                        <pre>{{ json_encode($log->data, JSON_PRETTY_PRINT) }}</pre>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">No logs found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $logs->links() }}
</div>
@endsection
