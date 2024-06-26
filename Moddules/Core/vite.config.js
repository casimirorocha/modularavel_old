import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export const paths = [
    'Modules/Core/resources/assets/sass/app.scss',
    'Modules/Core/resources/assets/js/app.js'
];

export default defineConfig({
    plugins: [
        laravel({
            input: paths,
            refresh: true
        })
    ]
});
