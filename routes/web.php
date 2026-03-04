<?php

use App\Http\Controllers\ContactController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Skill;
use App\Models\Project;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'skills' => Skill::all(),
        'projects' => Project::all(),
        // 'laravelVersion' => Application::VERSION,
        // 'phpVersion' => PHP_VERSION,
    ]);
    //Ejercicio de validación
    // return Inertia::render('Welcome', [
    //     'status' => 'Conexión Exitosa con el Poder Judicial',
    //     // ... tus otras props
    // ]);
});


//Contacto
Route::post('contact', [ContactController::class, 'contact'])->name('contact');
//Route::post('contact', [ContactController::class, 'store'])->name('contact.store');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
