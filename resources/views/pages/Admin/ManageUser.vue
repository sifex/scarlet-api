<template>
    <admin-template :current_user="current_user">
        <template #title>

            <h1 class="text-4xl text-white font-exo">
                <Link :href="$route('admin.usermanagement')" class="text-white/80 hover:text-white/40 transition-colors">
                    User Management
                </Link>
                <span class="text-slate-200/40">
                    <ChevronRightIcon class="inline-block w-9 text-white/30 -mb-1.5 -mt-1.5"></ChevronRightIcon>
                </span>
                {{ user.username }}
            </h1>
        </template>

        <div class="bg-white rounded-lg min-h-full py-10 px-10"></div>
    </admin-template>
</template>

<script lang="ts" setup>
import {computed, inject, onMounted, reactive, ref} from 'vue';
import {SelectorIcon, CheckIcon, XIcon, ChevronRightIcon} from '@heroicons/vue/solid'
import {MemberType} from "@/scripts/aaf/membertypes";
import AdminTemplate from "@/views/components/templates/admin-template.vue";
import MemberTypeBadge from '@/views/components/member-type-badge.vue'
import Fuse from "fuse.js";
import {Link} from "@inertiajs/inertia-vue3";
import {User} from "@/scripts/downloader/user";

const props = defineProps<{
    current_user: User,
    user: User,
}>()

let $route = inject('$route')
</script>

