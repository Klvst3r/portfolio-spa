<template>
    <section class="flex items-center justify-center p-4">
        <div
            :class="background"
            class="h-24 w-24 rounded-full border-8 border-double flex items-center justify-center"
        >
            <p class="text-2xl font-extrabold text-gray-800 mx-1">
                <slot></slot>
            </p>
        </div>
    </section>
</template>

<script setup>
// Usando script setup para ser consistente con Welcome.vue
defineProps({
    background: String,
});
</script>
