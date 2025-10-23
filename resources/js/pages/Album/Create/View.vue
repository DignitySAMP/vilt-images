<template>
    <Layout tab="Albums"  title="Create Album" description="Create a new album to store images in.">
        <div class="w-full h-full flex flex-col justify-center items-center">
            <form 
                @submit.prevent="submit" 
                class="w-full p-8 bg-white dark:bg-stone-800 text-indigo-800 dark:text-indigo-300 rounded-md flex flex-col gap-4"
            >
                <span class="w-fit text-lg text-indigo-500 dark:text-indigo-400 font-bold">
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

                <div>
                    <InputCheckbox
                        name="is_hidden"
                        label="Make album private"
                        v-model="form.is_hidden"
                    />
                </div>

                <div class="flex flex-col lg:flex-row w-full lg:justify-end gap-2">
                    <InputButton
                        :processing="form.processing"
                        type="submit"
                    >
                        Create album
                    </InputButton>

                    <InputLink
                        :href="route('album.index')"
                        :icon="IconReturn"
                        colors="bg-slate-500 hover:bg-slate-600 text-white"
                    >
                        Cancel
                    </InputLink>
                </div>
            </form>
        </div>
    </Layout>
</template>
<script setup lang="js">
    import { useForm } from '@inertiajs/vue3';
    
    import Layout from '@/layouts/Layout.vue';
    import InputText from '@/components/form/InputText.vue';
    import InputCheckbox from '@/components/form/InputCheckbox.vue';
    import InputButton from '@/components/form/InputButton.vue';
    import InputLink from '@/components/form/InputLink.vue';
    import IconReturn from '@/icons/IconReturn.vue';

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

