<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


//use App\Models\Contact; //Asegúrate de que el modelo exista, de momento no existe
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactedMessage;

class ContactController extends Controller
{
    public function contact(Request $request)
    {
        //De momento solo vamos a verificar que estamos recibiendo la información correctamente, luego haremos la validación y el almacenamiento en la base de datos.
        //dd($request->all());
        //Aquí podrías agregar validación de los datos recibidos, por ejemplo:

        //Laravel permite agruparlas. Si quieres que sea aún más estricto (verificando que el dominio tenga registros DNS reales), puedes usar:
        //'email' => 'required|email:rfc,dns'

        // 1. Es vital validar antes de enviar, para evitar que lleguen nulos al Mail
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|min:10',
        ], [
            // Mensajes personalizados
            'name.required'    => 'Por favor, escribe tu nombre para saber a quien contestar correctamente.',
            'email.required'   => 'Es necesario tu correo electrónico para poder responderle.',
            'email.email'      => 'Vaya, parece que este correo no es válido.',
            'message.required' => 'No olvide escribir su mensaje o duda.',
            'message.min'      => 'Cuentenos un poco más, el mensaje es demasiado corto.',
        ]);


        //Enviamos el archivo conig y ponemos el address del destinatario, que en este caso es el mismo que el remitente, pero podría ser cualquier otro.
        //como segundo parametro utilizamos, config('mail.to.address') para obtener la dirección de correo electrónico del destinatario desde el archivo de configuración mail.php, lo que hace que sea más fácil cambiar el destinatario sin tener que modificar el código.

        //La funcion send le pasamos el mailable que vamos a utilizar que es una instancia new ContactMessage, y le pasamos el request->all() para que el mailable pueda acceder a toda la información del formulario de contacto. que recibe el mensaje y peticion de donde viene y lo mismo para el name y el email, que lo obtiene del request->all() y lo asigna a las variables correspondientes en el mailable.

        //Mail::to(config('mail.to.address'), config)->send(new ContactMessage($request->all()));
        //Mail::to(config('mail.to.address'), config('mail.to.name'))->send(new ContactedMessage($request->email, $request->name, $request->message));



        // 2. Enviamos el correo
        // La forma más segura de pasarle el nombre y correo al TO es:
        Mail::to(config('mail.to.address'), config('mail.to.name'))
            ->send(new ContactedMessage(
                $request->name,
                $request->email,
                $request->message
            ));

        //Una vez que tenemos lo anterior, podremos estar enviando el mensaje y redirigiendo hacia la raiz del proyecto con un mensaje de éxito, que podríamos mostrar con un toast o algo similar en el frontend.
        //return Redirect::to('/')->with('success', '¡Mensaje enviado con éxito!');
        //return redirect()->back()->with('success', '¡Mensaje enviado con éxito!');
        //return redirect()->back();
        //return Redirect::to('/');

        // Cambiamos la clave a contacted para que el modal sepa que debe "transformarse":
        //return redirect()->back()->with('contacted', true);

        //queda definitivamente
        return redirect()->back()->with('success', '¡Mensaje enviado con éxito!');
    }
}
