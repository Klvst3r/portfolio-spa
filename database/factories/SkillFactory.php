<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

//Importamos la definición de Skill
use App\Models\Skill;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skill>
 */
class SkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $color = $this
            ->faker
            ->randomElement([Skill::getAvailableBackgrundColors()]); //Faker random element pasado a un array
        return [
            'name' => $this->faker->unique()->word(), //No repetir palabras, 
            'color' => $color, //Colores soportados por TailwindCSS - JTM - Lista de colores
        ];
    }

    
}
