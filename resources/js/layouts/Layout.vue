<template>

    <div class="w-screen h-screen bg-stone-200">
        <div class="container mx-auto pt-2 md:pt-4">
            
            <Header :active_tab="tab"/>

            <div class="mt-4 flex flex-col gap-4">
                <slot/>
            </div>
        </div>        
    </div>

</template>
<script setup>
    import Header from '@/layouts/Partials/Header.vue'

    const props = defineProps({
        tab: {
            type: String,
            default: 'Home',
        }
    })
</script>