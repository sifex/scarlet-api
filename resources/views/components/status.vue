<template>
	<span class="block text-slate-500 text-xs text-right mb-1 text-middle text-white">
		{{ title }}
		<span v-if="players" class="text-slate-600">(Players : <i>{{ players }}</i>)</span>
		<span class="h-2.5 w-2.5 inline-block rounded-full ml-3 transition-all duration-1000" :class="color_class"></span>
	</span>
</template>

<script>
export default {
    name: 'status',
    props: ['title', 'players', 'color'],
    computed: {
        color_class() {
            return this.color ? 'bg-green-400' : 'bg-orange-400'
        }
    }
};
</script>
