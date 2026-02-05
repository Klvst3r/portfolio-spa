<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;




class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'color',
        'icon_name',
    ];

    public static function getAvailableTextColors(): array
    {
        $elements = json_decode(
            File::get(resource_path('resources/json/customization.json')) //se carrga tamnien la funcionalidad de Skill con los colres de fondo y de texto
        );

        return $elements->texts;
    }

    public static function getAvailableIcons(): array
    {
        $elements = json_decode(
            File::get(resource_path('resources/json/customization.json')) //se carrga tamnien la funcionalidad de Skill con los colres de fondo y de texto
        );

        return $elements->icons;
    }
}
