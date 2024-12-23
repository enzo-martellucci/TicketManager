/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      colors: {
        darkBlue: '#01161E',
        blue: '#124559',
        lightBlue: '#598392',
        darkCream: '#AEC3B0',
        lightCream: '#EFF6E0',
      },
    },
  },
  plugins: [],
};