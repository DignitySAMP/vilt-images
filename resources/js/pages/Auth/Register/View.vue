<template>

    <Layout tab="Login"  title="Register" description="Register a new account to access the application.">
        
        <div class="w-full h-full grid grid-cols-1 lg:grid-cols-2 gap-4">

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

            <div class="bg-white dark:bg-stone-800 min-h-196 rounded p-6 flex flex-col justify-center items-center">

                <form @submit.prevent="submit" class="flex flex-col gap-4 w-full lg:px-8">
                    <span class="w-fit text-lg text-indigo-500 dark:text-indigo-400 font-bold">
                        Registration
                    </span>
                    
                    <div class="w-full flex flex-col gap-2">
                        <InputText 
                            label="Nametag"
                            id="name" 
                            name="name" 
                            type="text" 
                            placeholder="Nametag that is visible to others"
                            autocomplete="name"
                            v-model="form.name"
                            :errors="form.errors.name"
                        />
                        <span class="text-sm text-stone-400 dark:text-stone-500">
                            Refrain from using any real life references in your nametag, since it will be visible publically.
                        </span>
                    </div>

                    <div class="w-full">
                        <InputText 
                            label="E-mail address"
                            id="email" 
                            name="email" 
                            type="email" 
                            placeholder="your@email.com"
                            autocomplete="email"
                            v-model="form.email"
                            :errors="form.errors.email"
                        />
                    </div>

                    <div class="w-full flex flex-col gap-2">
                        <InputText 
                            label="Desired password"
                            id="password" 
                            name="password" 
                            type="password" 
                            placeholder="***"
                            autocomplete="password"
                            v-model="form.password"
                            :errors="form.errors.password"
                        />

                        <span class="text-sm text-stone-400 dark:text-stone-500">
                            At least 8 characters, one lowercase, one uppercase, one number and one symbol are required.
                        </span>
                    </div>

                    <div class="w-full">
                        <InputText 
                            label="Confirm password"
                            id="password_confirmation" 
                            name="password_confirmation" 
                            type="password" 
                            placeholder="***"
                            autocomplete="password_confirmation"
                            v-model="form.password_confirmation"
                            :errors="form.errors.password_confirmation"
                        />
                    </div>

                    <InputButton
                        :processing="form.processing"
                        :icon="IconClick"
                        type="submit"
                    >
                        Register
                    </InputButton>

                    <div class="flex w-full justify-end">
                        <Link :href="route('login')" class="text-sm underline text-stone-700 dark:text-stone-300">
                            Already have an account?
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </Layout>

</template>
<script setup lang="js">
    import { useForm, usePage, Link } from '@inertiajs/vue3';
    import { toast } from 'vue3-toastify';

    import Layout from '@/layouts/Layout.vue'
    
    import InputText from '@/components/Form/InputText.vue';
    import InputButton from '@/components/form/InputButton.vue';
    
    import IconClick from '@/icons/IconClick.vue'

    const form = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
    });

    const submit = () => {
        form.post(route('register'), {
            onSuccess: () => {
                form.reset();
                toast.info('You have registered.');
            },
            onError: (errors) => console.log(errors),
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    };
</script>