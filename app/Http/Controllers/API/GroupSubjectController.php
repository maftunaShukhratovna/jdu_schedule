<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupSubjectController extends Controller
{
    public function store(Request $request)
    {
        $validator = $request->validate([
            'group_id' => 'required|integer|exists:groups,id',
            'subject_id' => 'required|integer|exists:subjects,id',
        ]);

        $group = Group::findOrFail($validator['group_id']);
        $group->subjects()->attach($validator['subject_id']);

        return response()->json(['message' => 'Subject added to group']);
    }

    public function update(Request $request)
    {
        $validator = $request->validate([
            'group_id' => 'required|integer|exists:groups,id',
            'subject_id' => 'required|integer|exists:subjects,id',
        ]);

        $group = Group::findOrFail($validator['group_id']);
        $group->subjects()->sync($validator['subject_id']);

        return response()->json(['message' => 'Subject updated in group']);
    }

    public function destroy(string $id, Request $request)
    {
        $validator = $request->validate([
            'group_id' => 'required|integer|exists:groups,id',
        ]);

        $group = Group::findOrFail($validator['group_id']);
        $group->subjects()->detach($id);

        return response()->json(['message' => 'Subject removed from group']);
    }
}
