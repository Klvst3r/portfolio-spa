<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


//use App\Models\Contact; //Asegúrate de que el modelo exista, de momento no existe
use Illuminate\Support\Facades\Redirect;

class ContactController extends Controller
{
    public function contact(Request $request)
    {
        //De momento solo vamos a verificar que estamos recibiendo la información correctamente, luego haremos la validación y el almacenamiento en la base de datos.
        dd($request->all());
    }
}
