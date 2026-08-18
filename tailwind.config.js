import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                gold: {
                    50: '#FBF4E7',
                    100: '#F5E6C8',
                    300: '#E2C179',
                    500: '#C99E43',
                    600: '#B08A35',
                    900: '#5C4720',
                },
            },
        },
    },

    plugins: [forms],
};