<template>
    <Layout tab="Albums">
        <div class="w-full h-full flex flex-col justify-center items-center">
            <form 
                @submit.prevent="submit" 
                class="w-full p-8 bg-white text-indigo-800 rounded-md flex flex-col gap-4"
            >
                <span class="w-fit text-lg text-indigo-500 font-bold">
                    Edit album
                </span>

                <div class="w-full">
                    <InputText 
                        label="Album name"
                        id="name"
                        name="name"
                        type="text"
                        placeholder="Enter album name"
                        v-model="form.name"
                        :errors="form.errors.name"
                    />
                </div>

                <div class="w-full">
                    <InputText 
                        label="Description"
                        id="description"
                        name="description"
                        type="text"
                        placeholder="Enter album description"
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
                        Update album
                    </button>
                    <Link 
                        :href="route('album.show', usePage().props.album.id)"
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

    const form = useForm({
        name: usePage().props.album.name,
        description: usePage().props.album.description,
    });

    const submit = () => {
        form.put(route('album.update', usePage().props.album.id));
    };
</script>

