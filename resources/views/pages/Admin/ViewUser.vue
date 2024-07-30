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
            <div
                class="flex flex-col gap-2 md:flex-row md:gap-8 py-8 px-3 sm:px-4 md:px-6 lg:px-10 bg-slate-100 rounded-t-lg">
                <div class="shrink">
                    <b class="md:block pr-2 text-slate-600 text-sm">Role:</b>
                    <MemberTypeBadge class="text-center text-sm" :type="MemberType[user.type]"></MemberTypeBadge>
                </div>
                <div class="shrink">
                    <b class="md:block pr-4 text-slate-600 text-sm">Player ID <span
                        class="text-slate-400 whitespace-nowrap">(Steam ID)</span>:</b>
                    <a :href="'https://steamcommunity.com/profiles/' + user.playerID" class="text-sm text-red-800 font-medium" v-if="user.playerID">{{ user.playerID }}</a>
                    <XMarkIcon v-else class="inline-block h-5 w-5 mr-1 -ml-1 text-rose-500"></XMarkIcon>
                </div>
                <div class="shrink">
                    <b class="md:block pr-4 text-slate-600 text-sm">Scarlet Installed:</b>
                    <template v-if="user.installDir">
                        <CheckIcon class="inline-block h-5 w-5 mr-1 -ml-1 text-emerald-500"></CheckIcon>
                    </template>
                    <template v-else>
                        <XMarkIcon class="inline-block h-5 w-5 mr-1 -ml-1 text-rose-500"></XMarkIcon>
                    </template>
                </div>
                <div class="grow"></div>
                <div class="shrink flex gap-4">
                    <div class="grow">
                        <button
                            v-if="false"
                            class="block text-center text-sm w-full px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700 transition-colors">
                            <SteamLogo fill="#FFFFFF" class="inline-block h-4 mr-5 -mt-1"></SteamLogo>
                            Relink to Steam
                        </button>
                    </div>
                    <div class="grow">
                        <span class="italic text-red-600 text-sm">{{ alter_user_form.errors.deleted_at }}</span>
                        <button
                            @click="delete_user(false)"
                            v-if="!user.deleted_at"
                            class="block text-center text-sm w-full px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition-colors">
                            <TrashIcon class="inline-block h-5 w-5 mr-1 -ml-1 text-white"></TrashIcon>
                            Delete User
                        </button>
                        <button
                            @click="delete_user(true)"
                            v-else
                            class="block text-center text-sm w-full px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-emerald-700 hover:bg-emerald-900 transition-colors">
                            <CheckBadgeIcon class="inline-block h-5 w-5 mr-1 -ml-1 text-white"></CheckBadgeIcon>
                            Recover User
                        </button>
                    </div>
                </div>
            </div>
            <div id="archived_banner"
                 v-if="user.deleted_at"
                 class="overflow-hidden w-full bg-red-600 text-white py-2 text-center uppercase tracking-wide font-bold text-sm relative">
                <ExclamationTriangleIcon
                    class="inline-block h-5 w-5 mr-1 -ml-1 text-red-200 mr-4"></ExclamationTriangleIcon>
                <span class="z-10 relative">This user has been removed</span>
            </div>
            <section id="control-bay" class="py-10 px-3 sm:px-4 md:px-6 lg:px-10 border-b border-1">
                <form @submit.prevent="update_user" class="flex flex-col gap-6 md:gap-10">
                    <h2 class="text-2xl text-slate-700 font-medium font-exo">
                        Edit User
                    </h2>
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="basis-full md:basis-5/12">
                            <h3 class="text-xl text-slate-700 font-medium font-exo">
                                Username
                            </h3>
                            <label for="user_username" class="block text-sm text-slate-500">The user's username.</label>
                        </div>
                        <div class="basis-full md:basis-2/12"></div>
                        <div class="basis-full md:basis-5/12">
                            <input name="user_username" type="text" v-model="alter_user_form.username"
                                   :disabled="user.deleted_at !== null" :class="{'bg-gray-100 text-slate-600': user.deleted_at !== null}"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <span class="italic text-red-600 text-sm">{{ alter_user_form.errors.username }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="basis-full md:basis-5/12">
                            <h3 class="text-xl text-slate-700 font-medium font-exo">
                                Modify Role
                            </h3>
                            <label for="user_role" class="block text-sm text-slate-500">User roles control who has
                                access to the Administration panel, as well as displays on the website.</label>
                        </div>
                        <div class="basis-full md:basis-2/12"></div>
                        <div class="basis-full md:basis-5/12">
                            <member-type-dropdown name="user_role"
                                                  :disabled="user.deleted_at !== null" :class="{'bg-gray-100 text-slate-600': user.deleted_at !== null}"
                                                  v-model="alter_user_form.type"></member-type-dropdown>
                            <span class="italic text-red-600 text-sm">{{ alter_user_form.errors.type }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="basis-full md:basis-5/12">
                            <h3 class="text-xl text-slate-700 font-medium font-exo">
                                XML Remark
                            </h3>
                            <label for="user_remark" class="block text-sm text-slate-500">The XML remark is what
                                displays underneath the User's XML</label>
                        </div>
                        <div class="basis-full md:basis-2/12"></div>
                        <div class="basis-full md:basis-5/12">
                            <input placeholder="The Squad XML Remark" name="user_remark" type="text"
                                   :disabled="user.deleted_at !== null" :class="{'bg-gray-100 text-slate-600': user.deleted_at !== null}"
                                   v-model="alter_user_form.remark"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <span class="italic text-red-600 text-sm">{{ alter_user_form.errors.remark }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="basis-full md:basis-5/12">
                            <h3 class="text-xl text-slate-700 font-medium font-exo">
                                Website Comment
                            </h3>
                            <p class="block text-sm text-slate-500">Displays as a comment on the website. <span
                                class="text-slate-300">(Staff and Leaders only)</span></p>
                        </div>
                        <div class="basis-full md:basis-2/12"></div>
                        <div class="basis-full md:basis-5/12">
                            <input placeholder="Website Comment" name="user_remark" type="text"
                                   v-model="alter_user_form.comment"
                                   :disabled="user.deleted_at !== null" :class="{'bg-gray-100 text-slate-600': user.deleted_at !== null}"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <span class="italic text-red-600 text-sm">{{ alter_user_form.errors.comment }}</span>
                        </div>
                    </div>
                    <div id="save-row" class="flex">
                        <div class="grow"></div>
                        <div class="shrink">
                            <button type="submit"
                                    :disabled="alter_user_form.processing || !alter_user_form.isDirty"
                                    class="inline-block px-8 py-2 bg-emerald-500 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition-colors disabled:opacity-30">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </section>
            <section id="notes" class="py-10 px-3 sm:px-4 md:px-6 lg:px-10">
                <h2 class="text-2xl text-slate-700 font-medium font-exo">
                    User Notes
                </h2>
                <p class="block text-sm text-slate-500">User notes are used to show a timeline of updates about an
                    applicant or member.</p>

                <form @submit.prevent="add_note" id="writing_area" class="py-4 flex flex-col gap-4">
                    <div>
                        <label for="contents" class="sr-only">User Note Contents:</label>
                        <span v-if="note_form.errors.contents" class="italic text-red-600 text-sm">
                            {{ note_form.errors.contents }}
                        </span>
                        <textarea v-model="note_form.contents"
                                  name="contents"
                                  class="h-24 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md placeholder-slate-400"
                                  @keydown.meta.enter="add_note"
                                  @keyup.ctrl.enter="add_note"
                                  :placeholder="'Information about the user ' + user.username"></textarea>
                    </div>
                    <div class="flex">
                        <div class="grow"></div>
                        <div class="shrink">
                            <button type="submit"
                                    :disabled="note_form.processing || !note_form.isDirty"
                                    class="inline-block px-4 py-2 bg-indigo-500 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors disabled:opacity-30">
                                Commit new User Note
                            </button>
                        </div>
                    </div>
                </form>
                <div v-if="!(user.notes.length)" id="timeline" class="w-full text-center py-10 text-sm text-slate-400">
                    No notes have been made about this user yet.
                </div>
                <div v-else id="notes_section" class="flex flex-col">
                    <div class="flex py-3 items-center border-t border-slate-200" v-for="note in user.notes">
                        <div class="grow">
                            {{ note.contents }} <span class="text-slate-400 text-sm block">written by {{
                                note.author.username
                            }} {{ dayjs(note.created_at).fromNow() }}</span>
                        </div>
                        <div class="shrink">
                            <button
                                v-if="note.author.id === current_user.id"
                                @click="delete_note(note.id)"
                                class="block text-center w-full px-3 py-1 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-700 hover:text-white transition-colors">
                                <!--                                <ArchiveBoxIcon class="inline-block h-5 w-5 mr-1 -ml-1 text-white"></ArchiveBoxIcon>-->
                                Delete Note
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </admin-template>
</template>

<script lang="ts" setup>
import SteamLogo from '@/images/steam_logo.svg'
import {inject} from 'vue';
import {
    TrashIcon,
    CheckBadgeIcon,
    CheckIcon,
    ChevronRightIcon,
    ExclamationTriangleIcon,
    XMarkIcon
} from '@heroicons/vue/24/solid'
import {MemberType} from "@/scripts/aaf/membertypes";
import AdminTemplate from "@/views/components/templates/admin-template.vue";
import MemberTypeBadge from '@/views/components/member-type-badge.vue'
import {Link, useForm} from "@inertiajs/inertia-vue3";
import {User} from "@/scripts/downloader/user";
import dayjs from 'dayjs'
import relativeTime from "dayjs/plugin/relativeTime";
// @ts-ignore
// noinspection TypeScriptCheckImport
import {notify} from "notiwind"
import MemberTypeDropdown from '@/views/components/member-type-dropdown.vue'

dayjs.extend(relativeTime)

const props = defineProps<{
    current_user: User,
    user: User,
}>()

/**
 * Change User Role
 */

const alter_user_form = useForm({
    ...props.user
})

function update_user() {
    alter_user_form.patch(
        $route('admin.user.update', {
            user: alter_user_form.uuid
        }), {
            preserveScroll: true,
            onSuccess: () => {
                notify({
                    group: "generic",
                    title: "Success",
                    text: "User updated"
                })
            },
            onError: (error) => {
                notify({
                    group: "error",
                    title: "Error",
                    text: error[0]
                })
            }
        }
    )
}

function delete_user(restore: boolean = false) {
    alter_user_form.transform(data => ({
        restore
    })).delete(
        $route('admin.user.destroy', {
            user: alter_user_form.uuid
        }), {
            preserveScroll: true,
            onSuccess: () => {
                notify({
                    group: "generic",
                    title: "Success",
                    text: "User Deleted"
                })
            },
            onError: (error) => {
                notify({
                    group: "error",
                    title: "Error",
                    text: error[0]
                })
            }
        }
    )
}

/**
 * User Notes Section
 */
const note_form = useForm({
    contents: ''
})

function add_note() {
    note_form.post(
        $route('admin.user.note.store', {
            'user': props.user.uuid
        }), {
            preserveScroll: true,
            onSuccess: () => {
                note_form.reset('contents')
                notify({
                    group: "generic",
                    title: "Success",
                    text: "User comment was successfully added"
                })
            }
        }
    )
}

function delete_note(note_id: number) {
    note_form.delete(
        $route('admin.user.note.destroy', {
            'user': props.user.uuid,
            'note': note_id
        }), {
            preserveScroll: true,
            onSuccess: () => {
                notify({
                    group: "generic",
                    title: "Success",
                    text: "User comment was successfully deleted"
                })
            }
        }
    )
}

let $route: any = inject('$route')
</script>

