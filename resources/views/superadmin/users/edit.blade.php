@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit User</h2>

    <form method="POST" action="{{ route('superadmin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $user->name) }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email', $user->email) }}">
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="">-- Select Role --</option>
                @foreach($roles as $role)
                    <option value="{{ $role }}" {{ $user->hasRole($role) ? 'selected' : '' }}>{{ $role }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">Update User</button>
        <a href="{{ route('superadmin.users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
