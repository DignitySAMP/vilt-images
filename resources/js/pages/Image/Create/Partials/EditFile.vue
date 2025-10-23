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

    <div>
        <InputCheckbox
            :name="'is_hidden_' + props.index"
            label="Make image private"
            v-model="model.is_hidden"
        />
    </div>
</template>

<script setup lang="js">
    import InputText from '@/components/form/InputText.vue';
    import InputSelect from '@/components/form/InputSelect.vue';
    import InputCheckbox from '@/components/form/InputCheckbox.vue';

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

