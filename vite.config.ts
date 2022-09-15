import { defineConfig } from 'vite';
// @ts-ignore
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import svgLoader from "vite-svg-loader";
import {resolve} from "path";
import { visualizer } from "rollup-plugin-visualizer";

export default defineConfig({
    plugins: [
        laravel([
                'resources/scripts/main.ts'
            ],
        ),
        // visualizer(),
        svgLoader(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': resolve(__dirname, '/resources/'),
        },
    },
});
