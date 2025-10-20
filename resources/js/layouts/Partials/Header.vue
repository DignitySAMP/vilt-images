<template>
    <div class="flex py-1 justify-between bg-white rounded">
        <span class="px-4 text-lg text-transparent bg-clip-text font-extrabold bg-gradient-to-br from-indigo-700 to-indigo-500 p-2">
            {{ usePage().props.app.name }}
        </span>

        <div class="px-4 flex items-center gap-2">

            <span class="flex gap-4 px-3 py-1 rounded text-indigo-800 hover:bg-green-100 hover:text-green-800 cursor-pointer transition duration-300">
                <IconUpload/>
                Upload
            </span>

            <span class="flex gap-4 bg-indigo-500 px-3 py-1 rounded text-white font-semibold hover:bg-indigo-600 cursor-pointer  transition duration-300">
                <IconPublic/>
                Public
            </span>

            <span class="flex gap-4 px-3 py-1 rounded text-indigo-800 hover:bg-indigo-50 cursor-pointer transition duration-300">
                <IconYourFiles/>
                Profile 
            </span>

            <span class="flex gap-4 px-3 py-1 rounded text-indigo-800 hover:bg-red-100 hover:text-red-800 cursor-pointer transition duration-300">
                <IconLogout/>
                Logout
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
</script>