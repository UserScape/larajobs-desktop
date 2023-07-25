import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from 'tailwindcss';
import vue from "@vitejs/plugin-vue"; //add this line

export default defineConfig({
    plugins: [
        tailwindcss({
            config: './tailwind.config.js',
        }),
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
