<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
//import Welcome from '@/Components/Welcome.vue';


</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">                
                <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6 border-b border-gray-200 text-xl">
                    <!-- <Welcome /> -->
                     <p class="mb-5 font-semibold text-gray-700">Your Resources</p>
                    <ul class="space-y-4">
                        <li class="flex items-center">
                            <div class="bg-gray-400 h-2 w-2 rounded-full mr-3"></div>
                            <Link 
                                :href="route('skills.index')"
                                class="text-sm text-indigo-500 hover:text-gray-800 transition-colors"
                            >
                                Skills
                            </Link>
                        </li>
                        
                        <li class="flex items-center">
                            <div class="bg-gray-400 h-2 w-2 rounded-full mr-3"></div>
                            <Link 
                                :href="route('projects.index')"
                                class="text-sm text-indigo-500 hover:text-gray-800 transition-colors"
                            >
                                Projects
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
