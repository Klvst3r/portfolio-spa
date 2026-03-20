<script setup>
import { ref } from "vue"; // para el estado del modal
import { useForm, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Components/Button.vue";

//Importamos Componentes del modal y los input
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

//Objeto skill para el formulario
defineProps({
    skills: Array,
});

// Estado para controlar el Modal (reemplaza a acting en data)
const acting = ref(null);

// Definición del formulario con useForm hook en lugar del data() como se hacia con opcion api
const form = useForm({
    name: "",
    color: "",
});

// Opciones para el Select
const availableColors = [
    "bg-red-500",
    "bg-blue-500",
    "bg-green-500",
    "bg-yellow-500",
    "bg-indigo-500",
    "bg-purple-500",
    "bg-pink-500",
];

// Función para cerrar el modal y resetear el form
const closeModal = () => {
    acting.value = null; // Cierra el modal
    form.reset(); // Limpia los campos del formulario
    form.clearErrors(); // Quita los mensajes de error rojos
};

// Función de envío (Submit)
// Antes era un metodo del export default, ahora se define como una función para manejar estados
const submit = () => {
    form.post(route("skills.store"), {
        onSuccess: () => {
            closeModal(); // Si se guarda con éxito, limpiamos y cerramos
        },
        onError: () => {
            // Aquí puedes manejar qué pasa si hay un error (opcional)
            console.log("Hubo un error en la validación");
        },
    });
};
</script>

<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Skills
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-right">
                <JetButton
                    class="p-3 border-2 border-blue-500 text-blue-500 bg-blue-100 hover:bg-blue-200 font-bold ml-2 roundex-xl"
                    @click="acting = true"
                >
                    Add New +
                </JetButton>

                <Modal :show="acting !== null" @close="closeModal">
                    <div class="p-10 text-center">
                        <form @submit.prevent="submit" class="p-6">
                            <h2
                                class="text-2xl font-bold text-gray-800 border-b pb-3 text-center"
                            >
                                Crear Nueva Habilidad
                            </h2>

                            <div class="mt-6 text-left">
                                <InputLabel
                                    for="name"
                                    value="Nombre del Skill"
                                />
                                <TextInput
                                    id="name"
                                    type="text"
                                    v-model="form.name"
                                    class="mt-1 block w-full"
                                    placeholder="Ej: Laravel, Vue, PHP..."
                                />
                                <InputError
                                    :message="form.errors.name"
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
                                    </option>
                                </select>
                                <InputError
                                    :message="form.errors.color"
                                    class="mt-2"
                                />
                            </div>

                            <div class="mt-8 flex justify-end">
                                <SecondaryButton
                                    type="button"
                                    @click="closeModal"
                                >
                                    Cancelar
                                </SecondaryButton>

                                <PrimaryButton
                                    type="submit"
                                    class="ml-3 inline-flex items-center transition-all duration-200"
                                    :class="{
                                        'opacity-50 cursor-not-allowed':
                                            form.processing,
                                        'hover:bg-indigo-700': !form.processing,
                                    }"
                                    :disabled="form.processing"
                                >
                                    <span
                                        v-if="form.processing"
                                        class="animate-spin mr-2 text-xl inline-block"
                                        >&#9696;</span
                                    >

                                    <span class="font-medium">
                                        {{
                                            form.processing
                                                ? "Enviando..."
                                                : "Enviar"
                                        }}
                                    </span>
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </Modal>

                <table v-if="skills.length > 0" class="w-full mt-4">
                    <thead
                        class="border-b-2 border-gray-300 text-indigo-600 bg-gray-50"
                    >
                        <tr>
                            <th
                                class="px-6 py-3 text-left font-bold uppercase text-xs"
                            >
                                Name
                            </th>
                            <th
                                class="px-6 py-3 text-left font-bold uppercase text-xs"
                            >
                                Color
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
                            v-for="skill in skills"
                            :key="skill.id"
                            class="text-sm text-indigo-900 border-b border-gray-200 hover:bg-gray-50 transition-colors"
                        >
                            <td class="px-6 py-4 text-left font-medium">
                                {{ skill.name }}
                            </td>

                            <td class="px-6 py-4 text-left">
                                <div class="flex items-center">
                                    <span
                                        class="mr-3 h-5 w-5 rounded-full border border-gray-200 shadow-sm"
                                        :class="skill.color"
                                    ></span>
                                    <span
                                        class="text-xs font-mono text-gray-600"
                                        >{{ skill.color }}</span
                                    >
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <JetButton
                                        class="bg-indigo-600 text-white hover:bg-indigo-700 px-3 py-1 text-xs"
                                    >
                                        Edit
                                    </JetButton>

                                    <JetButton
                                        class="bg-red-600 text-white hover:bg-red-700 px-3 py-1 text-xs"
                                    >
                                        Delete
                                    </JetButton>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div
                    v-else
                    class="bg-red-100 border border-red-400 p-3 rounded-lg text-red-800"
                >
                    There are no skills yet. Let's create one :)
                </div>
            </div>
        </div>
    </app-layout>
</template>
