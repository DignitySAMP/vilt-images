<template>
    <Layout tab="Public">

        <div class="w-full h-fit flex justify-between items-center p-4 bg-stone-50 border border-white rounded-md">
            <span class="w-fit text-lg text-indigo-500 font-bold">
                Public images
            </span>
            <div class="flex gap-2">
                <button class="w-fit flex items-center gap-6 bg-indigo-500 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-600 transition duration-200 cursor-pointer">
                    <IconPhoto/>
                    <span>
                        View public albums
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
        <SearchBar v-if="showFilterBar"/>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            <ImageCard v-for="image in publicImages" :key="image.id" :image="image"/>
        </div>

        <Pagination :links="fakePagination"/>
    </Layout>
</template>
<script setup lang="js">
    import { ref } from 'vue';
    import Layout from '@/layouts/Layout.vue';
    import SearchBar from '@/pages/HomePartials/SearchBar.vue';
    import ImageCard from '@/pages/HomePartials/ImageCard.vue';
    import Pagination from '@/components/Pagination.vue';

    import IconFilter from '@/icons/IconFilter.vue'
    import IconPhoto from '@/icons/IconPhoto.vue'

    const showFilterBar = ref(false);
    const publicImages = [
        {
            id: 1,
            name: 'sunset.png',
            size: 54321,
            uploadedAt: '01/01/1970',
            author: 'John Doe'
        },
        {
            id: 2,
            name: 'mountains.jpg',
            size: 123456,
            uploadedAt: '12/12/2022',
            author: 'Jane Smith'
        },
        {
            id: 3,
            name: 'sunset.png',
            size: 54321,
            uploadedAt: '01/01/1970',
            author: 'John Doe'
        },
        {
            id: 4,
            name: 'mountains.jpg',
            size: 123456,
            uploadedAt: '12/12/2022',
            author: 'Jane Smith'
        },
        {
            id: 5,
            name: 'sunset.png',
            size: 54321,
            uploadedAt: '01/01/1970',
            author: 'John Doe'
        },
        {
            id: 6,
            name: 'mountains.jpg',
            size: 123456,
            uploadedAt: '12/12/2022',
            author: 'Jane Smith'
        },
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