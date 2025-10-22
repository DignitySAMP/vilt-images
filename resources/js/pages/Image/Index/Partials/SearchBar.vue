<template>
    <div class="grid grid-cols-1 lg:grid-cols-[auto_auto_1fr_auto] gap-4 items-center bg-white dark:bg-stone-800 rounded-md p-4 border border-stone-200 dark:border-stone-700">
        <button
            class="flex gap-6 items-center bg-rose-500 text-white text-sm px-4 py-2 rounded-md hover:bg-rose-600 transition duration-200 cursor-pointer"
            @click="handleReset"
        >
            <IconFilterRemove/>
            Reset Filters
        </button>

        <select 
            v-model="localFilters.sort"
            @change="handleSearch"
            class="bg-slate-50 dark:bg-stone-700 text-sm rounded-md w-full lg:w-fit border border-slate-300 dark:border-stone-600 text-slate-700 dark:text-stone-200 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
            <option value="latest">Sort by latest</option>
            <option value="oldest">Sort by oldest</option>
            <option value="largest">Sort by largest file size</option>
            <option value="smallest">Sort by smallest file size</option>
        </select>

        <div class="w-full text-indigo-800 dark:text-indigo-400">
            <div class="flex w-full items-center">
                <select 
                    v-model="localFilters.search_type"
                    class="bg-indigo-50 dark:bg-stone-700 text-sm border rounded-l-md border-indigo-300 dark:border-stone-600 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="author">Author</option>
                    <option value="name">Name</option>
                    <option value="description">Description</option>
                </select>
                <div class="flex border-l-0 w-full border-indigo-200 dark:border-stone-600 rounded-r-md border items-center bg-stone-50 dark:bg-stone-700 dark:text-stone-200 pr-2">
                    <input
                        v-model="localFilters.search"
                        type="text" 
                        placeholder="Enter search term..."
                        class="mr-2 w-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-transparent"
                        @keyup.enter="handleSearch"
                    />
                    <IconSearch />
                </div>
            </div>
        </div>

        <button 
            @click="handleSearch"
            class="flex items-center w-full gap-6 bg-indigo-500 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-600 transition duration-200 cursor-pointer"
        >
            <IconClick/>
            <span>Search</span>
        </button>
    </div>
</template>

<script setup lang="js">
    import { ref, watch } from 'vue';
    import { router } from '@inertiajs/vue3';
    import IconClick from '@/icons/IconClick.vue';
    import IconFilterRemove from '@/icons/IconFilterRemove.vue';
    import IconSearch from '@/icons/IconSearch.vue';

    const props = defineProps({
        filters: {
            type: Object,
            default: () => ({})
        }
    });

    const localFilters = ref({
        search: props.filters.search || '',
        search_type: props.filters.search_type || 'name',
        sort: props.filters.sort || 'latest'
    });

    watch(() => props.filters, (newFilters) => {
        localFilters.value = {
            search: newFilters.search || '',
            search_type: newFilters.search_type || 'name',
            sort: newFilters.sort || 'latest'
        };
    }, { deep: true });

    const handleSearch = () => {
        router.get(window.location.pathname, localFilters.value, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const handleReset = () => {
        localFilters.value = {
            search: '',
            search_type: 'name',
            sort: 'latest'
        };
        router.get(window.location.pathname, {}, {
            preserveState: true,
            preserveScroll: true,
        });
    };
</script>

