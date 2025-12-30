import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'
import vue from '@vitejs/plugin-vue';


export default defineConfig({
  plugins: [
    vue(),
    tailwindcss(),
  ],
  optimizeDeps: {
    include: ['chart.js/auto'],
    force: false, // Set to true if you continue to have cache issues
  },
  server: {
    fs: {
      strict: false,
    },
  },
})