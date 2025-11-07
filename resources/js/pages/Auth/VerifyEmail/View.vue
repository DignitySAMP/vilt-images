<template>

    <Layout tab="Verify Email" title="Verify Email" description="Confirm your email address to access the application.">
        <div class="w-full h-full grid grid-cols-1 lg:grid-cols-2 gap-4">

            <div class="bg-white dark:bg-stone-800 min-h-196 rounded p-6 flex flex-col justify-center items-center">
                <div class="flex flex-col gap-4 w-full lg:px-8">
                    <span
                        v-if="status === 'verification-link-sent'"
                        class="p-2 border border-emerald-200 bg-emerald-100 text-emerald-800 rounded w-full text-sm"
                    >
                        A new verification link has been sent to your email address.
                    </span>

                    <span class="w-fit text-lg text-indigo-500 dark:text-indigo-400 font-bold">
                        Verify your email
                    </span>

                    <div class="flex flex-col gap-2 text-sm text-stone-600 dark:text-stone-300">
                        <span>
                            Thanks for signing up! Before continuing, please check your inbox for a verification link.
                        </span>

                        <span>
                            If you did not receive the email, you may request another verification email below.
                        </span>
                    </div>

                    <InputButton
                        :processing="verificationForm.processing"
                        :icon="IconClick"
                        type="button"
                        class="lg:w-full"
                        @click="requestVerification"
                    >
                        Resend verification email
                    </InputButton>

                    <button
                        type="button"
                        class="self-end text-sm underline text-stone-700 dark:text-stone-300"
                        @click="submitLogout"
                        :disabled="logoutForm.processing"
                    >
                        Log out
                    </button>
                </div>
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
    import { useForm, usePage } from '@inertiajs/vue3';

    import Layout from '@/layouts/Layout.vue'
    import InputButton from '@/components/form/InputButton.vue';
    import IconClick from '@/icons/IconClick.vue'

    const props = defineProps({
        status: String,
    });

    const verificationForm = useForm({});
    const logoutForm = useForm({});

    const requestVerification = () => verificationForm.post(route('verification.send'));
    const submitLogout = () => logoutForm.post(route('logout'));
</script>

