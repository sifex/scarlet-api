<template>
    <span
        class="inline-block uppercase text-xs font-bold rounded py-0.5 px-1.5 text-white"
        :class="TypeColors[type]">
        {{ type }}
    </span>
</template>

<script setup lang="ts">
import {defineProps, PropType} from "vue";
import {MemberType} from "@/scripts/aaf/membertypes";

defineProps<{
    type: MemberType
}>()

const TypeColors: Record<MemberType, string> = {
    [MemberType.staff]: 'bg-blue-500',
    [MemberType.leader]: 'bg-orange-500',
    [MemberType.recruit]: 'bg-red-500',
    [MemberType.applicant]: 'bg-amber-500',
    [MemberType.special]: 'bg-teal-600',
    [MemberType.veteran]: 'bg-violet-500',
    [MemberType.member]: 'bg-slate-600',
}

</script>

<style scoped>

</style>
