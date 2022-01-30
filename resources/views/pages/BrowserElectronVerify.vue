<template>
    <div class="absolute h-full w-full bg-[#080e1f] bg-scarlet-background retina:bg-scarlet-background-2x bg-cover bg-center p-4 md:p-12 font-weight-bolder">
        <div class="min-h-full flex items-center justify-center py-12 px-2 sm:px-6 lg:px-8">
            <div v-if="!user" class="max-w-lg w-full space-y-4 bg-white rounded-xl px-4 py-8 md:px-8 shadow-2xl shadow-black space-y-4">
                <h2 class=" text-center text-3xl font-extrabold text-gray-800">
                    Redirecting you to Steam...
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Please wait as Scarlet redirects you to the Steam Login Page
                </p>
            </div>
            <div v-else class="max-w-lg w-full space-y-4 bg-white rounded-xl px-4 py-8 md:px-8 shadow-2xl shadow-black/30">
                <div class="space-y-4">
                    <h2 class=" text-center text-3xl font-extrabold text-gray-800">
                        Thank you {{ user.username }}
                    </h2>
                    <div class="block flex justify-center items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-slate-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-center text-sm text-gray-600">
                            Redirecting you back to Scarlet now...
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {inject, onMounted} from 'vue';
import {User} from "@/scripts/downloader/downloader";

const props = defineProps({
    user: Object as () => User,
    token: String,
})

onMounted(() => {
    const route = inject('$route')

    if(!props.user) {
        setTimeout(() => {
            window.location.href = route('login');
        }, 2000)
    } else {
        setTimeout(() => {
            window.location.href = 'scarlet://' + props.token
            setTimeout(() => {
                window.close()
            }, 200)
        }, 1000)
    }
})
</script>

<style></style>
