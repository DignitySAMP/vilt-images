<template>
    <Layout tab="Public">

        <div class="bg-white w-full h-full p-6 flex flex-col justify-center items-center gap-2">
            
            <span class="w-full flex justify-center text-lg text-indigo-700 font-bold">
                {{ usePage().props.image.description }}
            </span>

            <AppImage 
                :url="usePage().props.image.url"
                :alt="usePage().props.image.file_name"
                class="w-full min-h-128"
            />
            

            <div class="flex w-full gap-2 flex-wrap md:flex-nowrap md:gap-4">

                <div class="flex flex-col gap-2 w-full">
                    <div class="min-w-32 w-full flex justify-between px-2 py-1 rounded text-sky-700 bg-sky-50 border border-sky-200">
                        <IconOwner/>
                        {{ usePage().props.image.publisher.name ?? 'Unknown' }}
                    </div>

                    <div class="min-w-32 w-full flex justify-between px-2 py-1 rounded text-emerald-700  bg-emerald-50 border border-emerald-200">
                        <IconYourFiles/>
                        {{'No album' }}
                    </div>
                </div>

                <div class="flex flex-col gap-2 w-full">
                    <div class="min-w-32 w-full flex justify-between px-2 py-1 rounded text-amber-700 bg-amber-50 border border-amber-200">
                        <IconDate/>
                        {{ new Date(usePage().props.image.created_at).toLocaleString() ?? 'Unknown' }}
                    </div>
                    <div class="min-w-32 w-full flex justify-between px-2 py-1 rounded text-rose-700 bg-rose-50 border border-rose-200">
                        <IconFilesize/>
                        {{ usePage().props.image.file_size || 'Onbekend'}} kb
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-2 rounded">
            <span class="w-full text-lg text-indigo-700 font-bold px-4">
                Related images
            </span>
        </div>

        <div class="grid grid-cols-6 gap-4 h-full w-full">
            <Link 
                v-for="image in usePage().props.related_images"
                :href="route('image.show', image.id)"
                class="bg-white rounded p-4 flex flex-col gap-2 w-full h-full text-indigo-600"
            >
                <AppImage
                    :url="image.url"
                    :alt="image.file_name"
                    class="min-h-32"
                />
                <div class="bg-emerald-50 border border-emerald-300 text-emerald-700 py-1 rounded flex justify-between px-4">
                    <iconYourFiles class="w-6 h-6"/>
                    <span>{{ 'No album' }}</span>
                </div>
            </Link>
            
        </div>
    </Layout>
</template>
<script setup lang="js">
    import { usePage, Link } from '@inertiajs/vue3';

    import Layout from '@/layouts/Layout.vue'
    import AppImage from '@/components/AppImage.vue'

    import IconOwner from '@/icons/IconOwner.vue'
    import IconDate from '@/icons/IconDate.vue'
    import IconFilesize from '@/icons/IconFilesize.vue'
    import IconYourFiles from '@/icons/IconYourFiles.vue'


</script>