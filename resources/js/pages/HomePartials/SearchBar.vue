<template>

    <div v-if="!showFilterBar" class="flex">
        <button
            class="flex w-fit justify-between items-center bg-indigo-500 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-600 transition duration-200"
            @click="showFilterBar = true"
        >
            <IconFilter/>
            <span>
                Show filter options
            </span>
        </button>
    </div>

    <div v-else-if="showFilterBar" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center bg-white rounded-lg p-4 border border-stone-200">
    
        <div class="w-full">
            <select id="sort" class="bg-indigo-50 text-sm rounded-md w-full border border-indigo-300 text-indigo-700 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option>Sort by latest photos (public)</option>
                <option>Sort by lldest photos (public)</option>
                <option>Sort by largest file size</option>
                <option>Sort by lmallest file size</option>
            </select>
        </div>

        <div class="md:col-span-2 w-full text-indigo-800">

            <div class="flex w-full items-center">
                <select 
                    id="searchType" name="searchType"
                    class="bg-indigo-50 text-sm border rounded-l-md border-indigo-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="author">Author</option>
                    <option value="name">Name</option>
                    <option value="title">Title</option>
                    <option value="size">File size</option>
                </select>
                <div class="flex border-l-0 w-full border-indigo-200 rounded-r-md border items-center pr-2">
                    <input
                        id="searchQuery" name="searchQuery" type="text" placeholder="Enter search term..."
                        class="mr-2 w-full px-4 py-2 bg-stoe-50 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    />

                    <IconSearch />
                </div>
            </div>
        </div>

        <div class="flex items-end justify-end gap-2 h-full">
            <button
                class="flex w-full justify-between items-center bg-indigo-500 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-600 transition duration-200"
            >
                <IconClick/>
                <span>
                    Search
                </span>
            </button>
            <button
                class="flex w-full justify-between items-center bg-stone-200/50 text-stone-700 text-sm px-4 py-2 rounded-md hover:bg-stone-300/50 transition duration-200"
                @click="showFilterBar = false"
            >
                <IconFilterRemove/>
                Clear Filters
            </button>
        </div>
    </div>
</template>
<script setup>
    import { ref } from 'vue';

    import IconClick from '@/icons/IconClick.vue';
    import IconFilter from '@/icons/IconFilter.vue';
    import IconFilterRemove from '@/icons/IconFilterRemove.vue';
    import IconSearch from '@/icons/IconSearch.vue';

    const showFilterBar = ref(false);
</script>