/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        dark: '#0e0e0e',
        'dark-card': '#1a1a1a',
        'dark-lighter': '#2a2a2a',
        neon: '#facc15',
      },
      aspectRatio: {
        'movie': '1.7/1',
      }
    },
  },
  plugins: [],
}