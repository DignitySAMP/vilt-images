<template>
    <Layout tab="Albums">
        <div class="w-full h-full flex flex-col justify-center items-center p-8 bg-white dark:bg-stone-800">
            <form 
                @submit.prevent="submit" 
                class="w-full text-indigo-800 dark:text-indigo-300 rounded-md flex flex-col gap-4"
            >
                <span class="w-fit text-lg text-indigo-500 dark:text-indigo-400 font-bold">
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

                <div class="w-full flex items-center gap-2">
                    <input 
                        id="is_hidden"
                        name="is_hidden"
                        v-model="form.is_hidden"
                        type="checkbox"
                        class="w-4 h-4 bg-stone-50 dark:bg-stone-700 border border-stone-200 dark:border-stone-600 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 accent-sky-800 dark:accent-sky-600 active:accent-sky-900 transition duration-300"
                    />

                    <label for="is_hidden" class="text-sm text-stone-700 dark:text-stone-300">
                        Make album private
                    </label>
                </div>

                <div class="flex flex-wrap sm:flex-nowrap gap-2 w-full justify-end">
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="flex gap-6 w-full lg:w-fit bg-indigo-600 px-4 py-2 text-white text-center rounded hover:bg-indigo-500 cursor-pointer disabled:bg-indigo-300"
                    >
                        <span class="w-6 h-6">
                            <IconClick/>
                        </span>
                        <span>
                            Update album
                        </span>
                    </button>
                    <Link 
                        :href="route('album.show', usePage().props.album.id)"
                        class="flex gap-6 w-full lg:w-fit bg-slate-500 px-4 py-2 text-white text-center rounded hover:bg-slate-400 cursor-pointer"
                    >
                    <span class="w-6 h-6">
                            <IconReturn/>
                        </span>
                        <span>
                            Cancel
                        </span>
                    </Link>
                </div>
            </form>

            <DeleteAlbum :album="usePage().props.album" class="mt-4" />
        </div>
    </Layout>
</template>
<script setup lang="js">
    import { useForm, usePage, Link } from '@inertiajs/vue3';
    
    import Layout from '@/layouts/Layout.vue';
    import InputText from '@/components/form/InputText.vue';
    import DeleteAlbum from '@/pages/Album/Edit/Partials/DeleteAlbum.vue';

    import IconClick from '@/icons/IconClick.vue'
    import IconReturn from '@/icons/IconReturn.vue'

    const form = useForm({
        name: usePage().props.album.name,
        description: usePage().props.album.description,
        is_hidden: usePage().props.album.is_hidden === 1 ? true : false
    });

    const submit = () => {
        form.patch(route('album.update', usePage().props.album.id));
    };
</script>

