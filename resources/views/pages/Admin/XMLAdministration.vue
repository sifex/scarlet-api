<template>
    <admin-template :current_user="current_user">
        <template #title>
            <h1 class="text-4xl text-white font-exo">XML Administration</h1>
        </template>

        <div class="bg-white rounded-lg min-h-full py-10 px-4 sm:px-6 lg:px-10">
            <div class="md:flex">
                <div class="md:basis-2/4 lg:basis-3/4">
                    <h2 class="text-2xl text-slate-700 pb-8 font-exo">XML</h2>
                </div>
            </div>
        </div>
    </admin-template>
</template>

<script lang="ts" setup>
import {computed, inject, onMounted, ref} from 'vue';
import {CheckIcon, XMarkIcon} from '@heroicons/vue/24/solid'
import {MemberType} from "@/scripts/aaf/membertypes";
import AdminTemplate from "@/views/components/templates/admin-template.vue";
import MemberTypeBadge from '@/views/components/member-type-badge.vue'
import Fuse from "fuse.js";
import {Link} from "@inertiajs/inertia-vue3";
import {User} from "@/scripts/downloader/user";
import {Inertia} from "@inertiajs/inertia";

const props = defineProps<{
    current_user: User,
}>()


let $route = inject('$route')
</script>

