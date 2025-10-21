<template>
    <Link 
        as="div"
        @mouseenter="isImageHovered[props.image.id] = true"
        @mouseleave="isImageHovered[props.image.id] = false"
        :href="route('image.show', props.image.id)"
        class="flex flex-col gap-2 items-center p-4 bg-stone-50 border text-indigo-700 border-white hover:border-indigo-500 rounded-md  hover:shadow-md cursor-pointer transition duration-300"
        :class="isAnyImageHovered() && !isImageHovered[props.image.id] ? 'grayscale' : 'grayscale-0'"
    >
        <span class="w-full text-center truncate">
            {{ props.image.description }}
        </span>

        <div class="flex">
            <AppImage 
                :url="props.image.thumbnail_url"
                :alt="props.image.file_name"
                class="ize-96 sm:size-48 xl:size-52 2xl:size-64"
            />
            
        </div>

    </Link>
</template>
<script setup lang="js">
    import { reactive } from 'vue';
    import { Link } from '@inertiajs/vue3';
    import AppImage from '@/components/AppImage.vue';

    const isImageHovered = reactive({});
    const isAnyImageHovered = () => Object.values(isImageHovered).some(v => v === true);

    const props = defineProps({
        image: {
            type: Object,
            required: true
        }
    });
</script>