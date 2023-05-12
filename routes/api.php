<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/data', function () {


});
Route::middleware(['auth','api'])->group(function (){
    Route::get('/students',[\App\Http\Controllers\APIDataController::class,'getStudent']);
    Route::get('/student/{id}',[\App\Http\Controllers\APIDataController::class,'']);
    Route::post('/student',[\App\Http\Controllers\APIDataController::class,'']);
    Route::delete('/student',[\App\Http\Controllers\APIDataController::class,'']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
