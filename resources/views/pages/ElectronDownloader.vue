<template>
    <div
        class="font-[Exo_2] absolute h-full w-full bg-[#080e1f] bg-aaf-background retina:bg-aaf-background-2x bg-cover bg-center font-weight-bolder select-none">
        <ElectronDownloader></ElectronDownloader>

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
                            :color="Object.keys(arma_server).length !== 0"></status>
                    <status title="Scarlet Updater"
                            :color="!([ClientStatus.Error, ClientStatus.Disconnected].includes(downloader.client.status))"></status>

                </div>
            </div>
            <div id="banner" class="grow relative">
                <!-- Arma 4 Banner-->
<!--                <video autoplay="" loop="" muted="" playsinline=""-->
<!--                       class="absolute inset-0 w-full h-full object-cover -z-2">-->
<!--                    <source src="https://arma4.com/videos/loop.webm" type="video/webm">-->
<!--                    <source src="https://arma4.com/videos/loop.mp4" type="video/mp4">-->
<!--                    <p>Your browser cannot play the provided video file.</p>-->
<!--                </video>-->
<!--                -->
<!--                <div class="grid h-full grid-rows-[1fr,max-content] place-items-center relative bg-black/25">-->
<!--                    <div class="flex flex-col items-center">-->
<!--                        <svg focusable="false" data-name="arma_4_logo" xmlns="http://www.w3.org/2000/svg"-->
<!--                             viewBox="0 0 799.93 176.23" class="h-12 text-white sm:h-16 md:h-20 lg:h-24 2xl:h-32">-->
<!--                            <path fill="currentColor"-->
<!--                                  d="m351.74 151-21.69-31.24a75.68 75.68 0 0 0 14.47-15.93 63.82 63.82 0 0 0 8.83-19.9c.17-.65.3-1.31.45-2Zm-70.89-66.32a27.51 27.51 0 0 1-4.33.35h-34.31l-1.07-39.24h35.56a24.65 24.65 0 0 1 6.46.8c8.21 2.6 11.09 9.89 11.09 18.28 0 9.55-3.27 17.79-13.4 19.81m518.54-43.26H768L767.45 69h-18.82l17.85-69h-33L711 71 688.06.49h-92L567 89.91 564.21.1h-76.83l-26.91 82-26.91-82h-77.32l-1.46 49.17C353 38.92 349.19 29 342.38 20.86 330.4 5 312.55 1 302.33.1c-2.13-.23-4.65 0-7.93 0H179.63v92.79L149.33.1H57.24L0 175.68h70l33.33-126.9L120.16 113H96.45l-8.72 40.88h43.17l5.71 21.76h43v.15H247l-1.15-39.67h22.95l21.18 40.07H420.4l-2.51-83.85 27 83.29h30.69l26.93-83.2-2.57 83.76h68.26v-.1h40.59l33.28-126.74 16.86 64.3h-23.69l-8.72 40.84h43.12l5.72 21.74h69.89l-25.5-78.42h47.15l-.37 19.81h33.4Z"></path>-->
<!--                        </svg>-->
<!--                    </div>-->
<!--                </div>-->

                <div class="bg-slate-900 border-none overflow-hidden h-full w-full bg-cover bg-center" style="background-image: url('https://enfusionengine.com/_next/static/media/6_night_vehicles_hires.eb6cf375.jpg')" alt=""></div>
            </div>
            <div id="download-section-bottom" class="relative text-white">
                <LoadingBar :color="updater.statusColor" :width="downloader.client.currentPercentage"
                            class="-mt-5 mx-8"></LoadingBar>
            </div>
            <div id="buttons" class="h-24 px-8">
                <div id="status" class="pb-1.5">
                    <p :class="[{
                                'text-sky-500': updater.statusColor === 'sky',
                                'text-emerald-500': updater.statusColor === 'emerald',
                                'text-red-500': updater.statusColor === 'red',
                            }]" class="inline-block mr-2 font-exo tabular-nums text-sm font-semibold">
                        {{ updater.status }}
                    </p>
                    <p class="inline-block mr-2 text-slate-400 tabular-nums font-exo text-sm">
                        {{ updater.file }}
                    </p>
                    <!--                    <p class="inline-block mr-2 text-red-800 tabular-nums font-exo text-sm">-->
                    <!--                        {{downloader.client.status}}-->
                    <!--                    </p>-->
                </div>
                <div class="flex gap-1">
                    <button @click="toggleDownload"
                            :class="[{
                                'opacity-30': !updater.buttons.start.enabled,
                                'bg-sky-600 hover:bg-sky-500': updater.statusColor === 'sky',
                                'bg-emerald-600 hover:bg-emerald-500': updater.statusColor === 'emerald',
                                'bg-red-600 hover:bg-red-500': updater.statusColor === 'red',
                            }]"
                            class="font-exo px-6 py-1.5 text-sm hover:bg-sky-500 transition-all text-white rounded cursor-pointer">
                        {{ updater.buttons.start.label }}
                    </button>
                    <button @click="changeInstallLocation"
                            :class="{ 'opacity-30': !updater.buttons.changeLocation.enabled }"
                            class="font-exo px-6 py-1.5 text-sm bg-slate-800 hover:bg-slate-700 transition-all text-white rounded cursor-pointer">

                        <span
                            v-if="updater.buttons.changeLocation.enabled">{{ updater.buttons.changeLocation.label }}</span>

                        <span v-if="!updater.buttons.changeLocation.enabled" class="">
                            <svg class="animate-spin h-5 w-5 mx-16 text-slate-600" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <!--        <RemarkModal :is-open="false"/>-->
    </div>
