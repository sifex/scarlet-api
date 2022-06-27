<template>
    <div id="toolbar">
        <div data-tauri-drag-region id="drag" class="fixed w-full h-48 -mt-10 -mb-32 r-10 opacity-5 z-10"></div>
        <div v-if="ready" id="window-buttons" class="fixed top-0 right-0 z-10">
            <div @click="appWindow.minimize" id="minimise"
                 class="m-0 bg-white/5 inline-block w-20 h-7 text-center text-white cursor-default hover:bg-white/20 hover:text-white align-middle transition-colors">
                _
            </div>
            <div @click="appWindow.close" id="close"
                 class="m-0 bg-black/60 inline-block w-20 h-7 text-center text-white cursor-default hover:bg-red-500 hover:text-white align-middle transition-colors">
                ✕
            </div>
        </div>
    </div>
</template>

<script setup>
import {appWindow} from '@tauri-apps/api/window'
import {onMounted, ref} from "vue";

let ready = ref(false)

onMounted(() => {
    ready.value = true
    console.log('welcome')
})

</script>

<style scoped>
</style>
