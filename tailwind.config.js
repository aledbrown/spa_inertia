import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    daisyui: {
        darkTheme: "light",
        base: true,
        styled: true,
        themes: ["light",
            {
                spa_theme: {
                    ...require("daisyui/src/theming/themes")["light"],
                    "primary": "#89002e",
                    "secondary": "#707070",
                    "accent": "#6d28d9",
                    "neutral": "#2a323c",// light text
                    "base-100": "#e0e0e0", // "#1d232a" modal background
                    "info": "#C30037", //#00b5ff
                    "success": "#198754",
                    "warning": "#ffc107",
                    "error": "#89002e",
                },
            },
        ],
    },

    plugins: [forms, require("daisyui")],
};
