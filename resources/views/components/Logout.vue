<template>
    <a :href="$route('logout')" class="inline-block float-right text-center px-4 py-1 border border-transparent text-sm font-medium rounded-md text-red-600 bg-red-100 border-2 border-red-400 hover:bg-red-500 hover:text-white transition-colors">
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
