<template>

    <Layout tab="Profile" title="Your Account" description="Access your images or modify your account details.">
        <div class="grid grid-cols-1 xl:grid-cols-[1fr_auto] gap-4">
            <ProfileImages/>
            <UpdateProfile/>
        </div> 
    </Layout>
</template>
<script setup lang="js">
    import Layout from '@/layouts/Layout.vue';
    import UpdateProfile from '@/pages/ProfilePartials/UpdateProfile.vue';
    import ProfileImages from '@/pages/ProfilePartials/ProfileImages.vue';
</script>