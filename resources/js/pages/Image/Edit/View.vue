<template>
    <Layout tab="Public">
        <div class="w-full h-full flex flex-col justify-center items-center">
            <form 
                @submit.prevent="submit" 
                class="w-full p-8 bg-white text-indigo-800 rounded-md flex flex-col gap-4"
            >
                <span class="w-fit text-lg text-indigo-500 font-bold">
                    Edit image
                </span>

                <div class="w-full">
                    <AppImage 
                        :url="usePage().props.image.url"
                        :alt="usePage().props.image.file_name"
                        class="w-full max-h-96"
                    />
                </div>

                <div class="w-full">
                    <InputText 
                        label="Description"
                        id="description"
                        name="description"
                        type="text"
                        placeholder="Enter image description"
                        v-model="form.description"
                        :errors="form.errors.description"
                    />
                </div>

                <div class="flex gap-2">
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="flex-1 bg-indigo-600 px-4 py-2 text-white text-center rounded hover:bg-indigo-500 cursor-pointer disabled:bg-indigo-300"
                    >
                        Update image
                    </button>
                    <Link 
                        :href="route('image.show', usePage().props.image.id)"
                        class="flex-1 bg-slate-500 px-4 py-2 text-white text-center rounded hover:bg-slate-400 cursor-pointer"
                    >
                        Cancel
                    </Link>
                </div>
            </form>
        </div>
    </Layout>
</template>
<script setup lang="js">
    import { useForm, usePage, Link } from '@inertiajs/vue3';
    
    import Layout from '@/layouts/Layout.vue';
    import InputText from '@/components/form/InputText.vue';
    import AppImage from '@/components/AppImage.vue';

    const form = useForm({
        description: usePage().props.image.description,
    });

    const submit = () => {
        form.put(route('image.update', usePage().props.image.id));
    };
</script>

