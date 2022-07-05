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

        <div class="bg-white rounded-lg min-h-full ">
            <div class="flex flex-col gap-2 md:flex-row md:gap-8 py-8 px-3 sm:px-4 md:px-6 lg:px-10 bg-slate-100 rounded-t-lg">
                <div class="shrink">
                    <b class="md:block pr-2 text-slate-600 text-sm">Role:</b>
                    <MemberTypeBadge class="text-center text-sm" :type="MemberType[user.type]"></MemberTypeBadge>
                </div>
                <div class="shrink">
                    <b class="md:block pr-4 text-slate-600 text-sm">Player ID <span
                        class="text-slate-400 whitespace-nowrap">(Steam ID)</span>:</b>
                    <span class="text-sm" v-if="user.playerID">{{ user.playerID }}</span>
                    <XIcon v-else class="inline-block h-5 w-5 mr-1 -ml-1 text-rose-500"></XIcon>
                </div>
                <div class="shrink">
                    <b class="md:block pr-4 text-slate-600 text-sm">Scarlet Installed:</b>
                    <template v-if="user.installDir">
                        <CheckIcon class="inline-block h-5 w-5 mr-1 -ml-1 text-emerald-500"></CheckIcon>
                    </template>
                    <template v-else>
                        <XIcon class="inline-block h-5 w-5 mr-1 -ml-1 text-rose-500"></XIcon>
                    </template>
                </div>
                <div class="grow"></div>
                <div class="shrink flex gap-4">
                    <div class="grow">
                        <button
                            class="block text-center text-sm w-full px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700 transition-colors">
                            <SteamLogo fill="#FFFFFF" class="inline-block h-4 mr-5 -mt-1"></SteamLogo>
                            Relink to Steam
                        </button>
                    </div>
                    <div class="grow">
                        <button
                            class="block text-center text-sm w-full px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-slate-600 hover:bg-slate-700 transition-colors">
                            <ArchiveIcon class="inline-block h-5 w-5 mr-1 -ml-1 text-white"></ArchiveIcon>
                            Archive User
                        </button>
                    </div>
                </div>
            </div>
            <div id="archived_banner" class="overflow-hidden w-full bg-orange-500 text-white py-2 text-center uppercase tracking-wide font-bold text-sm relative">
                <ExclamationIcon class="inline-block h-5 w-5 mr-1 -ml-1 text-orange-200 mr-4"></ExclamationIcon>
                <span class="z-10 relative">This user is archived</span>
            </div>
            <div id="notes" class="py-10 px-3 sm:px-4 md:px-6 lg:px-10">
                <h2 class="text-2xl text-slate-700 font-medium font-exo">
                    User Notes
                </h2>
                <p class="block text-sm text-slate-500">User notes are used to show a timeline of updates about an
                    applicant or member.</p>

                <form @submit.prevent="create_new_user_note" id="writing_area" class="py-4 flex flex-col gap-4">
                    <div>
                    <label for="contents" class="sr-only">User Note Contents:</label>
                    <span v-if="note_form.errors.contents" class="italic text-red-600 text-sm">
                        {{ note_form.errors.contents }}
                    </span>
                    <textarea v-model="note_form.contents"
                              name="contents"
                              class="h-24 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md placeholder-slate-400"
                              @keydown.meta.enter="create_new_user_note"
                              @keyup.ctrl.enter="create_new_user_note"
                              :placeholder="'Information about the user ' + user.username"></textarea>
                    </div>
                    <div class="flex">
                        <div class="grow"></div>
                        <div class="shrink">
                            <button type="submit"
                                    :disabled="note_form.processing"
                                    class="inline-block px-4 py-2 bg-indigo-500 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors">
                                Commit new User Note
                            </button>
                        </div>
                    </div>
                </form>
                <div v-if="!(user.notes.length)" id="timeline" class="w-full text-center py-10 text-sm text-slate-400">
                    No notes have been made about this user yet.
                </div>
                <div v-else id="notes_section" class="flex flex-col">
                    <div class="flex py-3 items-center border-t border-slate-300" v-for="note in user.notes">
                        <div class="grow">
                            {{ note.contents }} <span class="text-slate-400 text-sm block">written by {{ note.author.username }} {{ dayjs(note.created_at).fromNow() }}</span>
                        </div>
                        <div class="shrink">
                            <button
                                v-if="note.author.id === current_user.id"
                                @click="delete_user_note(note.id)"
                                class="block text-center w-full px-3 py-1 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-700 hover:text-white transition-colors">
<!--                                <ArchiveIcon class="inline-block h-5 w-5 mr-1 -ml-1 text-white"></ArchiveIcon>-->
                                Delete Note
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </admin-template>
</template>

<script lang="ts" setup>
import SteamLogo from '@/images/steam_logo.svg'
import {inject} from 'vue';
import {ArchiveIcon, CheckIcon, ChevronRightIcon, ExclamationIcon, XIcon} from '@heroicons/vue/solid'
import {MemberType} from "@/scripts/aaf/membertypes";
import AdminTemplate from "@/views/components/templates/admin-template.vue";
import MemberTypeBadge from '@/views/components/member-type-badge.vue'
import {Link, useForm} from "@inertiajs/inertia-vue3";
import {User} from "@/scripts/downloader/user";
import dayjs from 'dayjs'
import relativeTime from "dayjs/plugin/relativeTime";

dayjs.extend(relativeTime)

const props = defineProps<{
    current_user: User,
    user: User,
}>()

const note_form = useForm({
    contents: ''
})

function create_new_user_note() {
    try {
        note_form.post(
            $route('admin.user.note.store', {
                'user': props.user.uuid
            }), {
                preserveScroll: true,
                onSuccess: () => note_form.reset('contents'),
            }
        )

        note_form.contents = ''
    } catch (e) {

    }
}

function delete_user_note(note_id: number) {
    note_form.delete(
        $route('admin.user.note.destroy', {
            'user': props.user.uuid,
            'note': note_id
        }), {
            preserveScroll: true,
        }
    )
}

let $route = inject('$route')
</script>

