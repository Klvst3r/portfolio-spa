<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Components/Button.vue"; // Usando el que ya te funcionó en Welcome
import { Link } from "@inertiajs/vue3";

// importacion de iconos
import * as SolidIcons from "@heroicons/vue/24/solid";

const getIcon = (iconName) => {
    const name = `${iconName || "Briefcase"}Icon`;
    return SolidIcons[name] || SolidIcons.BriefcaseIcon;
};

//Se define el objeto de Projects
defineProps({
    projects: Array,
});
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
                <table v-if="projects.length > 0" class="w-full">
                    <thead class="border-b-2 border-gray-300 text-indigo-600">
                        <tr>
                            <th class="px-6 py-3 text-left">Title</th>
                            <th class="px-6 py-3 text-left">Description</th>
                            <th class="px-6 py-3 text-left">Color</th>
                            <th class="px-6 py-3 text-left">Icon</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody v-if="projects.length > 0">
                        <tr
                            v-for="(project, index) in projects"
                            :key="project.id"
                            class="text-sm text-indigo-900 border-b border-gray-400"
                        >
                            <td class="px-6 py-4">
                                {{ project.title }}
                            </td>
                            <td class="px-6 py-4">
                                {{ project.description }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="mr-2 p-2 rounded"
                                    :class="project.color"
                                ></span>
                                {{ project.color }}
                            </td>
                            <td class="px-6 py-4">
                                <component
                                    :is="getIcon(project.icon_name)"
                                    class="h-6 w-6"
                                    :class="
                                        project.color.replace('bg-', 'text-')
                                    "
                                />
                            </td>
                            <td class="px-6 py-4">
                                <JetButton
                                    class="bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500 mr-2"
                                >
                                    Edit
                                </JetButton>

                                <JetButton
                                    class="bg-red-600 text-white hover:bg-red-700 focus:ring-red-500 ml-2"
                                >
                                    Delete
                                </JetButton>
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
