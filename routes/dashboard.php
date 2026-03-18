<?php

use App\Http\Controllers\SkillController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// No es necesario el middleware aquí, ya viene aplicado desde app.php

// URL: /dashboard -> nombre: dashboard.index
Route::get('/', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

// Recursos: /dashboard/skills y /dashboard/projects
Route::resource('skills', SkillController::class)->except(['create', 'show', 'edit']);
Route::resource('projects', ProjectController::class)->except(['create', 'show', 'edit']);
