<template>
        <div
            class="absolute h-full w-full bg-[#080e1f] bg-aaf-background retina:bg-aaf-background-2x bg-cover bg-center p-0 md:p-12 font-weight-bolder">


            <transition appear
                        enter-active-class="duration-700 ease-out"
                        enter-from-class="transform opacity-0 translate-y-4"
                        enter-to-class="opacity-100 translate-y-none"
            >
            <div class="min-h-full flex flex-col gap-5 items-center justify-center py-12 px-6 md:px-0 lg:px-8">
                <div class="max-w-5xl w-full bg-white rounded-xl shadow-2xl shadow-black/60">
                    <div class="flex-none md:flex">
                        <div
                            class="rounded-t-xl md:rounded-tr-none md:rounded-l-xl basis-2/5 bg-cover bg-center flex items-center justify-center md:items-end md:justify-start relative px-6 py-4"
                            :style="{ backgroundImage: 'url(\'' + background_home_image + '\')'}">
                            <div class="absolute bg-black/30 top-0 left-0 right-0 bottom-0 h-full w-full"></div>

                            <transition appear
                                        enter-active-class="delay-300 duration-700 ease-out"
                                        enter-from-class="transform opacity-0 translate-y-2"
                                        enter-to-class="opacity-100 translate-y-none"
                            >
                                <img v-if="logo"
                                     class="filter drop-shadow-xl drop-shadow-black h-20 md:h-20 w-auto"
                                     :src="aaf_logo" alt="AAF Logo"/>
                            </transition>
                        </div>
                        <div class="basis-3/5">
                            <slot></slot>
                        </div>
                    </div>
                </div>


                <transition appear
                            enter-active-class="delay-700 duration-500 ease-out"
                            enter-from-class="transform opacity-0 translate-y-4"
                            enter-to-class="opacity-100 translate-y-none"
                >
                    <div id="copyright" class="text-slate-300/20 align-middle">
                        Powered by
                        <ScarletLogo class="text-slate-300/40 inline-block h-5 w-5 mb-1"/>
                        Scarlet
                    </div>
                </transition>

            </div>

            </transition>
        </div>
</template>

<script lang="ts" setup>
import aaf_logo from '@/images/logo.png'
import background_home_image from '@/images/banner_home_small_2x.jpg'
import ScarletLogo from '@/images/scarlet_white.svg'

const props = defineProps({
    logo: {
        default: true,
        type: Boolean
    }
})

</script>

