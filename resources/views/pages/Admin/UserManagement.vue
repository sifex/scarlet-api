<template>
    <admin-template :current_user="current_user">
        <template #title>
            <h1 class="text-4xl text-white font-exo">User Management</h1>
        </template>

        <div class="bg-white rounded-lg min-h-full py-10 px-4 sm:px-6 lg:px-10">
            <div class="flex">
                <div class=" basis-3/4">
                    <h2 class="text-2xl text-slate-700 pb-8 font-exo">Existing Users</h2>
                </div>
                <div class=" -mt-5 basis-1/4">
                    <label for="first-name" class="block text-sm font-medium text-gray-700">Search</label>
                    <input v-model="search_term" type="text" name="first-name" id="first-name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                </div>
            </div>

            <div id="header" class="w-full border-b flex items-center gap-4 py-4 border-collapse table-auto w-full text-sm">
                <div class="basis-2/12 font-medium text-slate-500 text-left pl-4">
                    Username
                </div>

                <div class="basis-1/12 font-medium text-slate-500 text-center">
                    Installed
                </div>

                <div class="basis-5/12 font-medium text-slate-500 text-left">
                    Installation Directory
                </div>

                <div class="basis-1/12 font-medium text-slate-500 text-left">
                    Role / Type
                </div>

                <div class="basis-3/12 font-medium text-slate-500 text-right pr-4">


                </div>
            </div>

            <div class="group flex items-center gap-4 block h-12 border-b border-slate-100 text-slate-500 hover:bg-slate-100 transition-colors duration-100 rounded-xl" v-for="user in all_filtered_users">
                <div class="basis-2/12 truncate pl-4">
                    {{ user.item.username }}
                </div>
                <div class="basis-1/12 text-center truncate">
                    <template v-if="user.item.installDir">
                        <CheckIcon class="inline-block h-5 w-5 mr-1 -ml-1 text-emerald-500"></CheckIcon>
                    </template>
                    <template v-else>
                        <XIcon class="inline-block h-5 w-5 mr-1 -ml-1 text-rose-500"></XIcon>
                    </template>
                </div>
                <div class="basis-5/12 truncate">
                    {{ user.item.installDir }}
                </div>
                <div class="basis-1/12 truncate">
                    <MemberTypeBadge class="w-full text-center" :type="MemberType[user.item.type]"></MemberTypeBadge>
                </div>
                <div class="basis-3/12 text-slate-600 text-right pr-4">
                    <div class="flex">
                        <div class="grow"></div>
                        <button
                            v-if="user.item.type.toUpperCase() === MemberType.applicant.toUpperCase()"
                            class="group bg-slate-300 p-1 -my-1 ml-2 rounded px-2 uppercase font-semibold text-xs hover:text-white hover:bg-slate-600 transition-colors">
                            <ChevronUpIcon class="inline-block h-4 w-4 mr-1 -ml-1 text-slate-500 group-hover:text-white transition-colors"></ChevronUpIcon>
                            Promote to Member
                        </button>
                        <Link :href="$route('admin.usermanagement.user', { user: user.item.username })"
                            class="bg-slate-100 -my-1 ml-2 rounded py-2 px-3 uppercase font-semibold text-xs hover:text-white hover:bg-slate-600 transition-colors">
                            Edit
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </admin-template>
</template>

<script lang="ts" setup>
import {computed, inject, onMounted, reactive, ref} from 'vue';
import {SelectorIcon, CheckIcon, XIcon, ChevronUpIcon} from '@heroicons/vue/solid'
import {MemberType} from "@/scripts/aaf/membertypes";
import AdminTemplate from "@/views/components/templates/admin-template.vue";
import MemberTypeBadge from '@/views/components/member-type-badge.vue'
import Fuse from "fuse.js";
import {Link} from "@inertiajs/inertia-vue3";
import {User} from "@/scripts/downloader/user";
import {Inertia} from "@inertiajs/inertia";

const {current_user, all_users = []} = defineProps<{
    current_user: User,
    all_users: [User],
}>()



/**
 * Search
 * This is showing all search result'ed users
 */

let search_term = ref('')

let fuse = new Fuse(all_users, {
    threshold: .4,
    includeScore: true,
    keys: ['username']
})

const all_filtered_users = computed(() => {
    return search_term.value !== ''
        ? fuse.search(search_term.value)
        : all_users.map((user) => ({'item': user}))
})



onMounted(() => {
    Inertia.reload({only: ['all_users']})

    /**
     * Table Sorting
     */
    let sort_key: keyof User = 'type'
    let sort_asc = 'asc'

    let all_sorted_users = computed(() => {
        return all_users.sort((a: User, b: User) => {
            //@ts-ignore
            return a[sort_key] < b[sort_key] ? -1 : 1
        })
    })

})

let $route = inject('$route')
</script>

