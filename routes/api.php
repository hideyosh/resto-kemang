<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API routes dengan middleware 'api' (stateless, JSON)
Route::middleware('api')->group(function () {
    // Menu API
    Route::get('/menu', [MenuController::class, 'api']);
    Route::post('/menu', [MenuController::class, 'storeApi']);
    Route::get('/menu/{id}', [MenuController::class, 'show']);
    Route::put('/menu/{id}', [MenuController::class, 'update']);
    Route::delete('/menu/{id}', [MenuController::class, 'destroy']);
});
