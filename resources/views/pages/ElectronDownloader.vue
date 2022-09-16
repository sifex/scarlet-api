<template>
    <div
        class="font-[Exo_2] absolute h-full w-full bg-[#080e1f] bg-aaf-background retina:bg-aaf-background-2x bg-cover bg-center font-weight-bolder select-none"
    :class="{'isElectron': isElectron}">
        <ElectronToolbar v-if="true"></ElectronToolbar>
        <div class="flex flex-col h-full">
            <div class="flex pt-8 pb-6">
                <div class="flex-none pl-10">
                    <div id="logo">
                        <img draggable="false" :src="aaf_logo_2x" alt="" height="91" width="266">
                    </div>
                </div>
                <div class="grow"></div>
                <div class="flex-none pr-6 pt-8">
                    <status title="AAF Arma Server" :players="arma_server.gq_numplayers"
                            :color="arma_server.gq_online"></status>
                    <status title="Scarlet Updater"
                            :color="!([ClientStatus.Error, ClientStatus.Disconnected].includes(downloader.client.status))"></status>
                </div>
            </div>
            <div id="banner" class="grow relative">
                <div class="bg-slate-900 border-none overflow-hidden h-full w-full bg-cover bg-center" style="background-image: url('https://enfusionengine.com/_next/static/media/6_night_vehicles_hires.eb6cf375.jpg')"></div>
            </div>
            <div id="download-section-bottom" class="relative text-white">
                <LoadingBar :color="uiState.statusColor" :width="downloader.client.currentPercentage"
                            class="-mt-5 mx-8"></LoadingBar>
            </div>
            <div id="buttons" class="h-32 px-8">
                <div id="status" class="pb-4">
                    <p :class="[{
                                'text-sky-500': uiState.statusColor === 'sky',
                                'text-emerald-500': uiState.statusColor === 'emerald',
                                'text-red-500': uiState.statusColor === 'red',
                            }]" class="inline-block mr-2 font-exo tabular-nums text-sm font-semibold">
                        {{ uiState.status }}
                    </p>
                    <p class="inline-block mr-2 text-slate-400 tabular-nums font-exo">
                        {{ uiState.file }}
                    </p>
                    <p v-if="debug_messages" class="inline-block mr-2 text-red-800 tabular-nums font-exo text-sm">
                        {{ debug[downloader.client.status] }}
                    </p>
                </div>
                <div class="flex gap-1">
                    <button @click="toggleDownload"
                            :class="[{
                                'opacity-30': !uiState.buttons.start.enabled,
                                'bg-sky-600 hover:bg-sky-500 focus-visible:ring-sky-600': uiState.statusColor === 'sky',
                                'bg-emerald-600 hover:bg-emerald-500 focus-visible:ring-emerald-600': uiState.statusColor === 'emerald',
                                'bg-red-600 hover:bg-red-500 focus-visible:ring-red-600': uiState.statusColor === 'red',
                            }]"
                            class="font-exo px-6 py-2 hover:bg-sky-500 transition-all text-white rounded ring-offset-black focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2">
                        {{ uiState.buttons.start.label }}
                    </button>
                    <div class="grow"></div>
                    <div class="" v-if="current_user_instance.isAdminEnough()">
                    <button
                        v-if="isElectron"
                        @click="open_admin_page_in_browser"
                        class="block text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md bg-rose-500 text-white hover:bg-rose-700 hover:text-white transition-colors">
                        Open Admin in Browser
                        <ArrowTopRightOnSquareIcon class="inline-block h-4 w-4"/>
                    </button>
                    <a
                        v-else
                        :href="$route('admin')"
                        target="_blank"
                        class="block text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md bg-rose-500 text-white hover:bg-rose-700 hover:text-white transition-colors">
                        Open Admin Console
                        <ArrowTopRightOnSquareIcon class="inline-block h-4 w-4"/>
                    </a>
                    </div>
                    <Settings :downloader="downloader" :current_user="current_user" @settings_closed="refreshUser"></Settings>
                </div>
            </div>
        </div>


        <div class="fixed top-0 left-0 right-0 bottom-0 bg-black/40" v-if="current_user.archived_at" id="locked" >
            <div class="fixed z-200 top-10 left-10 right-10 bottom-10 bg-white rounded-2xl">
                <div class="flex w-full h-full flex-col text-center items-center justify-center gap-5 max-w-sm mx-auto">
                    <LockClosedIcon class="h-10 w-10 text-red-500"></LockClosedIcon>
                    <h2 class="text-2xl text-slate-600">You've been locked out of using&nbsp;Scarlet.</h2>
                    <p class="italic text-slate-400">If this was completed in error, please contact one of the staff over Discord to have them un-archive your account.</p>
                </div>
            </div>
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
                                        <svg class="w-6 h-6 text-emerald-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
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
    </div>
