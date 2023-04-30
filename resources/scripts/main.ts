import '@/css/app.css';

// @ts-ignore
import Notifications from 'notiwind'
import {InertiaProgress} from "@inertiajs/progress";

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

import * as Sentry from "@sentry/vue";

Sentry.init({
    dsn: import.meta.env.VITE_SENTRY_DSN_PUBLIC,
});

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
    resolve: (name) => resolvePageComponent(`../views/pages/${name}.vue`, import.meta.glob('../views/pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(InertiaProgress)
            .use(Notifications)
            .provide('$route', window.route)
            .mount(el)
    },
});
