<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
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

    public function store(StoreSubjectRequest $request)
    {
        $validator=$request->validated();
        $subject = Subject::create([
            'name' => $validator['name']
        ]);
        return response()->json($subject, 201);
    }

    public function show($id)
    {
        return response()->json(Subject::findOrFail($id));
    }

    public function update(UpdateSubjectRequest $request, $id)
    {
        $validator=$request->validated();
        $subject = Subject::findOrFail($id);
        $subject->update([
            'name' => $validator['name']
        ]);
        return response()->json($subject);
    }

    public function destroy($id)
    {
        Subject::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}