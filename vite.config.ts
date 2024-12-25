import { defineConfig } from 'vite';
// @ts-ignore
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import svgLoader from "vite-svg-loader";
import {resolve} from "path";

export default defineConfig({
    server: {
        hmr: {
            // host: '100.121.235.7'
        }
    },
    plugins: [
        laravel(['resources/scripts/main.ts']),
        // visualizer(),
        svgLoader(),
        vue({
            // template: {
            //     transformAssetUrls: {
            //         base: null,
            //         includeAbsolute: false,
            //     },
            // },
        }),
    ],
    resolve: {
        alias: {
            '@': resolve(__dirname, '/resources/'),
        },
    },
});
