<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\EnsureUserActive;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(auth()->check()) {
        $route = auth()->user()->user_level.".home";
        return redirect()->route($route);
    }
    return view('splash');	
});

Route::middleware(['auth', EnsureUserActive::class])->group(function () {
    Route::get('profile', [ProfileController::class, 'showProfilePage'])->name('profile');
    Route::post('profile-update', [ProfileController::class, 'handleProfileUpdate'])->name('profile.update');
});
