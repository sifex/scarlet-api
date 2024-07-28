<template>
    <model-template :welcome_image_url="welcome_image_url">
        <Head>
            <title>Scarlet - {{ !current_user ? 'Login' : ('Welcome ' + current_user.username) }}</title>
            <meta name="description" content="Your page description">
        </Head>
        <div v-if="!current_user" class="px-6 md:px-10 py-10 md:py-16 space-y-4">
            <h2 class="text-center text-3xl font-extrabold text-gray-800">
                Sign in to Scarlet
            </h2>

            <div class="flex justify-center">
                <p class="text-justify text-sm font-medium bg-slate-200 text-slate-600 py-2 md:py-1 px-3 rounded relative">

                    <span class="-top-1.5 -right-1.5 absolute inline-flex rounded-full h-3 w-3 bg-rose-500">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                    </span>
                    Scarlet has been updated to provide a better user-experience.
                </p>
            </div>
            <p class="text-center text-sm text-gray-600">
                Please login using your Steam Account
            </p>
            <div class="rounded-lg bg-green-100 p-4 text-md border-green-300 border-2">
                <b class="font-weight-bold text-lg text-green-800">👋 Hey!</b><br/>
                <span class="text-green-700">Scarlet has been updated to use your Steam ID to authenticate with. Click the "Login with Steam" button below to get started!</span>
            </div>
            <LoginWithSteam/>
        </div>
        <div v-else class="px-6 py-12 md:px-10 md:py-14 space-y-4">
            <h2 class="text-center text-3xl font-extrabold text-gray-800">
                Welcome <span class="text-indigo-500">{{ current_user.username }}</span>
            </h2>
            <div class="flex justify-center">
                <p class="text-justify text-sm font-medium bg-slate-200 text-slate-600 py-2 md:py-1 px-3 rounded relative">

                    <span class="-top-1.5 -right-1.5 absolute inline-flex rounded-full h-3 w-3 bg-rose-500">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                    </span>
                    Scarlet has been updated to provide a better user-experience.
                </p>
            </div>
            <p class="text-center text-sm text-gray-600">
                To get started, download the latest version of the client below.
            </p>
            <div class="bg-slate-100 -mx-6 md:-mx-10 -mb-14 p-6 md:p-10 md:py-4">
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
                    <ArrowDownTrayIcon v-if="scarlet_download" class="h-5 w-5 ml-2 mt-0.5 -mb-0.5"/>
                </a>
            </div>

            <div class="" v-if="current_user_instance.isAdminEnough()">
            <Link

                class="grow text-center px-4 py-2 text-sm font-medium rounded-md bg-rose-500 text-white hover:bg-rose-700 hover:text-white transition-colors flex justify-center items-center gap-2"
                :href="$route('admin.user.index')">
                Go to Admin Page
                <ChevronRightIcon class="inline-block h-4 w-4"/>
            </Link>
            </div>

            <div class="sm:flex space-y-4 sm:space-y-0 sm:space-x-4">
                <button
                    class="grow text-center px-4 py-2 text-sm font-medium rounded-md bg-slate-200 hover:bg-slate-700 hover:text-white transition-colors flex justify-center items-center gap-2"
                    @click="open_app">
                    Open Scarlet
                    <ChevronRightIcon class="h-4 w-4"/>
                </button>

                <Settings :current_user="current_user_instance" @settings_closed="refresh_user">
                    <button
                       class="text-center px-4 py-2 text-sm font-medium rounded-md text-slate-800 bg-slate-200 hover:bg-slate-500 hover:text-white transition-colors flex items-center gap-2">
                        <Cog6ToothIcon class="h-5 w-5 text-slate-700"></Cog6ToothIcon>
                        Settings
                    </button>
                </Settings>

                <a :href="$route('logout')"
                   class="block text-center px-4 py-2 text-sm font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-500 hover:text-white transition-colors">
                    Logout
                </a>
            </div>
        </div>
    </model-template>
</template>

<script lang="ts" setup>
import Settings from "@/views/components/electron/settings.vue";
import {computed, inject, onMounted} from 'vue';
import {ChevronRightIcon, Cog6ToothIcon} from '@heroicons/vue/24/solid'
import {ArrowDownTrayIcon} from '@heroicons/vue/24/outline'
import {Inertia} from "@inertiajs/inertia";
import {Link} from '@inertiajs/inertia-vue3'

import LoginWithSteam from "@/views/components/LoginWithSteam.vue";
import ModelTemplate from "@/views/components/templates/model-template.vue";
import {User} from "@/scripts/downloader/user";
import { Head } from '@inertiajs/inertia-vue3'
import {open_scarlet} from "@/scripts/downloader/protocol";

const $route = inject('$route')

const {
    current_user,
    scarlet_download = '',
    protocol,
    token = '',
} = defineProps<{
    current_user: User,
    scarlet_download?: string
    welcome_image_url: string,
    protocol: string,
    token: string
}>()

let current_user_instance = computed(() => {
    return Object.assign(new User(
        current_user.username,
        current_user.playerID,
    ), current_user)
})

onMounted(() => {
    Inertia.reload({only: ['scarlet_download']})

    if(typeof window.scarlet !== 'undefined') {
        window.location.replace($route('electron.intro'));
    }
})


function open_app() {
    open_scarlet(token)
}

function refresh_user() {
    Inertia.reload({only: ['current_user']})
}


</script>

