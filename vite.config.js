// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { webcrypto } from 'crypto';

//Garante que getRandomValues esteja disponível no ambiente Node
if (typeof globalThis.crypto === 'undefined') {
    globalThis.crypto = webcrypto;
}

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ]
});