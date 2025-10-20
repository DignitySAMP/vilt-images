<template>
    <div class="w-screen h-screen bg-stone-200">
        <div class="w-full h-full flex flex-col justify-center items-center">
            <div class="flex w-full justify-center items-center text-center mb-8">
                <span class="text-4xl text-transparent bg-clip-text font-extrabold bg-gradient-to-br from-indigo-700 to-indigo-500 p-2">
                    {{ usePage().props.app.name }}
                </span>
            </div>


            <div 
                @dragover="onStartDraggingOver" 
                @dragleave="onStopDraggingOver" 
                @drop="onFileDropped"
                class="w-128 p-8 bg-stone-50 border border-indigo-300 text-indigo-800 rounded-lg shadow-md cursor-copy"
            >

                <input type="file" name="file" id="fileInput" ref="file" multiple accept=".gif, .jpg, .jpeg, .png" @change="onInputUploadChange" class="hidden" />

                <label for="fileInput" class=" cursor-copy w-full text-center">
                    <div v-if="isDraggingDetected">
                        Release to drop files here.
                    </div>
                    <div v-else>
                        Drag files here or <u>click here</u> to {{ files.length > 0 ? 'upload more' : 'upload' }}.
                    </div>
                </label>

                <div v-if="files.length" class="mt-4 flex flex-col gap-2 px-4 py-2 rounded border-2 bg-white border-dotted border-indigo-300 cursor-default">

                    <div
                        v-for="file in files" :key="file.name" 
                        class="grid grid-cols-[auto_1fr_auto] gap-2 items-center p-2 border-1 border-indigo-300 rounded-lg bg-indigo-50"
                    >
                        <img 
                            @click="scalePreviewImage[files.indexOf(file)] = !scalePreviewImage[files.indexOf(file)];"
                            :src="generateUploadPreview(file)" 
                            class="h-16 justify-self-start transition duration-150 border-indigo-300 rounded"
                            :class="{
                                'cursor-zoom-out hover:cursor-zoom-out scale-256 border-0': scalePreviewImage[files.indexOf(file)],
                                'cursor-zoom-in hover:cursor-zoom-in border-1': !scalePreviewImage[files.indexOf(file)]
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

                    <span class="bg-indigo-600 px-4 py-2 text-white font-bold text-center rounded hover:bg-indigo-500 cursor-pointer">
                        Upload image
                    </span>

                    <span class="w-full text-center">
                        {{ files.length }} files with a total size of {{ getTotalSize() }} kb.
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const isDraggingDetected = ref(false);
const onStartDraggingOver = (e) => {
    e.preventDefault(); 
    isDraggingDetected.value = true;
}
const onStopDraggingOver = () => isDraggingDetected.value = false;

const files = ref([]);
const scalePreviewImage = ref([]);
const onInputUploadChange = (event) => appendFileToList(Array.from(event.target.files));

const onFileDropped = (e) => {
    e.preventDefault();
    appendFileToList(Array.from(e.dataTransfer.files));
    isDraggingDetected.value = false;
};

const removeFileFromList = (file) => {
    const index = files.value.indexOf(file); 

    if (index !== -1) {
        files.value.splice(index, 1);
    }
};
const generateUploadPreview = (file) => {
    let fileSrc = URL.createObjectURL(file);
    setTimeout(() => URL.revokeObjectURL(fileSrc), 1000);
    return fileSrc;
};

const appendFileToList = (uploadedFiles) => {
    const existingFiles = files.value;

    const uniqueFiles = uploadedFiles.filter(newFile => {
        return !existingFiles.some(existingFile =>
            existingFile.name === newFile.name &&
            existingFile.size === newFile.size &&
            existingFile.lastModified === newFile.lastModified
        );
    });

    files.value = [...existingFiles, ...uniqueFiles];
};

const getCleanFileName = (file) => {
    const name = file.name;
    if(file.name.length > (8 + 4)) {
        const lastDotIndex = name.lastIndexOf('.');

        const prefix = name.substring(0, lastDotIndex).slice(0, 8);
        const extension = name.substring(lastDotIndex);
        
        return `${prefix}... ${extension}`;
    }

    else return file.name;
};

const getTotalSize = () => {
    let size = 0;

    for(const file of files.value) {
        size += Math.round(file.size / 1000);
    }

    return size;
}
</script>