<template>
    <admin-template :current_user="current_user">
        <template #title>
            <h1 class="text-4xl text-white font-exo">Settings</h1>
            <h4 class=" text-white/50 font-exo">Pretty useless for now</h4>
        </template>

        <div class="rounded-lg min-h-full py-8 px-3 sm:px-4 md:px-6 lg:px-10 bg-white flex flex-col gap-12">
            <div class="flex flex-col gap-2">
                <h2 class="text-2xl font-exo text-gray-800">
                    Appearance
                </h2>
                <div class="flex gap-6">
                    <div class="basis-1/2 flex flex-col items-center gap-6">
                        <img :src="settings_form.launcher_image_url" class="rounded-lg shadow-lg w-96 h-52 object-cover"
                             alt="Launcher Background Image"/>
                        <label class="flex flex-col gap-1 text-sm font-medium text-gray-600 w-full">
                            Launcher Background Image URL
                            <span v-if="settings_form.errors.launcher_image_url" class="italic text-red-600 text-sm">
                            {{ settings_form.errors.launcher_image_url }}
                        </span>
                            <input v-model="settings_form.launcher_image_url"
                                   class="block w-full flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   type="text"/>
                        </label>
                    </div>

                    <div class="basis-1/2 flex flex-col items-center gap-6">
                        <img :src="settings_form.welcome_image_url" class="rounded-lg shadow-lg w-96 h-52 object-cover"
                             alt="Launcher Background Image"/>
                        <label class="flex flex-col gap-1 text-sm font-medium text-gray-600 w-full">
                            Welcome Background Image URL
                            <span v-if="settings_form.errors.welcome_image_url" class="italic text-red-600 text-sm">
                            {{ settings_form.errors.welcome_image_url }}
                        </span>
                            <input v-model="settings_form.welcome_image_url"
                                   class="block w-full flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   type="text"/>
                        </label>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="flex flex-col gap-2">
                <h2 class="text-2xl font-exo text-gray-800">
                    Mods Cache Control
                </h2>
                <div class="flex flex-col md:flex-row gap-12 md:gap-4">

                    <div class="max-w-lg space-y-4">
                        <p class="text-gray-600 text-sm">
                            This section allows you to regenerate the mods list that is served to the launcher. This is
                            to
                            control the cache of the mods list, such that if any file is replaced, the launcher will
                            recalculate the checksums for the new modset.
                        </p>
                        <p class="text-gray-600 text-sm">
                            If anyone is currently facing issues with the launcher, this is the likely cause.
                            Regenerating
                            the mods list will force the launcher to recalculate the checksums for all the mods.
                        </p>
                    </div>
                    <div class="flex flex-col justify-center items-center w-full gap-6">
                        <div class="">
                            <button
                                :class="{
                        'bg-blue-200': mods_form.processing,
                    }"
                                class="justify-center rounded-md border border-transparent bg-orange-500 px-4 py-2 text-sm font-medium text-white hover:bg-orange-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2"
                                @click="regenerate_mods"
                            >
                                Regenerate Mod List
                            </button>
                        </div>

                        <span v-if="is_mods_expired" class="text-red-600 text-center">
                                The current mods have expired.<br />The next time someone requests them from the server they will be regenerated.
                            </span>
                        <span v-else>
                            The current mods will still be served for <b
                            class="font-bold">{{ mods_ttl_formatted.fromNow(true) }}</b>
                            </span>
                    </div>
                </div>

            </div>
            <div class="py-6">
                <div class="flex gap-2 w-full">
                    <div class="grow"></div>

                    <button
                        class="inline-flex justify-center rounded-md border border-transparent bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                        type="button"
                        @click="update_settings"
                    >
                        Save
                    </button>
                    <button
                        class="inline-flex justify-center rounded-md border border-transparent bg-slate-300 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-slate-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-500 focus-visible:ring-offset-2"
                        type="button"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </admin-template>
</template>

<script lang="ts" setup>
import {computed, inject} from "vue";
import {User} from "@/scripts/downloader/user";
import {useForm} from "@inertiajs/inertia-vue3";
import AdminTemplate from "@/views/components/templates/admin-template.vue";
import {notify} from "notiwind"
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import {Inertia} from "@inertiajs/inertia";

dayjs.extend(relativeTime)
const props = defineProps<{
    current_user: User,
    mods_ttl: string,
    launcher_image_url: string,
    welcome_image_url: string,
}>();

const mods_ttl_formatted = computed(() => dayjs(props.mods_ttl))
const is_mods_expired = computed(() => mods_ttl_formatted.value.isBefore(dayjs()))

const settings_form = useForm({
    launcher_image_url: props.launcher_image_url,
    welcome_image_url: props.welcome_image_url,
})

const mods_form = useForm({})

function update_settings() {
    settings_form.patch(
        $route('admin.settings.update'), {
            preserveScroll: true,
            onSuccess: () => {
                notify({
                    group: "generic",
                    title: "Success",
                    text: "Settings saved successfully"
                })
            }
        }
    )
}

function regenerate_mods() {
    fetch($route('mods.regenerate'), {
        method: 'GET',
    }).then(response => {
        if (response.ok) {
            Inertia.reload({only: ['mods_ttl']});

            notify({
                group: "generic",
                title: "Success",
                text: "Mods regenerated successfully"
            })
        } else {
            notify({
                group: "generic",
                title: "Error",
                text: "An error occurred while regenerating mods"
            })
        }
    })
}


let $route: any = inject('$route')

</script>

