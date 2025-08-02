<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;

class UserManagementController extends Controller
{
    public function index ()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return Inertia::render('Admin/UserManagement', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|array',
            'roles.*' => 'required|string|exists:roles,name',
        ]);
        $user->syncRoles([$request->role]);
        return redirect()->back()->with('message', 'Role Updated');
    }
}
