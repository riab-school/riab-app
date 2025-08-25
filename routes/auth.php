<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'handleLogin'])->name('login.action');

Route::get('logout', function (Request $request) {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('splash');
})->name('logout');
Route::middleware('auth')->group(function () {
});

Route::middleware('guest')->group(function () {
    Route::get('register/student', [RegisterController::class, 'showRegisterPageStudent'])->name('register.student');
    Route::post('register/student', [RegisterController::class, 'handleRegisterStudent'])->name('register.student.action');

    Route::get('register/parent', [RegisterController::class, 'showRegisterPageParent'])->name('register.parent');
    Route::post('register/parent', [RegisterController::class, 'handleRegisterParent'])->name('register.parent.action');

    Route::get('forgot-password', [ForgotPasswordController::class, 'showPageForgotPassword'])->name('forgot-password');
    Route::post('forgot-password', [ForgotPasswordController::class, 'handleForgotPassword'])->name('forgot-password.action');

    Route::get('reset-password', [ResetPasswordController::class, 'showPageResetPassword'])->name('reset-password');
    Route::post('reset-password', [ResetPasswordController::class, 'handleResetPassword'])->name('reset-password.action');
});