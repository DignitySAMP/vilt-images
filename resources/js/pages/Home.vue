<template>
    <Layout>
            <div class="bg-stone-100 min-h-256 p-5">
                Home content goes here
            </div>

            <Pagination :links="fakePagination"/>
    </Layout>
</template>
<script setup>

    import Pagination from '@/components/Pagination.vue';
    import Layout from '@/layouts/Layout.vue';


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