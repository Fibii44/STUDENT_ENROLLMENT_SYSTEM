<?php

use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\EnrollmentController;
use App\Http\Controllers\Student\GradeController;
use App\Http\Controllers\Subject\SubjectController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});




Route::get('/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('dashboard');

Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])
    ->name('dashboardStudent')
    ->middleware('auth');
    

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('enrollments');
    Route::post('/enrollments', [EnrollmentController::class, 'store'])->name('enrollment.store'); 
    Route::get('/enrollments/{enrollment}/edit', [EnrollmentController::class, 'edit'])->name('enrollment.edit');
    Route::patch('/enrollments/{enrollment}', [EnrollmentController::class, 'update'])->name('enrollment.update');
    Route::delete('/enrollments/{enrollment}', [EnrollmentController::class, 'destroy'])->name('enrollment.destroy');


});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware('auth', 'verified', 'role:admin')->group(function () {
    
    Route::get('/students', [StudentController::class, 'index'])->name('students');
    Route::get('/{id}/studentInfo', [StudentController::class, 'showStudentGrades'])->name('student.info');
    Route::post('/students', [StudentController::class, 'store'])->name('student.store'); 
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::patch('/students/{student}', [StudentController::class, 'update'])->name('student.update');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('student.destroy');
    

});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects');
    Route::post('/subjects', [SubjectController::class, 'store'])->name('subject.store'); 
    Route::get('/subjects/{subject}/edit', [SubjectController::class, 'edit'])->name('subject.edit');
    Route::patch('/subjects/{subject}', [SubjectController::class, 'update'])->name('subject.update');
    Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy'])->name('subject.destroy');

});

Route::middleware('auth', 'verified', 'role:admin')->group(function () {
    Route::get('/grades', [GradeController::class, 'index'])->name('grades');
    Route::get('/grades/{student}', [GradeController::class, 'getStudentGrades']);
    Route::patch('/grades/{enrollment}', [GradeController::class, 'update'])->name('grade.update');
    Route::delete('/grades/{grade}', [GradeController::class, 'destroy'])->name('grade.destroy');
});



require __DIR__.'/auth.php';
