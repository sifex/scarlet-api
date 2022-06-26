<template>
    <div
        class="absolute h-full w-full bg-slate-950 bg-cover bg-center font-weight-bolder">

        <nav class="bg-rose-900 pb-44">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-b border-1 border-slate-300/20">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-8 w-8" src="https://australianarmedforces.org/admin/images/logo_2x.png" alt="Workflow">
                        </div>

                        <div class="ml-10 flex items-baseline space-x-4">
                            <Link :href="$route('home')" href="#" class="transition-colors text-white/70 hover:bg-black/40 hover:text-white px-4 py-2 rounded-md text-sm font-medium">
                                <ChevronLeftIcon class="inline-block h-5 w-5 mr-1 -ml-1"></ChevronLeftIcon>
                                Back
                            </Link>

                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <a href="#" class="transition-colors bg-black/70 text-white px-4 py-2 rounded-md text-sm font-medium" aria-current="page">
                                User Management
                            </a>
                        </div>
                    </div>

                    <div class="ml-4 flex items-center md:ml-6" @focusout="topRightMenuOpen = false">
                        <!-- Profile dropdown -->
                        <div class="ml-3 relative" >
                            <div>
                                <button type="button" class="max-w-xs bg-[#cb4742] rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true" @click="topRightMenuOpen = !topRightMenuOpen" >
                                    <span class="sr-only">Open user menu</span>
                                    <span class="h-10 w-10 block rounded-full text-white text-xl pt-[5px] font-bold">
                                        {{ user.username.slice(0, 1) }}
                                    </span>
                                </button>
                            </div>

                            <!--
                              Dropdown menu, show/hide based on menu state.

                              Entering: "transition ease-out duration-100"
                                From: "transform opacity-0 scale-95"
                                To: "transform opacity-100 scale-100"
                              Leaving: "transition ease-in duration-75"
                                From: "transform opacity-100 scale-100"
                                To: "transform opacity-0 scale-95"
                            -->
                            <transition
                                enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95"
                            >
                            <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" v-if="topRightMenuOpen">
                                <span class="block px-4 py-2 text-sm text-slate-700 border-b border-1 border-slate-100 font-semibold">
                                    Hello {{ user.username }}
                                </span>
                                <!-- Active: "bg-gray-100", Not Active: "" -->
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 transition-colors" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>

                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 transition-colors" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>

                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 transition-colors" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
                            </div>
                            </transition>
                        </div>
                    </div>


                </div>
            </div>
        </nav>
        <div class="max-w-7xl mx-auto -mt-32">
            <div id="title" class="mb-6">
                <span class="text-4xl text-white font-exo ">User Management</span>
            </div>
            <div class="bg-white rounded-lg px-4 sm:px-6 lg:px-8 min-h-full py-10">
                <table class="border-collapse table-auto w-full text-sm">
                    <thead>
                    <tr>
                        <th class="border-b font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 text-left">Username</th>
                        <th class="border-b font-medium p-4 pt-0 pb-3 text-slate-400 text-left">Installed</th>
                        <th class="border-b font-medium p-4 pt-0 pb-3 text-slate-400 text-left">Role / Type</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                    <tr v-for="user in all_users">
                        <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">
                            {{ user.username }}
                        </td>
                        <td class="border-b border-slate-100 p-4 text-slate-500">
                            <CheckIcon class="inline-block h-5 w-5 mr-1 -ml-1 text-emerald-500"></CheckIcon>
                        </td>
                        <td class="border-b border-slate-100 p-4 pr-8 text-slate-500">
                            1961
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {inject, onMounted, ref} from 'vue';
import {CheckIcon, ChevronLeftIcon, DownloadIcon} from '@heroicons/vue/solid'
import {Inertia} from "@inertiajs/inertia";
import {Link} from '@inertiajs/inertia-vue3'

import {User} from "@/scripts/downloader/downloader";


import LoginWithSteam from "@/views/components/LoginWithSteam.vue";
import ModelTemplate from "@/views/components/templates/model-template.vue";

const props = defineProps({
    user: Object as () => User,
    all_users: [Object as () => User],
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

/** ---------- **/

let topRightMenuOpen = ref(false)
</script>

