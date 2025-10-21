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

                <button class="w-fit flex items-center gap-6 bg-indigo-500 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-600 transition duration-200 cursor-pointer">
                    <IconPhoto/>
                    <span class="hidden md:inline-block">
                        View your albums
                    </span>
                </button>
            </div>
        </div>

        <ImagesSearchBar v-if="showFilterBar"/>

        <div ref="imageContainer" class="flex flex-col gap-4 mt-4">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <div
                    v-for="image in images"
                    class="h-fit flex flex-col justify-center items-center gap-4 p-4 bg-stone-50 border border-white rounded-md"     
                >
                    <span>{{ image.name }}</span>
                    <div class="flex">
                        <span class="bg-indigo-100 size-96 md:size-48 2xl:size-52 text-indigo-700 border border-indigo-200 rounded-md flex items-center justify-center">
                            Placeholder
                        </span>
                    </div>

                    <div 
                        :class="image.album === null ? 'bg-red-50 border-red-200 text-red-700' : 'bg-sky-50 border-sky-200 text-sky-700'"
                        class="flex gap-1 items-center w-full border justify-between px-2 py-0.5 rounded"
                    >
                        <IconPhoto/>
                        <span>{{ image.album === null ? 'No album' : image.album }}</span>
                    </div>
                </div>
            </div>
        </div>

        <Pagination :links="fakePagination" class="mt-4"/>
 
    </div>
</template>
<script setup lang="js">
    import { ref } from 'vue';

    import Pagination from '@/components/Pagination.vue'

    import IconDate from '@/icons/IconDate.vue'
    import IconFilesize from '@/icons/IconFilesize.vue'
    import IconPhoto from '@/icons/IconPhoto.vue'
    import IconUpload from '@/icons/IconUpload.vue'
    import IconSearch from '@/icons/IconSearch.vue'
    import IconFilter from '@/icons/IconFilter.vue'
    import ImagesSearchBar from '@/pages/ProfilePartials/ImagesSearchBar.vue';

    const showFilterBar = ref(false);

    const images = [
    {
            id: 1,
            name: 'sunset.png',
            size: 54321,
            url: 'https://via.placeholder.com/256',
            uploadedAt: '01/01/1970',
            author: 'John Doe',
            album: 'John\'s Album'
        },
        {
            id: 3,
            name: 'sunset.png',
            size: 54321,
            url: 'https://via.placeholder.com/256',
            uploadedAt: '01/01/1970',
            author: 'John Doe',
            album: 'John\'s Album'
        },
        {
            id: 5,
            name: 'sunset.png',
            size: 54321,
            url: 'https://via.placeholder.com/256',
            uploadedAt: '01/01/1970',
            author: 'John Doe',
            album: null
        },
        {
            id: 1,
            name: 'sunset.png',
            size: 54321,
            url: 'https://via.placeholder.com/256',
            uploadedAt: '01/01/1970',
            author: 'John Doe',
            album: 'John\'s Album'
        },
        {
            id: 3,
            name: 'sunset.png',
            size: 54321,
            url: 'https://via.placeholder.com/256',
            uploadedAt: '01/01/1970',
            author: 'John Doe',
            album: null
        },
        {
            id: 5,
            name: 'sunset.png',
            size: 54321,
            url: 'https://via.placeholder.com/256',
            uploadedAt: '01/01/1970',
            author: 'John Doe',
            album: 'John\'s Album'
        }
    ];


    const fakePagination = {
        links: [
            { url: null, label: "&laquo; Previous", active: false }, // disabled previous
            { url: "/page/1", label: "1", active: false },
            { url: "/page/2", label: "2", active: true }, // active
            { url: "/page/3", label: "3", active: false },
            { url: "/page/4", label: "4", active: false },
            { url: "/page/3", label: "Next &raquo;", active: false },
        ],
    };
</script>