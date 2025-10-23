<template>
    <div class="flex flex-col gap-2">

        <label 
            v-if="props.label && props.label.length > 1"
            :for="props.name" 
            class="text-sm" 
            :class="props.error ? 'text-red-500' : 'text-stone-700 dark:text-stone-300'"
        >
            {{ props.label }}
        </label>
        <select 
            :name="props.name"
            :id="props.name"
            v-model="model"
            class="bg-stone-50 dark:bg-stone-700 text-sm rounded-md w-full lg:w-fit border text-slate-700 dark:text-stone-200 px-4 py-2 focus:outline-none focus:ring-2"
            :class="props.error ? 'border-red-500 focus:ring-red-600' : 'border-stone-200 dark:border-stone-500 focus:ring-indigo-500'"
        >
            <option v-for="option in options" :value="option.value">{{ option.label }}</option>
        </select>
        <span v-if="props.error && props.error.length > 1" class="text-sm text-red-500">
            {{ props.error }}
        </span>
    </div>
</template>
<script setup>
    const model = defineModel();
    const props = defineProps({
        name: {
            type: String,
            required: true
        },
        label: {
            type: String,
            required: false,
            default: ''
        },
        options: {
            type: Array,
            required: true,
            validator: (value) => {

                if (!Array.isArray(value)) {
                    console.warn('options must be an array');
                    return false;
                }
                
                // validate that every option object has label and value
                return value.every(option => {
                    const hasLabel = 'label' in option && typeof option.label === 'string';
                    const hasValue = 'value' in option;
                    
                    if (!hasLabel || !hasValue) {
                        console.warn('each option must have a label (string) and value property', option);
                        return false;
                    }
                    
                    return true;
                });
            }
        },
        error: {
            type: String,
            required: false,
            default: '',
        }
    })
</script>