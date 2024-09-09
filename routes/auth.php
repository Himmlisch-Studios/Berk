<?php

use App\Livewire\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| Here are defined all the authentication & authorization routes based on
| Laravel UI scaffolding, converted to Livewire components.
|
*/

Route::middleware('guest')->group(function () {
    Route::get('login', Auth\Login::class)->name('login');
    Route::redirect('register', '/')->name('register');
    Route::redirect('terms', '/')->name('terms');
    Route::redirect('password/reset', '/')->name('password.request');
    Route::redirect('password/reset/{token}', '/')->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('password/confirm', Auth\ConfirmPassword::class)->name('password.confirm');
    Route::get('email/verify', Auth\Verification::class)->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', Auth\Verification::class)->name('verification.verify');

    Route::get('logout', function (Request $request) {
        auth()->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});
