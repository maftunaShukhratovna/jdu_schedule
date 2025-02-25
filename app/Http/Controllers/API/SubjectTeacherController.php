<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupTeacherController extends Controller
{
    public function store(Request $request)
    {
        $validator = $request->validate([
            'group_id' => 'required|integer|exists:groups,id',
            'teacher_id' => 'required|integer|exists:teachers,id',
        ]);

        $group = Group::findOrFail($validator['group_id']);
        $group->teachers()->attach($validator['teacher_id']);

        return response()->json(['message' => 'Teacher added to group']);
    }

    public function update(Request $request)
    {
        $validator = $request->validate([
            'group_id' => 'required|integer|exists:groups,id',
            'teacher_id' => 'required|integer|exists:teachers,id',
        ]);

        $group = Group::findOrFail($validator['group_id']);
        $group->teachers()->sync($validator['teacher_id']);

        return response()->json(['message' => 'Teacher updated in group']);
    }

    public function destroy(string $id, Request $request)
    {
        $validator = $request->validate([
            'group_id' => 'required|integer|exists:groups,id',
        ]);

        $group = Group::findOrFail($validator['group_id']);
        $group->teachers()->detach($id);

        return response()->json(['message' => 'Teacher removed from group']);
    }
}

