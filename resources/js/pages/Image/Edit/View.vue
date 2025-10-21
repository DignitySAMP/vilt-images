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

                <div class="w-full">
                    <label class="text-sm text-stone-700">Album</label>
                    <select 
                        v-model="form.album_id"
                        class="w-full px-4 py-2 bg-stone-50 border border-stone-200 rounded text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                        <option :value="null">No album</option>
                        <option v-for="album in usePage().props.albums" :key="album.id" :value="album.id">
                            {{ album.name }}
                        </option>
                    </select>
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
        album_id: usePage().props.image.album_id,
    });

    const submit = () => {
        form.patch(route('image.update', usePage().props.image.id));
    };
</script>

