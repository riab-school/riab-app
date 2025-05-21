<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Parent\AnandakuController;
use App\Http\Controllers\Parent\BeritaController;
use App\Http\Controllers\Parent\PerizinanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'homePageParent'])->name('parent.home');

Route::get('settings', function () {
    return view('app.parent.settings');
})->name('parent.settings');

Route::prefix('berita')->group(function() {
    Route::get('/', [BeritaController::class, 'showPage'])->name('parent.berita');
    Route::get('get', [BeritaController::class, 'getBerita'])->name('parent.berita.get');
});

Route::prefix('anandaku')->group(function() {
    Route::get('/', [AnandakuController::class, 'showPage'])->name('parent.anandaku');
    Route::post('find', [AnandakuController::class, 'findStudentData'])->name('parent.anandaku.find');
    Route::post('pair', [AnandakuController::class, 'pairingStudentWithParent'])->name('parent.anandaku.pair');
});

Route::prefix('perizinan')->group(function() {
    Route::get('/', [PerizinanController::class, 'showPage'])->name('parent.perizinan');
    Route::get('get-history', [PerizinanController::class, 'getHistory'])->name('parent.perizinan.history');
    Route::get('request', [PerizinanController::class, 'showPageRequestPermission'])->name('parent.perizinan.request');
    Route::post('request', [PerizinanController::class, 'handleRequestPermission'])->name('parent.perizinan.handle');
});

