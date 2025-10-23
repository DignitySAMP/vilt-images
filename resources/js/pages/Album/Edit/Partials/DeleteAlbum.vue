<template>
    <div class="w-full p-4 bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/50 rounded-md">
        <h3 class="text-lg font-bold text-red-700 dark:text-red-400 mb-2">Danger Zone</h3>
        <p class="text-sm text-red-600 dark:text-red-400 mb-4">
            Deleting this album will also delete all images within it. This action cannot be undone.
        </p>

        <InputButton
            type="button"
            @click="showModal = true"
            :icon="IconTrash"

            colors="bg-red-500 hover:bg-red-500 text-white"
        >
            Delete Album
        </InputButton>

        <Modal :show="showModal" @close="showModal = false">
            <h3 class="text-xl font-bold text-red-700 dark:text-red-500 mb-4">Confirm Album Deletion</h3>
            <p class="text-stone-700 dark:text-stone-300 mb-4">
                This will permanently delete this album and all images within it. Type the album name to confirm.
            </p>
            <form @submit.prevent="submit" class="flex flex-col gap-4">
                <InputText
                    label="Album Name Confirmation"
                    name="confirm_name"
                    type="text"
                    :placeholder="album.name"
                    v-model="form.confirm_name"
                    :errors="form.errors.confirm_name"
                />
                <div class="flex gap-2 justify-end">

                    <InputButton
                        type="button"
                        @click="showModal = false"
                        :icon="IconReturn"
                    >
                        Cancel
                    </InputButton>

                    <InputButton
                        type="submit"
                        :processing="form.processing"
                        colors="bg-red-500 hover:bg-red-500 text-white"
                    >
                        {{ form.processing ? 'Deleting...' : 'Delete Album' }}
                    </InputButton>
                </div>
            </form>
        </Modal>
    </div>
</template>

<script setup lang="js">
    import { ref } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    import { toast } from 'vue3-toastify'
    
    import Modal from '@/components/Modal.vue';
    import IconReturn from '@/icons/IconReturn.vue'
    import IconTrash from '@/icons/IconTrash.vue'
    import InputButton from '@/components/form/InputButton.vue';
    import InputText from '@/components/form/InputText.vue';

    const props = defineProps({
        album: {
            type: Object,
            required: true
        }
    });

    const showModal = ref(false);
    const form = useForm({
        confirm_name: '',
    });

    const submit = () => {
        form.delete(route('album.destroy', props.album.id), {
            onSuccess: () => {
                form.reset();
                showModal.value = false;
                toast.error('You have deleted an album.');
            }
        });
    };
</script>

