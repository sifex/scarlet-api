<template>
    <admin-template :current_user="current_user">
        <template #title>

            <h1 class="text-4xl text-white font-exo">
                <Link :href="$route('admin.user.index')" class="text-white/80 hover:text-white/40 transition-colors">
                    User Management
                </Link>
                <span class="text-slate-200/40">
                    <ChevronRightIcon class="inline-block w-9 text-white/30 -mb-1.5 -mt-1.5"></ChevronRightIcon>
                </span>
                {{ user.username }}
            </h1>
        </template>

        <div class="bg-white rounded-lg min-h-full py-10 px-10">
            <div class="flex gap-8 py-8 border-y border-1 border-slate-100">
                <div class="shrink">
                    <b class="block text-slate-600 text-sm">Role:</b>
                    <MemberTypeBadge class="w-full text-center" :type="MemberType[user.type]"></MemberTypeBadge>
                </div>
                <div class="shrink">
                    <b class="block text-slate-600 text-sm">Player ID <span class="text-slate-400">(Steam ID)</span>:</b>
                    <span class="text-sm">{{ user.playerID }}</span>
                </div>
                <div class="shrink">
                    <b class="block text-slate-600 text-sm">Scarlet Installed:</b>
                    <template v-if="user.installDir">
                        <CheckIcon class="inline-block h-5 w-5 mr-1 -ml-1 text-emerald-500"></CheckIcon>
                    </template>
                    <template v-else>
                        <XIcon class="inline-block h-5 w-5 mr-1 -ml-1 text-rose-500"></XIcon>
                    </template>
                </div>
                <div class="grow"></div>
                <div class="shrink">
                    <button
                       class="block text-center text-sm w-full px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700 transition-colors">
                        <SteamLogo fill="#FFFFFF" class="inline-block h-4 mr-5 -mt-1"></SteamLogo>Relink to Steam
                    </button>
                </div>
                <div class="shrink">
                    <button
                       class="block text-center text-sm w-full px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-rose-600 hover:bg-rose-700 transition-colors">
                        Delete User
                    </button>
                </div>
            </div>
        </div>
    </admin-template>
</template>

<script lang="ts" setup>
import SteamLogo from '@/images/steam_logo.svg'
import {inject} from 'vue';
import {CheckIcon, ChevronRightIcon, XIcon} from '@heroicons/vue/24/solid'
import {MemberType} from "@/scripts/aaf/membertypes";
import AdminTemplate from "@/views/components/templates/admin-template.vue";
import MemberTypeBadge from '@/views/components/member-type-badge.vue'
import {Link} from "@inertiajs/inertia-vue3";
import {User} from "@/scripts/downloader/user";

const props = defineProps<{
    current_user: User,
    user: User,
}>()

let $route = inject('$route')
</script>

