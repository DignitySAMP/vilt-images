<template>
    <Modal :show="props.show" @close="emit('close')">
        <h3 class="text-xl font-bold text-red-700 dark:text-red-500 mb-4">Confirm Account Deletion</h3>
        <p class="text-stone-700 dark:text-stone-300 mb-4">
            This action cannot be undone. All your images and albums will be deleted.
        </p>
        <form @submit.prevent="submit" class="flex flex-col gap-4">
            <div class="w-full">
                <label for="confirm_email" class="text-sm text-stone-700 dark:text-stone-300">
                    Email Confirmation
                </label>
                <input
                    id="confirm_email" 
                    name="confirm_email" 
                    v-model="form.confirm_email"
                    type="email" 
                    placeholder="Enter your email"
                    class="w-full px-4 py-2 bg-stone-50 dark:bg-stone-700 dark:text-stone-200 border border-stone-200 dark:border-stone-600 rounded text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />
                <span v-if="form.errors.confirm_email" class="text-sm text-red-500">{{ form.errors.confirm_email }}</span>
            </div>
            <div class="flex gap-2 justify-end">
                <button 
                    type="button"
                    @click="emit('close')"
                    class="px-4 py-2 bg-slate-500 text-white text-sm rounded-md hover:bg-slate-600 transition duration-200"
                >
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="px-4 py-2 bg-red-500 text-white text-sm rounded-md hover:bg-red-600 transition duration-200"
                    :disabled="form.processing"
                >
                    {{ form.processing ? 'Deleting...' : 'Delete Account' }}
                </button>
            </div>
        </form>
    </Modal>
</template>

<script setup lang="js">
    import { useForm } from '@inertiajs/vue3';
    import Modal from '@/components/Modal.vue';

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
              }
          });
      };
</script>

