<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GroupController;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\SubjectController;



Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);



Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::prefix('room')->group(function () {
    Route::post('/', [RoomController::class, 'store']); 
    Route::get('/', [RoomController::class, 'index']); 
    Route::get('/{id}', [RoomController::class, 'show']); 
    Route::put('/{id}', [RoomController::class, 'update']); 
    Route::delete('/{id}', [RoomController::class, 'destroy']);    
});

Route::prefix('subject')->group(function () {
    Route::post('/', [SubjectController::class, 'store']); 
    Route::get('/', [SubjectController::class, 'index']); 
    Route::get('/{id}', [SubjectController::class, 'show']); 
    Route::put('/{id}', [SubjectController::class, 'update']); 
    Route::delete('/{id}', [SubjectController::class, 'destroy']);    
});


Route::prefix('group')->group(function () {
    Route::post('/', [GroupController::class, 'store']); 
    Route::get('/', [GroupController::class, 'index']); 
    Route::get('/{id}', [GroupController::class, 'show']); 
    Route::put('/{id}', [GroupController::class, 'update']); 
    Route::delete('/{id}', [GroupController::class, 'destroy']);    
});




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
