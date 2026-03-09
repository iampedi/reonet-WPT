/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.php", "./assets/src/**/*.{js,ts,jsx,tsx}"],
  theme: {
    extend: {
      fontFamily: {
        jost: ["Jost", "sans-serif"],
      },
    },
  },
  plugins: [],
};
