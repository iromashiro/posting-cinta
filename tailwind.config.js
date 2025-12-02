import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    safelist: [
        { pattern: /(bg)-(red|orange|green|yellow|amber)-(50|100)/ },
        { pattern: /(border)-(red|orange|green|yellow|amber)-200/ },
        { pattern: /(text)-(red|orange|green|yellow|amber)-(600|700)/ },
    ],
    theme: {
        extend: {
            colors: {
                // Primary - Soft Rose Pink (girly & warm)
                primary: {
                    50: '#FFF5F7',
                    100: '#FFEBEF',
                    200: '#FFD6DE',
                    300: '#FFB3C4',
                    400: '#FF8FA9',
                    500: '#FF6B8A',
                    600: '#F04D6F',
                    700: '#D93A5C',
                    800: '#B82E4A',
                    900: '#8B233A',
                },
                // Secondary - Soft Mint (fresh & calming)
                secondary: {
                    50: '#F0FDF9',
                    100: '#CCFBEB',
                    200: '#9AF5D8',
                    300: '#5EE9C0',
                    400: '#2DD4A5',
                    500: '#14B88D',
                    600: '#0D9472',
                    700: '#0F755D',
                    800: '#115D4B',
                    900: '#124D3F',
                },
                // Accent - Soft Lavender (girly accent)
                accent: {
                    50: '#FAF5FF',
                    100: '#F3E8FF',
                    200: '#E9D5FF',
                    300: '#D8B4FE',
                    400: '#C084FC',
                    500: '#A855F7',
                    600: '#9333EA',
                    700: '#7E22CE',
                    800: '#6B21A8',
                    900: '#581C87',
                },
                // Warm - Peach (cozy accent)
                warm: {
                    50: '#FFF7ED',
                    100: '#FFEDD5',
                    200: '#FED7AA',
                    300: '#FDBA74',
                    400: '#FB923C',
                    500: '#F97316',
                    600: '#EA580C',
                    700: '#C2410C',
                    800: '#9A3412',
                    900: '#7C2D12',
                },
                // Neutral - Soft Warm Gray
                neutral: {
                    50: '#FDFCFB',
                    100: '#F9F7F5',
                    200: '#F0EDEA',
                    300: '#E2DDD8',
                    400: '#B8B0A8',
                    500: '#8A8178',
                    600: '#665E56',
                    700: '#4D4740',
                    800: '#33302B',
                    900: '#1A1816',
                },
            },
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                heading: ['Quicksand', ...defaultTheme.fontFamily.sans],
            },
            borderRadius: {
                '2xl': '1rem',
                '3xl': '1.5rem',
                '4xl': '2rem',
            },
            boxShadow: {
                'soft': '0 4px 20px -2px rgba(255, 107, 138, 0.15)',
                'soft-lg': '0 10px 40px -10px rgba(255, 107, 138, 0.2)',
                'card': '0 2px 12px -2px rgba(0, 0, 0, 0.06)',
                'card-hover': '0 8px 24px -4px rgba(255, 107, 138, 0.15)',
                'dreamy': '0 4px 30px -5px rgba(168, 85, 247, 0.12)',
                'glow': '0 0 20px rgba(255, 107, 138, 0.3)',
                'inner-glow': 'inset 0 2px 4px 0 rgba(255, 255, 255, 0.5)',
            },
            backgroundImage: {
                'gradient-girly': 'linear-gradient(135deg, #FFF5F7 0%, #FAF5FF 50%, #F0FDF9 100%)',
                'gradient-primary': 'linear-gradient(135deg, #FF8FA9 0%, #FF6B8A 100%)',
                'gradient-accent': 'linear-gradient(135deg, #E9D5FF 0%, #FFD6DE 100%)',
                'gradient-warm': 'linear-gradient(135deg, #FFEDD5 0%, #FFD6DE 100%)',
                'gradient-fresh': 'linear-gradient(135deg, #CCFBEB 0%, #E9D5FF 100%)',
                'pattern-dots': 'radial-gradient(circle, #FFD6DE 1px, transparent 1px)',
            },
            animation: {
                'float': 'float 6s ease-in-out infinite',
                'pulse-soft': 'pulse-soft 2s ease-in-out infinite',
                'wiggle': 'wiggle 1s ease-in-out infinite',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
                'pulse-soft': {
                    '0%, 100%': { opacity: 1 },
                    '50%': { opacity: 0.7 },
                },
                wiggle: {
                    '0%, 100%': { transform: 'rotate(-3deg)' },
                    '50%': { transform: 'rotate(3deg)' },
                },
            },
        },
    },
    plugins: [],
};
