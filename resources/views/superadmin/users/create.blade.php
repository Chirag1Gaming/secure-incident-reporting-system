@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New User</h2>

    <form method="POST" action="{{ route('superadmin.users.store') }}">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="">-- Select Role --</option>
                @foreach($roles as $role)
                    <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>{{ $role }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Create User</button>
        <a href="{{ route('superadmin.users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
