import '@/css/app.css';

import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/inertia-vue3'

// @ts-ignore
import Notifications from 'notiwind'
import {InertiaProgress} from "@inertiajs/progress";

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


/**
 * Imports the given page component from the page record.
 */
function resolvePageComponent(name: string, pages: Record<string, any>) {
    for (const path in pages) {
        if (path.endsWith(`${name.replace('.', '/')}.vue`)) {
            return typeof pages[path] === 'function'
                ? pages[path]()
                : pages[path]
        }
    }

    throw new Error(`Page not found: ${name}`)
}

// noinspection JSIgnoredPromiseFromCall
createInertiaApp({
    resolve: name => resolvePageComponent(name, import.meta.glob('../views/pages/**/*.vue')),
    // @ts-ignore
    setup({ el, App, props, plugin }) {
        const app = createApp({
            render: () => h(App, props) }
        )

        // @ts-ignore
        app.provide('$route', window.route)
        app.use(Notifications)
        app.use(plugin)
        app.mount(el)
    },
})
