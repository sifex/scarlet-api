<template>
    <div class="absolute h-full w-full bg-[#080e1f] bg-aaf-background retina:bg-aaf-background-2x bg-cover bg-center p-4 md:p-12 font-weight-bolder">
        <div class="min-h-full flex items-center justify-center py-12 px-2 sm:px-6 lg:px-8">
            <div class="max-w-lg w-full space-y-4 bg-white rounded-xl px-4 py-4 md:px-8 shadow-2xl shadow-black">
                <img class="mx-auto h-24 w-auto -mt-16" :src="aaf_logo" alt="Workflow" />
                <div v-if="!user" class="space-y-4">
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-800">
                        Sign in to Scarlet
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Please login using your Steam Account
                    </p>
                    <div class="rounded-lg bg-green-100 p-4 text-md border-green-300 border-2">
                        <b class="font-weight-bold text-lg text-green-800">👋 Hey!</b><br />
                        <span class="text-green-700">Scarlet has been updated to use your Steam ID to authenticate with. Click the "Login with Steam" button below to get started!</span>
                    </div>
                    <LoginWithSteam />
                </div>
                <div v-else class="space-y-4">
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-800">
                        Welcome {{ user.username }}
                    </h2>
                    <p class="text-center text-sm text-gray-600">
                        Download the latest version of the client below.
                    </p>
                    <p class="text-center text-base text-slate-500">
                        <CheckCircleIcon class="h-6 w-6 inline-block text-emerald-600" />
                        Your SteamID has been linked to AAF's XML
                    </p>

                    <div class="relative">
                        <a class="block w-full flex justify-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-white transition ease-in-out duration-150 transition-all
" :href="scarlet_download" :class="{ 'bg-emerald-500 hover:bg-emerald-400': scarlet_download, 'bg-slate-600 hover:bg-slate-500': !scarlet_download }">
                            <svg v-if="!scarlet_download" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ scarlet_download ? "Download Scarlet Updater" : "Fetching Updater" }}
                            <DownloadIcon v-if="scarlet_download" class="h-5 w-5 ml-2 mt-0.5 -mb-0.5" />
                        </a>

                    </div>

                    <Link class="block text-center w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700 transition-colors" :href="$route('electron')">
                        Go to Downloader
                        <ChevronRightIcon class="inline-block h-4 w-4" />
                    </Link>
                    <a :href="$route('logout')" class="inline-block float-right text-center px-4 py-1 border border-transparent text-sm font-medium rounded-md text-red-600 bg-red-100 border-2 border-red-400 hover:bg-red-500 hover:text-white transition-colors">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {inject, onMounted} from 'vue';
import {CheckCircleIcon, ChevronRightIcon, DownloadIcon} from '@heroicons/vue/solid'
import {Inertia} from "@inertiajs/inertia";
import {Link} from '@inertiajs/inertia-vue3'

import {User} from "@/scripts/downloader/downloader";

import aaf_logo from '../../images/logo.png'
import LoginWithSteam from "@/views/components/LoginWithSteam.vue";

const props = defineProps({
    user: Object as () => User,
    scarlet_download: {
        type: String,
        default: ''
    }
})

onMounted(() => {
    setTimeout(() => {
        Inertia.reload({only: ['scarlet_download']})
    }, 50)
})

let $route = inject('$route')

</script>

