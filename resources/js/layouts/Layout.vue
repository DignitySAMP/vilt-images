<template>
    <Head>
        <title>{{ usePage().props.app.name }} | {{ props.title }}</title>
        <meta head-key="description" name="description" :content="props.description" />
        <link rel="icon" type="image/svg+xml" href="/images/favicon.svg" />
    </Head>
    <div class="w-screen h-screen bg-stone-200 dark:bg-stone-900">
        <div class="container mx-auto pt-2 md:pt-4">
            
            <Header :active_tab="tab"/>

            <div class="mt-4 flex flex-col gap-4">
                <slot/>
            </div>
        </div>        
    </div>

</template>
<script setup>
    import { usePage, Head} from '@inertiajs/vue3'
    import Header from '@/layouts/Partials/Header.vue'

    const props = defineProps({
        tab: {
            type: String,
            default: 'Home',
        },
        title: {
            type: String,
            required: true,
        },
        description: {
            type: String,
            required: true
        }
    })
</script>