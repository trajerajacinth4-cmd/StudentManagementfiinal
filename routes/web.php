<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ActivityLogController;

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
    // CSV Import / Export & Bulk Routes
    Route::get('students/download-pdf', [StudentController::class, 'downloadPdf'])->name('students.pdf');
    Route::get('students/export-csv', [StudentController::class, 'exportCsv'])->name('students.export-csv');
    Route::post('students/import-csv', [StudentController::class, 'importCsv'])->name('students.import-csv');
    Route::post('students/bulk-delete', [StudentController::class, 'bulkDelete'])->name('students.bulk-delete');
    Route::post('students/bulk-promote', [StudentController::class, 'bulkPromote'])->name('students.bulk-promote');

    // Resource routes for Students & Courses
    Route::resource('students', StudentController::class);
    Route::resource('courses', CourseController::class);

    // Audit Logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});