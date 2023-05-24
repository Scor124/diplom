<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\APIDataController;

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
        Route::get('students',[APIDataController::class,'getStudents']);
        Route::get('student/{id}',[APIDataController::class,'getStudent']);
        Route::put('student/update/{id}',[APIDataController::class,'updateStudent']);
        Route::post('student/create',[APIDataController::class,'createStudent']);
        Route::delete('student/delete/{id}',[APIDataController::class,'deleteStudent']);
        Route::get('teachers',[APIDataController::class,'getTeachers']);
        Route::get('teachers/{id}',[APIDataController::class,'getTeacher']);
        Route::put('teachers/update/{id}',[APIDataController::class,'updateTeacher']);
        Route::post('teachers/create',[APIDataController::class,'createTeacher']);
        Route::delete('teachers/delete/{id}',[APIDataController::class,'deleteTeacher']);
        Route::get('users',[APIDataController::class,'getUsers']);
        Route::get('users/{id}',[APIDataController::class,'getUser']);
        Route::put('users/update/{id}',[APIDataController::class,'updateUser']);
        Route::post('users/create',[APIDataController::class,'createUser']);
        Route::delete('users/delete/{id}',[APIDataController::class,'deleteUser']);

    //});

    Route::get('classes', [APIDataController::class, 'getClasses']);
});
Route::middleware(['auth','api'])->get('/thisuser',function (Request $request){
    return response()->json(Auth::user());
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
