<template>
    <div class="text-indigo-700">
        <div class="w-full h-fit flex justify-between items-center p-4 bg-stone-50 border border-white rounded-md">
            <span class="w-fit text-lg text-indigo-500 font-bold">
                Manage your images
            </span>
            <div class="flex gap-2">
                <button class="w-fit flex items-center gap-6 bg-indigo-500 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-600 transition duration-200 cursor-pointer">
                    <IconPhoto/>
                    <span>
                        View your albums
                    </span>
                </button>

                <button class="w-fit flex items-center gap-6 bg-blue-500 text-white text-sm px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200 cursor-pointer" @click="showFilterBar = !showFilterBar">
                    <IconFilter/>
                    <span>
                        {{ showFilterBar ? 'Hide' : 'Show' }} filter
                    </span>
                </button>
            </div>
        </div>

        <div v-if="showFilterBar" class="w-full h-fit flex items-center justify-between p-4 bg-stone-50 border border-white rounded-md mt-4">
            <div class="flex w-full gap-2">
                <select 
                    id="searchSort" name="searchSort"
                    class="bg-slate-50 text-sm rounded-md w-fit border border-slate-300 text-slate-700 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    <option>Sort by latest photos (public)</option>
                    <option>Sort by oldest photos (public)</option>
                    <option>Sort by largest file size</option>
                    <option>Sort by lmallest file size</option>
                </select>

                <div class="flex w-full items-center">
                    <select 
                        id="searchType" name="searchType"
                        class="bg-indigo-50 text-sm border rounded-l-md border-indigo-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                        <option value="album">Album</option>
                        <option value="name">Name</option>
                        <option value="title">Title</option>
                        <option value="size">File size</option>
                    </select>
                    <div class="flex border-l-0 w-full border-indigo-200 rounded-r-md border items-center bg-stone-50 pr-2">
                        <input
                            id="searchQuery" 
                            name="searchQuery" 
                            type="text" 
                            placeholder="Enter search term..."
                            class="mr-2 w-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />

                        <IconSearch />
                    </div>
                </div>

                <button
                    class="min-w-48 justify-between flex items-center bg-green-600 text-white text-sm px-4 py-2 rounded-md hover:bg-green-500 transition duration-200 cursor-pointer"
                >
                    <IconUpload/>
                    <span>
                        Upload New Image
                    </span>
                </button>
            </div>

        </div>

        <div class="flex flex-col gap-4 mt-4">

            <div class="grid grid-cols-4 gap-4">
                <div class="h-fit flex flex-col justify-center items-center gap-4 p-4 bg-stone-50 border border-white rounded-md" v-for="image in images">

                    <span>{{ image.name }}</span>
                    <div class="flex">
                        <span class="bg-indigo-100 h-64 w-64 text-indigo-700 border border-indigo-200 rounded-md flex items-center justify-center">
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