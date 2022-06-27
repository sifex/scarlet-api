<template>
  <a :href="$route('login')"
     class="block text-center w-full px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700 transition-colors">
      <SteamLogo fill="#FFFFFF" class="inline-block h-6 mr-5 -mt-1"></SteamLogo>Login with Steam

  </a>
</template>

<script lang="ts" setup>
import {inject} from "vue";
import SteamLogo from '@/images/steam_logo.svg'

let $route = inject('$route')
</script>
