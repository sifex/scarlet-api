<script lang="ts" setup>
import type {User} from "@/scripts/downloader/user";

const props = defineProps<{
    current_user: User
}>();

const emit = defineEmits<{
    (e: 'on_select_install_dir', directory: string): void,
}>()


function showLocationDialog() {
    window.scarlet.open_choose_install_dir(
        props.current_user.installDir
    )

    window.scarlet.on_select_install_dir((event, directory: string) => {
        if (directory) {
            emit('on_select_install_dir', directory)
        }
    })
}
</script>

<template>
    <div @click="showLocationDialog">
        <slot>
            <button
                class="whitespace-nowrap shrink rounded-md border border-transparent bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-slate-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-500 focus-visible:ring-offset-2"
                type="button"

            >
                Update Installation Directory
            </button>
        </slot>
    </div>
</template>
