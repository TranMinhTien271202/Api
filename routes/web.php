<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\StudentLoginController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\TeacherLoginController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Middleware\CheckLogin;
use App\Http\Middleware\CheckStudentLogin;
use App\Http\Middleware\CheckTeacherLogin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});
Route::middleware([CheckLogin::class])->group(function () {
    Route::resource('user', UserController::class);
    Route::get('auth-logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('auth-profile', [AuthController::class, 'profile'])->name('auth.profile');
    Route::post('auth-profile', [AuthController::class, 'updateProfile'])->name('auth.updateProfile');
});
Route::prefix('student')->group(function () {
    Route::get('/', [StudentLoginController::class, 'index'])->name('student.index');
    Route::post('/', [StudentLoginController::class, 'login'])->name('student.login.post');
    Route::get('register', [StudentLoginController::class, 'register'])->name('student.register');
    Route::post('register', [StudentLoginController::class, 'registerPost'])->name('student.register.post');
    Route::middleware([CheckStudentLogin::class])->group(function () {
        Route::get('/student', [TeacherLoginController::class, 'index'])->name('student.student');
        Route::get('logout', [StudentLoginController::class, 'logout'])->name('student.logout');
    });
});
Route::prefix('teacher')->group(function () {
    Route::get('/', [TeacherLoginController::class, 'index'])->name('teacher.index');
    Route::post('/', [TeacherLoginController::class, 'login'])->name('teacher.login');
    Route::get('/register', [TeacherLoginController::class, 'register'])->name('teacher.register');
    Route::post('/register', [TeacherLoginController::class, 'registerPost'])->name('teacher.register.post');
    Route::post('/1', [TeacherLoginController::class, 'registerPost1'])->name('teacher.register.1');
    Route::middleware([CheckTeacherLogin::class])->group(function () {
        Route::get('logout', [TeacherLoginController::class, 'logout'])->name('teacher.logout');
        Route::resource('subject', SubjectController::class);
        Route::get('teacher-profile', [TeacherController::class, 'profile'])->name('teacher.profile');
        Route::post('teacher-profile', [TeacherController::class, 'profilePost'])->name('teacher.profile.post');
    });
});
Route::get('auth', [AuthController::class, 'index'])->name('auth.index');
Route::post('auth-login', [AuthController::class, 'login'])->name('auth.login');
Route::get('auth-register', [AuthController::class, 'register'])->name('auth.register');
Route::post('auth-register', [AuthController::class, 'store'])->name('auth.store');
