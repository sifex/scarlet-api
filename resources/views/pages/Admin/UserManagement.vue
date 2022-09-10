<template>
    <admin-template :current_user="current_user">
        <template #title>
            <h1 class="text-4xl text-white font-exo">User Management</h1>
        </template>

        <div class="bg-white rounded-lg min-h-full py-10 px-4 sm:px-6 lg:px-10">
            <div class="md:flex">
                <div class="md:basis-2/4 lg:basis-3/4">
                    <h2 class="text-2xl text-slate-700 pb-8 font-exo">Existing Users</h2>
                </div>
                <div class="-mt-5 md:basis-2/4 lg:basis-1/4">
                    <label for="search_term" class="block text-sm font-medium text-gray-700">Search</label>
                    <input v-model="search_term" type="text" name="search_term" id="search_term" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>
            </div>

            <div id="header" class="w-full border-b flex items-center gap-4 py-4 border-collapse table-auto w-full text-sm">
                <div class="basis-2/12 font-medium text-slate-500 text-left pl-4">
                    Username
                </div>

                <div class="basis-1/12 font-medium text-slate-500 text-left">
                    Player ID
                </div>

                <div class="basis-1/12 font-medium text-slate-500 text-left">
                    Role / Type
                </div>

                <div class="basis-1/12 font-medium text-slate-500 text-center">
                    Installed
                </div>

                <div class="basis-5/12 font-medium text-slate-500 text-left hidden md:block">
                    Installation Directory
                </div>

                <div class="basis-4/12 font-medium text-slate-500 text-right pr-4">


                </div>
            </div>

            <Link :href="$route('admin.user.show', { user: user.item.uuid })"
                v-for="user in all_filtered_users"
                class="group flex flex-col md:flex-row md:items-center md:gap-4 md:h-12 border-b border-slate-100 text-slate-500 hover:bg-slate-100 transition-colors duration-100 rounded-xl"
                :class="{'bg-orange-200': user.item.archived_at}">

                <div class="basis-2/12 truncate md:pl-4">
                    {{ user.item.username }}
                </div>
                <div class="basis-1/12 truncate text-sm">
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
                <div class="basis-5/12 truncate text-sm hidden md:block">
                    {{ user.item.installDir }}
                </div>
                <div class="basis-4/12 text-slate-600 text-right pr-4">
                    <div class="flex">

                    </div>
                </div>
            </Link>
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
    return search_term.value !== ''
        ? fuse.value.search(search_term.value)
        : all_mapped_users.value
})


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

let $route = inject('$route')
</script>

