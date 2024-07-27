<template>
    <!-- Main container -->
    <div
        :class="{'isElectron': isElectron}"
        class="font-[Exo_2] absolute h-full w-full bg-[#080e1f] bg-aaf-background retina:bg-aaf-background-2x bg-cover bg-center font-weight-bolder select-none"
    >
        <!-- Electron toolbar -->
        <ElectronToolbar v-if="true"></ElectronToolbar>

        <div class="flex flex-col h-full">
            <!-- Header section -->
            <header class="flex pt-8 pb-6">
                <!-- Logo -->
                <div class="flex-none pl-10">
                    <div id="logo">
                        <img :src="aaf_logo_2x" alt="AAF Logo" draggable="false" height="91" width="266">
                    </div>
                </div>
                <div class="grow"></div>
                <!-- Status indicators -->
                <div class="flex-none pr-6 pt-8">
                    <status-indicator :color="arma_server?.gq_online" :players="arma_server?.gq_numplayers" title="AAF Arma Server"></status-indicator>
                    <status-indicator
                        :color="!([StatusValue.Error, StatusValue.NotReady].includes(downloader.state.status))"
                        title="Scarlet Updater"
                    ></status-indicator>
                </div>
            </header>

            <!-- Banner section -->
            <div id="banner" class="grow relative">
                <div
                    :style="{ backgroundImage: `url(${launcher_image_url})` }"
                    class="bg-slate-900 border-none overflow-hidden h-full w-full bg-cover bg-center"
                ></div>
            </div>

            <!-- Download section -->
            <div id="download-section-bottom" class="relative text-white">
                <LoadingBar
                    :width="downloader.state.completionPercentage"
                    class="-mt-5 mx-8"
                    :loadingBarClass="uiState.loadingBarClass"
                ></LoadingBar>
            </div>

            <!-- Buttons and status section -->
            <div id="buttons" class="h-32 px-8">
                <!-- Status display -->
                <div id="status" class="pb-4">
                    <p :class="uiState.statusClass" class="inline-block mr-2 font-exo tabular-nums text-sm font-semibold">
                        {{ uiState.status }}
                    </p>
                    <p class="inline-block mr-2 text-slate-400 tabular-nums font-exo">
                        {{ uiState.file }}
                    </p>
                    <p class="kbs-downloaded inline-block mr-2" v-if="downloader.state.currentFileTotalSize !== 0">
            <span class="text-sky-500 tabular-nums font-exo font-medium text-sm">
              {{ formatDownloadProgress(
                downloader.state.currentFileDownloaded,
                downloader.state.currentFileTotalSize
            ) }}
            </span>
                    </p>
                    <p
                        v-if="is_debug_messages_enabled"
                        class="inline-block mr-2 text-red-500 tabular-nums font-exo font-medium text-sm"
                    >
                        {{ downloader.state.status }} {{ downloader.state.completionPercentage }}
                    </p>
                </div>

                <!-- Action buttons -->
                <div class="flex gap-1">
                    <button
                        :disabled="!uiState.buttons.start.enabled"
                        :class="uiState.buttons.start.classes"
                        @click="onDownloadButtonPress"
                    >
                        <svg v-if="uiState.buttons.start.loadingIcon" class="inline-block animate-spin -ml-2 -mt-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ uiState.buttons.start.label }}
                    </button>
                    <div class="grow"></div>
                    <!-- Admin button -->
                    <div v-if="current_user_instance.isAdminEnough()" class="">
                        <button
                            v-if="isElectron"
                            class="block text-center font-exo font-medium px-4 py-2 border border-transparent text-sm rounded-md bg-rose-500 text-white hover:bg-rose-700 hover:text-white transition-colors"
                            @click="open_admin_page_in_browser"
                        >
                            Open Admin in Browser
                            <ArrowTopRightOnSquareIcon class="inline-block h-4 w-4"/>
                        </button>
                        <a
                            v-else
                            :href="$route('admin')"
                            class="block text-center font-exo font-medium px-4 py-2 border border-transparent text-sm rounded-md bg-rose-500 text-white hover:bg-rose-700 hover:text-white transition-colors"
                            target="_blank"
                        >
                            Open Admin Console
                            <ArrowTopRightOnSquareIcon class="inline-block h-4 w-4"/>
                        </a>
                    </div>
                    <!-- Settings button -->
                    <Settings :current_user="current_user" :downloader="downloader" @settings_closed="refreshUser">
                        <button
                            class="flex gap-2 items-center font-exo font-medium px-4 py-2 bg-slate-800 hover:bg-slate-700 transition-all text-white rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-500 focus-visible:ring-offset-2 ring-offset-black"
                            type="button"
                        >
                            <Cog6ToothIcon class="h-6 w-6 text-slate-500"></Cog6ToothIcon>
                            Settings
                        </button>
                    </Settings>
                </div>
            </div>
        </div>

        <!-- Notifications -->
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
                            v-for="notification in notifications"
                            :key="notification.id"
                            class="w-full max-w-sm mt-4 overflow-hidden bg-white rounded-lg shadow-lg pointer-events-auto ring-1 ring-black ring-opacity-5"
                        >
                            <div class="p-4">
                                <div class="flex items-start">
                                    <div class="shrink-0">
                                        <svg aria-hidden="true" class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3 w-0 flex-1 pt-0.5">
                                        <p class="font-semibold text-gray-800">{{ notification.title }}</p>
                                        <p class="text-sm font-semibold text-gray-500">{{ notification.text }}</p>
                                    </div>
                                    <div class="flex ml-4 shrink-0">
                                        <button
                                            class="inline-flex text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400"
                                            @click="close(notification.id)"
                                        >
                                            <span class="sr-only">Close</span>
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path clip-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" fill-rule="evenodd"/>
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
import { computed, inject, onMounted, reactive, ref, watch } from 'vue';
import LoadingBar from '@/views/components/electron/loading-bar.vue';
import aaf_logo_2x from '@/images/aaf_logo_2x.png'
import { Inertia } from "@inertiajs/inertia";
import ScarletDownloader, {
    calculateDownloadSpeed,
    formatDownloadProgress,
    type Status as StatusType,
    Status as StatusValue
} from '@/scripts/downloader/downloader'
import ElectronToolbar from '@/views/components/electron/electron-toolbar.vue'
import { User } from "@/scripts/downloader/user";
import Settings from '@/views/components/electron/settings.vue'
import { ArrowTopRightOnSquareIcon, Cog6ToothIcon, LockClosedIcon } from '@heroicons/vue/24/solid'
import useLocalStorage from "@/scripts/useLocalStorage";
import StatusIndicator from "@/views/components/electron/status-indicator.vue";
import { notify } from "notiwind"

