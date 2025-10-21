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

                    <div class="w-full flex flex-col gap-2">
                        <div class="flex items-center gap-2">
                            <label class="text-sm font-semibold text-stone-700">Album:</label>
                            <button 
                                type="button"
                                @click="toggleAlbumCreation"
                                class="text-xs text-indigo-600 hover:text-indigo-800 underline"
                            >
                                {{ isCreatingAlbum ? 'Select existing' : 'Create new' }}
                            </button>
                        </div>

                        <div v-if="!isCreatingAlbum" class="w-full">
                            <select 
                                v-model="form.album_id"
                                class="w-full px-4 py-2 bg-stone-50 border border-stone-200 rounded text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            >
                                <option :value="null">No album</option>
                                <option v-for="album in usePage().props.albums" :key="album.id" :value="album.id">
                                    {{ album.name }}
                                </option>
                            </select>
                        </div>

                        <div v-else class="w-full flex flex-col gap-2">
                            <InputText 
                                label="Album name"
                                id="new_album_name"
                                name="new_album_name"
                                type="text"
                                placeholder="Enter album name"
                                v-model="form.new_album_name"
                                :errors="form.errors.new_album_name"
                            />
                            <InputText 
                                label="Album description"
                                id="new_album_description"
                                name="new_album_description"
                                type="text"
                                placeholder="Enter album description"
                                v-model="form.new_album_description"
                                :errors="form.errors.new_album_description"
                            />
                        </div>
                    </div>
       
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
import { useForm, usePage } from '@inertiajs/vue3';

import Layout from '@/layouts/Layout.vue';
import ListFiles from '@/pages/Image/Create/Partials/ListFiles.vue';
import InputText from '@/components/form/InputText.vue';

const files = ref([]);
const isCreatingAlbum = ref(false);

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

const form = useForm({
    files: [],
    album_id: null,
    new_album_name: '',
    new_album_description: '',
});

const toggleAlbumCreation = () => {
    isCreatingAlbum.value = !isCreatingAlbum.value;
    
    if (isCreatingAlbum.value) { // if we're creating an album, nullify the album_id so the validation skips it
        form.album_id = null;
    } 
    else { // vice-versa for new_album parameters when we are selecting an existing album
        form.new_album_name = null;
        form.new_album_description = null;
    }
};

const submit = () => {
    form.files = files.value;

    form.post(route('image.store'), {
        onSuccess: () => {
            form.reset();
            files.value = [];
            isCreatingAlbum.value = false;
        },
        onError: (errors) => console.log(errors)
    });
}
</script>