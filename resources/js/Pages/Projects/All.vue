<script setup>
import { ref, watch } from "vue"; // para el estado del modal

import { useForm, Link, usePage } from "@inertiajs/vue3"; //useform pertenece a la libreria de inertiajs para manejar formularios de manera reactiva y sencilla, con validaciones y manejo de errores integrado. Es una herramienta que facilita la gestión de formularios en aplicaciones Vue.js que utilizan Inertia.js como puente entre el frontend y el backend.

import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Components/Button.vue"; // Usando el que ya te funcionó en Welcome
//import { Link } from "@inertiajs/vue3";

// importacion de iconos
import * as SolidIcons from "@heroicons/vue/24/solid";

//Importamos Componentes del modal y los input
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

//lógica del getIcon
const getIcon = (iconName) => {
    // Si iconName es "Briefcase", busca "BriefcaseIcon" en el objeto SolidIcons
    const name = `${iconName}Icon`;
    return SolidIcons[name] || SolidIcons.QuestionMarkCircleIcon; // Icono por defecto si falla
};

//Se define el objeto de Projects
// Se reciben desde el controlador los proyectos, colores e iconos disponibles como props, lo que permite que el componente sea dinámico y se actualice automáticamente cuando se agreguen nuevos proyectos o se modifiquen las opciones de colores e iconos en el backend. Esto es una de las grandes ventajas de usar Inertia.js, ya que facilita la comunicación entre el frontend y el backend sin necesidad de recargar la página.
const props = defineProps({
    projects: Array,
    availableColors: Array,
    availableIcons: Array,
});

// --- ESTADO DEL MODAL Y FORMULARIO ---
//// Ajustes para Editar y Crear en el mismo modal

// 1. Cambiamos la lógica de 'acting' para que sea un objeto en lugar de un booleano. Esto nos permitirá almacenar información sobre el proyecto que estamos editando o creando.
// Estado para controlar el Modal (reemplaza a acting en data)
const acting = ref(null); // null = cerrado, true = creando, {objeto} = editando
// const method = ref("post");
// const action = ref(route("projects.store")); // Definimos el método y la ruta dinámicos

// Definición del formulario con useForm hook en lugar del data()
// Para que el formulario sea dinámico, necesitamos una función que "cargue" los datos del proyecto seleccionado en el objeto del formulario antes de mostrarlo o procesarlo. Usando el helper useForm de Inertia.js, podemos crear un formulario dinámico que se actualice automáticamente cuando cambiemos el valor de acting.
const form = useForm({
    title: "",
    description: "",
    color: "",
    icon_name: "",
});

// 2. Definimos variables para el método y la ruta dinámicos
const method = ref("post");
const action = ref(route("projects.store"));

// --- ACCIONES ---
// 3. Función para preparar el modal de creación
const openCreateModal = () => {
    acting.value = true;
    method.value = "post";
    action.value = route("projects.store");
    form.reset();
    form.clearErrors();
};

// 4. Función para preparar el modal de edición
// Esta función se dispara cuando hacemos clic en el botón de editar de la lista:
const openEditModal = (project) => {
    acting.value = project; // Guardamos el objeto project actual
    method.value = "put";
    action.value = route("projects.update", project.id);

    // Llenamos el formulario con los datos existentes
    form.title = project.title;
    form.description = project.description;
    form.color = project.color;
    form.icon_name = project.icon_name;
};

// 5. Función para cerrar el modal y resetear el form
const closeModal = () => {
    acting.value = null; // Cierra el modal
    form.reset(); // Limpia los campos del formulario
    form.clearErrors(); // Quita los mensajes de error rojos
};

// 6. Ajuste en el Submit (ahora usa las variables dinámicas)
// Función de envío UNIFICADA y DINÁMICA
//Envío de la Información: Dependiendo de si el form.id existe, sabremos si llamar a store (POST) o update (PUT/PATCH).

//Dado que ahora vamos a manejar mensajes de éxito, podremos mejorar la función submit en el componente All.vue para que, además de cerrar el modal, sepamos que el mensaje llegó:

const submit = () => {
    // Usamos form.submit para que acepte el método (put/post) y la ruta dinámicamente
    form.submit(method.value, action.value, {
        onSuccess: (page) => {
            closeModal();
            // El mensaje de éxito estará en page.props.flash.message
            //console.log("Servidor dice: " + page.props.flash.message);
            //ajuste con el middleware: app/Http/Middleware/HandleInertiaRequests.php
            const msg = page.props.flash.success || page.props.flash.message;
            console.log("Servidor dice: " + msg);
        },
        onError: () => {
            console.error("Errores de validación detectados en el formulario.");
        },
        onFinish: () => {
            // Esto se ejecuta siempre, termine en éxito o error
        },
    });
};

// 7. Como implementamos el fash para feedback del usuario, establecemos el borrado del mensaje despues de 3 segundos

const page = usePage();

