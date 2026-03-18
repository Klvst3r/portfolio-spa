<script setup>
defineProps({
    type: {
        type: String,
        default: "submit",
    },
});
</script>
<template>
    <button
        :type="type"
        :class="[
            'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150',
            // Si NO pasas ninguna clase de fondo en el componente, usará la gris por defecto
            $attrs.class
                ? ''
                : 'bg-gray-800 text-white hover:bg-gray-700 active:bg-gray-900 focus:bg-gray-700 focus:ring-indigo-500',
        ]"
    >
        <slot />
    </button>
</template>
