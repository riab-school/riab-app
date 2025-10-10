<?php

use App\Http\Controllers\Student\New\DashboardController;
use App\Http\Controllers\Student\New\DataDiriController;
use App\Http\Middleware\EnsurePsbPaid;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('student.home.new');



// Wajib Bayar jika reguler atau invited-reguler baru bisa akses data diri dan seterusnya
Route::group(['middleware' => EnsurePsbPaid::class], function () {
    Route::prefix('data-diri')->group(function () {
        Route::get('/', [DataDiriController::class, 'index'])->name('student.new.data-diri');
        Route::post('page-1', [DataDiriController::class, 'handleStorePage1'])->name('student.new.data-diri.store-page-1');
        Route::post('page-2', [DataDiriController::class, 'handleStorePage2'])->name('student.new.data-diri.store-page-2');
        Route::post('page-3', [DataDiriController::class, 'handleStorePage3'])->name('student.new.data-diri.store-page-3');
        Route::post('page-4', [DataDiriController::class, 'handleStorePage4'])->name('student.new.data-diri.store-page-4');
        Route::post('page-5', [DataDiriController::class, 'handleStorePage5'])->name('student.new.data-diri.store-page-5');
        Route::post('page-6', [DataDiriController::class, 'handleStorePage6'])->name('student.new.data-diri.store-page-6');
        Route::post('delete-certificate', [DataDiriController::class, 'handleDeleteCertificate'])->name('student.new.data-diri.delete-certificate');
    });
});

Route::get('test', function () {
    dd([
        'registration_history' => request()->registration_history,
        'registration_method' => request()->registration_method,
    ]);
});