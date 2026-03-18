<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Components/Button.vue"; // Usando el que ya te funcionó en Welcome
import { Link } from "@inertiajs/vue3";

defineProps({
    skills: Array,
});
</script>

<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Skills
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <table v-if="skills.length > 0" class="w-full">
                    <thead class="border-b-2 border-gray-300 text-indigo-600">
                        <tr>
                            <th class="px-6 py-3 text-left">Name</th>
                            <th class="px-6 py-3 text-left">Color</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody v-for="skill in skills">
                        <tr
                            class="text-sm text-indigo-900 border-b border-gray-400"
                        >
                            <td class="px-6 py-4">
                                {{ skill.name }}
                            </td>
                            <td class="px-6 py-4">
                                <p>
                                    <span
                                        class="mr-5 p-4 rounded"
                                        :class="skill.color"
                                    ></span>
                                    {{ skill.color }}
                                </p>
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
