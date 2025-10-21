<template>
    <Layout tab="Albums">

        <div class="bg-white w-full h-full px-4 py-2 grid grid-cols-[auto_auto_auto] items-center">

            <div class="flex gap-2 h-fit w-full">
                <div class="w-fit flex gap-2 text-center items-center p-1 text-sm rounded text-sky-700 bg-sky-50 border border-sky-200">
                    <IconOwner class="w-4 h-4"/>
                    <span>{{ usePage().props.album.user?.name ?? 'Unknown' }}</span>
                </div>

                <div class="w-fi flex gap-2 text-center items-center p-1 text-sm rounded text-amber-700 bg-amber-50 border border-amber-200">
                    <IconDate class="w-4 h-4"/>
                    <span>{{ new Date(usePage().props.album.created_at).toLocaleString() }}</span>
                </div>
            </div>

            <div class="flex flex-col w-full justify-self-start">
                <span class="text-2xl text-indigo-700 font-bold text-center"> {{ usePage().props.album.name }} </span>
                <span class="text-indigo-600 text-center"> {{ usePage().props.album.description }} </span>
            </div>

            <div v-if="canEdit" class="flex gap-2 h-fit justify-self-end">
                <Link 
                    :href="route('album.edit', usePage().props.album.id)"
                    class="flex items-center gap-2 bg-slate-500 text-white text-sm px-4 py-2 rounded-md hover:bg-slate-600 transition duration-200 cursor-pointer"
                >
                    <IconEdit/>
                    <span class="hidden md:inline-block">Edit</span>
                </Link>
            </div>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            <ImageCard v-for="image in usePage().props.images.data" :key="image.id" :image="image"/>
        </div>

        <Pagination :links="usePage().props.images"/>
    </Layout>
</template>
<script setup lang="js">
    import { computed } from 'vue';
    import { usePage, Link } from '@inertiajs/vue3';

    import Layout from '@/layouts/Layout.vue';
    import ImageCard from '@/pages/Image/Index/Partials/ImageCard.vue';
    import Pagination from '@/components/Pagination.vue';

    import IconOwner from '@/icons/IconOwner.vue';
    import IconDate from '@/icons/IconDate.vue';
    import IconEdit from '@/icons/IconEdit.vue';

    const canEdit = computed(() => {
        const user = usePage().props.auth.user;
        const album = usePage().props.album;
        return user && user.id === album.user_id;
    });

</script>

