<?php

namespace App\Http\Controllers;

use App\Models\Skill;

use Illuminate\Http\Request;

use Inertia\Inertia;

use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Redirect; // para redirecciones
//use App\Http\Controllers\Inertia;
//use App\Http\Controllers\Skill;


class SkillController extends Controller
{
    public function index()
    {
        return Inertia::render('Skills/All', [
            'skills' => Skill::all(),
            'availableColors' => Skill::getAvailableBackgroundColors(),
        ]);
    }

    public function store(Request $request)
    {
        // Almacenamos los colores válidos para usarlos en la validación
        $availableColors = Skill::getAvailableBackgroundColors();

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Skill::class)
            ],
            'color' => [
                'required',
                'string',
                'in:' . implode(',', $availableColors),
            ],
        ]);

        Skill::create($request->all());

        // Inertia necesita una redirección para actualizar los props en el frontend
        return Redirect::route('skills.index');
    }
}
