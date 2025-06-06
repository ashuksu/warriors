import {defineConfig, loadEnv} from 'vite'; // Import loadEnv
import {viteStaticCopy} from 'vite-plugin-static-copy'
import sharp from 'sharp'
import fs from 'fs/promises'
import path from 'path'
import cliProgress from 'cli-progress'
import md5 from 'md5'
import fullReload from 'vite-plugin-full-reload'

/**
 * @typedef {Object} ImageQualityConfig
 * @property {Object.<number, number>} webp - Quality settings for WebP format, keyed by size.
 * @property {number} jpeg - Quality setting for JPEG format.
 * @property {number} png - Quality setting for PNG format.
 */

/**
 * @typedef {Object} ImagePathsConfig
 * @property {string} src - Source directory for images.
 * @property {string} dest - Destination directory for processed images.
 * @property {string} cache - Directory for caching processed images.
 */

/**
 * @typedef {Object} SharpInstanceConfig
 * @property {number|false} limitInputPixels - Limit for input image pixels (0 or false to disable).
 * @property {boolean} fastShrinkOnLoad - Whether to use fast shrink on load.
 */

/**
 * @typedef {Object} ImagePluginConfig
 * @property {number[]} sizes - Array of widths to resize images to.
 * @property {number} fallbackSize - Width for the fallback image in its original format.
 * @property {string[]} formats - Target formats (primarily 'webp' is used in generation logic alongside original format).
 * @property {ImageQualityConfig} quality - Quality settings for different image formats and sizes.
 * @property {ImagePathsConfig} paths - Configuration for source, destination, and cache paths.
 * @property {string[]} skipProcessing - File extensions to copy directly without processing.
 * @property {string[]} processFiles - File extensions to process (e.g., resize, reformat).
 * @property {SharpInstanceConfig} sharp - Configuration options for the Sharp library.
 */

/** @type {ImagePluginConfig} */
const imageConfig = {
    sizes: [1200, 800, 400],
    fallbackSize: 800,
    formats: ['webp'],
    quality: {
        webp: {
            1200: 85,  // for large: tablets, laptops (DPR=3, DPR=2, Retina, HiDPI)
            800: 65,  // for medium: tablets, mobile devices (DPR=2, Retina, HiDPI)
            400: 70  // for small: mobile devices (DPR=1)
        },
        jpeg: 75,
        png: 75
    },
    paths: {
        src: 'src/assets/images',
        dest: 'public/dist/assets/images',
        cache: '.cache'
    },
    skipProcessing: ['svg', 'gif', 'webp'],
    processFiles: ['jpg', 'jpeg', 'png'],
    sharp: {
        limitInputPixels: 0,
        fastShrinkOnLoad: true
    }
}

/**
 * Recursively gets all file paths from a directory.
 * @param {string} dirPath - The directory path to scan.
 * @param {string[]} files - Accumulator for file paths.
 * @returns {Promise<string[]>} A promise that resolves to an array of full file paths.
 */
const getAllFiles = async (dirPath, files = []) => {
    const entries = await fs.readdir(dirPath, {withFileTypes: true})

    for (const entry of entries) {
        const fullPath = path.join(dirPath, entry.name)

        if (entry.isDirectory()) {
            await getAllFiles(fullPath, files)
        } else {
            files.push(fullPath)
        }
    }

    return files
}

/**
 * Processes an image with caching.
 * @param {string} srcPath - Full path to the source image.
 * @param {string} destPath - Full path to the destination for the processed image.
 * @param {number} size - Target width for resizing.
 * @param {string} format - Target format (e.g., 'webp', 'jpeg', 'png').
 * @param {cliProgress.SingleBar} progressBar - The progress bar instance to update.
 * @returns {Promise<void>}
 */
const processImageWithCache = async (srcPath, destPath, size, format, progressBar) => {
    const fileContent = await fs.readFile(srcPath)
    const contentHash = md5(fileContent)
    const cacheKey = `${path.basename(srcPath)}-${contentHash}-${size}-${format}`
    const cachePath = path.join(imageConfig.paths.cache, cacheKey)

    try {
        await fs.access(cachePath)
        progressBar.update({operation: 'Cached (Copying)...', filename: ''});
        await fs.copyFile(cachePath, destPath)
    } catch {
        progressBar.update({operation: 'Processing...', filename: ''});
        const image = sharp(srcPath, imageConfig.sharp)
        await fs.mkdir(path.dirname(destPath), {recursive: true})

        let CtxImage = image.resize(size, null, {
            withoutEnlargement: true,
            fit: 'inside'
        });

        if (format === 'webp') {
            CtxImage = CtxImage.webp({
                quality: typeof imageConfig.quality.webp === 'object'
                    ? imageConfig.quality.webp[size] || 75 // Default quality if size not in config
                    : imageConfig.quality.webp,
                effort: 6
            });
        } else if (format === 'jpeg' || format === 'jpg') {
            CtxImage = CtxImage.jpeg({
                quality: imageConfig.quality.jpeg
            });
        } else if (format === 'png') {
            CtxImage = CtxImage.png({
                quality: imageConfig.quality.png
            });
        }
        await CtxImage.toFile(destPath)
        await fs.copyFile(destPath, cachePath)
    }
}

