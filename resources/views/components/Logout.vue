<template>
    <a :href="route('logout')" class="inline-block float-right text-center px-2 py-1 border border-transparent text-base font-medium rounded-md text-white bg-red-500 hover:bg-red-400 transition-colors">
        Logout
    </a>
</template>

<script>
export default {
    name: "Logout",
    methods: {
        route
    }
}
</script>

<style scoped>

</style>
