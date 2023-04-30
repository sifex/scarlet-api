import '@/css/app.css';

// @ts-ignore
import Notifications from 'notiwind'
import {InertiaProgress} from "@inertiajs/progress";

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

import * as Sentry from "@sentry/vue";


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
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(InertiaProgress)
            .use(Notifications)
            .provide('$route', window.route)

        Sentry.init({
            app,
            dsn: 'https://5260c7cac99f4d0aaded21ce148273cb@o151013.ingest.sentry.io/4505104848388096',
            integrations: [
                // new Sentry.BrowserTracing({
                //     // routingInstrumentation: Sentry.vueRouterInstrumentation(router),
                // }),
                new Sentry.Replay(),
            ],
            // Performance Monitoring
            tracesSampleRate: 1.0, // Capture 100% of the transactions, reduce in production!
            // Session Replay
            replaysSessionSampleRate: 0.1, // This sets the sample rate at 10%. You may want to change it to 100% while in development and then sample at a lower rate in production.
            replaysOnErrorSampleRate: 1.0, // If you're not already sampling the entire session, change the sample rate to 100% when sampling sessions where errors occur.
        });

        app.mount(el)

        return app

    },
});
