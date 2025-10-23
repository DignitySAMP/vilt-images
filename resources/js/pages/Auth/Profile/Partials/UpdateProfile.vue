<template>
    <div class="flex flex-col gap-2 items-center p-4 bg-stone-50 dark:bg-stone-800 border border-white dark:border-stone-700 rounded-md h-fit w-full xl:w-96">
        <span class="w-full text-lg text-indigo-500 dark:text-indigo-400 font-bold">
            Update Profile
        </span>
        <form @submit.prevent="submit" class="flex flex-col gap-4 w-full">
            <InputText 
                label="Nametag"
                id="nametag"
                name="nametag"
                type="text"
                placeholder="Nametag that is visible to others"
                v-model="form.name"
                :errors="form.errors.name"
                autocomplete="username"
            />

            <InputText 
                label="E-mail address"
                id="email"
                name="email"
                type="email"
                placeholder="your@email.com"
                v-model="form.email"
                :errors="form.errors.email"
                autocomplete="email"
            />

            <InputText 
                label="New Password"
                id="new-password"
                name="new-password"
                type="password"
                placeholder="********"
                v-model="form.new_password"
                :errors="form.errors.new_password"
                autocomplete="new-password"
                
            />

            <InputText 
                label="Confirm New Password"
                id="confirm-new-password"
                name="confirm-new-password"
                type="password"
                placeholder="********"
                v-model="form.confirm_new_password"
                :errors="form.errors.confirm_new_password"
                autocomplete="new-password"
            />

            <InputText 
                label="Current Password"
                id="current-password"
                name="current-password"
                type="password"
                placeholder="********"
                v-model="form.current_password"
                :errors="form.errors.current_password"
                autocomplete="current-password"
            />

            <InputButton
                :processing="form.processing"
                :icon="IconClick"
                type="submit"
            >
                Update Profile
            </InputButton>
        </form>

        <div class="w-full border-t border-stone-200 dark:border-stone-700 pt-4 mt-2">
            <InputButton
                colors="bg-red-500 hover:bg-red-600 text-white"
                type="button"
                @click="showDeleteModal = true"
            >
                Delete Account
            </InputButton>
        </div>

        <DeleteProfile :show="showDeleteModal" @close="showDeleteModal = false" />
    </div>
</template>
<script setup lang="js">
    import { ref } from 'vue';
    import { useForm, usePage } from '@inertiajs/vue3';
    import { toast } from 'vue3-toastify'

    import IconClick from '@/icons/IconClick.vue'
    import DeleteProfile from '@/pages/Auth/Profile/Partials/DeleteProfile.vue';
    import InputText from '@/components/form/InputText.vue';
    import InputButton from '@/components/form/InputButton.vue';

    const user = usePage().props.auth.user;
    const showDeleteModal = ref(false);

    const form = useForm({
        name: user.name,
        email: user.email,
        new_password: '',
        confirm_new_password: '',
        current_password: ''
    });

    const submit = () => {
        form.patch(route('profile.update'), {
            onSuccess: () => {
                form.reset();
                toast.error('You have updated your profile.');
            }
        });
    };
</script>