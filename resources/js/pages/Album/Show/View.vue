<template>
    <Layout tab="Albums" title="Album" description="View an existing album.">

        <div 
            class="bg-white dark:bg-stone-800 w-full h-full px-4 py-2 flex gap-2"    
        >
            <span class="text-2xl text-indigo-700 dark:text-indigo-400">Viewing album:</span>
            <span class="text-2xl text-indigo-700 dark:text-indigo-400 font-bold"> 
                {{ usePage().props.album.name }} 
            </span>
        </div>
        <div class="grid grid-cols-[1fr_auto]">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <ImageCard v-for="image in usePage().props.images.data" :key="image.id" :image="image"/>
            </div>
            <div 
                class="bg-white dark:bg-stone-800 w-full h-full px-4 py-2 flex flex-col gap-4"    
            >

                <div class="flex flex-col w-full justify-self-start">
                    <span class="text-2xl text-indigo-700 dark:text-indigo-400 font-bold text-center"> {{ usePage().props.album.name }} </span>
                    <span class="text-indigo-600 dark:text-indigo-300 text-center"> {{ usePage().props.album.description }} </span>
                </div>

                <div class="flex flex-col gap-2 h-fit w-full">
                    <div class="w-full flex gap-2 text-center items-center p-1 text-sm rounded text-sky-700 dark:text-sky-400 bg-sky-50 dark:bg-sky-950/30 border border-sky-200 dark:border-sky-900/50">
                        <IconOwner class="w-4 h-4"/>
                        <span>{{ usePage().props.album.user?.name ?? 'Unknown' }}</span>
                    </div>

                    <div class="w-full flex gap-2 text-center items-center p-1 text-sm rounded text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-900/50">
                        <IconDate class="w-4 h-4"/>
                        <span>{{ new Date(usePage().props.album.created_at).toLocaleString() }}</span>
                    </div>
                </div>

                <div class="flex justify-center items-center" v-if="canEdit">
                    <InputLink
                        :href="route('album.edit', usePage().props.album.id)"
                        :icon="IconEdit"
                        colors="bg-slate-500 hover:bg-slate-600 text-white lg:w-full"
                    >
                        <span class="w-full text-center">Edit Album</span>
                    </InputLink>
                </div>
            </div>

        </div>
        <Pagination :links="usePage().props.images"/>
    </Layout>
</template>
<script setup lang="js">
    import { computed } from 'vue';
    import { usePage } from '@inertiajs/vue3';

    import Layout from '@/layouts/Layout.vue';

    import ImageCard from '@/pages/Image/Index/Partials/ImageCard.vue';

    import Pagination from '@/components/Pagination.vue';
    import InputLink from '@/components/form/InputLink.vue';

    import IconOwner from '@/icons/IconOwner.vue';
    import IconDate from '@/icons/IconDate.vue';
    import IconEdit from '@/icons/IconEdit.vue';

    const canEdit = computed(() => {
        const user = usePage().props.auth.user;
        const album = usePage().props.album;
        return user && user.id === album.user_id;
    });

</script>

