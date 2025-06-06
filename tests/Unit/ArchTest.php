<?php

declare(strict_types=1);

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\PasswordValidationRules;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Actions\Jetstream\DeleteUser;
use Illuminate\Database\Eloquent\Factories\Factory;

arch()->preset()->php();
arch()->preset()->laravel();
arch()->preset()->security();

arch('controllers')
    ->expect('App\Http\Controllers')
    ->not->toBeUsed();

arch('avoid mutation')
    ->expect('App')
    ->classes()
    ->toBeReadonly()
    ->ignoring([
        'App\Exceptions',
        'App\Jobs',
        'App\Models',
        'App\Providers',
        'App\Services',
        'App\Http\Requests',
        'App\Http\Resources',
        'App\Queries',
        'App\Livewire',
    ]);

arch('avoid inheritance')
    ->expect('App')
    ->classes()
    ->toExtendNothing()
    ->ignoring([
        'App\Models',
        'App\Exceptions',
        'App\Jobs',
        'App\Providers',
        'App\Services',
        'App\Livewire',
        'App\Http\Requests',
        'App\Http\Resources',
    ]);

// arch('annotations')
//     ->expect('App')
//     ->toHavePropertiesDocumented()
//     ->toHaveMethodsDocumented();

arch('avoid open for extension')
    ->expect('App')
    ->classes()
    ->toBeFinal()
    ->ignoring([
        'App\Livewire\Forms',
    ]);

arch('avoid abstraction')
    ->expect('App')
    ->not->toBeAbstract()
    ->ignoring([
        'App\Contracts',
    ]);

arch('factories')
    ->expect('Database\Factories')
    ->toExtend(Factory::class)
    ->toHaveMethod('definition')
    ->toOnlyBeUsedIn([
        'App\Models',
    ]);

arch('models')
    ->expect('App\Models')
    ->toHaveMethod('casts')
    ->toOnlyBeUsedIn([
        'App\Http',
        'App\Jobs',
        'App\Models',
        'App\Providers',
        'App\Actions',
        'App\Services',
        'Database\Factories',
        'Database\Seeders',
        'App\Policies',
        'App\Queries',
        'App\Contracts',
        'App\Livewire',
    ]);

arch('actions')
    ->expect('App\Actions')
    ->toHaveMethod('handle')
    ->ignoring([
        DeleteUser::class,
        CreateNewUser::class,
        ResetUserPassword::class,
        UpdateUserPassword::class,
        UpdateUserProfileInformation::class,
        PasswordValidationRules::class,
    ]);
