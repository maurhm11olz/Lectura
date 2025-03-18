import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            hotFile: 'vite.hot',
            input: [
                "resources/css/app.css",
            ],
            // refresh: ['resources/views/**'],
        }),
    ],
    resolve: {
        alias: {
            "@": "/resources",
        },
    },
});
