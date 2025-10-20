<template>
    <Layout>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            <ImageCard v-for="image in publicImages" :key="image.id" :image="image"/>
        </div>

        <Pagination :links="fakePagination"/>
    </Layout>
</template>
<script setup>

    import Layout from '@/layouts/Layout.vue';
    import ImageCard from '@/pages/HomePartials/ImageCard.vue';
    import Pagination from '@/components/Pagination.vue';

    const publicImages = [
        {
            id: 1,
            name: 'sunset.png',
            size: 54321,
            url: 'https://via.placeholder.com/256',
            uploadedAt: '01/01/1970',
            author: 'John Doe'
        },
        {
            id: 2,
            name: 'mountains.jpg',
            size: 123456,
            url: 'https://via.placeholder.com/256',
            uploadedAt: '12/12/2022',
            author: 'Jane Smith'
        },
        {
            id: 3,
            name: 'sunset.png',
            size: 54321,
            url: 'https://via.placeholder.com/256',
            uploadedAt: '01/01/1970',
            author: 'John Doe'
        },
        {
            id: 4,
            name: 'mountains.jpg',
            size: 123456,
            url: 'https://via.placeholder.com/256',
            uploadedAt: '12/12/2022',
            author: 'Jane Smith'
        },
        {
            id: 5,
            name: 'sunset.png',
            size: 54321,
            url: 'https://via.placeholder.com/256',
            uploadedAt: '01/01/1970',
            author: 'John Doe'
        },
        {
            id: 6,
            name: 'mountains.jpg',
            size: 123456,
            url: 'https://via.placeholder.com/256',
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