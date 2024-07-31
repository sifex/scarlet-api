<template>
    <div v-if="current_user_instance.isAdmin()" class="">
        <button
            class="block text-center font-exo font-medium px-4 py-2 border border-transparent text-sm rounded-md bg-rose-500 text-white hover:bg-rose-700 hover:text-white transition-colors"
            @click="open_admin_page_in_browser"
        >
            Open Admin in Browser
            <ArrowTopRightOnSquareIcon class="inline-block h-4 w-4"/>
        </button>
    </div>
</template>
<script lang="ts" setup>
import {computed} from "vue";
import {User} from "@/scripts/downloader/user";
import {ArrowTopRightOnSquareIcon} from "@heroicons/vue/16/solid";

const props = defineProps<{
    current_user: User
}>()

const current_user_instance = computed(() => {
    return Object.assign(new User(
        props.current_user.username,
        props.current_user.playerID,
    ), props.current_user)
});

function open_admin_page_in_browser() {
    window.scarlet.open_admin_page_in_browser();
}

</script>
