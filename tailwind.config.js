/** @type {import('tailwindcss').Config} */

const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./node_modules/flowbite/**/*.js" ,
        "./app/View/Components/**/*.php",
    ],

    safelist: [
        'bg-adm-primary',
        'text-adm-primary',
        'border-adm-primary',
        'hover:bg-adm-primary',
        'hover:text-adm-primary',
        'hover:border-adm-primary/30',
        'focus:ring-adm-primary/20',
        'bg-adm-primary/10',

        'bg-primary',
        'text-primary',
        'border-primary',
        'hover:bg-primary',
        'hover:text-primary',
        'hover:border-primary/30',
        'focus:ring-primary/20',
        'bg-primary/10',
    ],

    theme: {
        extend: {
            colors: {
                'primary': '#61D483',
                'adm-primary': '#61a0d4ff',
                'secondary': '#2A683D',
                'bg': '#F5F6F7',
                'danger': '#D46161',
                'success': '#dffff0ff',
                'border-success': '#A4F4CF',
                'bg-success': '#f3fffaff',
                'text-success': '#004f3b',
                'error': '#FFF1F2',
                'border-error': '#FFCCD3',
                'bg-error': '#fffafaff',
                'text-error': '#8B0836',
                'warning': '#FFF7ED',
                'border-warning': '#FFD7A8',
                'bg-warning': '#fffcf7ff',
                'text-warning': '#7E2A0C',
                'inative': '#919191',
            },

            fontFamily: {
                'sans': ['Poppins', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [
        require('flowbite/plugin')
    ],
}