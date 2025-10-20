<template>
    <div
        class="flex flex-col gap-2 items-center p-4 bg-stone-50 border border-white rounded-md  hover:shadow-md cursor-pointer hover:scale-105 transition duration-300"
        @mouseenter="isImageHovered[props.image.id] = true"
        @mouseleave="isImageHovered[props.image.id] = false"
        :class="isAnyImageHovered() && !isImageHovered[props.image.id] ? 'grayscale' : 'grayscale-0'"
    >

        <div class="text-sm w-full flex flex-col gap-2">
            <div class="flex gap-1  items-center w-full bg-indigo-50 border border-indigo-200 text-indigo-700 justify-between px-2 py-0.5 rounded">
                <IconPhoto/>
                <span>{{ props.image.name }}</span>
            </div>

            <div class="flex gap-1  items-center w-full bg-blue-50 border border-blue-200 text-blue-700 justify-between px-2 py-0.5 rounded">
                <IconOwner/> 
                <span>{{ props.image.author }}</span>
            </div>
        </div>

        <img
            :src="props.image.url"
            alt="Public file"
            class="w-64 h-64 object-cover rounded border border-indigo-200 bg-indigo-50/50 text-center text-indigo-800"
        />

        <div class="text-indigo-600 text-sm w-full flex gap-2">

            <div class="flex gap-1  items-center w-full bg-sky-50 border border-sky-200 text-sky-700 justify-between px-2 py-0.5 rounded">
                <IconDate/>
                <span>{{ props.image.uploadedAt }}</span>
            </div>
            

            <div class="flex gap-1  items-center w-full bg-sky-50 border border-sky-200 text-sky-700 justify-between px-2 py-0.5 rounded">
                <IconFilesize/>
                <span>{{ Math.round(props.image.size / 1000) }}kb</span>
            </div>

        </div>
    </div>
</template>
<script setup>
    import { reactive } from 'vue';
    import IconDate from '@/icons/IconDate.vue';
    import IconFilesize from '@/icons/IconFilesize.vue';
    import IconOwner from '@/icons/IconOwner.vue';
    import IconPhoto from '@/icons/IconPhoto.vue';

    const isImageHovered = reactive({});
    const isAnyImageHovered = () => Object.values(isImageHovered).some(v => v === true);

    const props = defineProps({
        image: {
            type: Object,
            required: true
        }
    })
</script>