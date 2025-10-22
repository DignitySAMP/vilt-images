<template>
    <Link 
        as="div"
        @mouseenter="isAlbumHovered[props.album.id] = true"
        @mouseleave="isAlbumHovered[props.album.id] = false"
        :href="route('album.show', props.album.id)"
        class="flex flex-col gap-2 items-center p-4 bg-stone-50 dark:bg-stone-800 border text-indigo-700 dark:text-indigo-400 border-white dark:border-stone-700 hover:border-indigo-500 dark:hover:border-indigo-400 rounded-md hover:shadow-md cursor-pointer transition duration-300"
        :class="isAnyAlbumHovered() && !isAlbumHovered[props.album.id] ? 'grayscale' : 'grayscale-0'"
    >
        <span class="w-full text-center text-lg font-bold truncate dark:text-stone-200">
            {{ props.album?.name ?? 'No album' }}
        </span>

        <div class="grid grid-rows-[auto_1fr_auto] gap-4 items-center w-full">
            <AppImage 
                v-if="props.album.images && props.album.images.length > 0"
                :url="props.album.images[0].thumbnail_url"
                :alt="props.album.images[0].file_name"
                class="w-full min-h-32"
            />

            <div class="flex flex-wrap gap-2 w-full text-sm">
                <div class="flex justify-between w-full bg-sky-50 dark:bg-sky-950/30 border border-sky-200 dark:border-sky-900/50 text-sky-700 dark:text-sky-400 px-2 py-1 rounded items-center gap-1">
                    <IconOwner class="w-4 h-4"/>
                    <span class="truncate">{{ props.album.user?.name ?? 'Unknown user' }}</span>
                </div>
                <div class="flex justify-between w-full bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-900/50 text-emerald-700 dark:text-emerald-400 px-2 py-1 rounded items-center gap-1">
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

