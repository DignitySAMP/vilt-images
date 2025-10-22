<template>
    <div class="w-full p-4 bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/50 rounded-md">
        <h3 class="text-lg font-bold text-red-700 dark:text-red-400 mb-2">Danger Zone</h3>
        <p class="text-sm text-red-600 dark:text-red-400 mb-4">
            Deleting this image is permanent and cannot be undone.
        </p>
        <InputButton
            colors="bg-red-500 hover:bg-red-600 text-white"
            type="button"
            @click="showModal = true"
        >
            Delete Image
        </InputButton>

        <Modal :show="showModal" @close="showModal = false">
            <h3 class="text-xl font-bold text-red-700 dark:text-red-500 mb-4">Confirm Image Deletion</h3>
            <p class="text-stone-700 dark:text-stone-300 mb-4">
                This will permanently delete this image. Type the image name to confirm.
            </p>
            <form @submit.prevent="submit" class="flex flex-col gap-4">
                <div class="w-full">
                    <label for="confirm_name" class="text-sm text-stone-700 dark:text-stone-300">
                        Image Name Confirmation
                    </label>
                    <input
                        id="confirm_name" 
                        name="confirm_name" 
                        v-model="form.confirm_name"
                        type="text" 
                        :placeholder="image.name"
                        class="w-full px-4 py-2 bg-stone-50 dark:bg-stone-700 dark:text-stone-200 border border-stone-200 dark:border-stone-600 rounded text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    />
                    <span v-if="form.errors.confirm_name" class="text-sm text-red-500">{{ form.errors.confirm_name }}</span>
                </div>
                <div class="flex gap-2 justify-end">
                    <InputButton
                        colors="bg-slate-500 hover:bg-slate-600 text-white"
                        :icon="IconReturn"
                        type="button"
                        @click="showModal = false"
                    >
                        Cancel
                    </InputButton>
                    <InputButton
                        colors="bg-red-500 hover:bg-red-600 text-white"
                        :processing="form.processing"
                        type="submit"
                    >
                        {{ form.processing ? 'Deleting...' : 'Delete Image' }}
                    </InputButton>
                </div>
            </form>
        </Modal>
    </div>
</template>

<script setup lang="js">
    import { ref } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    import Modal from '@/components/Modal.vue';
    import InputButton from '@/components/form/InputButton.vue';
    import IconReturn from '@/icons/IconReturn.vue';

    const props = defineProps({
        image: {
            type: Object,
            required: true
        }
    });

    const showModal = ref(false);

    const form = useForm({
        confirm_name: '',
    });

    const submit = () => {
        form.delete(route('image.destroy', props.image.id), {
            onSuccess: () => {
                form.reset();
                showModal.value = false;
            }
        });
    };
</script>

