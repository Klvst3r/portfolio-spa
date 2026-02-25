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
            // Este patrón busca cualquier clase de fondo con nivel 400 o 500
            // Puedes ajustarlo según los colores que tengas en tu customization.json
            pattern:
                /bg-(red|blue|green|yellow|indigo|purple|pink|orange|emerald|rose|sky|gray)-(400|500|600|700|800)/,
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
