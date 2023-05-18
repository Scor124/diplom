<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ProfileController;
use Auth;
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

    //Route::middleware('is-verified')->group(function (){
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard',[
                'isTeacher' => Auth::user()->is_teacher,
                'isVerified' => Auth::user()->is_verified
            ]);
        })->name('dashboard');
        Route::get('/marks',function (){
            return Inertia::render('MarksPage');
        })->name('marks');
        Route::get('/classes',function (){
            return DB::table('classes')->get();
        })->name('classes');
    //});

    //Route::middleware(['is-admin'])->group(function (){
        Route::get('/admin/students',function (){
            return Inertia::render('Admin/StudentsPage');
        })->name('admin.students');
        Route::get('/admin/users',function (){
            return Inertia::render('Admin/UsersPage');
        })->name('admin.users');
        Route::get('/admin/classes',function (){
            return Inertia::render('Admin/ClassesPage');
        })->name('admin.classes');
    //});
    Route::get('/mymarks',function (){
        return Inertia::render('MyMarks');
    })->name('mymarks');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
