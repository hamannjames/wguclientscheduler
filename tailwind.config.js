const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ], 

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
              'ml-blue': "#77d4fc"
            },
            maxWidth: {
              '8xl': '88rem'
            },
            width: {
                '120': '30rem',
                '112': '28rem',
                '104': '26rem'
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
