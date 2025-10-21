<template>
    <img 
        v-if="!isImageBroken" :src="props.url" :alt="props.alt"
        @error="onImageFailsToLoad"
        class="bg-indigo-100 rounded-md border border-indigo-300 text-indigo-700 w-full h-full flex items-center justify-center"
    />
    <div 
        v-else 
        class="bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-md border border-indigo-300 text-indigo-400 w-full h-full flex items-center justify-center"
    >
        <IconPhoto class="w-16 h-16"/>
    </div>
</template>
<script setup lang="js">
    import { ref } from 'vue';
    import IconPhoto from '@/icons/IconPhoto.vue';

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