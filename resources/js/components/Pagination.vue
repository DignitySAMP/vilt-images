<template>

    <div class="flex py-2 justify-center items-center bg-white rounded">
        <div class="select-none flex flex-wrap items-center justify-center gap-2 text-white">
            <template
                v-model="props.links"
                v-for="(link, index) in links.links"
                :key="index"
            >
                <div
                    v-if="link.url === null"
                    class="px-4 py-3 mr-1 text-sm leading-4 text-gray-400 border border-stone-200 bg-stone-100 rounded"
                >
                    <span v-html="link.label"></span>
                </div>
                <div v-else>
                    <Link as="button"
                        class="px-4 py-3 mr-1 text-sm leading-4 rounded  border border-indigo-100 transition duration-300"
                        :class="link.active == true ? 
                            'bg-indigo-500 text-white hover:bg-indigo-400' : 
                            'bg-white text-indigo-700  hover:bg-indigo-50'
                        "
                        :href="link.url"
                        v-html="link.label"
                    />
                </div>
            </template>
        </div>
    </div>
</template>

<script setup>
	import { Link } from '@inertiajs/vue3';
    
	// Important: the prop here must be the full laravel pagination object, not just the links
	const props = defineProps({
		links: {
			type: Object,
			required: true,
		},
	});
</script>