import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',
        './resources/js/**/*.tsx',
        './resources/js/**/*.js',
        './resources/js/**/*.ts',
    ],

    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: '#10b981', // emerald-500
                    foreground: '#ffffff',
                },
                secondary: {
                    DEFAULT: '#064e3b', // emerald-900
                    foreground: '#f0fdf4',
                },
                background: '#ffffff',
                foreground: '#0f172a',
                muted: {
                    DEFAULT: '#f1f5f9',
                    foreground: '#64748b',
                },
                accent: {
                    DEFAULT: '#f1f5f9',
                    foreground: '#0f172a',
                },
                card: {
                    DEFAULT: '#ffffff',
                    foreground: '#0f172a',
                },
                border: '#e2e8f0',
                input: '#e2e8f0',
                ring: '#10b981',
            },
            borderRadius: {
                lg: '0.75rem',
                md: 'calc(0.75rem - 2px)',
                sm: 'calc(0.75rem - 4px)',
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};