<template>
    <Link 
        :href="props.href"
        :method="props.method"
        :as="props.as"
        class="flex justify-between items-center h-fit w-full lg:w-fit gap-6 text-sm px-4 py-2 rounded-md transition duration-200 cursor-pointer"
        :class="props.colors"
    >
        <component :is="props.icon" v-if="props.icon"/>
        <span>
            <slot/>
        </span>
    </Link>
</template>
<script setup lang="js">

    import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        href: {
            type: String,
            required: true
        },
        method: {
            type: String,
            required: false,
            default: 'get'
        },
        as: {
            type: String,
            required: false,
            default: 'a'
        },
        icon: {
            type: Object,
            required: false,
            default: null
        },
        colors: {
            required: false,
            default: 'bg-indigo-500 hover:bg-indigo-600 text-white'
        }
    });
</script>

