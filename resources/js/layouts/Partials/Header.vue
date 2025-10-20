<template>
    <div class="flex py-1 justify-between bg-white rounded">
        <span class="px-4 text-lg text-transparent bg-clip-text font-extrabold bg-gradient-to-br from-indigo-700 to-indigo-500 p-2">
            {{ usePage().props.app.name }}
        </span>

        <div class="px-4 flex items-center gap-2">

            <span v-for="items in navItems" class="flex gap-4 px-3 py-1 rounded cursor-pointer transition duration-300" :class="props.active_tab === items.label ? items.active_style : items.style">
                <component :is="items.icon"/>
                {{ items.label }}
            </span>
        </div>
    </div>
</template>
<script setup>
    import { usePage } from '@inertiajs/vue3';

    import IconLogout from '@/icons/IconLogout.vue';
    import IconPublic from '@/icons/IconPublic.vue';
    import IconUpload from '@/icons/IconUpload.vue';
    import IconYourFiles from '@/icons/IconYourFiles.vue';

    const props = defineProps({
        active_tab: {
            type: String,
            required: true
        }
    });

    const navItems = [
        {
            label: 'Upload',
            icon: IconUpload,
            style: 'text-indigo-800 hover:bg-green-100 hover:text-green-800',
        },
        {
            label: 'Public',
            icon: IconPublic,
            style: 'text-indigo-800 hover:bg-indigo-50',
            active_style: 'bg-indigo-500 text-white hover:bg-indigo-600',
        },
        {
            label: 'Profile',
            icon: IconYourFiles,
            style: 'text-indigo-800 hover:bg-indigo-50',
            active_style: 'bg-indigo-500 text-white hover:bg-indigo-600',
        },
        {
            label: 'Logout',
            icon: IconLogout,
            style: 'text-indigo-800 hover:bg-red-100 hover:text-red-800'
        },
    ]
</script>