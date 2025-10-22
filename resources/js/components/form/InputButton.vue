<template>
    <button 
        :type="props.type" 
        class="flex justify-between items-center h-fit w-full lg:w-fit gap-6 text-sm px-4 py-2 rounded-md transition duration-200 cursor-pointer"
        :class="props.colors"
    >
        <IconLoadingAnimated v-if="props.processing"/>
        <component :is="props.icon" v-else/>
        <span>
            <slot/>
        </span>
    </button>
</template>
<script setup lang="js">

    import IconLoadingAnimated from '@/icons/IconLoadingAnimated.vue'
    import IconClick from '@/icons/IconClick.vue'

    const props = defineProps({
        processing: {
            type: Boolean,
            required: false,
            default: false
        },
        icon: {
            type: Object,
            required: false,
            default: IconClick
        },
        type: {
            required: false,
            default: 'submit'
        },
        colors: {
            required: false,
            default: 'bg-indigo-500 hover:bg-indigo-600 text-white'
        }
    });
</script>