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

        // Inertia necesita una redirección para actualizar los props en el frontend, anterior sin mensaje para el usuario
        //return Redirect::route('projects.index');

        //Redirección con mensaje de exito
        return redirect()->route('projects.index')
            ->with('success', 'Proyecto creado con éxito');
    }



    public function update(Request $request, Project $project)
    {
        // Obtenemos los valores válidos desde el modelo, llamamos a los métodos exactos de nuestro modelo para obtener los valores permitidos
        $availableColors = Project::getAvailableTextColors();
        $availableIcons = Project::getAvailableIcons();

        $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Project::class)->ignore($project->id)
            ],
            'description' => 'required|string',
            'color' => [
                'required',
                'string',
                'in:' . implode(',', $availableColors), // Valida contra backgrounds del JSON
            ],
            'icon_name' => [
                'required',
                'string',
                'in:' . implode(',', $availableIcons), // Valida contra icons del JSON
            ],
        ]);

        $project->update($request->only('title', 'description', 'color', 'icon_name'));

        //Redirección con mensaje de exito
        // return redirect()->route('projects.index')
        //     ->with('message', 'Proyecto actualizado con éxito');
        // Usamos 'success' para que coincida con tu Middleware HandleInertiaRequests
        return redirect()->route('projects.index')
            ->with('success', 'Proyecto actualizado con éxito');
    }


    public function destroy(Project $project)
    {
        // Opcional: Podemos borrar la imagen del servidor para no dejar basura
        // Storage::delete($project->image);

        $project->delete();

        return Redirect::route('projects.index')
            ->with('success', 'Projecto  eliminado satisfactoriamente.');
    }
}
