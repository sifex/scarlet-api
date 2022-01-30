<template>
    <div class="absolute h-full w-full bg-[#080e1f] bg-scarlet-background retina:bg-scarlet-background-2x bg-cover bg-center p-4 md:p-12 font-weight-bolder">
        <div class="min-h-full flex items-center justify-center py-12 px-2 sm:px-6 lg:px-8">
            <div class="max-w-lg w-full space-y-4 bg-white rounded-xl px-4 py-8 md:px-8 shadow-2xl shadow-black">
                <div v-if="!user.username" class="space-y-4">
                    <h2 class=" text-center text-3xl font-extrabold text-gray-800">
                        Sign in to Scarlet (Electron)
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Please login using your Steam Account
                    </p>

                    <a @click="open_steam_browser_login" class="block text-center w-full px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700 transition-colors">
                        <i class="text-2xl inline-block -my-[148px] pr-4 fa fa-steam" aria-hidden="true"></i> Login with Steam
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {User} from "@/scripts/downloader/downloader";

const props = defineProps({
    user: {
        type: Object as () => User,
        default: {username: '', steamID: ''}
    }
})

function open_steam_browser_login() {
    // noinspection ES6ConvertRequireIntoImport
    require('electron').ipcRenderer.send('steam_login')
}
</script>

