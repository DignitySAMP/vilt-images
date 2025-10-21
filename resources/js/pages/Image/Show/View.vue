<template>
    <Layout tab="Public">

        <div class="bg-white w-full h-full p-6 flex flex-col justify-center items-center gap-2">
            
            <span class="w-full flex justify-center text-lg text-indigo-700 font-bold">
                {{ usePage().props.image.description }}
            </span>

            <div class="bg-indigo-100 rounded-md border border-indigo-300 text-indigo-700 w-full min-h-128 flex items-center justify-center">
                {{ usePage().props.image.file_name }}
            </div>

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
                        {{ 'NaN kb' }}
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
            <div class="bg-white rounded p-4 flex flex-col gap-2 w-full h-full text-indigo-600" v-for="index, image in 6">
                <div class="bg-indigo-100 rounded-md border border-indigo-300 text-indigo-700 min-h-32 flex items-center justify-center">
                    Related Image #{{ index }}
                </div>
                <div class="bg-emerald-50 border border-emerald-300 text-emerald-700 py-1 rounded flex justify-between px-4">
                    <iconYourFiles class="w-6 h-6"/>
                    <span>Album name here</span>
                </div>
            </div>
            
        </div>
    </Layout>
</template>
<script setup lang="js">
    import Layout from '@/layouts/Layout.vue'
    import { usePage } from '@inertiajs/vue3';

    import IconOwner from '@/icons/IconOwner.vue'
    import IconDate from '@/icons/IconDate.vue'
    import IconFilesize from '@/icons/IconFilesize.vue'
    import IconYourFiles from '@/icons/IconYourFiles.vue'
    import IconPhoto from '@/icons/IconPhoto.vue'
</script>