// Borrar el mensaje automáticamente después de 5 segundos
watch(
    () => page.props.flash.success,
    (next) => {
        if (next) {
            setTimeout(() => {
                page.props.flash.success = null;
            }, 3000);
        }
    },
);

/**
 * borramos los arrays "const availableColors = [...]" y "const availableIcons = [...]"
 ya no se necesitam, provienent de las funciones estáticas del modelo Project, que a su vez leen los datos de un JSON, lo que hace que el sistema sea más flexible y fácil de mantener. Ahora, si quieres agregar un nuevo color o icono, solo necesitas actualizar el JSON en el backend sin tocar el código del frontend.
 */

// Opciones para el Select de colores
/*
const availableColors = [
    "bg-red-500",
    "bg-blue-500",
    "bg-green-500",
    "bg-yellow-500",
    "bg-indigo-500",
    "bg-purple-500",
    "bg-pink-500",
];
*/

//Opciones para el Select de iconos
//Debido a que no estamos iconos de FontAwesome no utilizamos los siguientes
/*
const availableIcons = [
    "fas fa-briefcase",
    "fas fa-chart-line",
    "fas fa-cogs",
    "fas fa-users",
    "fas fa-lightbulb",
    "fas fa-rocket",
    "fas fa-shield-alt",
];
*/

// Opciones para el Select de iconos (Nombres de Heroicons)
/*
const availableIcons = [
    "Briefcase",
    "ChartBar",      // Reemplaza a chart-line
    "Cog6Tooth",     // Reemplaza a cogs
    "Users",
    "LightBulb",
    "RocketLaunch",  // Reemplaza a rocket
    "ShieldCheck",   // Reemplaza a shield-alt
];
*/

// Función de envío (Submit)
// Antes era un metodo del export default, ahora se define como una función para manejar estados
// const submit = () => {
//     form.post(route("projects.store"), {
//         onSuccess: () => {
//             closeModal(); // Si se guarda con éxito, limpiamos y cerramos
//         },
//         onError: () => {
//             // Aquí puedes manejar qué pasa si hay un error (opcional)
//             console.log("Hubo un error en la validación");
//         },
//     });
// };
</script>

