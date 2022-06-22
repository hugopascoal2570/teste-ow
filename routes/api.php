<?php

use App\Http\Controllers\Api\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::post('/auth', [AuthController::class, 'auth']);
//Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
//Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');


Route::apiResource('users', UsersController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
