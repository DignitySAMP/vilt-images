<template>
    <Layout tab="Albums" :title="usePage().props.showOwnedAlbums ? 'Your albums' : 'Albums' " description="Display a list of albums.">

        <div class="w-full h-fit flex justify-between items-center p-4 bg-stone-50 dark:bg-stone-800 border border-white dark:border-stone-700 rounded-md">
            <span class="w-fit text-lg text-indigo-500 dark:text-indigo-400 font-bold">
                {{ usePage().props.showOwnedAlbums ? 'Your albums' : 'All albums' }}
            </span>
            <div class="flex gap-2">
                <InputButton
                    colors="bg-slate-500 hover:bg-slate-600 text-white"
                    :icon="IconFilter"
                    @click="showFilterBar = !showFilterBar"
                    type="button"
                >
                    {{ showFilterBar ? 'Hide' : 'Show' }} filter
                </InputButton>

                <InputLink
                    v-if="usePage().props.auth?.user !== null && usePage().props.showOwnedAlbums"
                    :href="route('album.index')"
                    :icon="IconPhoto"
                    colors="bg-amber-500 hover:bg-amber-600 text-white"
                >
                    <span class="hidden md:inline-block">
                        View all albums
                    </span>
                </InputLink>
                <InputLink
                    v-if="usePage().props.auth?.user !== null"
                    :href="route('album.create')"
                    :icon="IconPlus"
                    colors="bg-indigo-500 hover:bg-indigo-600 text-white"
                >
                    <span class="hidden md:inline-block">
                        Create new album
                    </span>
                </InputLink>
            </div>
        </div>

        <SearchBar 
            v-if="showFilterBar"
            :filters="usePage().props.filters || {}"
        />

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            <AlbumCard v-for="album in usePage().props.albums.data" :key="album.id" :album="album"/>
        </div>

        <Pagination :links="usePage().props.albums"/>
    </Layout>
</template>
<script setup lang="js">
    import { ref } from 'vue';
    import { usePage } from '@inertiajs/vue3';
    
    import Layout from '@/layouts/Layout.vue';
    
    import AlbumCard from '@/pages/Album/Index/Partials/AlbumCard.vue';
    import SearchBar from '@/pages/Album/Index/Partials/SearchBar.vue';

    import InputButton from '@/components/form/InputButton.vue';
    import InputLink from '@/components/form/InputLink.vue';
    import Pagination from '@/components/Pagination.vue';
    
    import IconPlus from '@/icons/IconPlus.vue';
    import IconPhoto from '@/icons/IconPhoto.vue';
    import IconFilter from '@/icons/IconFilter.vue';

    const showFilterBar = ref(false);
</script>

