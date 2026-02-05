<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $colorName = $this
            ->faker
            ->randomElement(Project::getAvailableTextColors()); //Faker random element pasado a un array

        //Iconos
        $iconName = $this
            ->faker
            ->randomElement(Project::getAvailableIcons());

        return [
            'title' => $this->faker->unique()->words(2, true), //No repetir palabras, queda coomo una fras corta
            'description' => $this->faker->sentence(), //5 palabras para la descripción
            'color' => $colorName, //Colores soportados por TailwindCSS - JTM - Lista de colores
            'icon_name' => $iconName,
        ];
    }
}
