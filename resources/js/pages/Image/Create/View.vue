<template>
    <Layout tab="Upload" title="Upload" description="Upload a new image.">
        <div class="w-full h-full flex flex-col justify-center items-center">
            <form 
                @submit.prevent="submit" 
                @dragover="onStartDraggingOver" 
                @dragleave="onStopDraggingOver" 
                @drop="onFileDropped"
                class="w-full p-8 bg-white dark:bg-stone-800 text-indigo-800 dark:text-indigo-300 rounded-md flex flex-col justify-center items-center"
            >
                <input type="file" name="file" id="fileInput" ref="file" multiple accept=".gif, .jpg, .jpeg, .png" @change="onInputUploadChange" class="hidden" />
                <label for="fileInput" class=" cursor-copy w-full h-full text-center rounded-lg border-4 border-dotted border-indigo-200 dark:border-stone-700 min-h-96 flex justify-center items-center">
                    <div v-if="isDraggingDetected">
                        Release to drop files here.
                    </div>
                    <div v-else>
                        Drag files here or <u>click here</u> to {{ uploadQueue.length > 0 ? 'upload more' : 'upload' }}.
                    </div>
                </label>

                <div v-if="uploadQueue.length" class="w-full mt-4 flex flex-col gap-2 rounded cursor-default">
                    <span class="w-full text-lg text-indigo-700 dark:text-indigo-400 font-bold">
                        Pending files:
                    </span>
                    <ListFiles v-model="uploadQueue" :albums="usePage().props.albums" :errors="form.errors || {}"/>
       
                    <button type="submit" class="bg-indigo-600 px-4 py-2 text-white text-center rounded hover:bg-indigo-500 cursor-pointer flex flex-col">
                        <span class="font-bold">Upload</span>
                        <span class="text-sm">{{ uploadQueue.length }} file{{ uploadQueue.length > 1 ? 's' : ''}} with a total size of {{ getTotalSize() }} kb.</span>
                    </button>
                </div>
            </form>
        </div>
    </Layout>
</template>
<script setup lang="js">
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify'

import Layout from '@/layouts/Layout.vue';
import ListFiles from '@/pages/Image/Create/Partials/ListFiles.vue';

const uploadQueue = ref([]);

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
    const uniqueFiles = uploadedFiles.filter(newFile => {
        return !uploadQueue.value.some(item =>
            item.file.name === newFile.name &&
            item.file.size === newFile.size &&
            item.file.lastModified === newFile.lastModified
        );
    });

    const newItems = uniqueFiles.map(file => {
        const baseName = file.name.substring(0, file.name.lastIndexOf('.')) || file.name;
        return {
            file: file,
            name: baseName,
            description: 'No description.',
            is_hidden: false,
            album_id: null
        };
    });

    uploadQueue.value = [...uploadQueue.value, ...newItems];
};

// gets the total size of all files
const getTotalSize = () => {
    let size = 0;
    for(const item of uploadQueue.value) {
        size += Math.round(item.file.size / 1000);
    }
    return size;
}

const form = useForm({
    uploads: []
});

const submit = () => {
    form.uploads = uploadQueue.value.map(item => ({
        file: item.file,
        name: item.name,
        description: item.description,
        is_hidden: item.is_hidden,
        album_id: item.album_id
    }));

    form.post(route('image.store'), {
        onSuccess: () => {
            form.reset();
            uploadQueue.value = [];
            toast.success('Your upload was successful.');
        },
        onError: (errors) => console.log(errors)
    });
}
</script>