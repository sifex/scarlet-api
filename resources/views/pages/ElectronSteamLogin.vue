<template>
    <div class="absolute h-full w-full bg-[#080e1f] bg-scarlet-background retina:bg-scarlet-background-2x bg-cover bg-center p-4 md:p-12 font-weight-bolder">
        <div class="min-h-full flex items-center justify-center py-12 px-2 sm:px-6 lg:px-8">
            <div class="max-w-lg w-full space-y-4 bg-white rounded-xl px-4 py-8 md:px-8 shadow-2xl shadow-black">
<!--                <img class="mx-auto h-24 w-auto -mt-16" :src="aaf_logo" alt="Workflow" />-->
                <div v-if="!user" class="space-y-4">
                    <h2 class=" text-center text-3xl font-extrabold text-gray-800">
                        Sign in to Scarlet (Electron)
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Please login using your Steam Account
                    </p>
                    <login-with-steam ></login-with-steam>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue';
import LoadingBar from '@/views/components/loading-bar.vue';
import LoginWithSteam from '@/views/components/LoginWithSteam.vue'
import Logout from '@/views/components/Logout.vue'
import { Link } from '@inertiajs/inertia-vue3'
import aaf_logo from '../../images/logo.png'
import {Inertia} from "@inertiajs/inertia";
import { CheckCircleIcon } from '@heroicons/vue/solid'

export default defineComponent({
    name: 'App',
    components: {
        LoginWithSteam,
        Logout,
        Link,
        CheckCircleIcon
    },
    data() {
        return {
            aaf_logo
        }
    },
    mounted() {

    }


});
</script>

<style></style>
