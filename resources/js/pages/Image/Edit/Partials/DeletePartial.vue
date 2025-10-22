<template>
    <div class="border border-red-200 text-red-800 p-4 w-full rounded flex flex-col gap-2">

        <span class="text-lg font-bold text-red-600">
            Delete image
        </span>

        <span>
            As a precaution to avoid potential mistakes, please confirm the name of the image in the field.
        </span>
        <form @submit.prevent="submit" class="flex gap-4">
            <InputText
                label=""
                name="confirm_name"
                id="confirm_name"
                v-model="form.confirm_name"
                :errors="form.errors.confirm_name"
                placeholder="Confirm the name"
            />

            <button 
                :disabled="form.processing" 
                type="submit" 
                class="h-fit flex justify-between items-center w-full max-w-48 gap-6 bg-red-500 text-white text-sm px-4 py-2 rounded-md hover:bg-red-600 transition duration-200 cursor-pointer"
                :class="!form.errors.confirm_name?.length ? 'send-end' : ''"    
            >
                <IconLoadingAnimated v-if="form.processing"/>
                <IconClick v-else/>
                <span>Confirm deletion</span>
            </button>
            
        </form>
    </div>

</template>
<script setup>
    import InputText from '@/components/form/InputText.vue'
    import { useForm } from '@inertiajs/vue3';

    import IconLoadingAnimated from '@/icons/IconLoadingAnimated.vue'
    import IconClick from '@/icons/IconClick.vue'

    const props = defineProps({
        image: {
            type: Object,
            required: true,
        }
    });


    const form = useForm({
        confirm_name: ''
    });

    const submit = () => {
        form.delete(route('image.destroy', props.image), {
            onSuccess: () => {

            },
            onError: (error) => console.error(error),
            onfinish: () => form.reset()
        })
    }
</script>