import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['/public_html/resources/css/app.css', '/public_html/resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            crypto: 'crypto-browserify'
        }
    }
});
