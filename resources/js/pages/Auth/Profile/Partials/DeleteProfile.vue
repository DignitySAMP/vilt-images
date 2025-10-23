<template>
    <Modal :show="props.show" @close="emit('close')">
        <h3 class="text-xl font-bold text-red-700 dark:text-red-500 mb-4">Confirm Account Deletion</h3>
        <p class="text-stone-700 dark:text-stone-300 mb-4">
            This action cannot be undone. All your images and albums will be deleted.
        </p>
        <form @submit.prevent="submit" class="flex flex-col gap-4">
            <InputText
                label="Email Confirmation"
                name="confirm_email"
                type="email"
                placeholder="Enter your email"
                v-model="form.confirm_email"
                :errors="form.errors.confirm_email"
            />
            <div class="flex gap-2 justify-end">
                <InputButton
                    colors="bg-slate-500 hover:bg-slate-600 text-white"
                    :icon="IconReturn"
                    type="button"
                    @click="emit('close')"
                >
                    Cancel
                </InputButton>
                <InputButton
                    colors="bg-red-500 hover:bg-red-600 text-white"
                    :processing="form.processing"
                    type="submit"
                >
                    {{ form.processing ? 'Deleting...' : 'Delete Account' }}
                </InputButton>
            </div>
        </form>
    </Modal>
</template>

<script setup lang="js">
    import { useForm } from '@inertiajs/vue3';
    import { toast } from 'vue3-toastify'
    import Modal from '@/components/Modal.vue';
    import InputButton from '@/components/form/InputButton.vue';
    import InputText from '@/components/form/InputText.vue';
    import IconReturn from '@/icons/IconReturn.vue';

    const props = defineProps({
        show: {
            type: Boolean,
            required: true
        }
    });
    const emit = defineEmits(['close']);

    const form = useForm({
        confirm_email: '',
    });

    const submit = () => {
        form.delete(route('profile.destroy'), {
            onSuccess: () => {
                form.reset();
                toast.error('You have deleted your account. All of your related images and albums are deleted.');
            }
        });
    };
</script>

