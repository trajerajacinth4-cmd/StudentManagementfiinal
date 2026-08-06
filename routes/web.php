<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\AttendanceController;

// Public Welcome Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Guest Routes (Accessible only when logged out)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Authenticated Routes (Protected)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CSV Import / Export & Bulk Routes
    Route::get('students/download-pdf', [StudentController::class, 'downloadPdf'])->name('students.pdf');
    Route::get('students/export-csv', [StudentController::class, 'exportCsv'])->name('students.export-csv');
    Route::post('students/import-csv', [StudentController::class, 'importCsv'])->name('students.import-csv');
    Route::post('students/bulk-delete', [StudentController::class, 'bulkDelete'])->name('students.bulk-delete');
    Route::post('students/bulk-promote', [StudentController::class, 'bulkPromote'])->name('students.bulk-promote');
    Route::get('students/honor-roll', [StudentController::class, 'honorRoll'])->name('students.honor-roll');
    Route::get('students/{student}/profile-pdf', [StudentController::class, 'profilePdf'])->name('students.profile-pdf');

    // Resource routes for Students & Courses
    Route::resource('students', StudentController::class);
    Route::resource('courses', CourseController::class);

    // Academic Management
    Route::resource('subjects', SubjectController::class);
    Route::resource('semesters', SemesterController::class);
    Route::post('semesters/{semester}/activate', [SemesterController::class, 'setActive'])->name('semesters.activate');
    Route::resource('enrollments', EnrollmentController::class)->except(['show', 'edit', 'update']);
    Route::resource('grades', GradeController::class);
    Route::resource('attendance', AttendanceController::class)->only(['index', 'create', 'store', 'update']);

    // Audit Logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});