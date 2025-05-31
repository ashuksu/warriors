import {defineConfig} from 'vite'
import {viteStaticCopy} from 'vite-plugin-static-copy'
import sharp from 'sharp'
import fs from 'fs/promises'
import path from 'path'

const imageConfig = {
    sizes: [400, 800, 1200],
    fallbackSize: 800,
    formats: ['webp'],
    quality: {
        webp: {
            400: 70,  // for small: mobile devices (DPR=1)
            800: 65,  // for medium: tablets, mobile devices (DPR=2, Retina, HiDPI)
            1200: 85  // for large: tablets, laptops (DPR=3, DPR=2, Retina, HiDPI)
        },
        jpeg: 80,
        png: 80
    },
    paths: {
        src: 'src/assets/images',
        dest: 'public/dist/assets/images'
    },
    // Files to copy without processing
    skipProcessing: ['svg', 'gif', 'webp'],
    // Files to process
    processFiles: ['jpg', 'jpeg', 'png']
}

const imagePlugin = () => ({
    name: 'image-optimizer',
    async writeBundle() {
        // Create a destination directory
        await fs.mkdir(imageConfig.paths.dest, {recursive: true})

        // Recursively get all files from the source directory
        const processDirectory = async (directory) => {
            const entries = await fs.readdir(directory, {withFileTypes: true})

            for (const entry of entries) {
                const srcPath = path.join(directory, entry.name)
                const relativePath = path.relative(imageConfig.paths.src, directory)
                const destDir = path.join(imageConfig.paths.dest, relativePath)

                if (entry.isDirectory()) {
                    // Process subdirectories recursively
                    await fs.mkdir(path.join(destDir, entry.name), {recursive: true})
                    await processDirectory(srcPath)
                    continue
                }

                const ext = path.extname(entry.name).toLowerCase().slice(1)
                const basename = path.basename(entry.name, `.${ext}`)

                // Simple copy files without processing from the skipProcessing list
                if (imageConfig.skipProcessing.includes(ext)) {
                    await fs.copyFile(
                        srcPath,
                        path.join(destDir, entry.name)
                    )
                    continue
                }

                // Process raster images
                if (imageConfig.processFiles.includes(ext)) {
                    const image = sharp(srcPath)

                    // WebP versions of all sizes
                    for (const size of imageConfig.sizes) {
                        await image
                            .resize(size, null, {
                                withoutEnlargement: true,
                                fit: 'inside'
                            })
                            .webp({
                                quality: typeof imageConfig.quality.webp === 'object'
                                    ? imageConfig.quality.webp[size]
                                    : imageConfig.quality.webp,
                                effort: 6
                            })
                            .toFile(path.join(
                                destDir,
                                `${basename}-${size}.webp`
                            ))
                    }

                    // Fallback in original format
                    await image
                        .resize(imageConfig.fallbackSize, null, {
                            withoutEnlargement: true,
                            fit: 'inside'
                        })
                        .toFile(path.join(
                            destDir,
                            `${basename}-${imageConfig.fallbackSize}.${ext}`
                        ))
                }
            }
        }

        await processDirectory(imageConfig.paths.src)
    }
})


export default defineConfig({
    build: {
        outDir: 'public/dist',
        manifest: true,
        copyPublicDir: false,
        rollupOptions: {
            input: {
                script: './src/js/script.js',
                main: './src/styles/main.scss',
                page_home: './src/styles/page_home.scss',
                page_home_critical: './src/styles/page_home_critical.scss',
                critical: './src/styles/critical.scss'
            },
            output: {
                manualChunks(id) {
                    const moduleChunks = {
                        'modules/Menu.js': 'menu',
                        'modules/Overlay.js': 'menu',
                        'modules/utils/SeeMore.js': 'utils'
                    };

                    const chunk = Object.entries(moduleChunks).find(([path]) => id.includes(path));
                    return chunk ? chunk[1] : undefined;
                },
                entryFileNames: 'js/[name].[hash].js',
                chunkFileNames: 'js/[name].[hash].js',
                assetFileNames: ({name}) => {
                    if (/\.(css|scss)$/.test(name ?? '')) {
                        return 'styles/[name].[hash].min[extname]'
                    }
                    if (/\.(gif|jpe?g|png|svg)$/.test(name ?? '')) {
                        return 'assets/images/[name].[hash][extname]'  // Matches imagePlugin
                    }
                    return 'assets/[name]-[hash].min[extname]'
                }
            }
        }
    },
    plugins: [
        imagePlugin(),
        viteStaticCopy({
            targets: [
                // example of static files copying
                // {
                //     src: ['src/assets/fonts/**/*'],
                //     dest: 'assets/fonts'
                // },
                // {
                //     src: ['src/assets/docs/**/*'],
                //     dest: 'assets/docs'
                // }
            ]
        })
    ],
    server: {
        port: 5173,
        strictPort: true,
        host: true,
        // hmr: false,
        origin: 'http://localhost:5173',
        proxy: {
            '^(?!/[@vite/client|src/]).*': {
                target: 'http://localhost:8080',
                changeOrigin: true
            }
        }
    }
})