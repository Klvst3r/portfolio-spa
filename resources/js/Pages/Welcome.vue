<script setup>
import { ref } from 'vue';
import { Head, Link } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Button from "@/Components/Button.vue";
import Section from "@/Components/Section.vue";
import Skill from "@/Components/Skill.vue";
import Project from "@/Components/Project.vue";
//import { BeakerIcon } from "@heroicons/vue/24/solid";
//import { defineAsyncComponent } from "vue";

// Importamos todos los iconos de Heroicons Solid
import * as SolidIcons from "@heroicons/vue/24/solid";


//Importamos Componentes del modal y los input

import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";


// Estado para abrir/cerrar el modal
const showingContactModal = ref(false);

// Formulario reactivo con Inertia
const form = useForm({
    name: '',
    email: '',
    message: '',
});

const openContactModal = () => {
    showingContactModal.value = true;
};

const closeModal = () => {
    showingContactModal.value = false;
    form.reset();
};

const sendMessage = () => {
    // Aquí es donde conectarás con tu controlador de Laravel más adelante
    console.log("Enviando mensaje:", form.data());
    // form.post(route('contact.send'), { ... });
};


// 1. Definimos las propiedades correctamente
const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    skills: Array,
    projects: Array, 
});

// 2. Convertimos el antiguo "method" en una función normal
// Nota: En script setup no usamos "this", usamos la constante "props"
const getIcon = (iconName) => {
    // Si iconName es "Beaker", buscamos "BeakerIcon" en el objeto SolidIcons
   const name = `${iconName || 'QuestionMarkCircle'}Icon`; // Agregamos un fallback inicial
    return SolidIcons[name] || SolidIcons.QuestionMarkCircleIcon; // Icono por defecto si no existe
};

const projectColors = [
    "bg-red-500",
    "bg-blue-500",
    "bg-green-500",
    "bg-yellow-500",
    "bg-purple-500",
];