</template>

<script lang="ts" setup>
import {onMounted, reactive} from 'vue';
import LoadingBar from '@/views/components/loading-bar.vue';
import aaf_logo_2x from '@/images/aaf_logo_2x.png'
import {Inertia} from "@inertiajs/inertia";
import ScarletDownloader, {Status as ClientStatus} from '@/scripts/downloader/downloader'
import Status from '@/views/components/status.vue'
import ElectronDownloader from '@/views/components/electron-toolbar.vue'
import {User} from "@/scripts/downloader/user";

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

let downloader = reactive(new ScarletDownloader(props.current_user))
downloader.init()

let updater = reactive({
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
    }
})

/** Get ARMA details */
onMounted(() => {
    stateDisconnected()
    Inertia.reload({only: ['arma_server']})
})

/**
 * Agent Controls
 */
function changeInstallLocation() {
    if (downloader.client.status === ClientStatus.Ready && updater.buttons.changeLocation.enabled) {
        downloader.showLocationDialog()
    }
}

function toggleDownload() {
    // window.startDownload = downloader.startDownload
    if (props.current_user?.installDir && updater.buttons.start.enabled) {
        if (downloader.client.status === ClientStatus.Ready) {
            downloader.startDownload()
        } else if (downloader.client.status === ClientStatus.Downloading) {
            downloader.stopDownload()
        }
    }
}


function stateDisconnected() {
    stateReady()
    updater.status = "Updater Disconnected"
    updater.file = 'Please make sure the agent is running.'
    updater.buttons.start.enabled = false
    updater.buttons.changeLocation.enabled = false
    updater.statusColor = 'red'
}

function stateReady() {
    updater.status = "Hello " + props.current_user.username
    updater.buttons.start.label = "Start Download";
    if (!props.user?.installDir) {
        updater.buttons.start.enabled = false
        updater.file = 'Please set your installation directory.'
    } else {
        updater.buttons.start.enabled = true
        updater.file = "Current Install Location is: " + props.current_user.installDir + "\\@Mods_AAF"
    }
    updater.buttons.changeLocation.enabled = true
    updater.statusColor = 'sky'
}

function stateComplete() {
    updater.buttons.start.label = "Revalidate";
    updater.buttons.start.enabled = true
    updater.buttons.changeLocation.enabled = true
    updater.file = "Download & validation completed successfully."
    updater.status = "Success"
    updater.statusColor = 'emerald'
}


// Ready
downloader.on('ready', () => stateReady())
downloader.on('complete', stateComplete)
downloader.on('disconnected', stateDisconnected)

// Downloading
downloader.on('downloading', () => {
    stateReady()
    updater.buttons.start.label = "Stop Download";
    updater.buttons.changeLocation.enabled = false
})

downloader.on('statusUpdate', (evt) => updater.status = evt.data.trim() ?? updater.status)
downloader.on('fileUpdate', (evt) => updater.file = evt.data.trim() ?? updater.file)


// Update Installer Location
downloader.on('updateInstallerLocation', evt => {
    Inertia.post('/@me/', {
        installDir: evt.data
    }, {
        // preserveState: false
        onSuccess: () => {
            Inertia.reload({only: ['current_user']})
            downloader.fire('ready')
        }
    })
})

</script>

<style></style>
