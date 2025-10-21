<template>

    <Layout>
        
        <div class="w-full h-full grid grid-cols-2 gap-4">

            <div class="bg-indigo-500 rounded w-full h-full flex flex-col justify-center items-center p-12">

                <span class="w-32 h-32 text-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h8v2H5v14h14v-7h2v7q0 .825-.587 1.413T19 21zm1-4h12l-3.75-5l-3 4L9 13zm12-7V5.825L16.4 7.4L15 6l4-4l4 4l-1.4 1.4L20 5.825V10z"/></svg>
                </span>

                <div class="flex flex-col gap-1 w-fit mt-8">
                    <span class="text-gray-300 italic text-sm">
                        “{{ usePage().props.quote.message }}”
                    </span>

                    <span class="text-gray-100 italic text-sm self-end">
                        {{ usePage().props.quote.author }}
                    </span>
                </div>
            </div>

            <div class="bg-white rounded p-6">

                <form @submit.prevent="submit" class="flex flex-col gap-4">
                    <span class="w-fit text-lg text-indigo-500 font-bold">
                        Registration
                    </span>
                    
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

                    <button type="submit" class="flex justify-between items-center w-full gap-6 bg-indigo-500 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-600 transition duration-200 cursor-pointer">
                        <IconLoadingAnimated v-if="form.processing"/>
                        <IconClick v-else/>

                        <span>
                            Register
                        </span>
                    </button>

                    <div class="flex w-full justify-end">
                        <Link :href="route('login')" class="text-sm underline text-stone-700">
                            Already have an account?
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </Layout>

</template>
<script setup lang="js">
    import Layout from '@/layouts/Layout.vue'
    import { useForm, usePage, Link } from '@inertiajs/vue3';
    import IconLoadingAnimated from '@/icons/IconLoadingAnimated.vue'
    import IconClick from '@/icons/IconClick.vue'

    const form = useForm({
        nametag: '',
        email: '',
        new_password: '',
        confirm_new_password: '',
        current_password: ''
    });


    const submit = () => {};
</script>