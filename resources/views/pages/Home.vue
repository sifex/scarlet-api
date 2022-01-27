<template>
    <div class="absolute h-full w-full bg-[#080e1f] bg-aaf-background retina:bg-aaf-background-2x bg-cover bg-center p-12 font-weight-bolder">
        <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-4 bg-white rounded-xl px-4 py-4">
                <img class="mx-auto h-24 w-auto -mt-16" :src="aaf_logo" alt="Workflow" />
                <div v-if="!user" class="space-y-4">
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-800">
                        Sign in to Scarlet
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Using your Steam Account
                    </p>
                    <div class="rounded bg-green-200 p-4 text-sm border-green-300 border-2">
                        <b class="font-weight-bold text-green-800">Hey!</b><br />
                        <span class="text-green-700">Scarlet has been updated to use your Steam ID to authenticate with. Click the "Login with Steam" button below to get started!</span>
                    </div>
                    <login-with-steam ></login-with-steam>
                </div>
                <div v-else class="space-y-4">
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-800">
                        Welcome {{ user.username }}
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Download the latest version of the client below.
                    </p>
                    <a class="block text-center w-full px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-emerald-500 hover:bg-emerald-700 transition-colors" :href="scarlet_download">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                        Download Latest Scarlet Updater
                    </a>
                    <Link class="block text-center w-full px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700 transition-colors" :href="$route('about')">About</Link>
                    <logout v-if="user"></logout>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue';
import HelloWorld from '@/views/components/HelloWorld.vue';
import LoadingBar from '@/views/components/loading-bar.vue';
import LoginWithSteam from '@/views/components/LoginWithSteam.vue'
import Logout from '@/views/components/Logout.vue'
import { Link } from '@inertiajs/inertia-vue3'
import aaf_logo from '../../../public/images/aaf/logo.png'

export default defineComponent({
    name: 'App',
    components: {
        HelloWorld,
        LoadingBar,
        LoginWithSteam,
        Logout,
        Link
    },
    props: {
        user: Object,
        scarlet_download: String
    },
    data() {
        return {
            aaf_logo
        }
    }


});
</script>

<style></style>
