import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
  // Base public path when served in production
  base: '/assets/',
  
  // Define the build output directory
  build: {
    // Output directory for the built files
    outDir: 'public/assets/dist',
    
    // Generate manifest.json in the output directory
    manifest: true,
    
    // Configure rollup options
    rollupOptions: {
      // Specify input entry points
      input: {
        main: resolve(__dirname, 'src/js/main.js'),
        style: resolve(__dirname, 'src/css/style.css'),
      },
      
      // Configure output options
      output: {
        // Define output file naming pattern
        entryFileNames: 'js/[name]-[hash].js',
        chunkFileNames: 'js/[name]-[hash].js',
        assetFileNames: (assetInfo) => {
          // Put CSS files in the css directory
          if (assetInfo.name.endsWith('.css')) {
            return 'css/[name]-[hash][extname]';
          }
          // Put other assets in their respective directories
          return 'assets/[name]-[hash][extname]';
        },
      },
    },
  },
  
  // Configure the development server
  server: {
    // Specify host and port
    host: '0.0.0.0',
    port: 3000,
    
    // Configure HMR (Hot Module Replacement)
    hmr: {
      // Enable HMR over HTTPS
      protocol: 'ws',
      host: 'localhost',
    },
    
    // Configure proxy for API requests
    proxy: {
      // Proxy API requests to the PHP server
      '/api': {
        target: 'http://localhost:8080',
        changeOrigin: true,
      },
    },
  },
  
  // Configure CSS processing
  css: {
    // Enable CSS modules
    modules: false,
    
    // Configure preprocessors
    preprocessorOptions: {
      // Add any preprocessor options here
    },
  },
  
  // Configure asset handling
  assetsInclude: ['**/*.svg', '**/*.png', '**/*.jpg', '**/*.gif'],
  
  // Configure plugins
  plugins: [
    // Add any plugins here
  ],
});