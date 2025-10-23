<template>
    <Layout tab="Albums"  title="Edit Album" description="Edit an existing album.">
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

                <div>
                    <InputCheckbox
                        name="is_hidden"
                        label="Make album private"
                        v-model="form.is_hidden"
                    />
                </div>

                <div class="flex flex-wrap sm:flex-nowrap gap-2 w-full justify-end">
                    <InputButton
                        :processing="form.processing"
                        type="submit"
                    >
                        Update album
                    </InputButton>

                    <InputLink
                        :href="route('album.show', usePage().props.album.id)"
                        :icon="IconReturn"
                        colors="bg-slate-500 hover:bg-slate-600 text-white"
                    >
                        Cancel
                    </InputLink>
                </div>
            </form>

            <DeleteAlbum :album="usePage().props.album" class="mt-4" />
        </div>
    </Layout>
</template>
<script setup lang="js">
    import { useForm, usePage } from '@inertiajs/vue3';
    import { toast } from 'vue3-toastify'

    import Layout from '@/layouts/Layout.vue';
    import InputText from '@/components/form/InputText.vue';
    import InputCheckbox from '@/components/form/InputCheckbox.vue';
    import DeleteAlbum from '@/pages/Album/Edit/Partials/DeleteAlbum.vue';

    import InputButton from '@/components/form/InputButton.vue'
    import InputLink from '@/components/form/InputLink.vue';
    import IconReturn from '@/icons/IconReturn.vue'

    const form = useForm({
        name: usePage().props.album.name,
        description: usePage().props.album.description,
        is_hidden: usePage().props.album.is_hidden === 1 ? true : false
    });

    const submit = () => {
        form.patch(route('album.update', usePage().props.album.id), {
            onSuccess: () => {
                form.reset();
                toast.warning('You have edited an album.');
            }
        });
    };
</script>

