<template>
    <div class="text-indigo-700">
        <div ref="headerBar" class="w-full h-fit flex justify-between items-center p-4 bg-stone-50 border border-white rounded-md">
            <span class="w-fit text-lg text-indigo-500 font-bold">
                Manage your images
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
                        View your albums
                    </span>
                </Link>
            </div>
        </div>

        <ImagesSearchBar v-if="showFilterBar"/>

        <div ref="imageContainer" class="flex flex-col gap-4 mt-4">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <Link 
                    v-for="image in usePage().props.images.data"
                    as="div"
                    class="cursor-pointer h-fit flex flex-col justify-center items-center gap-2 p-4 bg-stone-50 border border-white rounded-md"     
                    :href="route('image.show', image)"
                >
                    <span class="w-full text-center truncate">
                        {{ image.description }}
                    </span>
                    <div class="flex">
                        <AppImage
                            :url="image.thumbnail_url"
                            :alt="image.file_name"
                            class="size-full md:size-48 2xl:size-60"
                        />
                    </div>

                    <div 
                        :class="image.album === null ? 'bg-red-50 border-red-200 text-red-700' : 'bg-sky-50 border-sky-200 text-sky-700'"
                        class="flex gap-1 items-center w-full border justify-between px-2 py-0.5 rounded"
                    >
                        <IconPhoto/>
                        <span>{{ (image.album === undefined || image.album === null) ? 'No album' : image.album }}</span>
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

    import IconPhoto from '@/icons/IconPhoto.vue'
    import IconFilter from '@/icons/IconFilter.vue'
    import ImagesSearchBar from '@/pages/ProfilePartials/ImagesSearchBar.vue';

    const showFilterBar = ref(false);
</script>