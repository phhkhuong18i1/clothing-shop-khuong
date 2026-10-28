<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('about:store', function () {
    $this->comment('Atelier No. 8 clothing store');
})->purpose('Show the store name');

Artisan::command('store:make-admin', function () {
    $name = $this->ask('Administrator name');
    $email = $this->ask('Administrator email');
    $password = $this->secret('Password (12 characters minimum)');

    validator(compact('name', 'email', 'password'), [
        'name' => ['required', 'string', 'max:120'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'string', 'min:12'],
    ])->validate();

    App\Models\User::create([
        'name' => $name,
        'email' => $email,
        'password' => Illuminate\Support\Facades\Hash::make($password),
        'is_admin' => true,
    ]);

    $this->info('Administrator account created.');
})->purpose('Create an administrator account interactively');
