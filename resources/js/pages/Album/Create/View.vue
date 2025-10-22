<template>
    <Layout tab="Albums">
        <div class="w-full h-full flex flex-col justify-center items-center">
            <form 
                @submit.prevent="submit" 
                class="w-full p-8 bg-white text-indigo-800 rounded-md flex flex-col gap-4"
            >
                <span class="w-fit text-lg text-indigo-500 font-bold">
                    Create new album
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

                <div class="w-full flex items-center gap-2">
                    <input 
                        id="is_hidden"
                        name="is_hidden"
                        v-model="form.is_hidden"
                        type="checkbox"
                        class="w-4 h-4 bg-stone-50 border border-stone-200 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 accent-sky-800 active:accent-sky-900 transition duration-300"
                    />
                    <label for="is_hidden" class="text-sm text-stone-700">
                        Make album private
                    </label>
                </div>

                <div class="flex gap-2">
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="flex bg-indigo-600 px-4 py-2 text-white text-center rounded hover:bg-indigo-500 cursor-pointer disabled:bg-indigo-300"
                    >
                        Create album
                    </button>
                    <Link 
                        :href="route('album.index')"
                        class="flex bg-slate-500 px-4 py-2 text-white text-center rounded hover:bg-slate-400 cursor-pointer"
                    >
                        Cancel
                    </Link>
                </div>
            </form>
        </div>
    </Layout>
</template>
<script setup lang="js">
    import { useForm, Link } from '@inertiajs/vue3';
    
    import Layout from '@/layouts/Layout.vue';
    import InputText from '@/components/form/InputText.vue';

    const form = useForm({
        name: '',
        description: '',
        is_hidden: false,
    });

    const submit = () => {
        form.post(route('album.store'), {
            onSuccess: () => form.reset(),
        });
    };
</script>