// Props
const props = defineProps({
    current_user: {
        type: Object as () => User,
        required: true
    },
    arma_server: {
        type: Object,
        required: false
    },
    launcher_image_url: {
        type: String,
        default: 'https://i.imgur.com/0cm9dip.png'
    }
});

// Computed properties
const current_user_instance = computed(() => {
    return Object.assign(new User(
        props.current_user.username,
        props.current_user.playerID,
    ), props.current_user)
});

// Reactive state
const downloader = reactive(new ScarletDownloader());
const uiState = computed(() => ({
    loadingBarClass: loadingBarClass(downloader.state.status),
    statusClass: getStatusClasses(downloader.state.status),
    status: getStatusText(downloader.state.status),
    file: getFileText(downloader.state.status, downloader.state.currentFilePath),
    buttons: {
        start: {
            label: getStartButtonLabel(downloader.state.status),
            enabled: isStartButtonEnabled(downloader.state.status),
            classes: getStartButtonClasses(downloader.state.status),
            loadingIcon: [StatusValue.Downloading, StatusValue.Verifying, StatusValue.InitialCheck].includes(downloader.state.status)
        }
    }
}));

// Helper functions
function loadingBarClass(status: StatusType) {
    const colorMap = {
        [StatusValue.Ready]: 'bg-sky-500',
        [StatusValue.Downloading]: 'bg-sky-500',
        [StatusValue.Verifying]: 'bg-emerald-500',
        [StatusValue.InitialCheck]: 'bg-sky-500',
        [StatusValue.Done]: 'bg-emerald-500',
        [StatusValue.Error]: 'bg-red-500',
        [StatusValue.NotReady]: 'bg-gray-500'
    };

    return [colorMap[status]] || ['bg-grey-500'];
}

function getStatusClasses(status: StatusType) {
    const colorMap = {
        [StatusValue.Ready]: 'text-sky-500',
        [StatusValue.Downloading]: 'text-sky-500',
        [StatusValue.Verifying]: 'text-emerald-500',
        [StatusValue.InitialCheck]: 'text-sky-500',
        [StatusValue.Done]: 'text-emerald-500',
        [StatusValue.Error]: 'text-red-500',
        [StatusValue.NotReady]: 'text-gray-500'
    };

    return [colorMap[status]] || ['text-grey-500'];
}

