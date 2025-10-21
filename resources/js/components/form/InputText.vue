<template>

    <div class="w-full">
        <label :for="props.name" class="text-sm" :class="props.errors ? 'text-red-500' : 'text-stone-700'">
            {{ props.label }}
        </label>
        <div class="relative flex items-center">
            <input
                :id="props.name"
                :name="props.name"
                v-model="model"
                :type="(props.type === 'password' && showPassword) ? 'text' : props.type" 
                :placeholder="props.placeholder"
                v-bind="attributes"
                class="w-full px-4 py-2 bg-stone-50 border  rounded text-sm focus:outline-none focus:ring-2"
                :class="props.errors ? 'border-red-500 focus:ring-red-600 placeholder:text-red-300' : 'border-stone-200 focus:ring-indigo-500'"
            />
            <div v-if="props.type === 'password'" @click="showPassword = !showPassword">
                <IconPasswordHidden v-if="!showPassword" class="absolute top-2 right-1 text-stone-400"/>
                <IconPasswordShown v-else-if="showPassword" class="absolute top-2 right-1 text-stone-700"/>
            </div>
        </div>
        <span v-if="props.errors" class="text-sm text-red-500">
            {{ props.errors }}
        </span>
    </div>
</template>
<script setup lang="js">

    import { ref, useAttrs } from 'vue';
    const attributes = useAttrs()
    
    import IconPasswordHidden from '@/icons/IconPasswordHidden.vue';
    import IconPasswordShown from '@/icons/IconPasswordShown.vue';
    const showPassword = ref(false);

    const model = defineModel();
    const props = defineProps({
        label: {
            type: String,
            required: false,
            default: '',
        },
        name: {
            type: String,
            required: true
        },
        placeholder: {
            type: String,
            required: false,
            default: '',
        },
        type: {
            type: String,
            validator: () => ['text', 'email', 'password'],
            required: false,
            default: 'text'
        },
        errors: {
            type: String,
            required: false,
            default: '',
        }
    });
</script>