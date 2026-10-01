<?php

use App\http\Controllers\NoteController;
use App\http\Controllers\TagController;
use App\http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// User routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);

    // Note routes

    Route::post('/notes', [NoteController::class, 'create']);
    Route::get('/notes', [NoteController::class, 'getAll']);
    Route::get('/notes/{id}', [NoteController::class, 'getOneById']);
    Route::put('/notes/{id}', [NoteController::class, 'update']);
    Route::delete('/notes/{id}', [NoteController::class, 'delete']);

    // Tag routes

    Route::post('/tags', [TagController::class, 'create']);
    Route::get('/tags', [TagController::class, 'getAll']);
    Route::get('/tags/{id}', [TagController::class, 'getOneById']);
    Route::put('/tags/{id}', [TagController::class, 'update']);
    Route::delete('/tags/{id}', [TagController::class, 'delete']);
});