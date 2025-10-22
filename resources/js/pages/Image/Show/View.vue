<template>
    <Layout tab="Public">

        <div class="bg-white w-full h-full p-6 flex flex-col justify-center items-center gap-2">
            
            <div class="w-full flex justify-between items-center">
                <div class="flex flex-col w-full">
                    <span class="text-lg text-indigo-700 font-bold">
                        {{ usePage().props.image.name }}
                    </span>
                                
                    <span class="text-indigo-700 truncate">
                        {{ usePage().props.image.description ?? 'No description added.'}}
                    </span>
                </div>
                
                <div v-if="canEdit" class="flex gap-2">
                    <Link 
                        :href="route('image.edit', usePage().props.image.id)"
                        class="flex items-center gap-2 bg-slate-500 text-white text-sm px-4 py-2 rounded-md hover:bg-slate-600 transition duration-200 cursor-pointer"
                    >
                        <IconEdit/>
                        <span class="hidden md:inline-block">Edit</span>
                    </Link>
                </div>
            </div>
        </div>
        <div class="bg-white w-full h-full p-6 flex flex-col justify-center items-center gap-2">
            
            <AppImage 
                :url="usePage().props.image.url"
                :alt="usePage().props.image.file_name"
                class="w-full min-h-128 max-h-164"
            />
        </div>
        <div class="bg-white w-full p-6 flex flex-col gap-2">
            <h2 class="text-lg font-semibold text-indigo-800">Extra information</h2>

            <ul class="flex flex-col divide-y divide-indigo-200 text-sm text-indigo-700">
                <li class="flex items-center justify-between py-2">
                    <div class="flex items-center gap-2">
                        <IconOwner class="w-4 h-4 text-indigo-500" />
                        <span class="text-indigo-500">Uploaded by</span>
                    </div>
                    <span class="font-medium text-indigo-800">
                        {{ usePage().props.image.publisher.name ?? 'Unknown' }}
                    </span>
                </li>

                <li class="flex items-center justify-between py-2">
                    <div class="flex items-center gap-2">
                        <IconYourFiles class="w-4 h-4 text-indigo-500" />
                        <span class="text-indigo-500">Belongs to</span>
                    </div>
                    <span class="font-medium text-indigo-800">
                        {{ usePage().props.image?.album?.name ?? 'No album' }}
                    </span>
                </li>

                <li class="flex items-center justify-between py-2">
                    <div class="flex items-center gap-2">
                        <IconDate class="w-4 h-4 text-indigo-500" />
                        <span class="text-indigo-500">Published on</span>
                    </div>
                    <span class="font-medium text-indigo-800">
                        {{ new Date(usePage().props.image.created_at).toLocaleString() ?? 'Unknown date' }}
                    </span>
                </li>

                <li class="flex items-center justify-between py-2">
                    <div class="flex items-center gap-2">
                        <IconFilesize class="w-4 h-4 text-indigo-500" />
                        <span class="text-indigo-500">File size</span>
                    </div>
                    <span class="font-medium text-indigo-800">
                        {{ usePage().props.image.file_size || 'Unknown' }} kb
                    </span>
                </li>

                <li class="flex items-center justify-between py-2">
                    <div class="flex items-center gap-2">
                        <IconSpy class="w-4 h-4 text-indigo-500" />
                        <span class="text-indigo-500">Private?</span>
                    </div>
                    <span class="font-medium text-indigo-800">

                        <span>{{  usePage().props.image.is_hidden === 1 ? 'Yes' : 'No'}}</span>
                    </span>
                </li>
            </ul>
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
                    <span>{{ image.album?.name ?? 'No album'}}</span>
                </div>
            </Link>
            
        </div>
    </Layout>
</template>
<script setup lang="js">
    import { computed } from 'vue';
    import { usePage, Link, router } from '@inertiajs/vue3';

    import Layout from '@/layouts/Layout.vue'
    import AppImage from '@/components/AppImage.vue'

    import IconOwner from '@/icons/IconOwner.vue'
    import IconDate from '@/icons/IconDate.vue'
    import IconFilesize from '@/icons/IconFilesize.vue'
    import IconYourFiles from '@/icons/IconYourFiles.vue'
    import IconEdit from '@/icons/IconEdit.vue'
    import IconSpy from '@/icons/IconSpy.vue';

    const canEdit = computed(() => {
        const user = usePage().props.auth.user;
        const image = usePage().props.image;
        return user && user.id === image.publisher_id;
    });
</script>