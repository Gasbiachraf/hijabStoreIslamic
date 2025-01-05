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
            colors:{
                "alpha" : "#B19D7B",
                "beta" : "#D7D5CD",
                "gamma" : "#7E4F02",
                "delta" : "#CFC4AF",
                "teta" : "#E9E8E4"
            }
        },
    },

    plugins: [forms],
};
