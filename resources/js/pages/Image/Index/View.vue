<template>
    <Layout tab="Public">

        <div class="w-full h-fit flex justify-between items-center p-4 bg-stone-50 dark:bg-stone-800 border border-white dark:border-stone-700 rounded-md">
            <span class="w-fit text-lg text-indigo-500 dark:text-indigo-400 font-bold">
                Public images
            </span>
            <div class="flex gap-2">
                <button class="w-fit flex items-center gap-6 bg-slate-500 text-white text-sm px-4 py-2 rounded-md hover:bg-slate-600 transition duration-200 cursor-pointer" @click="showFilterBar = !showFilterBar">
                    <IconFilter/>
                    <span class="hidden md:inline-block">
                        {{ showFilterBar ? 'Hide' : 'Show' }} filter
                    </span>
                </button>

                <Link 
                    :href="route('album.index')"
                    class="w-fit flex items-center gap-6 bg-indigo-500 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-600 transition duration-200 cursor-pointer"
                >
                    <IconPhoto/>
                    <span class="hidden md:inline-block">
                        View public albums
                    </span>
                </Link>
            </div>
        </div>
        <SearchBar 
            v-if="showFilterBar"
            :filters="usePage().props.filters || {}"
        />

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            <ImageCard v-for="image in usePage().props.images.data" :key="image.id" :image="image"/>
        </div>

        <Pagination :links="usePage().props.images"/>
    </Layout>
</template>
<script setup lang="js">
    import { ref } from 'vue';
    import { usePage, Link } from '@inertiajs/vue3';
    
    import Layout from '@/layouts/Layout.vue';
    import SearchBar from '@/pages/Image/Index/Partials/SearchBar.vue';
    import ImageCard from '@/pages/Image/Index/Partials/ImageCard.vue';
    import Pagination from '@/components/Pagination.vue';

    import IconFilter from '@/icons/IconFilter.vue'
    import IconPhoto from '@/icons/IconPhoto.vue'

    const showFilterBar = ref(false);
</script>