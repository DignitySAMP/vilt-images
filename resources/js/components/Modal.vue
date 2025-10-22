<template>
    <div v-if="props.show" class="fixed inset-0 backdrop-blur-sm bg-black/30 dark:bg-black/60 flex items-center justify-center z-50" @click="emit('close')">
        <div class="bg-white dark:bg-stone-800 rounded-md p-6 max-w-md w-full mx-4" @click.stop>
            <slot />
        </div>
    </div>
</template>

<script setup lang="js">
    const props = defineProps({
        show: {
            type: Boolean,
            required: true
        }
    });

    const emit = defineEmits(['close']);
</script>

