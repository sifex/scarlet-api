<template>
  <button @click="loginToSteam"
     class="relative block text-center w-full px-4 py-3 font-medium rounded-md text-white bg-gradient-to-r from-[#3f86b4] to-[#0f1c40] transition-colors group overflow-hidden">
      <span id="hover" class="z-0 absolute top-0 left-0 right-0 bottom-0 group-hover:bg-black/30 transition-all"></span>
      <span class="z-10 relative">
      <SteamLogo fill="#ffffff" class="inline-block h-6 mr-5 -mt-1"></SteamLogo>Login with Steam
          </span>
  </button>
</template>

<script lang="ts" setup>
import {inject} from "vue";
import SteamLogo from '@/images/steam_logo.svg'

let $route: any = inject('$route')

let loginToSteam = () => {
    if(typeof window.scarlet !== 'undefined') {
        window.scarlet.steam_login()
    } else {
        location.href = $route('login')
    }

}


</script>
