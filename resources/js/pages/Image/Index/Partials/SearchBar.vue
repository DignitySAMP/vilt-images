<template>
    <div class="grid grid-cols-1 lg:grid-cols-[auto_auto_1fr_auto] gap-4 items-center bg-white dark:bg-stone-800 rounded-md p-4 border border-stone-200 dark:border-stone-700">
        <InputButton
            colors="bg-rose-500 hover:bg-rose-600 text-white"
            :icon="IconFilterRemove"
            @click="handleReset"
            type="button"
        >
            Reset Filters
        </InputButton>

        <InputSelect 
            name="search_order"
            v-model="localFilters.sort"
            @change="handleSearch"
            :options="[
                { label: 'Sort by latest', value: 'latest' },
                { label: 'Sort by oldest', value: 'oldest' },
                { label: 'Sort by largest file size' , value: 'largest' },
                { label: 'Sort by smallest file size' , value: 'smallest' },
            ]"
        />

        <div class="w-full text-indigo-800 dark:text-indigo-400">
            <div class="flex w-full items-center gap-4">
                <InputSelect 
                    name="search_type"
                    v-model="localFilters.search_type"
                    :options="[
                        { label: 'Author', value: 'author'},
                        { label: 'Name', value: 'name'},
                        { label: 'Description', value: 'description'},
                    ]"
                />
                <InputText 
                    v-model="localFilters.search"
                    name="search_term"
                    type="text" 
                    placeholder="Enter search term..."
                    @keyup.enter="handleSearch"
                />
            </div>
        </div>

        <InputButton
            @click="handleSearch"
            :icon="IconSearch"
            type="button"
        >
            Search
        </InputButton>
    </div>
</template>

<script setup lang="js">
    import { ref, watch } from 'vue';
    import { router } from '@inertiajs/vue3';
    import InputButton from '@/components/form/InputButton.vue';
    import IconFilterRemove from '@/icons/IconFilterRemove.vue';
    import IconSearch from '@/icons/IconSearch.vue';
    import InputSelect from '@/components/form/InputSelect.vue';
    import InputText from '@/components/form/InputText.vue'

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

