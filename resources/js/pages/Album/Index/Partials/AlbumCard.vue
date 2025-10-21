<template>
    <Link 
        as="div"
        @mouseenter="isAlbumHovered[props.album.id] = true"
        @mouseleave="isAlbumHovered[props.album.id] = false"
        :href="route('album.show', props.album.id)"
        class="flex flex-col gap-2 items-center p-4 bg-stone-50 border text-indigo-700 border-white hover:border-indigo-500 rounded-md  hover:shadow-md cursor-pointer transition duration-300"
        :class="isAnyAlbumHovered() && !isAlbumHovered[props.album.id] ? 'grayscale' : 'grayscale-0'"
    >
        <span class="w-full text-center text-lg font-bold truncate">
            {{ props.album.name }}
        </span>

        <div class="grid grid-rows-[auto_1fr_auto] gap-4 items-center w-full">
            <AppImage 
                v-if="props.album.images && props.album.images.length > 0"
                :url="props.album.images[0].thumbnail_url"
                :alt="props.album.images[0].file_name"
                class="w-full min-h-32"
            />

            <div class="flex gap-2 w-full text-sm">
                <div class="flex justify-between w-full bg-sky-50 border border-sky-200 text-sky-700 px-2 py-1 rounded items-center gap-1">
                    <IconOwner class="w-4 h-4"/>
                    <span class="truncate">{{ props.album.user?.name ?? 'Unknown' }}</span>
                </div>
                <div class="flex justify-between w-full bg-emerald-50 border border-emerald-200 text-emerald-700 px-2 py-1 rounded items-center gap-1">
                    <IconYourFiles class="w-4 h-4"/>
                    <span>{{ props.album.images_count ?? 0 }} images</span>
                </div>
            </div>
        </div>

    </Link>
</template>
<script setup lang="js">
    import { reactive } from 'vue';
    import { Link } from '@inertiajs/vue3';
    
    import AppImage from '@/components/AppImage.vue';
    import IconPhoto from '@/icons/IconPhoto.vue';
    import IconOwner from '@/icons/IconOwner.vue';
    import IconYourFiles from '@/icons/IconYourFiles.vue';

    const isAlbumHovered = reactive({});
    const isAnyAlbumHovered = () => Object.values(isAlbumHovered).some(v => v === true);

    const props = defineProps({
        album: {
            type: Object,
            required: true
        }
    });
</script>

