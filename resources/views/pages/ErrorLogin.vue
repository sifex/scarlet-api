<template>
    <model-template :logo="false">
        <Head>
            <title>Scarlet - Error</title>
            <meta name="description" content="Your page description">
        </Head>
        <div class="p-8 space-y-4">
            <ShieldExclamationIcon class="h-10 w-10 text-red-500 mx-auto"></ShieldExclamationIcon>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-800">
                There was an error with your account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600" v-for="error in errors">{{ error }}</p>
        </div>
    </model-template>
</template>

<script lang="ts" setup>
import {computed, inject, onMounted} from 'vue';
import ModelTemplate from "@/views/components/templates/model-template.vue";
import { Head } from '@inertiajs/inertia-vue3'
import {ShieldExclamationIcon} from "@heroicons/vue/20/solid";

const props = defineProps({
    errors: {
        default: {}
    }
})

onMounted(() => {
    if(Object.keys(props.errors).length === 0) {
        location.href = $route('home')
    }
})

let $route: any = inject('$route')

</script>

