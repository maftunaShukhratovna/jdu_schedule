<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GroupController;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\SubjectController;
use App\Http\Controllers\API\RoleUserController;
use App\Http\Controllers\API\GroupStudentController;
use App\Http\Controllers\API\GroupSubjectController;
use App\Http\Controllers\API\SubjectTeacherController;
use App\Http\Controllers\API\ScheduleController;



Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);



Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});


Route::resource('room', RoomController::class);
Route::resource('group-student', GroupStudentController::class);
Route::resource('group', GroupController::class);
Route::resource('group-subject', GroupSubjectController::class);
Route::resource('subject', SubjectController::class);
Route::resource('subject-teacher', SubjectTeacherController::class);
Route::resource('role-user', RoleUserController::class);
Route::resource('schedule', ScheduleController::class);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
