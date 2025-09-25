<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Student\Active\DataDiriController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'homePageStudentActive'])->name('student.home.active');

Route::prefix('data-diri')->group(function () {
    Route::get('/', [DataDiriController::class, 'index'])->name('student.active.data-diri');
    Route::post('page-1', [DataDiriController::class, 'handleStorePage1'])->name('student.active.data-diri.store-page-1');
    Route::post('page-2', [DataDiriController::class, 'handleStorePage2'])->name('student.active.data-diri.store-page-2');
    Route::post('page-3', [DataDiriController::class, 'handleStorePage3'])->name('student.active.data-diri.store-page-3');
    Route::post('page-4', [DataDiriController::class, 'handleStorePage4'])->name('student.active.data-diri.store-page-4');
    Route::post('page-5', [DataDiriController::class, 'handleStorePage5'])->name('student.active.data-diri.store-page-5');
    Route::post('page-6', [DataDiriController::class, 'handleStorePage6'])->name('student.active.data-diri.store-page-6');
});

Route::get('prestasi', function () {
    return view('coming-soon');
})->name('student.active.prestasi');

Route::get('pelanggaran', function () {
    return view('coming-soon');
})->name('student.active.pelanggaran');

Route::get('perizinan', function () {
    return view('coming-soon');
})->name('student.active.perizinan');

Route::get('hafalan-tahfidz', function () {
    return view('coming-soon');
})->name('student.active.hafalan-tahfidz');

Route::get('kesehatan', function () {
    return view('coming-soon');
})->name('student.active.kesehatan');