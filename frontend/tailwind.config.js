/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      fontFamily: {
        'sans': ['Roboto', 'sans-serif'],
      },
      colors: {
        primary: "#0A192F",
        highlight: "#0077FF",
        softBlue: "#00A8E8",
        secondary: "#728EB8",
        softGray: "#D1D5DB",
        error: "#FF3B30",
        warning: "#FFA500",
        success: "#32D74B",
      },
    },
  },
  plugins: [],
}