const getIconText = (title) => {
    return title ? title.charAt(0).toUpperCase() : "?";
};
</script>
<template>

     <Head title="Portafolio" />

    <div
        class="grid grid-cols-2 text-right py-10 px-72 bg-gray-800 text-gray-300"
    >
        <!-- <div>
            <jet-application-mark class="h-12 w-auto"></jet-application-mark>
        </div> -->

        <ApplicationMark class="h-20 w-auto" />

        <div v-if="canLogin">
            <Link
                v-if="$page.props.user"
                :href="route('dashboard')"
                class="text-sm underline"
            >
                Dashboard
            </Link>

            <template v-else>
                <Link :href="route('login')" class="text-base underline">
                    Log in
                </Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="text-base underline place-self-end ml-4"
                >
                    Register
                </Link>
            </template>
        </div>
    </div>

    <Section class="bg-gray-800 pt-16 h-screen px-72">
        <div class="h-2/3 flex flex-wrap content-between border-gray-600 pb-36">
            <p
                class="border-b-2 font-bold border-gray-400 pb-3 text-2xl text-gray-300 uppercase"
            >
                Hola Jefe, esto es Inertia!. I'm software engineer and I would
                like to work with you
            </p>
        </div>

        <div class="flex items-end border-b-2 border-gray-500 pb-2 w-fit">
            <p class="font-bold mr-5 text-gray-500 text-xl">
                Want to know more about me?
               <Button 
                    @click="openContactModal"
                    class="bg-green-700 rounded font-bold text-sm text-gray-200 hover:bg-green-500 ml-2"
                >
                    Let's chat
                </Button>
            </p>
        </div>

        <div class="animate-pulse mt-3 text-gray-300 text-center text-7xl">
            <a href="#skills">&#8675;</a>
        </div>
    </Section>

    <Section
        id="skills"
        class="bg-gray-200 text-gray-800 min-h-screen px-72 py-20"
    >
        <h2 class="text-6xl font-bold pt-3 mb-12">Skills</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-10 pl-16">
            <div v-for="(skill, index) in skills" :key="skill.id">
                <Skill
                    :background="
                        skill.color || skillColors[index % skillColors.length]
                    "
                >
                    <template #icon>{{ skill.name.substring(0, 2) }}</template>
                    <template #name>{{ skill.name }}</template>
                </Skill>
            </div>
        </div>

        <div class="flex justify-center mt-12">
            <Button
                class="bg-indigo-800 rounded font-bold text-sm text-gray-200 hover:bg-indigo-700 ml-2"
            >
                Get in touch
            </Button>
        </div>
    </Section>
    <Section class="bg-gray-600 text-gray-200 min-h-screen">
    <div class="px-72 pt-16 mb-10">
        <h2 class="text-5xl font-bold">Projects</h2>
    </div>

    <div class="space-y-7 px-7">
    <div v-for="(project, index) in projects" :key="project.id">
        <Project
            :title="project.title"
            :description="project.description"
            :color="project.color"
        >
                <!-- <span class="text-3xl font-black text-white">
                    {{ getIconText(project.title) }}
                </span> -->
                <!-- <BeakerIcon></BeakerIcon> -->
                <component 
                :is="getIcon(project.icon_name)" 
                class="h-8 w-8 text-white" 
            />
            
            <!-- <span class="ml-2">{{ project.title }}</span> -->
        </Project>
            
        </div>
        </div>

        <div class="flex justify-center mt-16">
            <Button
                class="bg-purple-600 rounded font-bold text-sm text-gray-800 hover:bg-purple-800 px-10 py-3"
            >
                Know more
            </Button>
        </div>
    </Section>

    <footer class="flex justify-between bg-gray-800 text-gray-200 text-xl">
        <p>&copy; 2026. All rights reserved.- Made with ❤️ by Klvst3r</p>
        <div class="flex justify-evenly item-center">
            <Link
                class="border-b pb-1 px-2 hover:text-gray-50"
                href="#"
                target="_blank"
                >Github</Link
            >
            <Link
                class="border-b pb-1 px-2 hover:text-gray-50"
                href="#"
                target="_blank"
                >X</Link
            >
            <Link
                class="border-b pb-1 px-2 hover:text-gray-50"
                href="#"
                target="_blank"
                >Stackoverflow</Link
            >
            <Link
                class="border-b pb-1 px-2 hover:text-gray-50"
                href="#"
                target="_blank"
                >Linkedin</Link
            >
        </div>
    </footer>

    <Modal :show="showingContactModal" @close="closeModal">
    <div class="p-6">
        <h2 class="text-2xl font-bold text-gray-800 border-b pb-3">
            Cuéntame sobre tu proyecto
        </h2>

        <div class="mt-6">
            <InputLabel for="name" value="Nombre" />
            <TextInput 
                id="name" 
                v-model="form.name" 
                type="text" 
                class="mt-1 block w-full" 
                placeholder="Raúl Aguilar" 
            />
            <InputError :message="form.errors.name" class="mt-2" />
        </div>

        <div class="mt-4">
            <InputLabel for="email" value="Correo electrónico" />
            <TextInput 
                id="email" 
                v-model="form.email" 
                type="email" 
                class="mt-1 block w-full" 
                placeholder="tu@correo.com" 
            />
            <InputError :message="form.errors.email" class="mt-2" />
        </div>

        <div class="mt-4">
            <InputLabel for="message" value="Mensaje" />
            <textarea
                id="message"
                v-model="form.message"
                rows="5"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-800"
                placeholder="¿En qué puedo ayudarte?"
            ></textarea>
            <InputError :message="form.errors.message" class="mt-2" />
        </div>

        <div class="mt-8 flex justify-end">
            <SecondaryButton @click="closeModal">
                Cancelar
            </SecondaryButton>

            <PrimaryButton
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="sendMessage"
            >
                Enviar Mensaje
            </PrimaryButton>
        </div>
    </div>
</Modal>
</template>