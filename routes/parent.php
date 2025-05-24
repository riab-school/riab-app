<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Parent\AnandakuController;
use App\Http\Controllers\Parent\BeritaController;
use App\Http\Controllers\Parent\CardController;
use App\Http\Controllers\Parent\ChatController;
use App\Http\Controllers\Parent\DocumentController;
use App\Http\Controllers\Parent\KesehatanController;
use App\Http\Controllers\Parent\PelanggaranController;
use App\Http\Controllers\Parent\PerizinanController;
use App\Http\Controllers\Parent\PrestasiController;
use App\Http\Controllers\Parent\ProfileController;
use App\Http\Controllers\Parent\RaportController;
use App\Http\Controllers\Parent\SettingController;
use App\Http\Controllers\Parent\SppController;
use App\Http\Controllers\Parent\TahfidzController;
use App\Http\Controllers\Parent\TasriController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'homePageParent'])->name('parent.home');

Route::prefix('profile')->group(function() {
    Route::get('/', [ProfileController::class, 'showPage'])->name('parent.profile');
    Route::post('update', [ProfileController::class, 'updateProfile'])->name('parent.profile.update');
});

Route::prefix('password')->group(function() {
    Route::get('/', [ProfileController::class, 'showPagePassword'])->name('parent.password');
    Route::post('update', [ProfileController::class, 'updatePassword'])->name('parent.password.update');
});

Route::prefix('settings')->group(function() {
    Route::get('/', [SettingController::class, 'showSettingPage'])->name('parent.settings');
    Route::post('update', [SettingController::class, 'updateNotificationSetting'])->name('parent.settings.update-notification');
});

Route::prefix('chat')->group(function() {
    Route::get('/', [ChatController::class, 'showPage'])->name('parent.chat');
});

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
    Route::get('get-detail', [PerizinanController::class, 'getDetail'])->name('parent.perizinan.detail');
    Route::get('request', [PerizinanController::class, 'showPageRequestPermission'])->name('parent.perizinan.request');
    Route::post('request', [PerizinanController::class, 'handleRequestPermission'])->name('parent.perizinan.handle');
});

Route::prefix('pelanggaran')->group(function() {
    Route::get('/', [PelanggaranController::class, 'showPage'])->name('parent.pelanggaran');
    Route::get('get-data', [PelanggaranController::class, 'getData'])->name('parent.pelanggaran.history');
});

Route::prefix('prestasi')->group(function() {
    Route::get('/', [PrestasiController::class, 'showPage'])->name('parent.prestasi');
    Route::get('get-data', [PrestasiController::class, 'getData'])->name('parent.prestasi.history');
});

Route::prefix('kesehatan')->group(function() {
    Route::get('/', [KesehatanController::class, 'showPage'])->name('parent.kesehatan');
    Route::get('get-data', [KesehatanController::class, 'getData'])->name('parent.kesehatan.history');
    Route::get('get-detail', [KesehatanController::class, 'getDetail'])->name('parent.kesehatan.detail');
});

Route::prefix('tahfidz')->group(function() {
    Route::get('/', [TahfidzController::class, 'showPage'])->name('parent.tahfidz');
});

Route::prefix('spp')->group(function() {
    Route::get('/', [SppController::class, 'showPage'])->name('parent.spp');
});

Route::prefix('tasri')->group(function() {
    Route::get('/', [TasriController::class, 'showPage'])->name('parent.tasri');
});

Route::prefix('raport-sekolah')->group(function() {
    Route::get('/', [RaportController::class, 'showPageRaportSekolah'])->name('parent.raport.sekolah');
});

Route::prefix('raport-dayah')->group(function() {
    Route::get('/', [RaportController::class, 'showPageRaportDayah'])->name('parent.raport.dayah');
});

Route::prefix('document')->group(function() {
    Route::get('/', [DocumentController::class, 'showPage'])->name('parent.document');
});

Route::prefix('card')->group(function() {
    Route::get('/', [CardController::class, 'showPage'])->name('parent.card');
});

