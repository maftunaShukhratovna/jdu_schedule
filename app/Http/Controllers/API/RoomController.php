<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Room;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $groups = Room::when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', "%{$request->search}%");
            })->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return response()->json($groups);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:groups']);
        $group = Room::create($request->only('name'));
        return response()->json($group, 201);
    }

    public function show($id)
    {
        return response()->json(Room::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $group = Room::findOrFail($id);
        $group->update($request->only('name'));
        return response()->json($group);
    }

    public function destroy($id)
    {
        Room::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

}