<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Projects
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <transition name="fade">
                    <div
                        v-if="$page.props.flash.success"
                        class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8"
                    >
                        <div
                            class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800 shadow-md"
                            role="alert"
                        >
                            <svg
                                class="flex-shrink-0 w-5 h-5"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"
                                />
                            </svg>
                            <div class="ml-3 text-sm font-medium">
                                {{ $page.props.flash.success }}
                            </div>
                            <button
                                @click="$page.props.flash.success = null"
                                type="button"
                                class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                            >
                                <span class="sr-only">Cerrar</span>
                                <svg
                                    class="w-3 h-3"
                                    fill="none"
                                    viewBox="0 0 14 14"
                                >
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </transition>

                <div class="text-right mb-6">
                    <JetButton
                        class="p-3 border-2 border-blue-500 text-blue-500 bg-blue-100 hover:bg-blue-200 font-bold ml-2 rounded-xl"
                        @click="openCreateModal"
                    >
                        Add New +
                    </JetButton>
                </div>

                <Modal :show="acting !== null" @close="closeModal">
                    <div class="p-10 text-center">
                        <form @submit.prevent="submit" class="p-6">
                            <h2
                                class="text-2xl font-bold text-gray-800 border-b pb-3 text-center"
                            >
                                {{
                                    acting === true
                                        ? "Crear Nuevo Proyecto"
                                        : "Editar Proyecto"
                                }}
                            </h2>

                            <div class="mt-6 text-left">
                                <InputLabel
                                    for="title"
                                    value="Nombre del proyecto"
                                />
                                <TextInput
                                    id="title"
                                    type="text"
                                    v-model="form.title"
                                    class="mt-1 block w-full"
                                    placeholder="Ej: Mi Portafolio..."
                                />
                                <InputError
                                    :message="form.errors.title"
                                    class="mt-2"
                                />
                            </div>

                            <div class="mt-6 text-left">
                                <InputLabel
                                    for="description"
                                    value="Descripción del proyecto"
                                />
                                <TextInput
                                    id="description"
                                    type="text"
                                    v-model="form.description"
                                    class="mt-1 block w-full"
                                    placeholder="Ej: Aplicación SPA con Vue..."
                                />
                                <InputError
                                    :message="form.errors.description"
                                    class="mt-2"
                                />
                            </div>

                            <div class="mt-4 text-left">
                                <InputLabel
                                    for="color"
                                    value="Color de Identificación"
                                />
                                <select
                                    id="color"
                                    v-model="form.color"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                >
                                    <option value="" disabled>
                                        Selecciona un color
                                    </option>
                                    <option
                                        v-for="color in availableColors"
                                        :key="color"
                                        :value="color"
                                    >
                                        {{
                                            color
                                                .replace("bg-", "")
                                                .replace("-500", "")
                                        }}
                                        <!-- {{ color.replace("bg-", "").replace("-500", "").toUpperCase() }} -->
                                    </option>
                                </select>
                                <InputError
                                    :message="form.errors.color"
                                    class="mt-2"
                                />
                            </div>

                            <div class="mt-4 text-left">
                                <InputLabel
                                    for="icon_name"
                                    value="Icono de Identificación"
                                />
                                <select
                                    id="icon_name"
                                    v-model="form.icon_name"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                >
                                    <option value="" disabled>
                                        Selecciona un icono
                                    </option>
                                    <option
                                        v-for="icon in availableIcons"
                                        :key="icon"
                                        :value="icon"
                                    >
                                        {{ icon }}
                                    </option>
                                </select>
                                <InputError
                                    :message="form.errors.icon_name"
                                    class="mt-2"
                                />
                            </div>

                            <div
                                class="mt-8 p-6 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200"
                            >
                                <p
                                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 text-left"
                                >
                                    Vista previa de la tarjeta:
                                </p>

                                <div
                                    class="flex items-center p-4 bg-white rounded-lg shadow-sm border border-gray-100"
                                >
                                    <div
                                        class="p-4 rounded-full shadow-md transition-all duration-500 ease-in-out transform hover:scale-110"
                                        :class="form.color || 'bg-gray-200'"
                                    >
                                        <component
                                            :is="getIcon(form.icon_name)"
                                            class="h-8 w-8 text-white"
                                        />
                                    </div>

                                    <div class="ml-5 text-left flex-1">
                                        <h4
                                            class="text-lg font-extrabold text-gray-900 leading-tight truncate"
                                        >
                                            {{
                                                form.title ||
                                                "Título del Proyecto"
                                            }}
                                        </h4>
                                        <p
                                            class="text-sm text-gray-500 line-clamp-2 mt-1"
                                        >
                                            {{
                                                form.description ||
                                                "Aquí aparecerá la descripción detallada de tu gran idea..."
                                            }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex justify-end">
                                <SecondaryButton
                                    type="button"
                                    @click="closeModal"
                                    >Cancelar</SecondaryButton
                                >
                                <PrimaryButton
                                    type="submit"
                                    class="ml-3"
                                    :class="{ 'opacity-50': form.processing }"
                                    :disabled="form.processing"
                                >
                                    {{
                                        form.processing
                                            ? "Enviando..."
                                            : "Enviar"
                                    }}
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </Modal>

                <div
                    v-if="projects.length > 0"
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <table class="w-full">
                        <thead
                            class="border-b-2 border-gray-300 text-indigo-600 bg-gray-50"
                        >
                            <tr>
                                <th
                                    class="px-6 py-3 text-left font-bold uppercase text-xs"
                                >
                                    Title
                                </th>
                                <th
                                    class="px-6 py-3 text-left font-bold uppercase text-xs"
                                >
                                    Description
                                </th>
                                <th
                                    class="px-6 py-3 text-left font-bold uppercase text-xs"
                                >
                                    Color
                                </th>
                                <th
                                    class="px-6 py-3 text-left font-bold uppercase text-xs"
                                >
                                    Icon
                                </th>
                                <th
                                    class="px-6 py-3 text-center font-bold uppercase text-xs"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="project in projects"
                                :key="project.id"
                                class="text-sm text-indigo-900 border-b border-gray-200 hover:bg-gray-50 transition-colors"
                            >
                                <td class="px-6 py-4 text-left font-medium">
                                    {{ project.title }}
                                </td>
                                <td class="px-6 py-4 text-left text-gray-600">
                                    {{ project.description }}
                                </td>
                                <td class="px-6 py-4 text-left">
                                    <div class="flex items-center">
                                        <span
                                            class="mr-3 h-5 w-5 rounded-full border border-gray-200 shadow-sm"
                                            :class="project.color"
                                        ></span>
                                        <span
                                            class="text-xs font-mono text-gray-600"
                                            >{{ project.color }}</span
                                        >
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-left">
                                    <component
                                        :is="getIcon(project.icon_name)"
                                        class="h-6 w-6"
                                        :class="
                                            project.color
                                                ? project.color.replace(
                                                      'bg-',
                                                      'text-',
                                                  )
                                                : 'text-gray-500'
                                        "
                                    />
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <JetButton
                                            @click="openEditModal(project)"
                                            class="bg-indigo-600 text-white hover:bg-indigo-700 px-3 py-1 text-xs"
                                            >Edit</JetButton
                                        >
                                        <JetButton
                                            class="bg-red-600 text-white hover:bg-red-700 px-3 py-1 text-xs"
                                            >Delete</JetButton
                                        >
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div
                    v-else
                    class="bg-red-100 border border-red-400 p-3 rounded-lg text-red-800 text-center"
                >
                    There are no projects yet. Let's create one :)
                </div>
            </div>
        </div>
    </app-layout>
</template>
