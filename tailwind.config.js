/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          primary: '#87ceeb',
          hover: '#66bce6',
          tint: '#f4f9fc',
          alert: '#0284c7',
        },
        slate: {
          800: '#1e293b',
          500: '#64748b',
        }
      },
      fontFamily: {
        sans: ['Poppins', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
