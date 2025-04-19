<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'homePageStudentNew'])->name('student.home.new');

Route::get('test', function () {
    dd([
        'registration_history' => request()->registration_history,
        'registration_method' => request()->registration_method,
    ]);
});