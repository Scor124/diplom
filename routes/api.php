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
// 'auth'
Route::middleware(['api'])->group(function (){
    //Route::middleware('is-admin')->group(function (){
        Route::get('/students',[\App\Http\Controllers\APIDataController::class,'getStudents']);
        Route::get('/student/{id}',[\App\Http\Controllers\APIDataController::class,'getStudent']);
        Route::post('/student/update/{id}',[\App\Http\Controllers\APIDataController::class,'updateStudent']);
        Route::post('/student/create',[\App\Http\Controllers\APIDataController::class,'createStudent']);
        Route::delete('/student/delete/{id}',[\App\Http\Controllers\APIDataController::class,'deleteStudent']);
        Route::get('/teachers',[\App\Http\Controllers\APIDataController::class,'getTeachers']);
        Route::get('/teachers/{id}',[\App\Http\Controllers\APIDataController::class,'getTeacher']);
        Route::post('/teachers/update/{id}',[\App\Http\Controllers\APIDataController::class,'updateTeacher']);
        Route::post('/teachers/create',[\App\Http\Controllers\APIDataController::class,'createTeacher']);
        Route::delete('/teachers/delete/{id}',[\App\Http\Controllers\APIDataController::class,'deleteTeacher']);
        Route::get('/users',[\App\Http\Controllers\APIDataController::class,'getUsers']);
        Route::get('/users/{id}',[\App\Http\Controllers\APIDataController::class,'getUser']);
        Route::put('/users/update/{id}',[\App\Http\Controllers\APIDataController::class,'updateUser']);
        Route::post('/users/create',[\App\Http\Controllers\APIDataController::class,'createUser']);
        Route::delete('/users/delete/{id}',[\App\Http\Controllers\APIDataController::class,'deleteUser']);

    //});

    Route::get('/classes', [\App\Http\Controllers\APIDataController::class, 'getClasses']);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
