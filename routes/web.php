<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Skill;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'skills' => Skill::all(),
        // 'laravelVersion' => Application::VERSION,
        // 'phpVersion' => PHP_VERSION,
    ]);
    //Ejercicio de validación
    // return Inertia::render('Welcome', [
    //     'status' => 'Conexión Exitosa con el Poder Judicial',
    //     // ... tus otras props
    // ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
