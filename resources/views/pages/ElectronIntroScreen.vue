<template>
    <div class="absolute h-full w-full bg-[#080e1f] bg-scarlet-background retina:bg-scarlet-background-2x bg-cover bg-center font-weight-bolder">
        <div data-tauri-drag-region id="drag" class="fixed w-full h-48 -mt-10 -mb-32 r-10 opacity-5" style="-webkit-user-select: none; -webkit-app-region: drag;"></div>
        <div class="min-h-full flex items-center justify-center py-12">
            <div class="w-full space-y-4 bg-white px-4 py-8">
                <div class="max-w-lg mx-auto">
                <div v-if="!current_user?.username" class="space-y-4">
                    <h2 class=" text-3xl font-extrabold text-gray-800">
                        Welcome to Scarlet
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Please login using your Steam Account<br />to download the modset.
                    </p>


                    <div class="rounded-lg bg-green-100 p-4 text-md border-green-300 border-2">
                        <b class="font-weight-bold text-lg text-green-800">👋 Hey!</b><br/>
                        <span class="text-green-700">Scarlet has been updated to use your Steam ID to authenticate with. Click the "Login with Steam" button below to get started!</span>
                    </div>

                    <LoginWithSteam/>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {User} from "@/scripts/downloader/user";
import LoginWithSteam from "@/views/components/LoginWithSteam.vue";

const props = defineProps<{
    current_user: User
}>()
</script>

