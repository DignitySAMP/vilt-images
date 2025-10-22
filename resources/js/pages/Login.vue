<template>

    <Layout tab="Login">
        <div class="w-full h-full grid grid-cols-1 lg:grid-cols-2 gap-4">

            <div class="bg-white dark:bg-stone-800 min-h-196 rounded p-6 flex flex-col justify-center items-center">
                <form @submit.prevent="submit" class="flex flex-col gap-4 w-full lg:px-8">
                    <span class="w-fit text-lg text-indigo-500 dark:text-indigo-400 font-bold">
                        Authenticate
                    </span>
                    
                    <div class="w-full">
                        <InputText
                            id="email" 
                            name="email" 
                            label="E-mail address"
                            type="email" 
                            placeholder="your@email.com"
                            autocomplete="email"
                            v-model="form.email"
                            :errors="form.errors.email"
                        />
                    </div>
                    <div class="w-full">
                        <InputText
                            id="empasswordail" 
                            name="password" 
                            label="Password"
                            type="password" 
                            placeholder="***"
                            autocomplete="password"
                            v-model="form.password"
                            :errors="form.errors.password"
                        />
                    </div>

                    <div class="w-full flex items-center gap-4">
                        <input 
                            id="remember"
                            name="remember"
                            v-model="form.remember"
                            type="checkbox"
                            class="w-4 h-4 bg-stone-50 dark:bg-stone-700 border border-stone-200 dark:border-stone-600 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 accent-sky-800 dark:accent-sky-600 active:accent-sky-900 transition duration-300"
                        />

                        <label for="remember" class="text-sm text-stone-700 dark:text-stone-300">
                            Remember me?
                        </label>
                    </div>

                    <InputButton
                        :processing="form.processing"
                        :icon="IconClick"
                        type="submit"
                    >
                        Login
                    </InputButton>
                
                    <div class="flex justify-between">
                        <span class="text-sm underline text-stone-700 dark:text-stone-300">
                            Forgot your password?
                        </span>

                        <Link :href="route('register')" class="text-sm underline text-stone-700 dark:text-stone-300">
                            Don't have an account yet?
                        </Link>
                    </div>
                </form>
            </div>

            <div class="hidden lg:flex bg-indigo-500 rounded w-full h-full flex-col justify-center items-center p-12">
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
    import IconClick from '@/icons/IconClick.vue'
    import InputText from '@/components/Form/InputText.vue';
    import InputButton from '@/components/form/InputButton.vue';

    const form = useForm({
        email: '',
        password: '',
        remember: false
    });

    const submit = () => {
        form.post(route('login'), {
            onSuccess: () => form.reset(),
            onError: (errors) => console.log(errors),
            onFinish: () => form.reset('password'),
        });
    };
</script>