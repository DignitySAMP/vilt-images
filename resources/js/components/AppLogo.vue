<template>
    <Link :href="route('home')" class="gap-2 flex items-center bg-clip-text font-extrabold bg-linear-to-br from-indigo-700 to-indigo-500 dark:from-indigo-400 dark:to-indigo-300 text-indigo-600 dark:text-indigo-400 p-2 hover:scale-105 transition duration-300">
        <span class="w-8 h-8">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h8v2H5v14h14v-7h2v7q0 .825-.587 1.413T19 21zm1-4h12l-3.75-5l-3 4L9 13zm12-7V5.825L16.4 7.4L15 6l4-4l4 4l-1.4 1.4L20 5.825V10z"/></svg>
        </span>
        <span class="text-transparent text-lg">
        
            {{ usePage().props.app.name }}
        </span>
    </Link>
</template>
<script setup lang="js">
    import { Link, usePage } from '@inertiajs/vue3';
</script>