<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', static function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function (): void {
    Route::redirect('settings', 'settings/profile');

    Volt::route('user/password', 'settings.password')->name('settings.password');
    Volt::route('user/security', 'settings.security')->name('settings.security');
    Volt::route('user/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', static function () {
        return view('dashboard');
    })->name('dashboard');
});
