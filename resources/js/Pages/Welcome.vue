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

//Importando componentes para capurar mensaje de exito necesitamos computed y watch para reaccionar a los cambios en la sesión

import { computed, watch } from 'vue';

//Para la barri de transicion
import {  nextTick } from 'vue';



import { usePage } from '@inertiajs/vue3';



const page = usePage();

// Esta variable será reactiva. Si hay un mensaje en la sesión, aparecerá aquí.
//const flashSuccess = computed(() => page.props.flash.success);
const flashSuccess = ref(null);
let timeoutId = null;

//barra
const progressWidth = ref(100); // Empezamos al 100%



// Observamos los cambios en los props de flash
watch(
    () => page.props.flash.success,
    async (newValue) => {
        if (newValue) {
            flashSuccess.value = newValue;
            progressWidth.value = 100; // Resetear barra

            // Forzamos a Vue a esperar que el DOM se renderice antes de iniciar la animación
            await nextTick();
            
            // Iniciamos la reducción de la barra casi de inmediato
            setTimeout(() => {
                progressWidth.value = 0;
            }, 50);

            if (timeoutId) clearTimeout(timeoutId);

            timeoutId = setTimeout(() => {
                flashSuccess.value = null;
            }, 3000);
        }
    },
    { immediate: true }
);


///Demas funciones para el modal

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
    form.clearErrors(); // Elimina los mensajes de error previos
    form.reset();       // Regresa los campos a su estado inicial (vacíos)
};


const sendMessage = () => {
    form.post(route('contact'), {
        preserveScroll: true,
        onSuccess: () => {
            // Cerramos el modal si es necesario
            if (typeof closeModal === 'function') closeModal();
            
            // Limpiamos los campos
            form.reset();
            
            // El mensaje aparecerá automáticamente gracias a flashSuccess
        },
        onError: (errors) => {
            console.log("Errores detectados:", errors);
        }
    });
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

       <!-- <transition name="fade">
        <div v-if="flashSuccess" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ flashSuccess }}</span>
        </div>
    </transition> -->
    <!-- Pasamos esto al final -->



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
                @click="openContactModal"
                class="bg-indigo-800 rounded font-bold text-sm text-gray-200 hover:bg-indigo-700 ml-2"
            >
                ¿Tienes un proyecto en mente?
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
            @click="openContactModal"
                class="bg-purple-600 rounded font-bold text-sm text-gray-800 hover:bg-purple-800 px-10 py-3"
            >
                Contratar para un proyecto similar
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
    <form @submit.prevent="sendMessage" class="p-6">
        <h2 class="text-2xl font-bold text-gray-800 border-b pb-3">
            Cuéntame sobre tu proyecto
        </h2>

        <div class="mt-6">
            <InputLabel for="name" value="Nombre" />
            <TextInput 
                id="name" 
                v-model="form.name" 
                @input="form.clearErrors('name')" 
                class="mt-1 block w-full" 
                placeholder="Escribe tu nombre y apellidos para establecer contacto" 
            />
            <InputError :message="form.errors.name" class="mt-2" />
        </div>

        <div class="mt-4">
            <InputLabel for="email" value="Correo electrónico" />
            <TextInput 
                id="email" 
                type="email" 
                v-model="form.email" 
                @input="form.clearErrors('email')" 
                class="mt-1 block w-full" placeholder="tu@correo.com" 
            />
            <InputError :message="form.errors.email" class="mt-2" />
        </div>

        <div class="mt-4">
            <InputLabel for="message" value="Mensaje" />
            <textarea
                id="message"
                v-model="form.message"
                @input="form.clearErrors('message')"
                rows="5"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-800 transition-colors duration-200"
                :class="{ 'border-red-500': form.errors.message }"
                placeholder="¿En qué puedo ayudarte?"
            ></textarea>
            <InputError :message="form.errors.message" class="mt-2" />
        </div>

        <div class="mt-8 flex justify-end">
            <SecondaryButton type="button" @click="closeModal">
                Cancelar
            </SecondaryButton>

             <PrimaryButton
                type="submit"
                class="ml-3 inline-flex items-center transition-all duration-200" 
                :class="{ 
                    'opacity-50 cursor-not-allowed': form.processing,
                    'hover:bg-indigo-700': !form.processing 
                }"
                :disabled="form.processing"
            >
            <!-- <span 
                    v-if="form.processing" 
                    class="animate-spin mr-2 text-xl inline-block" 
                    v-show="form.processing"
                    aria-hidden="true"
                >
                    &#9696;
                </span> -->
                <svg 
                    v-if="form.processing" 
                    class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" 
                    xmlns="http://www.w3.org/2000/svg" 
                    fill="none" 
                    viewBox="0 0 24 24"
                >
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>

                <span class="font-medium">
                    {{ form.processing ? 'Enviando...' : 'Enviar Mensaje' }}
                </span>
            </PrimaryButton>        
        </div>
    </form>
</Modal>

<transition name="fade">
    <div 
        v-if="flashSuccess" 
        class="fixed top-24 left-1/2 -translate-x-1/2 z-[100] w-[90%] max-w-2xl"
    >
        <div class="relative overflow-hidden bg-green-500 text-white px-8 py-5 rounded-xl shadow-2xl flex items-center justify-between border border-green-400/50 backdrop-blur-sm bg-opacity-95">
            
            <div class="absolute top-0 left-0 h-1 bg-green-300/50 w-full">
                <div 
                    class="h-full bg-white transition-all linear"
                    :style="{ width: progressWidth + '%', transitionDuration: '5000ms' }"
                ></div>
            </div>

            <div class="flex items-center space-x-4 mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-semibold text-lg tracking-wide">{{ flashSuccess }}</span>
            </div>
            
            <button @click="flashSuccess = null" class="ml-4 hover:bg-green-600/50 rounded-full p-1 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
</transition>
</template>

<style scoped>
.linear {
  transition-timing-function: linear !important;
}

.fade-enter-active,
.fade-leave-active {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translate(-50%, -30px); /* El -50% mantiene el centrado */
}
</style>