<template>
    <div class="flex py-1 justify-between bg-white rounded">
        <AppLogo/>

        <div class="px-4 flex items-center gap-2">

            <Link 
                v-for="items in navItems"  
                :method="items.method !== null ? items.method : 'GET'" 
                :href="items.url" 
                class="flex gap-4 px-3 py-1 rounded cursor-pointer transition duration-300"
                :class="props.active_tab === items.label ? items.active_style : items.style"
            >
                <component :is="items.icon"/>
                {{ items.label }}
            </Link>

        </div>
    </div>
</template>
<script setup>
    import { Link } from '@inertiajs/vue3';
    import AppLogo from '@/components/AppLogo.vue';
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
            url: route('upload'),
            style: 'text-indigo-800 hover:bg-green-100 hover:text-green-800',
        },
        {
            label: 'Public',
            icon: IconPublic,
            url: route('home'),
            style: 'text-indigo-800 hover:bg-indigo-50',
            active_style: 'bg-indigo-500 text-white hover:bg-indigo-600',
        },
        {
            label: 'Profile',
            icon: IconYourFiles,
            url: route('profile'),
            style: 'text-indigo-800 hover:bg-indigo-50',
            active_style: 'bg-indigo-500 text-white hover:bg-indigo-600',
        },
        {
            label: 'Logout',
            icon: IconLogout,
            url: route('logout'),
            method: 'POST',
            style: 'text-indigo-800 hover:bg-red-100 hover:text-red-800'
        },
    ]
</script>