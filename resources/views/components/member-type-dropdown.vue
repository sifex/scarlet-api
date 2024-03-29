<template>
    <Listbox :model-value="modelValue" @update:modelValue="update_model_value($event)">
        <div class="relative mt-1 z-10">
            <ListboxButton
                class="text-left mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <span class="block truncate">{{ membership_types[modelValue] }}</span>
                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                    <ArrowsUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                </span>
            </ListboxButton>

            <transition
                leave-active-class="transition duration-100 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <ListboxOptions
                    class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                >
                    <ListboxOption
                        v-slot="{ active, selected }"
                        v-for="(title, type) in membership_types"
                        :key="type"
                        :value="type"
                        as="template"
                    >
                        <li
                            :class="[
                  active ? 'bg-indigo-100 text-indigo-900' : 'text-gray-900',
                  'relative cursor-default select-none py-2 pl-10 pr-4',
                ]"
                        >
                <span
                    :class="[
                    selected ? 'font-medium' : 'font-normal',
                    'block truncate',
                  ]"
                >{{ title }}</span
                >
                            <span
                                v-if="selected"
                                class="absolute inset-y-0 left-0 flex items-center pl-3 text-indigo-600"
                            >
                  <CheckIcon class="h-5 w-5" aria-hidden="true"/>
                </span>
                        </li>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>

<script setup lang="ts">
import {ref} from 'vue'
import {
    Listbox,
    ListboxLabel,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
} from '@headlessui/vue'
import {CheckIcon, ArrowsUpDownIcon} from '@heroicons/vue/24/solid'
import {MemberType} from "@/scripts/aaf/membertypes";

const membership_types = MemberType

const props = defineProps<{
    modelValue: MemberType
}>()
const emit = defineEmits<{
    (e: 'update:modelValue', modelValue: MemberType): void
}>()

function update_model_value(type: MemberType) {
    emit('update:modelValue', type)
}

</script>
