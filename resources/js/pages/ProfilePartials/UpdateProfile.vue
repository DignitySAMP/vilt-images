<template>
    <div class="flex flex-col gap-2 items-center p-4 bg-stone-50 border border-white rounded-md h-fit">
        <span class="w-full text-lg text-indigo-500 font-bold">
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

            <button type="submit" class="flex justify-between items-center w-full gap-6 bg-indigo-500 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-600 transition duration-200 cursor-pointer">
                <IconLoadingAnimated v-if="form.processing"/>
                <IconClick v-else/>

                <span>
                    Update Profile
                </span>
            </button>
        </form>

        <div class="w-full border-t border-stone-200 pt-4 mt-2">
            <button 
                type="button"
                @click="showDeleteModal = true"
                class="w-full px-4 py-2 bg-red-500 text-white text-sm rounded-md hover:bg-red-600 transition duration-200"
            >
                Delete Account
            </button>
        </div>

        <DeleteProfile :show="showDeleteModal" @close="showDeleteModal = false" />
    </div>
</template>
<script setup lang="js">
    import { ref } from 'vue';
    import { useForm, usePage } from '@inertiajs/vue3';

    import IconClick from '@/icons/IconClick.vue'
    import IconLoadingAnimated from '@/icons/IconLoadingAnimated.vue';
    import DeleteProfile from '@/pages/ProfilePartials/DeleteProfile.vue';
    import InputText from '@/components/form/InputText.vue';

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
        form.patch(route('profile.update'));
    };
</script>