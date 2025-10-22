<template>
    <Layout tab="Albums">

        <div class="w-full h-fit flex justify-between items-center p-4 bg-stone-50 border border-white rounded-md">
            <span class="w-fit text-lg text-indigo-500 font-bold">
                All albums
            </span>
            <div class="flex gap-2">
                <Link 
                    v-if="usePage().props.auth?.user !== null"
                    :href="route('album.create')"
                    class="w-fit flex items-center gap-6 bg-indigo-500 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-600 transition duration-200 cursor-pointer"
                >
                    <IconPlus/>
                    <span class="hidden md:inline-block">
                        Create new album
                    </span>
                </Link>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            <AlbumCard v-for="album in usePage().props.albums.data" :key="album.id" :album="album"/>
        </div>

        <Pagination :links="usePage().props.albums"/>
    </Layout>
</template>
<script setup lang="js">
    import { usePage, Link } from '@inertiajs/vue3';
    
    import Layout from '@/layouts/Layout.vue';
    import AlbumCard from '@/pages/Album/Index/Partials/AlbumCard.vue';
    import Pagination from '@/components/Pagination.vue';

    import IconPlus from '@/icons/IconPlus.vue';
</script>

