<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRoleUserRequest;
use App\Http\Requests\StoreRoleUserRequest;
use App\Http\Requests\UpdateRoleUserRequest;
use App\Models\User;

class RoleUserController extends Controller
{
    public function index()
    {
        return response()->json(User::with('roles')->get());
    }
    public function store(StoreRoleUserRequest $request)
    {
        $validator = $request->validated();

        $user = User::findOrFail($validator['user_id']);
        $user->roles()->attach($validator['role_id']);

        return response()->json(['message' => 'Role assigned to user successfully.']);
    }

    public function update(UpdateRoleUserRequest $request, string $id)
    {
        $validator = $request->validated();

        $user = User::findOrFail($id);
        $user->roles()->sync($validator['role_id']);

        return response()->json(['message' => 'User roles updated successfully.']);
    }

    public function destroy(DeleteRoleUserRequest $request, string $id)
    {
        $validator = $request->validated();

        $user = User::findOrFail($id);
        $user->roles()->detach($validator['role_id']);

        return response()->json(['message' => 'User role removed successfully.']);
    }
}
