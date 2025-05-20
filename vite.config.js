import {defineConfig} from 'vite'
import {viteStaticCopy} from 'vite-plugin-static-copy'

export default defineConfig({
    // root: './',
    // base: '/',
    build: {
        outDir: 'public/dist',
        manifest: true,
        copyPublicDir: false,
        rollupOptions: {
            input: {
                script: './src/js/script.js',
                style: './src/css/style.css',
                criticalStyles: './src/css/criticalStyles.css',
                main: './src/scss/main.scss'
            },
            output: {
                manualChunks: undefined,
                entryFileNames: 'js/[name].[hash].js',
                chunkFileNames: 'js/[name].[hash].js',
                assetFileNames: ({name}) => {
                    if (/\.(gif|jpe?g|png|svg)$/.test(name ?? '')) {
                        return 'assets/[name].[hash][extname]'
                    }
                    if (/\.(css|scss)$/.test(name ?? '')) {
                        return 'css/[name].[hash].min[extname]'
                    }
                    return 'assets/[name]-[hash].min[extname]'
                }
            }
        }
    },
    plugins: [
        viteStaticCopy({
            targets: [{
                src: 'src/assets/**/*',
                dest: 'assets'
            }]
        })
    ],
    server: {
        port: 5173,
        strictPort: true,
        host: true,
        origin: 'http://localhost:5173',
        proxy: {
            '^(?!/[@vite/client|src/]).*': {
                target: 'http://localhost:8080',
                changeOrigin: true
            }
        }
    }
})