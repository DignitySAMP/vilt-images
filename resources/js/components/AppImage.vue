<template>
    <img 
        v-if="!isImageBroken" :src="props.url" :alt="props.alt"
        @error="onImageFailsToLoad"
        class="bg-indigo-100 rounded-md border border-indigo-300 text-indigo-700 w-full h-full flex items-center justify-center"
    />
    <span 
        v-else 
        class="bg-indigo-100 rounded-md border border-indigo-300 text-indigo-700 w-full h-full flex items-center justify-center"
    >
        Image could not be loaded
    </span>
</template>
<script setup lang="js">
    import { ref } from 'vue';

    const props = defineProps({
        url: {
            type: String,
            required: true,
        },
        alt: {
            type: String,
            required: true
        }
    })

    const isImageBroken = ref(false);
    const onImageFailsToLoad = () => isImageBroken.value = true;
</script>