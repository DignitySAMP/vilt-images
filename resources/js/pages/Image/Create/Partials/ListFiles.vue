<template>
    <div
        v-for="(item, index) in model" :key="item.file.name + index"
        class="flex flex-col gap-3 p-4 border border-indigo-300 dark:border-stone-600 rounded-md bg-indigo-50 dark:bg-stone-700"
    >
        <div class="flex flex-wrap items-center gap-4">
            <img 
                @click="scalePreviewImage[index] = !scalePreviewImage[index];"
                :src="generateUploadPreview(item.file)" 
                class="h-20 w-20 object-cover transition duration-150 border-indigo-300 dark:border-stone-600 rounded"
                :class="{
                    'cursor-zoom-out hover:cursor-zoom-out scale-256 border-0': scalePreviewImage[index],
                    'cursor-zoom-in hover:cursor-zoom-in border-1': !scalePreviewImage[index]
                }"
            />

            <div class="flex gap-4 flex-col md:flex-row w-full md:w-fit">
                <p class="text-sm truncate font-semibold text-indigo-800 dark:text-indigo-300">
                    {{ item.file.name }}
                </p>
                <p class="text-xs text-indigo-600 dark:text-indigo-400">
                    {{ Math.round(item.file.size / 1000) }} kb
                </p>
            </div>

            <button
                type="button"
                @click="toggleEdit(index)"
                class="px-3 py-1 text-xs font-semibold text-indigo-700 dark:text-indigo-200 bg-indigo-200 dark:bg-stone-600 rounded hover:bg-indigo-300 dark:hover:bg-stone-500 transition-colors duration-300"
                :class="{ 'animate-pulse': !isEditing[index] }"
            >
                {{ isEditing[index] ? 'Close' : 'Edit' }}
            </button>

            <span
                @click="removeFileFromList(index)"
                class="cursor-pointer text-indigo-700 dark:text-indigo-300 hover:text-red-500 dark:hover:text-red-400 transition-colors duration-300 w-6 h-6"
            >
                <IconTrash/>    
            </span>
        </div>

        <transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="opacity-0 max-h-0"
            enter-to-class="opacity-100 max-h-96"
            leave-active-class="transition-all duration-300 ease-in"
            leave-from-class="opacity-100 max-h-96"
            leave-to-class="opacity-0 max-h-0"
        >
            <div v-if="isEditing[index]" class="flex flex-col gap-3 overflow-hidden">
                <EditFile 
                    :index="index"
                    :albums="props.albums"
                    :errors="props.errors"
                    v-model="model[index]"
                />
            </div>
        </transition>
    </div>
</template>
<script setup lang="js">
    import { ref } from 'vue';
    import EditFile from '@/pages/Image/Create/Partials/EditFile.vue';
    import IconTrash from '@/icons/IconTrash.vue'

    const props = defineProps({
        albums: {
            type: Array,
            required: true
        },
        errors: {
            type: Object,
            default: () => ({})
        }
    });

    const model = defineModel();
    const scalePreviewImage = ref([]);

    const isEditing = ref([]);
    const toggleEdit = (index) => isEditing.value[index] = !isEditing.value[index];

    const removeFileFromList = (index) => {
        model.value.splice(index, 1);
        isEditing.value.splice(index, 1);
    };

    const generateUploadPreview = (file) => {
        let fileSrc = URL.createObjectURL(file);
        setTimeout(() => URL.revokeObjectURL(fileSrc), 1000);
        return fileSrc;
    };

    const getCleanFileName = (file) => {
        const name = file.name;
        const NAME_LIMIT = 32;
        if(file.name.length > (NAME_LIMIT + 4)) {
            const lastDotIndex = name.lastIndexOf('.');
            const prefix = name.substring(0, lastDotIndex).slice(0, NAME_LIMIT);
            const extension = name.substring(lastDotIndex);
            return `${prefix}... ${extension}`;
        }
        else return file.name;
    };
</script>