function getStatusText(status: StatusType): string {
    const statusMap = {
        [StatusValue.Ready]: `Hello ${current_user_instance.value?.username || ''}`,
        [StatusValue.Downloading]: 'Downloading...',
        [StatusValue.Verifying]: 'Verifying...',
        [StatusValue.InitialCheck]: 'Checking files...',
        [StatusValue.Done]: 'Download Complete',
        [StatusValue.Error]: 'Error Occurred',
        [StatusValue.NotReady]: 'Initializing...'
    };
    return statusMap[status] || 'Initializing...';
}

function getFileText(status: StatusType, file: string): string {
    if (status === StatusValue.Ready && !props.current_user?.installDir) {
        return 'Please set your installation directory.';
    }
    if (status === StatusValue.Ready) {
        return `Current Install Location is: ${props.current_user.installDir}\\@Mods_AAF`;
    }
    if (status === StatusValue.Done) {
        return 'All files are up to date.';
    }
    return file.split('/').pop() || '';
}

function getStartButtonLabel(status: StatusType): string {
    if (status === StatusValue.Ready && !props.current_user?.installDir) {
        return 'Set Install Location';
    }
    const labelMap = {
        [StatusValue.Ready]: 'Start Download',
        [StatusValue.Error]: 'Start Download',
        [StatusValue.Downloading]: 'Stop Download',
        [StatusValue.Verifying]: 'Stop Download',
        [StatusValue.InitialCheck]: 'Stop Download',
        [StatusValue.Done]: 'Verify Again'
    };
    return labelMap[status] || 'Start Download';
}

function isStartButtonEnabled(status: StatusType): boolean {
    return (props.current_user?.installDir !== null || status === StatusValue.Ready);
}

function getStartButtonClasses(status: StatusType): string {
    const baseClasses = "font-exo font-medium px-6 py-2 transition-all text-white rounded ring-offset-black focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2";
    const colorClasses = {
        [StatusValue.Ready]: "bg-sky-600 hover:bg-sky-500 focus-visible:ring-sky-600",
        [StatusValue.Downloading]: "bg-sky-600 hover:bg-sky-500 focus-visible:ring-sky-600",
        [StatusValue.InitialCheck]: "bg-sky-600 hover:bg-sky-500 focus-visible:ring-sky-600",
        [StatusValue.Verifying]: "bg-emerald-600 hover:bg-emerald-500 focus-visible:ring-emerald-600",
        [StatusValue.Done]: "bg-emerald-500 hover:bg-emerald-500 focus-visible:ring-emerald-600",
        [StatusValue.Error]: "bg-red-600 hover:bg-red-500 focus-visible:ring-red-600",
        [StatusValue.NotReady]: "bg-gray-600 hover:bg-gray-500 focus-visible:ring-gray-600",
    };
    return `${baseClasses} ${colorClasses[status] || colorClasses[StatusValue.NotReady]}`;
}

function onDownloadButtonPress() {
    if (!props.current_user?.installDir) {
        Inertia.visit('/settings');
        return;
    }

    switch (downloader.state.status) {
        case StatusValue.Ready:
        case StatusValue.Error:
        case StatusValue.Done:
            downloader.state.status = StatusValue.Verifying;

            return downloader.startDownload(props.current_user.installDir)
                .catch(e => {
                    downloader.ping();
                });
        case StatusValue.Downloading:
        case StatusValue.Verifying:
        case StatusValue.InitialCheck:
            return downloader.stopDownload();
        default:
            return;
    }
}

onMounted(() => {
    Inertia.reload({only: ['arma_server']});

    // Download Status Polling
    downloader.ping();
    downloader.pollingInterval = 100;
    downloader.checkProgressAndContinue();

    window.scarlet.update_available((event, directory) => {
        notify({
            group: "generic",
            title: "Update Available",
            text: "A new update is available for download"
        });
    });

    window.scarlet.update_downloaded((event, directory) => {
        notify({
            group: "generic",
            title: "Update Downloaded",
            text: "A new update has been downloaded and is ready to install"
        });
    });
});

function refreshUser() {
    console.log('Refreshing User');
    Inertia.reload({only: ['current_user']});
}

function open_admin_page_in_browser() {
    if (isElectron.value) {
        window.scarlet.open_admin_page_in_browser();
    }
}

const isElectron = ref(typeof window.scarlet !== 'undefined');
const is_debug_messages_enabled = useLocalStorage('scarlet_debug_messages', false);
const $route: any = inject('$route');
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
</style>
