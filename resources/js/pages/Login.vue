<template>

    <Layout>
        
        <div class="w-full h-full grid grid-cols-2 gap-4">

            <div class="bg-white rounded p-6">

                <form @submit.prevent="submit" class="flex flex-col gap-4">
                    <span class="w-fit text-lg text-indigo-500 font-bold">
                        Authenticate
                    </span>
                    
                    <div class="w-full">
                        <label for="email" class="text-sm text-stone-700">
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
                        <label for="password" class="text-sm text-stone-700">
                            Password
                        </label>
                        <input
                            id="password" 
                            name="password" 
                            v-model="form.password"
                            type="password" 
                            placeholder="********"
                            class="w-full px-4 py-2 bg-stone-50 border border-stone-200 rounded text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            autocomplete="password"
                        />
                    </div>

                    <div class="w-full flex items-center gap-4">

                        <input 
                            id="remember"
                            name="remember"
                            v-model="form.remember"
                            type="checkbox"
                            class="w-4 h-4 bg-stone-50 border border-stone-200 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 accent-sky-800 active:accent-sky-900 transition duration-300"
                        />

                        <label for="remember" class="text-sm text-stone-700">
                            Remember me?
                        </label>
                    </div>

                    <button type="submit" class="flex justify-between items-center w-full gap-6 bg-indigo-500 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-600 transition duration-200 cursor-pointer">
                        <IconLoadingAnimated v-if="form.processing"/>
                        <IconClick v-else/>

                        <span>
                            Login
                        </span>
                    </button>
                
                    <div class="flex justify-between">
                        <span class="text-sm underline text-stone-700">
                            Forgot your password?
                        </span>

                        <Link :href="route('register')" class="text-sm underline text-stone-700">
                            Don't have an account yet?
                        </Link>
        
                    </div>
                </form>

                
            </div>

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
        </div>
    </Layout>

</template>
<script setup lang="js">
    import Layout from '@/layouts/Layout.vue'
    import { useForm, usePage, Link } from '@inertiajs/vue3';
    import IconLoadingAnimated from '@/icons/IconLoadingAnimated.vue'
    import IconClick from '@/icons/IconClick.vue'

    const form = useForm({
        email: '',
        password: '',
        remember: false
    });


    const submit = () => {};
</script>