<template>
    <admin-template :current_user="current_user">
        <template #title>
            <h1 class="text-4xl text-white font-exo">Settings</h1>
            <h4 class=" text-white/50 font-exo">Pretty useless for now</h4>
        </template>

        <div class="rounded-lg min-h-full py-8 px-3 sm:px-4 md:px-6 lg:px-10 bg-white ">
            <div class="flex flex-col gap-2">
                <div class="flex flex-col gap-6">
                    <label class="flex flex-col gap-1 text-sm font-medium text-gray-700">
                        Launcher Background Image URL
                        <span v-if="settings_form.errors.launcher_image_url" class="italic text-red-600 text-sm">
                            {{ settings_form.errors.launcher_image_url }}
                        </span>
                        <input v-model="settings_form.launcher_image_url"
                               class="block w-full flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               type="text"/>
                    </label>
                    <label class="flex flex-col gap-1 text-sm font-medium text-gray-700">
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
import {inject} from "vue";
import {User} from "@/scripts/downloader/user";
import {useForm} from "@inertiajs/inertia-vue3";
import AdminTemplate from "@/views/components/templates/admin-template.vue";
import {notify} from "notiwind"

const props = defineProps<{
    current_user: User,

    launcher_image_url: string,
    welcome_image_url: string,

}>();

const settings_form = useForm({
    launcher_image_url: props.launcher_image_url,
    welcome_image_url: props.welcome_image_url,
})


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


let $route = inject('$route')

</script>

