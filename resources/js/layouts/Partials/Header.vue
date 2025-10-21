<template>
    <div class="flex py-1 justify-between items-center bg-white rounded">
        <AppLogo/>

        <div class="hidden md:flex px-4 items-center gap-2">
            <span v-for="items in navItems">
                <Link 
                    v-if="items.auth === null || (items.auth !== true && usePage().props.auth.user === null) || (items.auth === true && usePage().props.auth.user !== null)"
                    :method="items.method !== null ? items.method : 'GET'" 
                    :href="items.url" 
                    class="flex gap-4 px-3 py-1 rounded cursor-pointer transition duration-300"
                    :class="props.active_tab === items.label ? items.active_style : items.style"
                >
                    <component :is="items.icon"/>
                    {{ items.label }}
                </Link>
            </span>
        </div>
        <div class="relative flex justify-end md:hidden px-4 text-indigo-500 w-full">

            <IconHeaderBreadcrumbs class="w-10 h-10" @click="showMobileHeader = !showMobileHeader"/>
            <div v-if="showMobileHeader"  class="absolute bg-white border border-stone-200 shadow-lg min-w-48 rounded p-2 right-1 top-8 z-50 flex flex-col">
                <span v-for="items in navItems">
                    <Link 
                        v-if="items.auth === null || (items.auth !== true && usePage().props.auth.user === null) || (items.auth === true && usePage().props.auth.user !== null)"
                        :method="items.method !== null ? items.method : 'GET'" 
                        :href="items.url" 
                        class="flex justify-between px-3 py-1 rounded cursor-pointer transition duration-300"
                        :class="props.active_tab === items.label ? items.active_style : items.style"
                    >
                        <component :is="items.icon"/>
                        {{ items.label }}
                    </Link>
                </span>
            </div>
        </div>
    </div>
</template>
<script setup>
    import { Link, usePage } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import AppLogo from '@/components/AppLogo.vue';

    import IconHeaderBreadcrumbs from '@/icons/IconHeaderBreadcrumbs.vue';
    const showMobileHeader = ref(false);

    import IconLogout from '@/icons/IconLogout.vue';
    import IconPublic from '@/icons/IconPublic.vue';
    import IconUpload from '@/icons/IconUpload.vue';
    import IconYourFiles from '@/icons/IconYourFiles.vue';
    import IconLogin from '@/icons/IconLogin.vue';
    import IconPhoto from '@/icons/IconPhoto.vue';

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
            url: route('image.create'),
            style: 'text-indigo-800 hover:bg-green-100 hover:text-green-800',
            active_style: 'bg-green-500 text-white hover:bg-green-600',
            auth: null
        },
        {
            label: 'Public',
            icon: IconPublic,
            url: route('home'),
            style: 'text-indigo-800 hover:bg-indigo-50',
            active_style: 'bg-indigo-500 text-white hover:bg-indigo-600',
            auth: null
        },
        {
            label: 'Albums',
            icon: IconPhoto,
            url: route('album.index'),
            style: 'text-indigo-800 hover:bg-indigo-50',
            active_style: 'bg-indigo-500 text-white hover:bg-indigo-600',
            auth: null
        },
        {
            label: 'Profile',
            icon: IconYourFiles,
            url: route('profile'),
            style: 'text-indigo-800 hover:bg-indigo-50',
            active_style: 'bg-indigo-500 text-white hover:bg-indigo-600',
            auth: true
        },
        {
            label: 'Logout',
            icon: IconLogout,
            url: route('logout'),
            method: 'POST',
            style: 'text-indigo-800 hover:bg-red-100 hover:text-red-800',
            auth: true
        },
        {
            label: 'Login',
            icon: IconLogin,
            url: route('login'),
            style: 'text-sky-800 hover:bg-sky-100 hover:text-sky-800',
            active_style: 'bg-indigo-500 text-white hover:bg-indigo-600',
            auth: false
        },
    ]
</script>