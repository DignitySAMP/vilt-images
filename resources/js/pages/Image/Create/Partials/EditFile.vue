<template>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <InputText 
            :label="'Name'"
            :id="'name_' + props.index"
            :name="'name_' + props.index"
            type="text"
            placeholder="Enter image name"
            v-model="model.name"
        />
        
        <InputText 
            :label="'Description'"
            :id="'description_' + props.index"
            :name="'description_' + props.index"
            type="text"
            placeholder="Enter image description"
            v-model="model.description"
        />
    </div>

    <div class="w-full">
        <label class="text-sm text-stone-700">Album</label>
        <select 
            v-model="model.album_id"
            class="w-full px-4 py-2 bg-stone-50 border border-stone-200 rounded text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
            <option :value="null">No album</option>
            <option v-for="album in props.albums" :key="album.id" :value="album.id">
                {{ album.name }}
            </option>
        </select>
    </div>

    <div class="flex items-center gap-2">
        <input 
            :id="'is_hidden_' + props.index"
            :name="'is_hidden_' + props.index"
            v-model="model.is_hidden"
            type="checkbox"
            class="w-4 h-4 bg-stone-50 border border-stone-200 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 accent-sky-800 active:accent-sky-900 transition duration-300"
        />
        <label :for="'is_hidden_' + props.index" class="text-sm text-stone-700">
            Make this image private
        </label>
    </div>
</template>

<script setup lang="js">
    import InputText from '@/components/form/InputText.vue';

    const props = defineProps({
        index: {
            type: Number,
            required: true
        },
        albums: {
            type: Array,
            required: true
        }
    });

    const model = defineModel();
</script>

