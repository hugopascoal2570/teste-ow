<?php

use App\Http\Controllers\Api\MovementUserController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::post('/auth', [AuthController::class, 'auth']);
//Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
//Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');


//register users

//Route::get('/register',[RegisterController::class,'index']);
Route::post('/register',[RegisterController::class,'store']);

//users view
Route::get('/users', [UsersController::class,'index']);
Route::post('/user/{id}',[UsersController::class,'show']);

//users delete
Route::delete('/user/delete/{id}',[UsersController::class,'destroy']);

//type movement x user 
Route::post('/user/{user_id}/movement/{movement_id}/insert',[MovementUserController::class,'insertUserMovement']);

//history with all users movement
Route::get('/movements/user',[MovementUserController::class,'showUserMovement']);

Route::delete('/type/movement/{movement_id}/delete',[MovementUserController::class,'dettachMovementAndUserRelation']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
