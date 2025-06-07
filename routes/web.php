<?php

declare(strict_types=1);

use App\Models\Recipe;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', static fn () => view('welcome'))->name('home');

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
])->group(function (): void {
    Route::get('/dashboard', static fn () => view('dashboard'))->name('dashboard');

    Route::prefix('recipes')->name('recipes.')->group(function (): void {
        Volt::route('/', 'recipes.index')->name('index');
        // Volt::route('/create', 'recipes.create')->name('create');
        Volt::route('/{recipe}', 'recipes.show')->name('show');
    });
});

// Testing route for PDF Template
if (app()->isLocal()) {
    Route::get('pdf-test/{recipe}', static function (Recipe $recipe) {
        if (request()->get('pdf')) {
            return Pdf::loadView('livewire.recipes.pdf', [
                'recipe' => $recipe,
            ])->stream();
        }

        return view('livewire.recipes.pdf', [
            'recipe' => $recipe,
        ]);
    });
}
