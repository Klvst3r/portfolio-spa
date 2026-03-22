<?php

namespace App\Http\Controllers;

use App\Models\Project;

use Illuminate\Http\Request;

use Inertia\Inertia;

use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Redirect;

class ProjectController extends Controller
{
    public function index()
    {
        return Inertia::render('Projects/All', [
            'projects' => Project::all(),
            // Pasamos las opciones reales del JSON a Vue
            'availableColors' => Project::getAvailableTextColors(),
            'availableIcons' => Project::getAvailableIcons(),
        ]);
    }


    public function store(Request $request)
    {
        // Almacenamos los colores válidos para usarlos en la validación
        $availableColors = Project::getAvailableTextColors();
        $availableIcons = Project::getAvailableIcons();

        $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Project::class)
            ],
            'description' => [
                'required',
                'string',
                'max:255',
            ],

            'color' => [
                'required',
                'string',
                'in:' . implode(',', $availableColors),
            ],
            'icon_name' => [
                'required',
                'string',
                'in:' . implode(',', $availableIcons),
            ],
        ]);

        //Project::create($request->all());
        // Usar solo los datos validados es más seguro que $request->all()
        Project::create($request->only(['title', 'description', 'color', 'icon_name']));

        // Inertia necesita una redirección para actualizar los props en el frontend
        return Redirect::route('projects.index');
    }
}
