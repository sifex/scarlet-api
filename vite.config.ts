import vue from '@vitejs/plugin-vue'
// @ts-ignore
import tailwind from 'tailwindcss'
import autoprefixer from 'autoprefixer'
import svgLoader from 'vite-svg-loader'
// @ts-ignore
import laravel from "vite-plugin-laravel";
import {defineConfig} from "vite";

export default defineConfig({
    plugins: [
        vue({
            // @ts-ignore
            reactivityTransform: true
        }),
        laravel({
            postcss: [
                tailwind(),
                autoprefixer(),
            ]
        }),
        svgLoader()
    ]
})
