import '@/css/app.css';

// @ts-ignore
import Notifications from 'notiwind'
import {InertiaProgress} from "@inertiajs/progress";

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

InertiaProgress.init({
    // The delay after which the progress bar will
    // appear during navigation, in milliseconds.
    delay: 100,

    // The color of the progress bar.
    color: '#fff',

    // Whether to include the default NProgress styles.
    includeCSS: true,

    // Whether the NProgress spinner will be shown.
    showSpinner: true,
})

createInertiaApp({
    resolve: (name) => resolvePageComponent(`../views/Pages/${name}.vue`, import.meta.glob('../views/Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            // .use(InertiaProgress)
            // .use(Notifications)
            .provide('$route', window.route)
            .mount(el)
    },
});
