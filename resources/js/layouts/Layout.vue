<template>

    <div class="w-screen h-screen bg-stone-200">
        <div class="container mx-auto pt-4">
            
            <Header/>

            <div class="mt-4 flex flex-col gap-4">
                <slot/>
            </div>
        </div>        
    </div>

</template>
<script setup>
    import Header from '@/layouts/Partials/Header.vue'
</script>