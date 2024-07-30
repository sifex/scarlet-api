<template>
    <div class="absolute h-full w-full bg-cover bg-center font-weight-bolder">
        <electron-toolbar></electron-toolbar>
        <model-template :enable_copyright="false" :welcome_image_url="welcome_image_url" class="bg-scarlet-background retina:bg-scarlet-background-2x ">
            <Head>
                <title>Scarlet - {{ !current_user ? 'Login' : ('Welcome ' + current_user.username) }}</title>
                <meta name="description" content="Your page description">
            </Head>
            <div class="px-6 md:px-10 py-10 md:py-16 space-y-4" v-if="electron">
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
            <div class="px-6 md:px-10 py-10 md:py-16 space-y-4" v-if="oldElectron">
                <h2 class="text-center text-3xl font-extrabold text-gray-800">
                    Update your Scarlet
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
                    Hey, it looks like you're not using the latest version of Scarlet.<br />Please update to the latest version to continue.
                </p>

                <div class="flex justify-center">
                    <button @click="open_scarlet_website_old_electron" class="flex justify-center px-4 py-3 font-semibold leading-6 text-sm shadow rounded-md text-white transition-colors ease-in-out duration-150 bg-emerald-500 hover:bg-emerald-400">
                        Visit the Scarlet Website to Download <ArrowTopRightOnSquareIcon class="h-4 w-4 ml-2 mt-0.5 -mb-0.5"/>
                    </button>
                </div>

            </div>
        </model-template>
    </div>
</template>

<script lang="ts" setup>
import {ArrowTopRightOnSquareIcon} from "@heroicons/vue/16/solid";
import type {User} from "@/scripts/downloader/user";
import LoginWithSteam from "@/views/components/LoginWithSteam.vue";
import ElectronToolbar from '@/views/components/electron/ElectronWindowControls.vue'
import {Head, Link} from "@inertiajs/inertia-vue3";
import ModelTemplate from "@/views/components/templates/model-template.vue";
import {inject, onMounted, ref} from "vue";


const $route = inject('$route')

const props = defineProps<{
    current_user: User,
    welcome_image_url: string
}>()


let electron = ref(false)
let oldElectron = ref(false)

onMounted(() => {
    electron.value = typeof window.scarlet !== 'undefined';
    oldElectron.value = typeof window.module !== 'undefined';
})

function open_scarlet_website_old_electron() {
    require('electron').shell.openExternal('https://staging.scarlet.australianarmedforces.org/')
}
</script>


<style>
body {
    user-select: none;
}
:not(input):not(textarea),
:not(input):not(textarea)::after,
:not(input):not(textarea)::before {
    -webkit-user-select: none;
    user-select: none;
    cursor: default;
}
input, button, textarea, :focus {
    outline: none;
}
</style>
