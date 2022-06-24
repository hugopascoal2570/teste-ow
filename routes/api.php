<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\BalanceController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth', [AuthController::class, 'auth']);

//Route::get('/register',[RegisterController::class,'index']);
Route::post('/register',[RegisterController::class,'store']);

Route::middleware(['auth:sanctum'])->group(function(){

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//view all users
Route::get('/users', [UsersController::class,'index']);
//view users by id
Route::post('/user/{id}',[UsersController::class,'show']);

//users delete
Route::delete('/user/delete/{id}',[UsersController::class,'destroy']);

//Route::any('historic-search', 'BalanceController@searchHistoric')->name('historic.search');
Route::get('/historic', [BalanceController::class,'historic'])->name('historic');

//deposito
Route::post('/deposit/{value}', [BalanceController::class,'deposit']);

//débito
Route::post('/debit/{value}', [BalanceController::class,'debit']);

//delete
Route::delete('/delete/{id}', [BalanceController::class,'deleteBalance']);

});

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/