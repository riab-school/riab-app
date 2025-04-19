<?php

use App\Http\Controllers\Api\PsbInfo;
use App\Http\Controllers\Api\WilayahController;
use Illuminate\Support\Facades\Route;

Route::get('psbinfo', [PsbInfo::class, 'index']);

Route::prefix('wilayah')->group(function () {
    Route::get('province', [WilayahController::class, 'getAllProvince'])->name('api.wilayah.province');
    Route::get('city', [WilayahController::class, 'getCity'])->name('api.wilayah.city');
    Route::get('district', [WilayahController::class, 'getDistrict'])->name('api.wilayah.district');
    Route::get('village', [WilayahController::class, 'getVillage'])->name('api.wilayah.village');
});