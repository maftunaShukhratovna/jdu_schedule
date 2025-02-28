<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function store(StoreScheduleRequest $request)
    {
        $validator=$request->validated();
        $schedule = Schedule::query()->where('group_id', $validator['group_id'])
            ->where('subject_id', $validator['subject_id'])
            ->where('teacher_id', $validator['teacher_id'])
            ->where('room_id', $validator['room_id'])
            ->where('pair', $validator['pair'])
            ->where('week_day', $validator['week_day'])
            ->where('date', $validator['date'])
            ->first();
        
        Schedule::create($validator);
        return response()->json($schedule, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
