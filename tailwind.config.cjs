/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./resources/**/*.html",
    ],
    theme: {
        extend: {
            colors: {
                'parlamento': {
                    azul: '#1a3a5c',
                    'azul-claro': '#2a5a8c',
                    oro: '#c9a84c',
                    'oro-claro': '#dbb95c',
                }
            }
        },
    },
    plugins: [],
};