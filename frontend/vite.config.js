import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import { readFileSync } from 'fs'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  server: {
    host: 'spoodler', // Allow access via "spoodler"
    port: 3000,
    https: {
      key: readFileSync('./path/to/your-key.pem'),
      cert: readFileSync('./path/to/your-cert.pem')
    },
    proxy: {
      '/api': {
        target: 'https://localhost:8443',
        changeOrigin: true,
        secure: false // To enable self signed certificates
      }
    }
  }
})
