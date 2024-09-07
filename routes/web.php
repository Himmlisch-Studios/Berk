<?php

use App\Livewire;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

// * Front admin panel
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
	Route::page('Dashboard', '/');
	Route::front('User');

	Route::get('profile', Livewire\Profile::class)->name('profile');
	Route::get('logs', [LogViewerController::class, 'index']);
});

Route::redirect('/', '/login');
