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
                    <status-indicator :color="arma_server?.gq_online" :players="arma_server?.gq_numplayers"
                                      title="AAF Arma Server"></status-indicator>
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
                <LoadingBar :downloader="downloader" class="-mt-5 mx-8"></LoadingBar>
            </div>

            <div class="relative px-8" v-if="is_debug_messages_enabled">
                <div class="p-2 rounded bg-slate-950">
                    <code class="text-slate-400">
                        {{ downloader }}
                    </code>
                </div>
            </div>

            <!-- Buttons and status section -->
            <div id="buttons" class="h-32 px-8">
                <!-- Status display -->
                <div id="status" class="pb-4">
                    <p :class="uiState.statusClass"
                       class="inline-block mr-2 font-exo tabular-nums text-sm font-semibold">
                        {{ uiState.status }}
                    </p>
                    <p class="inline-block mr-2 text-slate-400 tabular-nums font-exo">
                        {{ uiState.file }}
                    </p>
                    <p v-if="downloader.state.currentFileTotalSize !== 0" class="kbs-downloaded inline-block mr-2">
            <span class="text-sky-500 tabular-nums font-exo font-medium text-sm">
              {{
                    formatDownloadProgress(
                        downloader.state.currentFileDownloaded,
                        downloader.state.currentFileTotalSize
                    )
                }}
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
                        :class="uiState.buttons.start.classes"
                        :disabled="!uiState.buttons.start.enabled"
                        @click="onDownloadButtonPress"
                    >
                        <svg v-if="uiState.buttons.start.loadingIcon"
                             class="inline-block animate-spin -ml-2 -mt-1 mr-2 h-5 w-5 text-white"
                             fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                            <path class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                  fill="currentColor"></path>
                        </svg>
                        {{ uiState.buttons.start.label }}
                    </button>
                    <div class="grow"></div>
                    <!-- Admin button -->
                    <AdminButton :current_user="current_user"/>
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
        <ElectronNotifications/>
    </div>
</template>

<script lang="ts" setup>
import {computed, inject, onMounted, reactive, ref} from 'vue';
import LoadingBar from '@/views/components/electron/LoadingBar.vue';
import aaf_logo_2x from '@/images/aaf_logo_2x.png'
import {Inertia} from "@inertiajs/inertia";
import ScarletDownloader, {
    formatDownloadProgress,
    type Status as StatusType,
    Status as StatusValue
} from '@/scripts/downloader/downloader'
import ElectronToolbar from '@/views/components/electron/ElectronWindowControls.vue'
import {User} from "@/scripts/downloader/user";
import Settings from '@/views/components/electron/SettingsModal.vue'
import {Cog6ToothIcon} from '@heroicons/vue/24/solid'
import useLocalStorage from "@/scripts/useLocalStorage";
import StatusIndicator from "@/views/components/electron/StatusIndicator.vue";
import {notify} from "notiwind"
import {useForm} from "@inertiajs/inertia-vue3";
import ElectronNotifications from "@/views/components/electron/ElectronNotifications.vue";
import AdminButton from "@/views/components/electron/AdminButton.vue";

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


// Reactive state
const downloader = reactive(new ScarletDownloader());
const uiState = computed(() => ({
    statusClass: getStatusClasses(downloader.state.status),
    status: getStatusText(downloader.state.status),
    file: getFileText(downloader.state.status, downloader.state.currentFilePath),
    buttons: {
        start: {
            label: getStartButtonLabel(downloader.state.status),
            enabled: isStartButtonEnabled(downloader.state.status),
            classes: getStartButtonClasses(downloader.state.status),
            loadingIcon: [StatusValue.Downloading].includes(downloader.state.status)
        }
    }
}));

// Helper functions


function getStatusClasses(status: StatusType) {
    const colorMap = {
        [StatusValue.Ready]: 'text-sky-500',
        [StatusValue.Initiating]: 'text-sky-500',
        [StatusValue.Downloading]: 'text-sky-500',
        [StatusValue.Done]: 'text-emerald-500',
        [StatusValue.Error]: 'text-red-500',
    };

    return [colorMap[status]] || ['bg-grey-500'];
}

function getStatusText(status: StatusType): string {
    const statusMap = {
        [StatusValue.Ready]: `Hello ${props.current_user ?.username || ''}`,
        [StatusValue.Initiating]: 'Initiating...',
        [StatusValue.Downloading]: 'Downloading...',
        [StatusValue.Done]: 'Download Complete',
        [StatusValue.Error]: 'Error Occurred',
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
        [StatusValue.Initiating]: 'Stop Download',
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
        [StatusValue.Done]: "bg-emerald-500 hover:bg-emerald-500 focus-visible:ring-emerald-600",
        [StatusValue.Error]: "bg-red-600 hover:bg-red-500 focus-visible:ring-red-600",
        [StatusValue.NotReady]: "bg-gray-600 hover:bg-gray-500 focus-visible:ring-gray-600",
    };
    return `${baseClasses} ${colorClasses[status] || colorClasses[StatusValue.NotReady]}`;
}

// Update the onDownloadButtonPress function
function onDownloadButtonPress() {
    if (!props.current_user?.installDir) {
        showLocationDialog();
        return;
    }

    switch (downloader.state.status) {
        case StatusValue.Ready:
        case StatusValue.Error:
        case StatusValue.Done:
            downloader.state.status = StatusValue.Initiating;

            return downloader.startDownload(props.current_user.installDir)
                .catch(e => {
                    downloader.ping();
                });
        case StatusValue.Downloading:
        case StatusValue.Initiating:
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



const isElectron = ref(typeof window.scarlet !== 'undefined');
const is_debug_messages_enabled = useLocalStorage('scarlet_debug_messages', false);
const $route: any = inject('$route');

/**
 * Installation Directory Selection
 */
const alter_user_form = useForm({
    ...props.current_user
})

function showLocationDialog() {
    window.scarlet.open_choose_install_dir(
        props.current_user.installDir
    )

    window.scarlet.on_select_install_dir((event, directory: string) => {
        if (directory) {
            alter_user_form.installDir = directory
            alter_user_form.patch(
                $route('user.update'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        notify({
                            group: "generic",
                            title: "Success",
                            text: "Settings saved successfully"
                        })
                        refreshUser()
                    }
                }
            )
        }
    })
}
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
