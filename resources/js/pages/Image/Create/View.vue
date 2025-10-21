<template>
    <Layout tab="Upload">
        <div class="w-full h-full flex flex-col justify-center items-center">
            <form 
                @submit.prevent="submit" 
                @dragover="onStartDraggingOver" 
                @dragleave="onStopDraggingOver" 
                @drop="onFileDropped"
                class="w-full p-8 bg-white text-indigo-800 rounded-md flex flex-col justify-center items-center"
            >
                <input type="file" name="file" id="fileInput" ref="file" multiple accept=".gif, .jpg, .jpeg, .png" @change="onInputUploadChange" class="hidden" />
                <label for="fileInput" class=" cursor-copy w-full h-full text-center rounded-lg border-4 border-dotted border-indigo-200 min-h-96 flex justify-center items-center">
                    <div v-if="isDraggingDetected">
                        Release to drop files here.
                    </div>
                    <div v-else>
                        Drag files here or <u>click here</u> to {{ files.length > 0 ? 'upload more' : 'upload' }}.
                    </div>
                </label>

                <div v-if="files.length" class="w-full mt-4 flex flex-col gap-2 rounded cursor-default">
                    <span class="w-full text-lg text-indigo-700 font-bold">
                        Pending files:
                    </span>
                    <ListFiles v-model="files"/>       
                    <button type="submit" class="bg-indigo-600 px-4 py-2 text-white text-center rounded hover:bg-indigo-500 cursor-pointer flex flex-col">
                        <span class="font-bold">Upload</span>
                        <span class="text-sm">{{ files.length }} file{{ files.length > 1 ? 's' : ''}} with a total size of {{ getTotalSize() }} kb.</span>
                    </button>
                </div>
            </form>
        </div>
    </Layout>
</template>
<script setup lang="js">
import { ref } from 'vue';
import Layout from '@/layouts/Layout.vue'

const files = ref([]);
import ListFiles from '@/pages/Image/Create/Partials/ListFiles.vue';
import { useForm } from '@inertiajs/vue3';

// isDraggingDetected, onStartDraggingOver and onStopDraggingOver is used to 
// conditionally show the 'drop files here to upload' string when dragging
const isDraggingDetected = ref(false);
const onStartDraggingOver = (e) => {
    e.preventDefault(); 
    isDraggingDetected.value = true;
}
const onStopDraggingOver = () => isDraggingDetected.value = false;

 // prevents the default behaviour (opening dropped file in a new tab) and updates the file list.
const onFileDropped = (e) => {
    e.preventDefault();
    appendFileToList(Array.from(e.dataTransfer.files));
    isDraggingDetected.value = false;
};

// updates the file list after the input gets triggered
const onInputUploadChange = (event) => appendFileToList(Array.from(event.target.files));

// adds a collection of files to the list after filtering it for uniqueness
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

// gets the total size of all files
const getTotalSize = () => {
    let size = 0;

    for(const file of files.value) {
        size += Math.round(file.size / 1000);
    }

    return size;
}

const submit = () => {
    const form = useForm({
        files: files.value
    });

    form.post(route('image.store'), 
    {
        onSuccess: () => form.reset(),
        onError: (errors) => console.log(errors)
    });
}
</script>