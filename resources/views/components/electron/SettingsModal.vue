<template>
    <div @click="openModal">
        <slot>
            <button class="flex gap-2 items-center font-exo px-4 py-2 bg-slate-800 hover:bg-slate-700 transition-all text-white rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-500 focus-visible:ring-offset-2 ring-offset-black"
                    type="button">
                <Cog6ToothIcon class="h-6 w-6 text-slate-500"></Cog6ToothIcon>
                Settings
            </button>
        </slot>
    </div>
    <TransitionRoot :show="isOpen" appear as="template">
        <Dialog as="div" class="relative z-10" @close="closeModal">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black bg-opacity-25"/>
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div
                    class="flex min-h-full items-center justify-center p-4 text-center"
                >
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                            class="w-full max-w-4xl transform overflow-hidden rounded-2xl bg-white text-left align-middle shadow-xl transition-all flex flex-col"
                        >
                            <form @submit.prevent="update_user">
                                <div class="p-8 flex flex-col gap-4">
                                    <h2 class="text-xl font-medium leading-6 text-gray-900">Settings</h2>
                                    <DialogTitle
                                        as="h3"
                                        class="text-lg font-medium leading-6 text-gray-900"
                                    >
                                        Installer
                                    </DialogTitle>
                                    <div class="flex flex-col gap-6">
                                        <label class="flex flex-col gap-1 block text-sm font-medium text-gray-700"
                                               for="company-website">
                                            Username
                                            <span v-if="alter_user_form.errors.username"
                                                  class="italic text-red-600 text-sm">
                                                {{ alter_user_form.errors.username }}
                                            </span>
                                            <input v-model="alter_user_form.username"
                                                   class="block w-full flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                   type="text"/>
                                        </label>

                                        <label v-if="isElectron"
                                               class="flex flex-col gap-1 text-sm font-medium text-gray-700"
                                               for="company-website">
                                            Installation Directory
                                            <span class="font-normal text-slate-400">Your installation directory is where your Addons will be installed.</span>
                                            <span v-if="alter_user_form.errors.installDir"
                                                  class="italic text-red-600 text-sm">
                                                    {{ alter_user_form.errors.installDir }}
                                                </span>

                                            <div class="flex md:flex-row flex-col gap-2">
                                                <span class="grow bg-slate-100 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                      type="text">
                                                    {{ alter_user_form.installDir }}<span class="text-slate-400">\{{mods_prefix}}</span>
                                                </span>

                                                <SelectInstallDirectory
                                                    :current_user="current_user"
                                                    @on_select_install_dir="on_select_install_dir"/>
                                            </div>
                                        </label>

                                        <label v-if="isElectron"
                                               class="flex gap-4 items-center text-sm font-medium text-gray-700"
                                               for="company-website">
                                            <span class="order-2 flex flex-col">
                                                Debug Messages
                                                <span class="font-normal text-slate-400 mb-1">Not a really helpful toggle but may give some indication of what can go wrong with Scarlet.</span>
                                            </span>

                                            <div class="flex md:flex-row flex-col gap-2">

                                                <Switch
                                                    v-model="debug_messages"
                                                    :class="debug_messages
                                                        ? 'bg-red-600'
                                                        : 'bg-slate-400/40 '"
                                                    class="relative inline-flex h-[30px] w-[54px] shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                                                >
                                                    <span class="sr-only">Use debug messages</span>
                                                    <span
                                                        :class="debug_messages ? 'translate-x-6' : 'translate-x-0'"
                                                        aria-hidden="true"
                                                        class="pointer-events-none inline-block h-[26px] w-[26px] transform rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out"
                                                    />
                                                </Switch>

                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="bg-slate-100 p-6">

                                    <div class="flex gap-2 w-full">
                                        <a v-if="isElectron"
                                           :href="$route('logout')"
                                           class="inline-flex justify-center rounded-md border border-transparent bg-red-100 px-4 py-2 text-sm font-medium text-red-900 hover:bg-red-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2"
                                           type="button"
                                           @click="closeModal"
                                        >
                                            Logout
                                        </a>
                                        <div class="grow"></div>

                                        <button
                                            class="inline-flex justify-center rounded-md border border-transparent bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                            type="button"
                                            @click="update_user"
                                        >
                                            Save
                                        </button>
                                        <button
                                            class="inline-flex justify-center rounded-md border border-transparent bg-slate-300 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-slate-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-500 focus-visible:ring-offset-2"
                                            type="button"
                                            @click="closeModal"
                                        >
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script lang="ts" setup>
import {inject, ref} from 'vue'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'

import {Cog6ToothIcon} from '@heroicons/vue/24/solid'
import {User} from "@/scripts/downloader/user";
import {useForm} from "@inertiajs/inertia-vue3";
import {notify} from "notiwind"
import {Switch} from '@headlessui/vue'
import useLocalStorage from "@/scripts/useLocalStorage";
import type ScarletDownloader from "@/scripts/downloader/downloader";
import SelectInstallDirectory from "@/views/components/electron/SelectInstallDirectory.vue";


const isOpen = ref(false)

const props = defineProps<{
    current_user: User,
    downloader: ScarletDownloader,
}>();

const emit = defineEmits<{
    (e: 'settings_saved'): void,
    (e: 'settings_closed'): void,
}>()


function closeModal() {
    emit('settings_closed')
    isOpen.value = false

    // Because we don't want the UI to flash on close of model
    setTimeout(alter_user_form.reset, 500)
}

function openModal() {
    isOpen.value = true
}

const alter_user_form = useForm({
    ...props.current_user
})

let isElectron = ref(typeof window.scarlet !== 'undefined')
let mods_prefix = '@Mods_AAF'

/**
 * Installation Directory
 */
function on_select_install_dir(directory: string) {
    alter_user_form.installDir = transformInstallDir(directory)
}

function transformInstallDir(installDir: string | null): string | null {
    if (installDir === null) {
        return null;
    }

    // Remove "/Directory" or "/Directory/" suffix if it exists
    installDir = installDir.replace(new RegExp(`/${mods_prefix}/?$`), '');

    // Remove "\Directory\" or "\Directory" suffix if it exists (for Windows-style paths)
    installDir = installDir.replace(new RegExp(`\\\\${mods_prefix}\\\\?$`), '');

    // Remove trailing slash or backslash if it exists
    return installDir.replace(/[/\\]$/, '');
}


function update_user() {
    alter_user_form.patch(
        $route('user.update'), {
            preserveScroll: true,
            onSuccess: () => {
                notify({
                    group: "generic",
                    title: "Success",
                    text: "Settings saved successfully"
                })
                closeModal()
            }
        }
    )
}


/**
 * Debug Toggle
 */

const debug_messages = useLocalStorage('scarlet_debug_messages', false)

let $route: any = inject('$route')

</script>
