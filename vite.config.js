// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { webcrypto } from 'crypto';

if (typeof globalThis.crypto === 'undefined') {
    globalThis.crypto = webcrypto;
}

export default defineConfig({
    base: '/public/build/', // <- define o caminho base correto
    plugins: [
        laravel({
            input: [
                'resources/scss/front.scss',
                'resources/js/front.js',
                'resources/css/app.css',
                //'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build',
        manifest: true,
        emptyOutDir: true,
    },
    server: {
        host: true,
        hmr: {
            host: 'localhost'
        }
    },
    css: {
        devSourcemap: true
    },
    resolve: {
        alias: {
            '@': '/resources',
            '~': '/public'
        }
    },
});
