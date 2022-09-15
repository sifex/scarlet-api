<template>
    <div
        class="absolute h-full w-full bg-[#080e1f] bg-aaf-background retina:bg-aaf-background-2x bg-cover bg-center p-0 md:p-12 font-weight-bolder">
        <div class="min-h-full flex flex-col gap-5 items-center justify-center py-12 px-0 sm:px-6 lg:px-8">
            <div class="max-w-lg w-full space-y-4 bg-white rounded-xl shadow-2xl shadow-black">
                <img class="mx-auto h-24 w-auto -mt-14 -mb-2" :src="aaf_logo" alt="AAF Logo"/>
                <slot></slot>
            </div>
            <div id="copyright" class="text-slate-300/20 align-middle">
                Powered by <ScarletLogo class="text-slate-300/40 inline-block h-5 w-5 mb-1" /> Scarlet
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import aaf_logo from '@/images/logo.png'
import ScarletLogo from '@/images/scarlet_white.svg'
</script>

