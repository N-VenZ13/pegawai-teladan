/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./node_modules/flowbite/**/*.js",
    ],

    theme: {
        extend: {
            // Kita tidak meng-extend fontFamily untuk sementara
            // untuk menghindari require('tailwindcss/defaultTheme')
            colors: {
                "brand-blue": "#36A4E1",
                "brand-orange": "#F28F25",
                "brand-green": "#74B848",
                "brand-amber": "#F59E0B", // Kuning/Oren aksen
                "brand-teal": "#14B8A6", // Hijau sukses
                "brand-rose": "#E11D48", // Merah bahaya
                "brand-dark": "#1B3446",
            },
        },
    },

    plugins: [require("@tailwindcss/forms"), require("flowbite/plugin")],
};
