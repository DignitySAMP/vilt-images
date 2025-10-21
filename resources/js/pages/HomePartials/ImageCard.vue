<template>
    <div
        class="flex flex-col gap-2 items-center p-4 bg-stone-50 border text-indigo-700 border-white hover:border-indigo-500 rounded-md  hover:shadow-md cursor-pointer transition duration-300"
        @mouseenter="isImageHovered[props.image.id] = true"
        @mouseleave="isImageHovered[props.image.id] = false"
        :class="isAnyImageHovered() && !isImageHovered[props.image.id] ? 'grayscale' : 'grayscale-0'"
    >
        {{ props.image.name }}

        <div class="flex">
            <span class="bg-indigo-100 size-96 sm:size-48 xl:size-52 2xl:size-64 text-indigo-700 border border-indigo-200 rounded-md flex items-center justify-center">
                Placeholder
            </span>
        </div>

    </div>
</template>
<script setup>
    import { reactive } from 'vue';

    const isImageHovered = reactive({});
    const isAnyImageHovered = () => Object.values(isImageHovered).some(v => v === true);

    const props = defineProps({
        image: {
            type: Object,
            required: true
        }
    })
</script>