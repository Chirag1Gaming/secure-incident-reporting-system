<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('superadmin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::pluck('name');
        return view('superadmin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'is_blocked' => false,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('superadmin.users.index')->with('success', 'User created.');
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('name');
        return view('superadmin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|exists:roles,name',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->route('superadmin.users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted.');
    }

    public function toggleBlock(User $user)
    {
        $user->update(['is_blocked' => !$user->is_blocked]);
        return back()->with('success', $user->is_blocked ? 'User blocked.' : 'User unblocked.');
    }
}
