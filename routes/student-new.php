<?php

use App\Http\Controllers\Student\New\AnnouncementController;
use App\Http\Controllers\Student\New\CetakBerkasController;
use App\Http\Controllers\Student\New\DashboardController;
use App\Http\Controllers\Student\New\DataDiriController;
use App\Http\Controllers\Student\New\PaymentController;
use App\Http\Middleware\EnsurePsbAdmChecingkIsPassed;
use App\Http\Middleware\EnsurePsbPaid;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('student.home.new');

// 💳 Pembayaran
Route::get('payment', [PaymentController::class, 'index'])->name('student.payment.new');
Route::post('payment', [PaymentController::class, 'handleVerification'])->name('student.payment.new.action');

// =============================
// 🔐 Setelah Bayar
// =============================
Route::group(['middleware' => EnsurePsbPaid::class], function () {

    // 🧾 DATA DIRI — dibuka setelah masa pendaftaran dimulai
    Route::prefix('data-diri')
        ->middleware('psb.schedule:register')
        ->group(function () {
            Route::get('/', [DataDiriController::class, 'index'])->name('student.new.data-diri');
            Route::post('page-1', [DataDiriController::class, 'handleStorePage1'])->name('student.new.data-diri.store-page-1');
            Route::post('page-2', [DataDiriController::class, 'handleStorePage2'])->name('student.new.data-diri.store-page-2');
            Route::post('page-3', [DataDiriController::class, 'handleStorePage3'])->name('student.new.data-diri.store-page-3');
            Route::post('page-4', [DataDiriController::class, 'handleStorePage4'])->name('student.new.data-diri.store-page-4');
            Route::post('page-5', [DataDiriController::class, 'handleStorePage5'])->name('student.new.data-diri.store-page-5');
            Route::post('page-6', [DataDiriController::class, 'handleStorePage6'])->name('student.new.data-diri.store-page-6');
            Route::post('delete-certificate', [DataDiriController::class, 'handleDeleteCertificate'])->name('student.new.data-diri.delete-certificate');
        });

    // 📢 PENGUMUMAN — dibuka setelah jadwal pengumuman
    Route::prefix('pengumuman')
        ->middleware('psb.schedule:pengumuman')
        ->group(function () {
            Route::get('/', [AnnouncementController::class, 'index'])->name('student.new.announcement');
            Route::post('pindah-reguler', [AnnouncementController::class, 'handlePindahReguler'])->name('student.new.announcement.pindah-reguler');
        });

    // 🪪 CETAK KARTU & PILIH JADWAL
    Route::group(['middleware' => EnsurePsbAdmChecingkIsPassed::class], function () {

        // Cetak kartu — dibuka jika siswa lulus administrasi & punya exam_number
        Route::prefix('cetak-kartu')
            ->group(function () {
                Route::get('/', [CetakBerkasController::class, 'index'])->name('student.new.cetak-berkas');
            });

        // Pilih jadwal — dibuka setelah masa ujian dimulai dan masih diizinkan mengubah jadwal
        Route::prefix('pilih-jadwal')
            ->group(function () {
                Route::get('/', [CetakBerkasController::class, 'getAvailabilitySchedule'])->name('student.new.get-availability-schedule');
                Route::post('/', [CetakBerkasController::class, 'handlePilihJadwal'])->name('student.new.set-schedule');
                Route::post('cetak', [CetakBerkasController::class, 'handleCetak'])->name('student.new.handle.cetak-berkas');
            });
    });
});

// =============================
// 🔧 Test / Dev Routes
// =============================
Route::get('test', function () {
    dd([
        'registration_history' => request()->registration_history,
        'registration_method' => request()->registration_method,
        'psb_config' => request()->psb_config,
        'home_url' => request()->home_url,
        'id' => auth()->user()->id,
    ]);
});

Route::get('exam', function () {
    return getCounter(auth()->user()->id);
});
