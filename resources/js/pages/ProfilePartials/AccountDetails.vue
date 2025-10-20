<template>
    <div class="flex flex-col gap-2 items-center p-4 bg-stone-50 border border-white rounded-lg  hover:shadow-md cursor-pointer hover:scale-105 transition duration-300">
        <span class="w-full text-lg text-indigo-500 font-bold">
            Update Profile
        </span>
        <form @submit.prevent="submit" class="flex flex-col gap-4">
            <div class="w-full">
                <label for="nametag" class="text-sm text-stone-700">
                    Nametag
                </label>
                <input
                    id="nametag" 
                    name="nametag" 
                    v-model="form.nametag"
                    type="text" 
                    placeholder="Nametag that is visible to others"
                    class="w-full px-4 py-2 bg-stone-50 border border-stone-200 rounded text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    autocomplete="username"
                />
            </div>

            <div class="w-full">
                <label for="nametag" class="text-sm text-stone-700">
                    E-mail address
                </label>
                <input
                    id="email" 
                    name="email" 
                    v-model="form.email"
                    type="email" 
                    placeholder="your@email.com"
                    class="w-full px-4 py-2 bg-stone-50 border border-stone-200 rounded text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    autocomplete="email"
                />
            </div>



            <div class="w-full">
                <label for="nametag" class="text-sm text-stone-700">
                    New Password
                </label>
                <input
                    id="new-password" 
                    name="new-password" 
                    v-model="form.new_password"
                    type="password" 
                    placeholder="********"
                    class="w-full px-4 py-2 bg-stone-50 border border-stone-200 rounded text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    autocomplete="new-password"
                />
            </div>

            <div class="w-full">
                <label for="nametag" class="text-sm text-stone-700">
                    Confirm New Password
                </label>
                <input
                    id="confirm-new-password" 
                    name="confirm-new-password" 
                    v-model="form.confirm_new_password"
                    type="password" 
                    placeholder="********"
                    class="w-full px-4 py-2 bg-stone-50 border border-stone-200 rounded text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    autocomplete="confirm-new-password"
                />
            </div>

            <div class="w-full">
                <label for="nametag" class="text-sm text-stone-700">
                    Current Password
                </label>
                <input
                    id="current-password" 
                    name="current-password" 
                    v-model="form.current_password"
                    type="password" 
                    placeholder="********"
                    class="w-full px-4 py-2 bg-stone-50 border border-stone-200 rounded text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    autocomplete="current-password"
                />
            </div>

            <button type="submit" class="flex justify-between items-center w-full gap-6 bg-indigo-500 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-600 transition duration-200 cursor-pointer">
                <IconLoadingAnimated v-if="form.processing"/>
                <IconClick v-else/>

                <span>
                    Update Profile
                </span>
            </button>
        </form>
    </div>
</template>
<script setup lang="js">
    import { useForm } from '@inertiajs/vue3';

    import IconClick from '@/icons/IconClick.vue'
    import IconLoadingAnimated from '@/icons/IconLoadingAnimated.vue';

    const form = useForm({
        nametag: '',
        email: '',
        new_password: '',
        confirm_new_password: '',
        current_password: ''
    });

    const submit = () => {}
</script>