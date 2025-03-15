<?php

use App\Http\Controllers\AirtimeTopupController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

   Route::get('airtime', [AirtimeTopupController::class, 'create'])->name('airtime.create');
   Route::get('airtime/history', [AirtimeTopupController::class, 'index'])->name('airtime.index');
   Route::post('airtime', [AirtimeTopupController::class, 'store'])->name('airtime.store');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
