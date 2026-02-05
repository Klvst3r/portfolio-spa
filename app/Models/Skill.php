<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;



class Skill extends Model
{
    /** @use HasFactory<\Database\Factories\SkillFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
    ];

    public static function getAvailableBackgroundColors(): array
    {
        // Si el archivo está en resources/resources/json/
        $path = resource_path('resources/json/customization.json');

        $elements = json_decode(
            File::get($path) //se carrga tamnien la funcionalidad de Skill con los colres de fondo y de texto
        );


        return $elements->backgrounds; //obtener los elementos de backgrounds
    }
}
