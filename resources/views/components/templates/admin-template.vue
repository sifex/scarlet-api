<template>
    <div
        class="absolute h-full w-full bg-slate-950 bg-cover bg-center font-weight-bolder">

        <nav class="bg-gradient-to-r from-[#c42d4d] to-[#df4c49] pb-64">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 border-b border-1 border-slate-300/20">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <Link :href="$route('home')">
                                <ScarletLogo fill="#ffffff" class="inline-block h-10 w-10 text-white" />
<!--                                <img class="h-8 w-8" src="https://australianarmedforces.org/admin/images/logo_2x.png" alt="Scarlet Logo">-->
                            </Link>
                        </div>

                        <div class="ml-10 flex items-baseline space-x-4">


                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <Link :href="$route('admin.user.index')" class="transition-colors bg-black/70 hover:bg-black/60 text-white px-4 py-2 rounded-md text-sm font-medium" aria-current="page">
                                User Management
                            </Link>
                            <Link :href="$route('admin.xml.index')" class="transition-colors hover:bg-white/20 text-white px-4 py-2 rounded-md text-sm font-medium" aria-current="page">
                                XML
                            </Link>
                        </div>
                    </div>

                    <div class="ml-4 flex items-center md:ml-6" @focusout="topRightMenuOpen = false">
                        <!-- Profile dropdown -->
                        <div class="ml-3 relative" >
                            <div>
                                <button type="button" class="max-w-xs bg-rose-600 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-rose-900 focus:ring-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true" @click="topRightMenuOpen = !topRightMenuOpen" >
                                    <span class="sr-only">Open user menu</span>
                                    <span class="h-10 w-10 block rounded-full text-white text-xl pt-[5px] font-bold">
                                        {{ current_user.username.slice(0, 1) }}
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
                                    Hello {{ current_user.username }}
                                </span>
                                    <!-- Active: "bg-gray-100", Not Active: "" -->
                                    <!--                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 transition-colors" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>-->

                                    <!--                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 transition-colors" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>-->

                                    <Link :href="$route('logout')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 transition-colors" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</Link>
                                </div>
                            </transition>
                        </div>
                    </div>


                </div>
            </div>
        </nav>
        <div class="max-w-7xl mx-auto -mt-56">
            <div class="mx-4">
                <div id="title" class="mb-6 px-4 sm:px-6 lg:px-10">
                    <slot name="title"></slot>
                </div>

                <slot></slot>
            </div>
        </div>

        <div class="max-w-7xl mx-auto text-center px-4 sm:px-6 lg:px-10 mt-6 mb-20">
            <span id="copyright" class="text-sm text-slate-700">Copyright &copy; 2022 Australian Armed Forces</span>
        </div>

        <NotificationGroup group="generic">
            <div class="fixed inset-0 flex items-start justify-end p-6 px-4 py-6 pointer-events-none z-50">
                <div class="w-full max-w-sm">
                    <Notification
                        v-slot="{ notifications, close }"
                        enter="ease-out duration-300 transition"
                        enter-from="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4"
                        enter-to="translate-y-0 opacity-100 sm:translate-x-0"
                        leave="transition ease-in duration-500"
                        leave-from="opacity-100"
                        leave-to="opacity-0"
                        move="transition duration-500"
                        move-delay="delay-300"
                    >
                        <div
                            class="w-full max-w-sm mt-4 overflow-hidden bg-white rounded-lg shadow-lg pointer-events-auto ring-1 ring-black ring-opacity-5"
                            v-for="notification in notifications"
                            :key="notification.id"
                        >
                            <div class="p-4">
                                <div class="flex items-start">
                                    <div class="shrink-0">
                                        <svg class="w-6 h-6 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3 w-0 flex-1 pt-0.5">
                                        <p class="font-semibold text-gray-800">{{ notification.title }}</p>
                                        <p class="text-sm font-semibold text-gray-500">{{ notification.text }}</p>
                                    </div>
                                    <div class="flex ml-4 shrink-0">
                                        <button @click="close(notification.id)" class="inline-flex text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                                            <span class="sr-only">Close</span>
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Notification>
                </div>
            </div>
        </NotificationGroup>

        <NotificationGroup group="error">
            <div class="fixed inset-0 flex items-start justify-end p-6 px-4 py-6 pointer-events-none z-50">
                <div class="w-full max-w-sm">
                    <Notification
                        v-slot="{ notifications, close }"
                        enter="ease-out duration-300 transition"
                        enter-from="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4"
                        enter-to="translate-y-0 opacity-100 sm:translate-x-0"
                        leave="transition ease-in duration-500"
                        leave-from="opacity-100"
                        leave-to="opacity-0"
                        move="transition duration-500"
                        move-delay="delay-300"
                    >
                        <div
                            class="w-full max-w-sm mt-4 overflow-hidden bg-white rounded-lg shadow-lg pointer-events-auto ring-1 ring-black ring-opacity-5"
                            v-for="notification in notifications"
                            :key="notification.id"
                        >
                            <div class="p-4">
                                <div class="flex items-start">
                                    <div class="shrink-0">
                                        <ExclamationCircleIcon class="h-6 w-6 text-red-500"></ExclamationCircleIcon>
                                    </div>
                                    <div class="ml-3 w-0 flex-1 pt-0.5">
                                        <p class="font-semibold text-gray-800">{{ notification.title }}</p>
                                        <p class="text-sm font-semibold text-gray-500">{{ notification.text }}</p>
                                    </div>
                                    <div class="flex ml-4 shrink-0">
                                        <button @click="close(notification.id)" class="inline-flex text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                                            <span class="sr-only">Close</span>
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Notification>
                </div>
            </div>
        </NotificationGroup>

    </div>
</template>

<script lang="ts" setup>
import {inject, ref} from 'vue';
import {Link} from '@inertiajs/inertia-vue3'

import {User} from "@/scripts/downloader/user";
import { InertiaProgress } from '@inertiajs/progress'
import ScarletLogo from '@/images/scarlet_white.svg'
import { ExclamationCircleIcon } from "@heroicons/vue/24/solid";

const props = defineProps<{
    current_user: User
}>()

let $route = inject('$route')

/** ---------- **/



let topRightMenuOpen = ref(false)

</script>

