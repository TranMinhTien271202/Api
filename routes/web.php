<?php

use App\Http\Controllers\admin\AddstudentController;
use App\Http\Controllers\admin\ARoomController;
use App\Http\Controllers\admin\ASemesterController;
use App\Http\Controllers\admin\AStudentController;
use App\Http\Controllers\admin\ASubjectController;
use App\Http\Controllers\admin\ATeacherController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\StudentLoginController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\TeacherLoginController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomStudentController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\student\SendPointController;
use App\Http\Controllers\student\SPointController;
use App\Http\Controllers\student\SRoomController;
use App\Http\Controllers\student\SStudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SyntheController;
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
Route::prefix('admin')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('auth.index');
    Route::post('auth-login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('auth-register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('auth-register', [AuthController::class, 'store'])->name('auth.store');
    Route::middleware([CheckLogin::class])->group(function () {
        Route::resource('user', UserController::class);
        Route::get('auth-logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('auth-profile', [AuthController::class, 'profile'])->name('auth.profile');
        Route::post('auth-profile', [AuthController::class, 'updateProfile'])->name('auth.updateProfile');
        Route::resource('admin-room', ARoomController::class);
        Route::resource('admin-subject', ASubjectController::class);
        Route::resource('admin-semester', ASemesterController::class);
        Route::resource('admin-student', AStudentController::class);
        Route::resource('admin-teacher', ATeacherController::class);
        Route::get('admin-add-student', [AddstudentController::class, 'index'])->name('admin.addStudent');
        Route::post('admin-add-student', [AddstudentController::class, 'store'])->name('admin.addStudent.store');
    });
});
Route::prefix('student')->group(function () {
    Route::get('/', [StudentLoginController::class, 'index'])->name('student.index');
    Route::post('login', [StudentLoginController::class, 'login'])->name('student.login.post');
    Route::get('register', [StudentLoginController::class, 'register'])->name('student.register');
    Route::post('register', [StudentLoginController::class, 'registerPost'])->name('student.register.post');
    Route::middleware([CheckStudentLogin::class])->group(function () {
        Route::get('dashboard', [StudentLoginController::class, 'dashboard'])->name('student.dashboard');
        Route::get('student-user/{id}', [SStudentController::class, 'student'])->name('student-user.user');
        Route::get('student-point/{id}', [SPointController::class, 'point'])->name('student-point.point');
        Route::get('logout', [StudentLoginController::class, 'logout'])->name('student.logout');
        Route::get('student-room', [SRoomController::class, 'index'])->name('student-room.index');
        Route::get('student-point', [SPointController::class, 'index'])->name('student-point.index');
        Route::get('student-mail', [SendPointController::class, 'view'])->name('student-mail.view');
        Route::get('send-point', [SendPointController::class, 'index'])->name('send-point.index');
    });
});
Route::prefix('teacher')->group(function () {
    Route::get('/', [TeacherLoginController::class, 'index'])->name('teacher.index');
    Route::post('/', [TeacherLoginController::class, 'login'])->name('teacher.login');
    Route::get('/register', [TeacherLoginController::class, 'register'])->name('teacher.register');
    Route::post('/register', [TeacherLoginController::class, 'registerPost'])->name('teacher.register.post');
    Route::middleware([CheckTeacherLogin::class])->group(function () {
        Route::get('logout', [TeacherLoginController::class, 'logout'])->name('teacher.logout');
        Route::resource('subject', SubjectController::class);
        Route::resource('room', RoomController::class);
        Route::resource('point', PointController::class);
        Route::resource('semester', SemesterController::class);
        Route::resource('room-student', RoomStudentController::class);
        Route::get('teacher-profile', [TeacherController::class, 'profile'])->name('teacher.profile');
        Route::post('teacher-profile', [TeacherController::class, 'profilePost'])->name('teacher.profile.post');

        Route::get('syn', [SyntheController::class, 'index'])->name('syn.index');
        Route::get('syn-room/{id}', [SyntheController::class, 'room'])->name('syn.room');
        Route::get('syn-student/{id}', [SyntheController::class, 'student'])->name('syn.student');
    });
});