</template>

<script lang="ts" setup>
import {computed, inject, onMounted, reactive, ref} from 'vue';
import LoadingBar from '@/views/components/electron/loading-bar.vue';
import aaf_logo_2x from '@/images/aaf_logo_2x.png'
import {Inertia} from "@inertiajs/inertia";
import ScarletDownloader, {Status as ClientStatus} from '@/scripts/downloader/downloader'
import Status from '@/views/components/electron/status.vue'
import ElectronToolbar from '@/views/components/electron/electron-toolbar.vue'
import {User} from "@/scripts/downloader/user";
import Settings from '@/views/components/electron/settings.vue'
import {ArrowTopRightOnSquareIcon, LockClosedIcon} from '@heroicons/vue/24/solid'
import {notify} from "notiwind"
import {Link} from "@inertiajs/inertia-vue3";
import Debug from "@/scripts/downloader/debug";
import useLocalStorage from "@/scripts/useLocalStorage";

const props = defineProps({
    current_user: {
        type: Object as () => User,
        default: {username: '', steamID: ''}
    },
    arma_server: {
        type: Object,
        default: {}
    }
})

let current_user_instance = computed(() => {
    return Object.assign(new User(
        props.current_user.username,
        props.current_user.playerID,
    ), props.current_user)
})

let downloader = reactive(new ScarletDownloader(props.current_user))
downloader.init()

let uiState = reactive({
    statusColor: "sky",
    status: "Hello " + props.current_user.username,
    file: '',
    buttons: {
        start: {
            label: 'Start Download',
            enabled: false
        },
        changeLocation: {
            label: 'Change Download Location',
            enabled: false
        },
    },

    disconnected() {
        uiState.ready()
        uiState.status = "Updater Disconnected"
        uiState.file = 'Please make sure the agent is running.'
        uiState.buttons.start.enabled = false
        uiState.buttons.changeLocation.enabled = false
        uiState.statusColor = 'red'
    },

    ready() {
        uiState.status = "Hello " + props.current_user.username
        uiState.buttons.start.label = "Start Download";
        if (!props.current_user?.installDir) {
            uiState.buttons.start.enabled = false
            uiState.file = 'Please set your installation directory.'
        } else {
            uiState.buttons.start.enabled = true
            uiState.file = "Current Install Location is: " + props.current_user.installDir + "\\@Mods_AAF"
        }
        uiState.buttons.changeLocation.enabled = true
        uiState.statusColor = 'sky'
    },

    completed() {
        uiState.buttons.start.label = "Revalidate";
        uiState.buttons.start.enabled = true
        uiState.buttons.changeLocation.enabled = true
        uiState.file = "Download & validation completed successfully."
        uiState.status = "Success"
        uiState.statusColor = 'emerald'
    }

})

/** Get ARMA details */
onMounted(() => {
    uiState.disconnected()
    Inertia.reload({only: ['arma_server']})
})

/** Updating user after a settings page update */
function refreshUser() {
    Inertia.reload({only: ['current_user']})
    downloader.init()
}

/**
 * Agent Controls
 */

function toggleDownload() {
    if (props.current_user?.installDir && uiState.buttons.start.enabled) {
        if (downloader.client.status === ClientStatus.Ready) {
            downloader.startDownload()
        } else if (downloader.client.status === ClientStatus.Downloading) {
            downloader.stopDownload()
        }
    }
}

let debug = Debug

// Ready
downloader.on('ready', () => uiState.ready())
downloader.on('complete', () => uiState.completed())
downloader.on('disconnected', () => uiState.disconnected())

// Downloading
downloader.on('downloading', () => {
    uiState.ready()
    uiState.buttons.start.label = "Stop Download";
    uiState.buttons.changeLocation.enabled = false
})

downloader.on('statusUpdate', (evt) => uiState.status = evt.data.trim() ?? uiState.status)
downloader.on('fileUpdate', (evt) => uiState.file = evt.data.trim() ?? uiState.file)


/**
 * Admin Outlink
 */

function open_admin_page_in_browser() {
    if(isElectron) {
        window.scarlet.open_admin_page_in_browser()
    }
}

let isElectron = ref(typeof window.scarlet !== 'undefined')

/**
 * Debug Messages
 */
const debug_messages = useLocalStorage('scarlet_debug_messages', false)

let $route = inject('$route')

</script>

<style>
body {
    user-select: none;
}
.isElectron :not(input):not(textarea),
.isElectron :not(input):not(textarea)::after,
.isElectron :not(input):not(textarea)::before {
    -webkit-user-select: none;
    user-select: none;
    cursor: default;
}
/*.isElectron input, .isElectron button, .isElectron textarea, .isElectron :focus {*/
/*    outline: none;*/
/*}*/
</style>
