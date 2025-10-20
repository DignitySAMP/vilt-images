<template>

    <Layout tab="Profile">

        <div class="grid grid-cols-[1fr_auto]">

            <div class="">
                <!-- album space -->
            </div>

            
            <AccountDetails/>
        </div> 
    </Layout>
</template>
<script setup lang="js">
    import Layout from '@/layouts/Layout.vue';
    import AccountDetails from '@/pages/ProfilePartials/AccountDetails.vue';
</script>