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
Route::middleware(['auth','api','role'])->group(function (){
    Route::get('/students',[\App\Http\Controllers\APIDataController::class,'getStudents']);
    Route::get('/student/{id}',[\App\Http\Controllers\APIDataController::class,'getStudent']);
    Route::post('/student/update/{id}',[\App\Http\Controllers\APIDataController::class,'updateStudent'])->middleware('role');
    Route::post('/student/create',[\App\Http\Controllers\APIDataController::class,'createStudent'])->middleware('role');
    Route::delete('/student/delete/{id}',[\App\Http\Controllers\APIDataController::class,'deleteStudent'])->middleware('role');
    Route::get('/teachers',[\App\Http\Controllers\APIDataController::class,'getTeachers']);
    Route::get('/teachers/{id}',[\App\Http\Controllers\APIDataController::class,'getTeacher']);
    Route::post('/teachers/update/{id}',[\App\Http\Controllers\APIDataController::class,'updateTeacher'])->middleware('role');
    Route::post('/teachers/create',[\App\Http\Controllers\APIDataController::class,'createTeacher'])->middleware('role');
    Route::delete('/teachers/delete/{id}',[\App\Http\Controllers\APIDataController::class,'deleteTeacher'])->middleware('role');
    Route::get('/users',[\App\Http\Controllers\APIDataController::class,'getUsers']);
    Route::get('/users/{id}',[\App\Http\Controllers\APIDataController::class,'getUser']);
    Route::post('/users/update/{id}',[\App\Http\Controllers\APIDataController::class,'updateUser'])->middleware('role');
    Route::post('/users/create',[\App\Http\Controllers\APIDataController::class,'createUser'])->middleware('role');
    Route::delete('/users/delete/{id}',[\App\Http\Controllers\APIDataController::class,'deleteUser'])->middleware('role');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
