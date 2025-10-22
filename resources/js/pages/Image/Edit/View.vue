<template>
    <Layout tab="Public">
        <div class="w-full h-full flex flex-col justify-center items-center p-8 bg-white">
            <form 
                @submit.prevent="submit" 
                class="w-full  text-indigo-800 rounded-md flex flex-col gap-4"
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
                        class="w-4 h-4 bg-stone-50 border border-stone-200 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 accent-sky-800 active:accent-sky-900 transition duration-300"
                    />

                    <label for="is_hidden" class="text-sm text-stone-700">
                        Make image private
                    </label>
                </div>


                <div class="w-full">
                    <label for="album_id" class="text-sm" :class="form.errors.album_id ? 'text-red-500' : 'text-stone-700'">
                        Album
                    </label>
                    <select 
                        id="album_id"
                        v-model="form.album_id"
                        class="w-full px-4 py-2 bg-stone-50 border rounded text-sm focus:outline-none focus:ring-2"
                        :class="form.errors.album_id ? 'border-red-500 focus:ring-red-600' : 'border-stone-200 focus:ring-indigo-500'"
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

                <div class="flex w-full gap-4">
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="w-full flex justify-between bg-indigo-600 px-4 py-2 text-white text-center rounded hover:bg-indigo-500 cursor-pointer disabled:bg-indigo-300"
                    >

                        <span class="w-6 h-6">
                            <IconClick />
                        </span>

                        <span>
                            Update image
                        </span>
                    </button>

                    <Link 
                        :href="route('image.show', usePage().props.image.id)"
                        class="flex justify-between w-full bg-slate-500 px-4 py-2 text-white text-center rounded hover:bg-slate-400 cursor-pointer"
                    >
                        <IconReturn/>
                        <span>
                            Cancel
                        </span>
                    </Link>
                </div>
            </form>

            <div class="mt-4 flex gap-4 w-full">
                <div
                    @click="showDeleteModal = !showDeleteModal" 
                    class="flex  w-fit justify-between bg-red-600 px-4 py-2 text-white text-center rounded hover:bg-red-500 cursor-pointer disabled:bg-red-300">
                    <IconTrash/>
                    <span>
                        I want to delete this image
                    </span>
                </div>       

            </div>

            <DeletePartial v-if="showDeleteModal" class="mt-4" :image="usePage().props.image"/>
        </div>
    </Layout>
</template>
<script setup lang="js">
    import { ref } from 'vue';
    import { useForm, usePage, Link } from '@inertiajs/vue3';
    
    import Layout from '@/layouts/Layout.vue';
    import InputText from '@/components/form/InputText.vue';
    import AppImage from '@/components/AppImage.vue';
    
    import DeletePartial from '@/pages/Image/Edit/Partials/DeletePartial.vue';
    const showDeleteModal = ref(false);

    import IconClick from '@/icons/IconClick.vue'
    import IconTrash from '@/icons/IconTrash.vue'
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

