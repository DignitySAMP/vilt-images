<template>
    <div class="flex py-1 justify-between items-center bg-white dark:bg-stone-800 rounded">
        <AppLogo/>

        <div class="hidden lg:flex px-4 items-center gap-2">
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
            <span
                @click="toggleDarkMode"
                class="flex gap-4 px-3 py-1 rounded cursor-pointer transition duration-300 text-indigo-800 dark:text-amber-500 hover:bg-indigo-50 dark:hover:bg-stone-700"
                aria-label="Toggle dark mode"
            >
                <IconMoon v-if="!isDark" class="w-6 h-6" />
                <IconSun v-else class="w-6 h-6" />
            </span>
        </div>
        <div class="relative flex justify-end lg:hidden px-4 text-indigo-500 dark:text-stone-300 w-full">

            <IconHeaderBreadcrumbs class="w-10 h-10 dark:text-indigo-500" @click="showMobileHeader = !showMobileHeader"/>
            <div v-if="showMobileHeader"  class="absolute bg-white dark:bg-stone-800 border border-stone-200 dark:border-stone-700 shadow-lg min-w-48 rounded p-2 right-1 top-8 z-50 flex flex-col">
                <span v-for="items in navItems">
                    <Link 
                        v-if="items.auth === null || (items.auth !== true && usePage().props.auth.user === null) || (items.auth === true && usePage().props.auth.user !== null)"
                        :method="items.method !== null ? items.method : 'GET'" 
                        :href="items.url" 
                        class="flex w-full justify-between px-3 py-1 rounded cursor-pointer transition duration-300"
                        :class="props.active_tab === items.label ? items.active_style : items.style"
                    >
                        <component :is="items.icon"/>
                        <span>
                            {{ items.label }}
                        </span>
                    </Link>
                </span>
                <span
                    @click="toggleDarkMode"
                    class="flex justify-between px-3 py-1 rounded cursor-pointer transition duration-300 text-indigo-800  dark:text-amber-500 hover:bg-indigo-50 dark:hover:bg-stone-700"
                    aria-label="Toggle dark mode"
                >
                    <IconMoon v-if="!isDark" class="w-6 h-6" />
                    <IconSun v-else class="w-6 h-6" />
                    <span>{{ isDark ? 'Light' : 'Dark' }}</span>
                </span>
            </div>
        </div>
    </div>
</template>
<script setup>
    import { ref } from 'vue';
    import { Link, usePage } from '@inertiajs/vue3';

    import AppLogo from '@/components/AppLogo.vue';
    import IconHeaderBreadcrumbs from '@/icons/IconHeaderBreadcrumbs.vue';

    import { useDarkMode } from '@/composables/useDarkMode.js';
    import IconMoon from '@/icons/IconMoon.vue';
    import IconSun from '@/icons/IconSun.vue';
    const showMobileHeader = ref(false);
    const { isDark, toggleDarkMode } = useDarkMode();

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
            style: 'text-indigo-800 dark:text-indigo-500 hover:bg-green-100 dark:hover:bg-emerald-300  hover:text-green-800 dark:hover:text-emerald-700',
            active_style: 'bg-green-500 text-white hover:bg-green-600',
            auth: true
        },
        {
            label: 'Public',
            icon: IconPublic,
            url: route('home'),
            style: 'text-indigo-800 dark:text-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-300 dark:hover:text-indigo-700',
            active_style: 'bg-indigo-500 text-white hover:bg-indigo-600',
            auth: null
        },
        {
            label: 'Albums',
            icon: IconPhoto,
            url: route('album.index'),
            style: 'text-indigo-800 dark:text-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-300 dark:hover:text-indigo-700',
            active_style: 'bg-indigo-500 text-white hover:bg-indigo-600',
            auth: null
        },
        {
            label: 'Profile',
            icon: IconYourFiles,
            url: route('profile'),
            style: 'text-indigo-800 dark:text-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-300 dark:hover:text-indigo-700',
            active_style: 'bg-indigo-500 text-white hover:bg-indigo-600',
            auth: true
        },
        {
            label: 'Logout',
            icon: IconLogout,
            url: route('logout'),
            method: 'POST',
            style: 'text-indigo-800 dark:text-indigo-500 hover:bg-red-100 hover:text-red-800 dark:hover:bg-red-300 dark:hover:text-red-700',
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