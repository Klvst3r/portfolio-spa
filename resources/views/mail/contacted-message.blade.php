<x-mail::message>
# Nuevo mensaje de contacto

Alguien te ha contactado con la siguiente información, tal vez se requiera establecer contacto: 

**Nombre:** {{ $name }}  
**Correo:** {{ $email }}  

**Mensaje:** {{ $message }}

<x-mail::button :url="config('app.url')">
Ir al portafolio
</x-mail::button>

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>