<template>

    <div class="flex py-2 justify-center items-center bg-white dark:bg-stone-800 rounded">
        <div class="select-none flex flex-wrap items-center justify-center gap-2 text-white">
            <template
                v-model="props.links"
                v-for="(link, index) in links.links"
                :key="index"
            >
                <div
                    v-if="link.url === null"
                    class="px-4 py-3 mr-1 text-sm leading-4 text-gray-400 dark:text-gray-500 border border-stone-200 dark:border-stone-700 bg-stone-100 dark:bg-stone-900 rounded"
                >
                    <span v-html="link.label"></span>
                </div>
                <div v-else>
                    <Link as="button"
                        class="px-4 py-3 mr-1 text-sm leading-4 rounded border border-indigo-100 dark:border-indigo-900 transition duration-300 cursor-pointer"
                        :class="link.active == true ? 
                            'bg-indigo-500 text-white hover:bg-indigo-400' : 
                            'bg-white dark:bg-stone-800 text-indigo-700 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-stone-700'
                        "
                        :href="link.url"
                        v-html="link.label"
                    />
                </div>
            </template>
        </div>
    </div>
</template>

<script setup lang="js">
	import { Link } from '@inertiajs/vue3';
    
	// Important: the prop here must be the full laravel pagination object, not just the links
	const props = defineProps({
		links: {
			type: Object,
			required: true,
		},
	});
</script>