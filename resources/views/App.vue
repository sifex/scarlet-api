<template>
    <div class="absolute h-full w-full bg-aaf-background retina:bg-aaf-background-2x bg-cover bg-center p-12 text-white font-weight-bolder text-lg">
        <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8 bg-white rounded-xl px-4 py-12">
                <div>
                    <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow" />
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-800">
                        Sign in to Scarlet
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Using your Steam Account
                    </p>
                </div>
                <login-with-steam></login-with-steam>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue';
import HelloWorld from './components/HelloWorld.vue';
import LoadingBar from './components/loading-bar.vue';
import LoginWithSteam from './components/LoginWithSteam.vue'

export default defineComponent({
	name: 'App',
	components: {
		HelloWorld,
        LoadingBar,
        LoginWithSteam
	},
});
</script>

<style></style>
