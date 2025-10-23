<template>
    <div class="w-full flex items-center gap-4">
        <input 
            :id="props.name"
            :name="props.name"
            v-model="model"
            type="checkbox"
            class="w-4 h-4 bg-stone-50 dark:bg-stone-700 border border-stone-200 dark:border-stone-600 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 accent-sky-800 dark:accent-sky-600 active:accent-sky-900 transition duration-300"
        />

        <label v-if="props.label && props.label.length > 1" :for="props.name" class="text-sm text-stone-700 dark:text-stone-300">
            {{ props.label }}
        </label>
    </div>
</template>
<script setup lang="js">
    const model = defineModel();
    const props = defineProps({
        label: {
            type: String,
            required: false,
            default: ''
        },
        name: {
            type: String,
            required: true
        }
    });
</script>