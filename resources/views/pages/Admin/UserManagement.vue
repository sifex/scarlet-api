<template>
    <admin-template :current_user="current_user">
        <template #title>
            <h1 class="text-4xl text-white font-exo">User Management</h1>
            <h4 class=" text-white/50 font-exo">This page allows you to modify and update users within Scarlet.</h4>
        </template>

        <div class="bg-white rounded-lg min-h-full py-4 md:py-10 px-4 sm:px-6 lg:px-10">
            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4 justify-between mb-10">
                <div class="shrink flex space-x-1 rounded-xl bg-slate-200 p-1">
                    <button
                        @click="deleted_user_filter_button = 'active'"
                        :class="[
              'grow transition rounded-lg py-2.5 px-10 text-sm font-medium leading-5 ',
              'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
              deleted_user_filter_button === 'active'
                ? 'text-blue-500 bg-white shadow'
                : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800',
            ]"
                    >
                        Active
                    </button>
                    <button
                        @click="deleted_user_filter_button = 'deleted'"
                        :class="[
              'grow transition rounded-lg py-2.5 px-10 text-sm font-medium leading-5 ',
              'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
              deleted_user_filter_button === 'deleted'
                ? 'text-blue-500 bg-white shadow'
                : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800',
            ]"
                    >
                        Deleted
                    </button>
                </div>

                <div class="grow"></div>

                <div class="md:basis-2/4 lg:basis-1/4 flex flex-col gap-1">
                    <label for="search_term" class="block text-sm font-medium text-gray-700">Search</label>
                    <input v-model="search_term" type="text" name="search_term" id="search_term"
                           autocomplete="given-name"
                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                </div>
            </div>

            <div id="header"
                 class="w-full border-b flex items-center gap-4 py-4 border-collapse table-auto w-full text-sm">
                <div class="basis-2/12 font-medium text-slate-500 text-left pl-4">
                    Username
                </div>

                <div class="basis-3/12 font-medium text-slate-500 text-left">
                    Player ID
                </div>

                <div class="basis-1/12 font-medium text-slate-500 text-left">
                    Role / Type
                </div>

                <div class="basis-1/12 font-medium text-slate-500 text-center">
                    Installed
                </div>

<!--                <div class="basis-5/12 font-medium text-slate-500 text-left hidden md:block">-->
<!--                    Installation Directory-->
<!--                </div>-->

                <div class="basis-2/12 font-medium text-slate-500 text-center">
                    Last Login
                </div>

                <div class="basis-2/12 font-medium text-slate-500 text-center">
                    Last Download
                </div>
            </div>

            <Link :href="$route('admin.user.show', { user: user.item.uuid })"
                  v-for="user in all_filtered_users"
                  class="group flex flex-col md:flex-row md:items-center md:gap-4 md:h-12 text-slate-500 hover:bg-slate-100 transition-colors duration-100 rounded-xl"
                  :class="{'bg-red-100 !text-red-700 font-bold my-2 border border-2 border-red-500': user.item.deleted_at}">

                <div class="basis-2/12 truncate md:pl-4">
                    {{ user.item.username }}
                </div>
                <div class="basis-3/12 truncate text-sm">
                    {{ user.item.playerID }}
                </div>
                <div class="basis-1/12 truncate">
                    <MemberTypeBadge class="md:w-full text-center" :type="MemberType[user.item.type]"></MemberTypeBadge>
                </div>
                <div class="basis-1/12 text-center truncate">
                    <template v-if="user.item.installDir">
                        <CheckIcon class="inline-block h-5 w-5 mr-1 -ml-1 text-emerald-500"></CheckIcon>
                    </template>
                    <template v-else>
                        <XMarkIcon class="inline-block h-5 w-5 mr-1 -ml-1 text-rose-500"></XMarkIcon>
                    </template>
                </div>

                <div class="basis-2/12 font-medium text-slate-500 text-center">
                    <span class="italic text-red-800 opacity-40" v-if="!user.item.last_login_time">Never</span>
                    <span class="text-slate-600" v-else>{{ dayjs.tz(user.item.last_login_time, 'utc').fromNow() }}</span>
                </div>

                <div class="basis-2/12 font-medium text-slate-500 text-center">
                    <span class="italic text-red-800 opacity-40" v-if="!user.item.last_download_time">Never</span>
                    <span class="text-slate-600" v-else>{{ dayjs.tz(user.item.last_download_time, 'utc').fromNow() }}</span>
                </div>
            </Link>

            <div class="p-24 text-center text-slate-400" v-if="all_filtered_users.length === 0">No users found by those filters</div>
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

import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import utc from "dayjs/plugin/utc";
import timezone from "dayjs/plugin/timezone";

dayjs.extend(relativeTime)
dayjs.extend(utc)
dayjs.extend(timezone)

const props = defineProps<{
    current_user: User,
    all_users?: User[],
}>()

/**
 * Turn User[] into {item: User}[]
 */
let all_mapped_users = computed(() =>
    (props.all_users ?? []).map((user) => ({
        'item': user
    }))
)

/**
 * Search
 * This is showing all search result'ed users
 */
let search_term = ref('')

let fuse = computed(() => new Fuse((props.all_users ?? []), {
    threshold: .3,
    includeScore: true,
    keys: ['username']
}))

let all_filtered_users = computed(() => {
    return (
        search_term.value !== ''
        ? fuse.value.search(search_term.value)
        : all_mapped_users.value
    ).filter(
        deleted_user_filter_function(deleted_user_filter_button.value)
    )
})

/**
 * Filter only deleted users
 */

let deleted_user_filter_button = ref('active')

let deleted_user_filter_function = function(type: string) {
    switch (type) {
        case 'active':
            return (user: any) => !user.item.deleted_at
        case 'deleted':
            return (user: any) => !!user.item.deleted_at
        default:
            return (user: any) => true
    }
}


onMounted(() => {
    Inertia.reload({only: ['all_users']})

    // /**
    //  * Table Sorting
    //  */
    // let sort_key: keyof User = 'type'
    // let sort_asc = 'asc'
    //
    // all_sorted_users = computed(() => {
    //     return all_users.sort((a: User, b: User) => {
    //         //@ts-ignore
    //         return a[sort_key] < b[sort_key] ? -1 : 1
    //     })
    // })
})

let $route: any = inject('$route')
</script>

