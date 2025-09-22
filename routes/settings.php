<?php

use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::redirect('configuracion', '/configuracion/perfil');

    Route::get('configuracion/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('configuracion/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('configuracion/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('configuracion/contraseña', [PasswordController::class, 'edit'])->name('password.edit');

    Route::put('configuracion/contraseña', [PasswordController::class, 'update'])
        ->middleware('throttle:6,1')
        ->name('password.update');

    // Route::get('configuracion/apariencia', function () {
    //     return Inertia::render('settings/appearance');
    // })->name('appearance');
});
