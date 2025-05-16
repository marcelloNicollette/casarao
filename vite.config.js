// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { webcrypto } from 'crypto';

if (typeof globalThis.crypto === 'undefined') {
    globalThis.crypto = webcrypto;
}

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
            publicDirectory: 'public',
        }),
    ],
    build: {
        outDir: 'public/build',
        manifest: true,
        rollupOptions: {
            output: {
                manualChunks: undefined
            }
        }
    },
    server: {
        host: true,
        hmr: {
            host: 'localhost'
        }
    },
    css: {
        devSourcemap: true
    }
});
