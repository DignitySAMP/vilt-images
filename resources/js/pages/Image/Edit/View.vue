<template>
    <Layout tab="Public">
        <div class="w-full h-full flex flex-col justify-center items-center p-8 bg-white dark:bg-stone-800">
            <form 
                @submit.prevent="submit" 
                class="w-full text-indigo-800 dark:text-indigo-300 rounded-md flex flex-col gap-4"
            >
                <span class="w-fit text-lg text-indigo-500 dark:text-indigo-400 font-bold">
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
                        label="Name"
                        id="name"
                        name="name"
                        type="text"
                        placeholder="Enter image name"
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
                        placeholder="Enter image description"
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
                        Make image private
                    </label>
                </div>


                <div class="w-full">
                    <label for="album_id" class="text-sm" :class="form.errors.album_id ? 'text-red-500' : 'text-stone-700 dark:text-stone-300'">
                        Album
                    </label>
                    <select 
                        id="album_id"
                        v-model="form.album_id"
                        class="w-full px-4 py-2 bg-stone-50 dark:bg-stone-700 dark:text-stone-200 border rounded text-sm focus:outline-none focus:ring-2"
                        :class="form.errors.album_id ? 'border-red-500 focus:ring-red-600' : 'border-stone-200 dark:border-stone-600 focus:ring-indigo-500'"
                    >
                        <option :value="null">No album</option>
                        <option v-for="album in usePage().props.albums" :key="album.id" :value="album.id">
                            {{ album.name }}
                        </option>
                    </select>
                    <span v-if="form.errors.album_id" class="text-sm text-red-500">
                        {{ form.errors.album_id }}
                    </span>
                </div>

                <div class="flex flex-wrap sm:flex-nowrap gap-2 w-full justify-end">
                    <InputButton
                        :processing="form.processing"
                        :icon="IconClick"
                        type="submit"
                        colors="bg-indigo-600 hover:bg-indigo-500 text-white disabled:bg-indigo-300"
                    >
                        Update image
                    </InputButton>
                    
                    <Link 
                        :href="route('image.show', usePage().props.image.id)"
                        class="flex  gap-6 w-full lg:w-fit bg-slate-500 px-4 py-2 text-white text-center rounded hover:bg-slate-400 cursor-pointer"
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

            <DeleteImage class="mt-4" :image="usePage().props.image" />
        </div>
    </Layout>
</template>
<script setup lang="js">
    import { useForm, usePage, Link } from '@inertiajs/vue3';
    
    import Layout from '@/layouts/Layout.vue';
    import InputText from '@/components/form/InputText.vue';
    import InputButton from '@/components/form/InputButton.vue';
    import AppImage from '@/components/AppImage.vue';
    import DeleteImage from '@/pages/Image/Edit/Partials/DeleteImage.vue';

    import IconClick from '@/icons/IconClick.vue'
    import IconReturn from '@/icons/IconReturn.vue'


    const form = useForm({
        name: usePage().props.image.name,
        description: usePage().props.image.description,
        album_id: usePage().props.image.album_id || null,
        is_hidden: usePage().props.image.is_hidden === 1 ? true : false
    });

    const submit = () => {
        form.patch(route('image.update', usePage().props.image.id));
    };
</script>

