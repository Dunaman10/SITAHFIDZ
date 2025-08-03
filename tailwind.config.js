// tailwind.config.js
module.exports = {
  content: [
    "./resources/**/*.blade.php", // Semua blade file
    "./resources/**/*.js", // Jika kamu pakai JavaScript
    "./resources/**/*.vue", // Jika kamu pakai Vue
    "./app/**/*.php", // Komponen Filament bisa ada di folder ini
    "./storage/framework/views/*.php", // Untuk cached views Laravel
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};
