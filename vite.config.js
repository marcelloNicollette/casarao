import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { webcrypto } from 'crypto';

// ⚠️ Esse bloco injeta o 'crypto.getRandomValues' no Node.js
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