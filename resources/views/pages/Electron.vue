<template>
    <div class="font-[Exo_2] absolute h-full w-full bg-[#080e1f] bg-aaf-background retina:bg-aaf-background-2x bg-cover bg-center font-weight-bolder select-none">
        <div id="drag" class="fixed w-full h-48 -mt-10 -mb-32 r-10 opacity-5"></div>
        <div id="window-buttons" class="fixed top-0 right-0 z-10">
            <div @click="minimise" id="minimise" class="m-0 bg-white/5 inline-block w-20 h-7 text-center text-white cursor-default hover:bg-white/20 hover:text-white align-middle transition-colors">_</div>
            <div @click="close" id="close" class="m-0 bg-black/60 inline-block w-20 h-7 text-center text-white cursor-default hover:bg-red-500 hover:text-white align-middle transition-colors">✕</div>
        </div>

        <div class="flex flex-col h-full">
            <div class="flex pt-10 pb-6">
                <div class="flex-none pl-10">
                    <div id="logo" class="">
                        <img :src="aaf_logo_2x" alt="" height="91" width="266">
                    </div>
                </div>
                <div class="grow">

                </div>
                <div class="flex-none pr-6 pt-4">
                    <status title="AAF Arma Server" :players="arma_server.gq_numplayers" :color="Object.keys(arma_server).length !== 0"></status>
                    <status title="Scarlet Updater" :color="!([ClientStatus.Error, ClientStatus.Disconnected].includes(downloader.client.status))"></status>
                </div>
            </div>
            <div id="banner" class="grow">
                <div class="bg-slate-900 border-none overflow-hidden h-full w-full bg-cover bg-center" style="background-image: url('https://pbs.twimg.com/media/FJjwyzcagAM9sSf?format=jpg&name=large')" alt=""></div>
            </div>
            <div id="download-section-bottom" class=" text-white">
                <LoadingBar :width="56" class="-mt-5 mx-8"></LoadingBar>
            </div>
            <div id="buttons" class="h-32 px-8">
                <div id="status" class="pb-1.5">
                    <p class="inline-block mr-2 text-sky-500 font-exo text-sm font-semibold">Hello {{user.username}}</p>
                    <p class="inline-block mr-2 text-slate-400 tabular-nums font-exo text-sm">Connected to Client Updater</p>
                </div>
                <div class="flex gap-1">
                    <button class="font-exo px-6 py-1.5 text-sm bg-sky-600 hover:bg-sky-500 transition-colors text-white rounded cursor-pointer">Start Download</button>
                    <button class="font-exo px-6 py-1.5 text-sm bg-slate-800 hover:bg-slate-700 transition-colors text-white rounded cursor-pointer">Change Download Location</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {onMounted, ref} from 'vue';
import LoadingBar from '@/views/components/loading-bar.vue';
import aaf_logo_2x from '@/images/aaf_logo_2x.png'
import {Inertia} from "@inertiajs/inertia";
import ScarletDownloader, {ClientStatus, User} from '@/scripts/downloader/downloader'
import Status from '@/views/components/status.vue'

const props = defineProps({
    user: {
        type: Object as () => User
    },
    arma_server: {
        type: Object,
        default: {}
    }
})

let downloader = ref(new ScarletDownloader(props.user ?? {username: '', steamID: ''}))

onMounted(() => {
    Inertia.reload({ only: ['arma_server'] })
    setTimeout(() => {
        downloader.value.client.status = ClientStatus.Disconnected
    }, 1000)
})

function close() {
    console.log('close')
}
function minimise() {
    console.log('minimise')
}

</script>

<style></style>
