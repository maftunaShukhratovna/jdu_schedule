<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteGroupSubjectRequest;
use App\Http\Requests\StoreGroupSubjectRequest;
use App\Http\Requests\UpdateGroupSubjectRequest;
use App\Models\Group;


class GroupSubjectController extends Controller
{
    public function store(StoreGroupSubjectRequest $request)
    {
        $validator = $request->validated();

        $group = Group::findOrFail($validator['group_id']);
        $group->subjects()->attach($validator['subject_id']);

        return response()->json(['message' => 'Subject added to group']);
    }

    public function update(UpdateGroupSubjectRequest $request)
    {
        $validator = $request->validated();

        $group = Group::findOrFail($validator['group_id']);
        $group->subjects()->sync($validator['subject_id']);

        return response()->json(['message' => 'Subject updated in group']);
    }

    public function destroy(string $id, DeleteGroupSubjectRequest $request)
    {
        $validator = $request->validated();

        $group = Group::findOrFail($validator['group_id']);
        
        $group->subjects()->detach($id);

        return response()->json(['message' => 'Subject removed from group']);
    }
}
