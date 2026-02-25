<template>
    <div class="flex items-center space-x-4 p-2">
        <div
            :class="background"
            class="h-20 w-20 flex-shrink-0 rounded-full border-8 border-double flex items-center justify-center shadow-sm"
        >
            <span class="text-xl font-extrabold text-gray-800">
                <slot name="icon"></slot>
            </span>
        </div>

        <div class="flex-1">
            <h3
                class="text-lg font-bold text-gray-700 uppercase tracking-wider"
            >
                <slot name="name"></slot>
            </h3>
            <p class="text-sm text-gray-500">
                <slot name="level"></slot>
            </p>
        </div>
    </div>
</template>

<script setup>
defineProps({
    background: {
        type: String,
        default: "bg-gray-200 border-gray-400",
    },
});
</script>
