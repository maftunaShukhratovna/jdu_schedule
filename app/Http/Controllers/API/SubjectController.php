<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $subjects = Subject::when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', "%{$request->search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return response()->json($subjects);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:subjects']);
        $subject = Subject::create($request->only('name'));
        return response()->json($subject, 201);
    }

    public function show($id)
    {
        return response()->json(Subject::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->update($request->only('name'));
        return response()->json($subject);
    }

    public function destroy($id)
    {
        Subject::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}