<template>
    <div id="toolbar">
        <div data-tauri-drag-region id="drag" class="fixed w-full h-48 -mt-10 -mb-32 r-10 opacity-5 z-10"></div>
        <div v-if="electron" id="window-buttons" class="fixed top-0 right-0 z-10">
            <div @click="appWindow.minimize" id="minimise"
                 class="m-0 bg-white/5 inline-block w-20 h-7 text-center text-white cursor-default hover:bg-white/20 hover:text-white align-middle transition-colors duration-75">
                _
            </div>
            <div @click="appWindow.close" id="close"
                 class="m-0 bg-black/60 inline-block w-20 h-7 text-center text-white cursor-default hover:bg-red-500 hover:text-white align-middle transition-colors duration-75">
                ✕
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";

let appWindow = {
    minimize: () => window.scarlet.minimise(),
    close: () => window.scarlet.close(),
}

let electron = ref(false)

onMounted(() => {
    if(typeof window.scarlet !== 'undefined') {
        electron.value = true
    }
})

</script>

<style scoped>
#drag {
    -webkit-user-select: none;
    -webkit-app-region: drag;
}
#window-buttons {
    -webkit-app-region: no-drag;
}
</style>
