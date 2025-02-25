<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    public function index()
    {
        return response()->json(User::with('roles')->get());
    }
    public function store(Request $request)
    {
        $validator = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($validator['user_id']);
        $user->roles()->attach($validator['role_id']);

        return response()->json(['message' => 'Role assigned to user successfully.']);
    }

    public function update(Request $request, string $id)
    {
        $validator = $request->validate([
            'role_id' => 'required|array',
            'role_id.*' => 'exists:roles,id',
        ]);

        $user = User::findOrFail($id);
        $user->roles()->sync($validator['role_id']);

        return response()->json(['message' => 'User roles updated successfully.']);
    }

    public function destroy(Request $request, string $id)
    {
        $validator = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($id);
        $user->roles()->detach($validator['role_id']);

        return response()->json(['message' => 'User role removed successfully.']);
    }
}
