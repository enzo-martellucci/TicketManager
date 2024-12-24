/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
    ],
    theme: {
        extend: {
            colors: {
                'dark-blue': '#01161E',
                'blue': '#124559',
                'light-blue': '#598392',
                'dark-cream': '#AEC3B0',
                'light-cream': '#EFF6E0',
            },
        },
    },
    plugins: [],
}
