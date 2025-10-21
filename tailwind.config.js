import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    safelist: [
        { pattern: /(bg)-(red|orange|green|yellow|amber)-(50|100)/ },
        { pattern: /(border)-(red|orange|green|yellow|amber)-200/ },
        { pattern: /(text)-(red|orange|green|yellow|amber)-(600|700)/ },
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};
