<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\APIDataController;
use App\Http\Controllers\ProfileController;
use App\Models\Student;
use Auth;
use DB;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Auth::routes();

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');
Route::get('/about',function (){
    return redirect('http://og-ti.ru/sveden/common');
})->name('about');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard',[
            'id' => Auth::user()->id,
            'isTeacher' => Auth::user()->is_teacher,
            'isVerified' => Auth::user()->is_verified
        ]);
    })->name('dashboard');
    // Страница ученика
    Route::get('/mymarks',function (){
        return Inertia::render('MyMarks',[
            'user' => Student::where('UserID','=', Auth::user()->id)->first()
        ]);
    })->name('mymarks');
    Route::get('/classes/{id}/subjects', [APIDataController::class, 'getSubjectsOfGroup']);
    Route::post('/marks/byStudentAndDate', [APIDataController::class, 'getMarksBySubjectDateAndStudent']);
    Route::middleware(['is_teacher'])->group(function (){
        // Cтраницы для учителей
        Route::get('/marks',function (){
            return Inertia::render('MarksPage');
        })->name('marks');
        // api для учителей
        Route::get('/classes/{id}/students', [APIDataController::class, 'getStudentsByGroupId']);
        Route::get('/classes', [APIDataController::class, 'getClasses']);
        Route::post('/marksBySubject',[APIDataController::class, 'getMarkBySubjectDate']);
        Route::post('/marks/create', [APIDataController::class,'markAddOrUpdate']);

        // Страницы для администратора
        Route::middleware(['check.user.id'])->group(function (){
            // Страницы администрирования данными и пользователями
            Route::get('/admin/students',function (){
                return Inertia::render('Admin/StudentsPage');
            })->name('admin.students');
            Route::get('/admin/teachers',function (){
                return Inertia::render('Admin/TeachersPage');
            })->name('admin.teachers');
            Route::get('/admin/users',function (){
                return Inertia::render('Admin/UsersPage');
            })->name('admin.users');
            Route::get('/admin/classes',function (){
                return Inertia::render('Admin/ClassesPage');
            })->name('admin.classes');
            Route::get('/admin/classes/{id}/subjects',function ($id){
                if ($id!=null){
                    return Inertia::render('Admin/SubjectsForClass',['groupId' => $id]);
                }
                else return response()->json(['message' => 'Выберите класс']);
            })->name('class.subjects');
            Route::get('/admin/classes/{id}/students',function ($id){
                if ($id!=null){
                    return Inertia::render('Admin/StudentsPage',['groupId' => $id]);
                }
                else return response()->json(['message' => 'Выберите класс']);
            })->name('class.subjects');
            //
            Route::get('/students',[APIDataController::class,'getStudents']);
            Route::get('/student/{id}',[APIDataController::class,'getStudent']);
            Route::put('/student/update/{id}',[APIDataController::class,'updateStudent']);
            Route::post('/student/create',[APIDataController::class,'createStudent']);
            Route::delete('/student/delete/{id}',[APIDataController::class,'deleteStudent']);
            Route::get('/teachers',[APIDataController::class,'getTeachers']);
            Route::get('/teachers/{id}',[APIDataController::class,'getTeacher']);
            Route::put('/teachers/update/{id}',[APIDataController::class,'updateTeacher']);
            Route::post('/teachers/create',[APIDataController::class,'createTeacher']);
            Route::delete('/teachers/delete/{id}',[APIDataController::class,'deleteTeacher']);
            Route::get('/users',[APIDataController::class,'getUsers']);
            Route::get('/users/{id}',[APIDataController::class,'getUser']);
            Route::put('/users/update/{id}',[APIDataController::class,'updateUser']);
            Route::post('/users/create',[APIDataController::class,'createUser']);
            Route::delete('/users/delete/{id}',[APIDataController::class,'deleteUser']);
            Route::get('/classes/{id}', [APIDataController::class, 'getClass']);
            Route::post('/classes/create', [APIDataController::class,'createClass']);
            Route::delete('/classes/delete/{id}', [APIDataController::class, 'deleteClass']);
            Route::get('/subject/marks', [APIDataController::class, 'getMarksFromCurrentSubject']);
            Route::post('/subject/create',[APIDataController::class, 'storeSubject']);
            Route::get('/markses', [APIDataController::class,'getMark']);
        });
    });




    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
