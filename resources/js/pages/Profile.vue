<template>

    <Layout tab="Profile">
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_auto] gap-4">
            <Images/>
            <Details/>
        </div> 
    </Layout>
</template>
<script setup lang="js">
    import Layout from '@/layouts/Layout.vue';
    import Details from '@/pages/ProfilePartials/Details.vue';
    import Images from '@/pages/ProfilePartials/Images.vue';
</script>