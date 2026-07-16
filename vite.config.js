import path from 'path';
import { defineConfig } from 'vite';

function watchDirs() {
  return {
    name: 'watch-dirs',
    buildStart() {
      this.addWatchFile(path.resolve(__dirname, 'assets/js'));
      this.addWatchFile(path.resolve(__dirname, 'assets/scss'));
    },
  };
}

export default defineConfig({
  root: __dirname,

  plugins: [watchDirs()],

  resolve: {
    alias: {
      '@scss': path.resolve(__dirname, 'assets/scss'),
    },
  },

  server: {
    watch: {
      usePolling: true,      // ensures watch works on all OS / environments
      interval: 100,         // faster polling
    },
    hmr: false,              // disable Vite HMR (WordPress doesn't use it)
  },

  build: {
    outDir: 'dist',
    emptyOutDir: false,      // prevents dist from being wiped (optional)

    // watch mode only when running locally, not in CI/GitHub Actions
    watch: process.env.CI ? null : {
      include: [
        'assets/js/**/*',
        'assets/scss/**/*',
      ],
      exclude: [
        'node_modules/**'
      ],
      chokidar: {
        usePolling: true,
        interval: 100,
      },
    },

    rollupOptions: {
      input: {
        main: path.resolve(__dirname, 'assets/js/main.js'),
        style: path.resolve(__dirname, 'assets/scss/style.scss'),
      },

      output: {
        entryFileNames: '[name].bundle.js',
        assetFileNames: '[name].[ext]',
        chunkFileNames: '[name].js',
      },
    },
  },
}); 