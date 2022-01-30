<template>
    <div class="text-white">
        <Head title="About" />
        <h1>About</h1>



        <Link href="/">Home</Link>
    </div>
</template>

<script>
// import Layout from './Layout'
import { Head } from '@inertiajs/inertia-vue3'
import { Link } from '@inertiajs/inertia-vue3'


export default {
    components: {
        Head,
        Link
        // Layout,
    },
    data() {
        return {
            user: {
                name: 'Alex'
            }
        }
    },
    props: {
        // user: Object,
    },
}
</script>