/**
 * Handles a single file: copies or processes into multiple formats/sizes.
 * Updates the progress bar payload to reflect the current operation.
 * @param {string} srcPath - Full path to the source file.
 * @param {string} destDir - Destination directory for the output files.
 * @param {string} basename - Base name of the file (without extension).
 * @param {string} ext - Extension of the file (without dot).
 * @param {cliProgress.SingleBar} progressBar - The progress bar instance to update.
 * @returns {Promise<void>}
 */
const processFile = async (srcPath, destDir, basename, ext, progressBar) => {
    await fs.mkdir(destDir, {recursive: true});
    const currentFilename = `${basename}.${ext}`;

    if (imageConfig.skipProcessing.includes(ext)) {
        progressBar.update({operation: 'Copying...', filename: ''});
        const destPath = path.join(destDir, currentFilename)
        await fs.copyFile(srcPath, destPath)
        return
    }

    if (imageConfig.processFiles.includes(ext)) {
        progressBar.update({operation: 'Processing...', filename: ''});
        const tasks = []

        // Generate WebP versions for specified sizes
        for (const size of imageConfig.sizes) {
            tasks.push(processImageWithCache(
                srcPath,
                path.join(destDir, `${basename}-${size}.webp`),
                size,
                'webp',
                progressBar
            ))
        }

        // Generate a fallback image in its original format and specified fallback size
        tasks.push(processImageWithCache(
            srcPath,
            path.join(destDir, `${basename}-${imageConfig.fallbackSize}.${ext}`),
            imageConfig.fallbackSize,
            ext,
            progressBar
        ))

        await Promise.all(tasks)
    }
}

/**
 * Vite plugin to optimize images.
 * @returns {import('vite').Plugin}
 */
const imagePlugin = () => ({
    name: 'image-optimizer',
    async writeBundle() {
        console.log('Starting image optimization...');
        await fs.mkdir(imageConfig.paths.dest, {recursive: true})
        await fs.mkdir(imageConfig.paths.cache, {recursive: true})

        const allSrcFiles = await getAllFiles(imageConfig.paths.src)
        if (allSrcFiles.length === 0) {
            console.log('No files found in source image directory. Skipping image optimization.');
            return;
        }

        console.log(`Found ${allSrcFiles.length} files to potentially process or copy.`);

        const progressBar = new cliProgress.SingleBar({
            format: 'Optimizing Images: [{bar}] {percentage}% | ETA: {eta_formatted} | {value}/{total} | {operation} {filename}'
        }, cliProgress.Presets.shades_classic);

        progressBar.start(allSrcFiles.length, 0, {operation: 'Initializing...', filename: 'N/A'});

        const tasks = allSrcFiles.map(async (filePath) => {
            const relativeDir = path.relative(imageConfig.paths.src, path.dirname(filePath));
            const destDir = path.join(imageConfig.paths.dest, relativeDir);
            const ext = path.extname(filePath).toLowerCase().slice(1);
            const basename = path.basename(filePath, `.${ext}`);

            // processFile will update the payload (operation, filename)
            await processFile(filePath, destDir, basename, ext, progressBar);
            progressBar.increment(); // Increment advances the counter
        });

        try {
            await Promise.all(tasks);
            progressBar.stop();
            console.log('Image processing and copying completed successfully.');
        } catch (error) {
            progressBar.stop();
            console.error('\nError during image processing:', error);
            throw error;
        }
    }
})

export default defineConfig(({mode}) => {
    const env = loadEnv(mode, process.cwd(), '');

    const plugins = [
        imagePlugin(),
        viteStaticCopy({
            targets: [
                // example of static files copying
                // {
                //     src: ['src/assets/fonts/**/*'],
                //     dest: 'assets/fonts'
                // },
            ]
        }),
        // Add fullReload plugin to watch PHP template files and public assets
        fullReload([
            './app/Views/**/*',
            './public/**/*.php',
            './public/**/*.html',
            './app/Controllers/**/*',
            './app/Helpers/**/*'
        ])
    ];

    if (env.ENABLE_FULL_RELOAD === 'true') {
        plugins.push(
            fullReload([
                './app/Views/**/*',
                './app/Controllers/**/*',
                './app/Helpers/**/*',
                './public/**/*.php', // Watch PHP and HTML files in public
                './public/**/*.html'
            ])
        );
    }

    return {
        build: {
            outDir: 'public/dist',
            manifest: true,
            copyPublicDir: false,
            emptyOutDir: true,
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
                            return 'assets/images/[name].[hash][extname]'
                        }
                        return 'assets/[name]-[hash].min[extname]'
                    }
                }
            }
        },
        plugins: plugins,
        server: {
            port: 5173,
            strictPort: true,
            host: '0.0.0.0',
            hmr: env.ENABLE_HMR === 'true' ? {
                host: 'localhost',
                port: 5173,
            } : false, // Conditionally enable HMR
            origin: 'http://localhost:5173',
        }
    };
});