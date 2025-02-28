<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Group;

use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $groups = Group::when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', "%{$request->search}%");
            })->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return response()->json($groups);
    }

    public function store(StoreGroupRequest $request)
    {
        $validator=$request->validated();
        $group = Group::create($validator['name']);
        return response()->json($group, 201);
    }

    public function show($id)
    {
        return response()->json(Group::findOrFail($id));
    }

    public function update(UpdateGroupRequest $request, $id)
    {
        $validator=$request->validated();
        $group = Group::findOrFail($id);
        $group->update($validator['name']);
        return response()->json($group);
    }

    public function destroy($id)
    {
        Group::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

}
