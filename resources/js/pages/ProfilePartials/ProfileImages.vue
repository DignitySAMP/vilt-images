<template>
    <div class="text-indigo-700 dark:text-indigo-400">
        <div ref="headerBar" class="w-full h-fit flex justify-between items-center p-4 bg-stone-50 dark:bg-stone-800 border border-white dark:border-stone-700 rounded-md">
            <span class="w-fit text-lg text-indigo-500 dark:text-indigo-400 font-bold">
                Manage your images
            </span>
            <div class="flex gap-2">
                <InputButton
                    colors="bg-slate-500 hover:bg-slate-600 text-white"
                    :icon="IconFilter"
                    @click="showFilterBar = !showFilterBar"
                    type="button"
                >
                    <span class="hidden md:inline-block">
                        {{ showFilterBar ? 'Hide' : 'Show' }} filter
                    </span>
                </InputButton>

                <InputLink
                    :href="route('album.index', { owned_albums: 1 })"
                    :icon="IconPhoto"
                    colors="bg-indigo-500 hover:bg-indigo-600 text-white"
                >
                    <span class="hidden md:inline-block">
                        View your albums
                    </span>
                </InputLink>
            </div>
        </div>

        <ImagesSearchBar 
            v-if="showFilterBar"
            :filters="usePage().props.filters || {}"
        />

        <div ref="imageContainer" class="flex flex-col gap-4 mt-4">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <Link 
                    v-for="image in usePage().props.images.data"
                    as="div"
                    class="cursor-pointer h-fit flex flex-col justify-center items-center gap-2 p-4 bg-stone-50 dark:bg-stone-800 border border-white dark:border-stone-700 rounded-md"     
                    :href="route('image.show', image)"
                >
                    <span class="w-full text-center truncate dark:text-stone-200">
                        {{ image.name }}
                    </span>
                    <div class="flex">
                        <AppImage
                            :url="image.thumbnail_url"
                            :alt="image.file_name"
                            class="size-full md:size-48 2xl:size-60"
                        />
                    </div>

                    <div 
                        :class="image.album === null ? 'bg-red-50 dark:bg-red-950/30 border-red-200 dark:border-red-900/50 text-red-700 dark:text-red-400' : 'bg-sky-50 dark:bg-sky-950/30 border-sky-200 dark:border-sky-900/50 text-sky-700 dark:text-sky-400'"
                        class="flex gap-1 items-center w-full border justify-between px-2 py-0.5 rounded"
                    >
                        <IconPhoto/>
                        <span class="text-sm truncate">{{ ( image.album === null) ? 'No album' : image.album.name }}</span>
                    </div>
                </Link>
            </div>
        </div>

        <Pagination :links="usePage().props.images" class="mt-4"/>
 
    </div>
</template>
<script setup lang="js">
    import { ref } from 'vue';
    import { usePage, Link } from '@inertiajs/vue3';

    import Pagination from '@/components/Pagination.vue'
    import AppImage from '@/components/AppImage.vue'
    import ImagesSearchBar from '@/pages/ProfilePartials/ImagesSearchBar.vue'
    import InputButton from '@/components/form/InputButton.vue'
    import InputLink from '@/components/form/InputLink.vue';

    import IconPhoto from '@/icons/IconPhoto.vue'
    import IconFilter from '@/icons/IconFilter.vue'

    const showFilterBar = ref(false);
</script>