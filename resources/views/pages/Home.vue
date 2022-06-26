<template>
    <model-template>
        <div v-if="!user" class="px-8 pb-8 space-y-4">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-800">
                Sign in to Scarlet
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Please login using your Steam Account
            </p>
            <div class="rounded-lg bg-green-100 p-4 text-md border-green-300 border-2">
                <b class="font-weight-bold text-lg text-green-800">👋 Hey!</b><br/>
                <span class="text-green-700">Scarlet has been updated to use your Steam ID to authenticate with. Click the "Login with Steam" button below to get started!</span>
            </div>
            <LoginWithSteam/>
        </div>
        <div v-else class="px-8 pb-8 space-y-4">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-800">
                Welcome <span class="text-indigo-500">{{ user.username }}</span>.
            </h2>
            <p class="text-center text-sm text-gray-400 bold !-mt-0 block">
                Scarlet has been updated to provide a better user-experience.
            </p>
            <p class="text-center text-sm text-gray-600">
                To get started, download the latest version of the client below.
            </p>
            <div class="bg-slate-100 -mx-8 -mb-14 p-8">
                <a class="block w-full flex justify-center px-4 py-3 font-semibold leading-6 text-sm shadow rounded-md text-white transition-colors ease-in-out duration-150
" :href="scarlet_download"
                   :class="{ 'bg-emerald-500 hover:bg-emerald-400': scarlet_download, 'bg-slate-600 hover:bg-slate-500': !scarlet_download }">
                    <svg v-if="!scarlet_download" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ scarlet_download ? "Download Scarlet Updater" : "Fetching Updater" }}
                    <DownloadIcon v-if="scarlet_download" class="h-5 w-5 ml-2 mt-0.5 -mb-0.5"/>
                </a>
            </div>


            <div class="sm:flex space-y-4 sm:space-y-0 sm:space-x-4">
                <Link
                    class="grow block text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md bg-slate-200 hover:bg-slate-700 hover:text-white transition-colors"
                    :href="$route('electron')">
                    Go to Web Downloader
                    <ChevronRightIcon class="inline-block h-4 w-4"/>
                </Link>

                <a :href="$route('logout')"
                   class="block text-center px-4 py-2 text-sm font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-500 hover:text-white transition-colors">
                    Logout
                </a>
            </div>
        </div>
    </model-template>
</template>

<script lang="ts" setup>
import {inject, onMounted} from 'vue';
import {ChevronRightIcon, DownloadIcon} from '@heroicons/vue/solid'
import {Inertia} from "@inertiajs/inertia";
import {Link} from '@inertiajs/inertia-vue3'

import {User} from "@/scripts/downloader/downloader";


import LoginWithSteam from "@/views/components/LoginWithSteam.vue";
import ModelTemplate from "@/views/components/templates/model-template.vue";

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

