<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route group "api/auth/register" "api/auth/login"
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Route for create message
Route::post('/message', [MessageController::class, 'create']);

// Route for user with auth middleware
Route::middleware('auth')->group(function () {
    Route::patch('/user', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'delete']);
});
