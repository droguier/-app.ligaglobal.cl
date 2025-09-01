import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/Http/Resources/**/*.blade.php',
        './app/Http/Resources/**/*.js',
        './app/Http/Resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                'pastel-rosa': '#FFE4EC',
                // ...otros colores
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};
