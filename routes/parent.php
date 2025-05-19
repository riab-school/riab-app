<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Parent\AnandakuController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'homePageParent'])->name('parent.home');

Route::get('anandaku', [AnandakuController::class, 'showPage'])->name('parent.anandaku');
Route::post('anandaku/find', [AnandakuController::class, 'findStudentData'])->name('parent.anandaku.find');
Route::post('anandaku/pair', [AnandakuController::class, 'pairingStudentWithParent'])->name('parent.anandaku.pair');
