<template>
    <section
       class="flex items-center px-44 py-4 justify-between border-b border-gray-500/30 hover:bg-gray-500/5 transition-colors"
    >
        <div
            :class="[color]"
            class="h-24 w-24 rounded-2xl flex items-center justify-center shrink-0 shadow-lg"
        >
            <slot></slot>
        </div>

        <p class="text-xl font-extrabold mx-10 flex-1 leading-none uppercase">
            {{ title }}
        </p>

        <p
            class="text-xl mx-10 flex-1 leading-tight text-gray-400 font-light italic"
        >
            {{ description }}
        </p>
    </section>
</template>

<script setup>
defineProps({
    title: String,
    description: String,
    color: String,
});
</script>
