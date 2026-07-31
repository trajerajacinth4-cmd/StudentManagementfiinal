<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;

// Guest Routes (Accessible only when logged out)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Authenticated Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('students.index');
    });

    Route::get('students/download-pdf', [StudentController::class, 'downloadPdf'])->name('students.pdf');
    Route::resource('students', StudentController::class);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});