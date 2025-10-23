<template>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <InputText 
            :label="'Name'"
            :id="'name_' + props.index"
            :name="'name_' + props.index"
            type="text"
            placeholder="Enter image name"
            v-model="model.name"
            :errors="getErrorKey('name')"
        />
        
        <InputText 
            :label="'Description'"
            :id="'description_' + props.index"
            :name="'description_' + props.index"
            type="text"
            placeholder="Enter image description"
            v-model="model.description"
            :errors="getErrorKey('description')"
        />
    </div>

    <div class="w-full">

        <InputSelect
            label="Choose album"
            :name="'album_' + props.index"
            v-model="model.album_id"
            :error="getErrorKey('album_id')"
            :options="[
                { label: 'No album', value: null },
                ... props.albums.map(album => ({
                    label: album.name,
                    value: album.id
                }))
            ]"
        />
    </div>

    <div class="flex items-center gap-2">
        <input 
            :id="'is_hidden_' + props.index"
            :name="'is_hidden_' + props.index"
            v-model="model.is_hidden"
            type="checkbox"
            class="w-4 h-4 bg-stone-50 dark:bg-stone-700 border border-stone-200 dark:border-stone-600 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 accent-sky-800 dark:accent-sky-600 active:accent-sky-900 transition duration-300"
        />
        <label :for="'is_hidden_' + props.index" class="text-sm text-stone-700 dark:text-stone-300">
            Make this image private
        </label>
    </div>
</template>

<script setup lang="js">
    import InputText from '@/components/form/InputText.vue';
    import InputSelect from '@/components/form/InputSelect.vue';

    const props = defineProps({
        index: {
            type: Number,
            required: true
        },
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
    const getErrorKey = (field) => props.errors[`uploads.${props.index}.${field}`];
</script>

