<template>
    <div
        v-for="file in model" :key="file.name"
        class="grid grid-cols-[auto_1fr_auto] gap-2 items-center p-2 border-1 border-indigo-300 rounded-md bg-indigo-50"
    >
        <img 
            @click="scalePreviewImage[model.indexOf(file)] = !scalePreviewImage[model.indexOf(file)];"
            :src="generateUploadPreview(file)" 
            class="h-16 justify-self-start transition duration-150 border-indigo-300 rounded"
            :class="{
                'cursor-zoom-out hover:cursor-zoom-out scale-256 border-0': scalePreviewImage[model.indexOf(file)],
                'cursor-zoom-in hover:cursor-zoom-in border-1': !scalePreviewImage[model.indexOf(file)]
            }"
        />

        <p class="justify-self-center">
            {{ getCleanFileName(file) }} -
            {{ Math.round(file.size / 1000) + "kb" }}
        </p>

        <span
            @click="removeFileFromList(file)"
            class="justify-self-end cursor-pointer hover:text-red-500 transition-colors duration-300"
        >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/></svg>
        </span>
    </div>

</template>
<script setup lang="js">
    import { ref } from 'vue';

    const model = defineModel();


    const scalePreviewImage = ref([]);
    const removeFileFromList = (file) => {
        const index = model.value.indexOf(file); 

        if (index !== -1) {
            model.value.splice(index, 1);
        }
    };
    const generateUploadPreview = (file) => {
        let fileSrc = URL.createObjectURL(file);
        setTimeout(() => URL.revokeObjectURL(fileSrc), 1000);
        return fileSrc;
    };

    const getCleanFileName = (file) => {
        const name = file.name;
        const NAME_LIMIT = 32; // 32 characters
        if(file.name.length > (NAME_LIMIT + 4)) {
            const lastDotIndex = name.lastIndexOf('.');

            const prefix = name.substring(0, lastDotIndex).slice(0, NAME_LIMIT);
            const extension = name.substring(lastDotIndex);
            
            return `${prefix}... ${extension}`;
        }

        else return file.name;
    };
</script>