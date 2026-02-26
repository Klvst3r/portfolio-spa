import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./resources/json/*.json",
    ],
    // AGREGA ESTA SECCIÓN
    safelist: [
        {
            // Patrón para fondos: bg-color-nivel
            pattern:
                /bg-(red|blue|green|yellow|indigo|purple|pink|orange|emerald|rose|sky|gray|violet)-(100|400|500|600|700|800)/,
        },
        {
            // Patrón para bordes: border-color-nivel (Necesario para tus Skills)
            pattern:
                /border-(red|blue|green|yellow|indigo|purple|pink|orange|emerald|rose|sky|gray|violet)-(400|500|600|700|800)/,
        },
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, typography],
};
