import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import { readFileSync } from 'fs'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  server: {
    host: '0.0.0.0',
    port: 3443,
    https: {
      key: readFileSync('./ssl/key.pem'),
      cert: readFileSync('./ssl/cert.pem')
    },
    proxy: {
      '/api': {
        target: 'https://nginx:443',
        changeOrigin: true,
        secure: false // To enable self signed certificates
      }
    }
  }
})
