import '@/css/app.css';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'

// noinspection JSIgnoredPromiseFromCall
createInertiaApp({
    resolve: name => import(`../views/pages/${name}.vue`),
    // @ts-ignore
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
        // @ts-ignore
        app.config.globalProperties.$route = window.route
        app.use(plugin)
        app.mount(el)
        // Vue.config.globalProperties.devtools = false
        // Vue.config.globalProperties.debug = false
        // Vue.config.globalProperties.silent = true

    },
})
