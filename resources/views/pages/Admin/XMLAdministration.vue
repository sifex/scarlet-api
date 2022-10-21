<template>
    <admin-template :current_user="current_user">
        <template #title>
            <h1 class="text-4xl text-white font-exo">XML Administration</h1>
            <h4 class=" text-white/50 font-exo">Squad XML Control</h4>
        </template>

        <div class="rounded-lg min-h-full md:flex">
            <div
                class="bg-white rounded-t-lg md:rounded-r-none md:rounded-l-lg md:basis-1/2 py-10 px-4 sm:px-6 lg:px-10">
                <h2 class="text-2xl text-slate-700 pb-8">Squad XML</h2>

                <div class="flex flex-col gap-2">
                    <label for="squad-xml-link" class="block text-sm font-medium text-gray-700">Squad XML Link</label>
                    <input disabled type="text" name="first-name" id="squad-xml-link"
                           class="block w-full rounded-md border-gray-300 bg-slate-100 text-slate-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           :value="xml_link">
                    <button class="w-full p-2 bg-indigo-500 font-bold text-sm text-white rounded-md">
                        <ClipboardIcon class="inline-block h-6 w-6"></ClipboardIcon>
                        Copy to Clipboard
                    </button>
                </div>
            </div>
            <div
                class="text-slate-700 bg-slate-200 rounded-b-lg md:rounded-l-none md:rounded-r-lg md:basis-1/2 py-10 px-4 sm:px-6 lg:px-10">
                <highlightJS language="xml" :code="xml_content" class="shadow-2xl bg-[#22272F] code overflow-x-scroll
                     h-[800px] mt-3 block w-full rounded-lg  focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></highlightJS>
            </div>
        </div>
    </admin-template>
</template>

<script lang="ts" setup>
import {defineComponent, inject} from 'vue';
import AdminTemplate from "@/views/components/templates/admin-template.vue";
import {User} from "@/scripts/downloader/user";
import {ClipboardIcon} from "@heroicons/vue/24/outline";

import 'highlight.js/lib/common';
import 'highlight.js/styles/github-dark-dimmed.css'
import hljsVuePlugin from "@highlightjs/vue-plugin";

// noinspection JSUnusedGlobalSymbols
const highlightJS = hljsVuePlugin.component

const props = defineProps<{
    current_user: User,
    xml_content: string,
    xml_link: string
}>()

const $route = inject('$route')
</script>

