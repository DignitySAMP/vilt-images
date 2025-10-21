<template>
    <div ref="imageSearchBar" class="w-full h-fit flex items-center justify-between p-4 bg-stone-50 border border-white rounded-md mt-4">
        <div class="flex w-full gap-2">
            <select 
                id="searchSort" name="searchSort"
                class="bg-slate-50 text-sm rounded-md w-fit border border-slate-300 text-slate-700 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >
                <option>Sort by latest photos (public)</option>
                <option>Sort by oldest photos (public)</option>
                <option>Sort by largest file size</option>
                <option>Sort by lmallest file size</option>
            </select>

            <div class="flex w-full items-center">
                <select 
                    id="searchType" name="searchType"
                    class="bg-indigo-50 text-sm border rounded-l-md border-indigo-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="album">Album</option>
                    <option value="name">Name</option>
                    <option value="title">Title</option>
                    <option value="size">File size</option>
                </select>
                <div class="flex border-l-0 w-full border-indigo-200 rounded-r-md border items-center bg-stone-50 pr-2">
                    <input
                        id="searchQuery" 
                        name="searchQuery" 
                        type="text" 
                        placeholder="Enter search term..."
                        class="mr-2 w-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    />

                    <IconSearch />
                </div>
            </div>

            <button
                class="min-w-48 justify-between flex items-center bg-green-600 text-white text-sm px-4 py-2 rounded-md hover:bg-green-500 transition duration-200 cursor-pointer"
            >
                <IconUpload/>
                <span>
                    Upload New Image
                </span>
            </button>
        </div>
    </div>
</template>
<script setup>
    import IconUpload from '@/icons/IconUpload.vue'
    import IconSearch from '@/icons/IconSearch.vue'

    const props = defineProps({
        show: {
            type: Boolean,
            required: false
        }
    })
</script>