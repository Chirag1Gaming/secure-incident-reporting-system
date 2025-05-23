@extends('layouts.app')

@section('content')
<div class="container">
    <h2>User Management</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('superadmin.users.create') }}" class="btn btn-primary mb-3">Add New User</a>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role(s)</th>
                    <th>Status</th>
                    <th>Blocked</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->getRoleNames()->join(', ') }}</td>
                        <td>{{ $user->email_verified_at ? 'Verified' : 'Unverified' }}</td>
                        <td>
                            <form method="POST" action="{{ route('superadmin.users.toggleBlock', $user->id) }}">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm {{ $user->is_blocked ? 'btn-success' : 'btn-danger' }}">
                                    {{ $user->is_blocked ? 'Unblock' : 'Block' }}
                                </button>
                            </form>
                        </td>
                        <td class="d-flex gap-2">
                            <a href="{{ route('superadmin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('superadmin.users.destroy', $user->id) }}" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $users->links() }}
</div>
@endsection
