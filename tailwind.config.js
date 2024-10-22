const defaultTheme = require('tailwindcss/defaultTheme')
const colors = require('tailwindcss/colors')

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                sarabun: ['Sarabun', ...defaultTheme.fontFamily.sans]
            },

            colors: {
                dark: {
                    'eval-0': '#151823',
                    'eval-1': '#222738',
                    'eval-2': '#2A2F42',
                    'eval-3': '#2C3142',
                },
                'primary': {
                    DEFAULT: colors.blue[500],
                    ...colors.blue
                },
                'danger': {
                    DEFAULT: colors.rose[500],
                    ...colors.rose
                },
                'success': {
                    DEFAULT: colors.emerald[500],
                    ...colors.emerald
                },
                'warning': {
                    DEFAULT: colors.yellow[500],
                    ...colors.yellow
                },
                'secondary': {
                    DEFAULT: colors.gray[500],
                    ...colors.gray
                },
                'info': {
                    DEFAULT: colors.sky[500],
                    ...colors.sky
                }
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
}
