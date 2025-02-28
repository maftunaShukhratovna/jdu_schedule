<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteSubjectTeacherRequest;
use App\Http\Requests\StoreSubjectTeacherRequest;
use App\Http\Requests\UpdateSubjectTeacherRequest;
use App\Models\Group;

class SubjectTeacherController extends Controller
{
    public function store(StoreSubjectTeacherRequest $request)
    {
        $validator = $request->validated();

        $group = Group::findOrFail($validator['group_id']);
        $group->teachers()->attach($validator['teacher_id']);

        return response()->json(['message' => 'Teacher added to group']);
    }

    public function update(UpdateSubjectTeacherRequest $request)
    {
        $validator = $request->validated();

        $group = Group::findOrFail($validator['group_id']);
        $group->teachers()->sync($validator['teacher_id']);

        return response()->json(['message' => 'Teacher updated in group']);
    }

    public function destroy(string $id, DeleteSubjectTeacherRequest $request)
    {
        $validator = $request->validated();

        $group = Group::findOrFail($validator['group_id']);
        $group->teachers()->detach($id);

        return response()->json(['message' => 'Teacher removed from group']);
    }
}

