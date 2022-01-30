<template>
  <a :href="$route('login')"
     class="block text-center w-full px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700 transition-colors">
    <i class="text-2xl inline-block -my-[148px] pr-4 fa fa-steam" aria-hidden="true"></i> Login with Steam
  </a>
</template>

<script lang="ts" setup>
import {inject} from "vue";

let $route = inject('$route')
</script>
