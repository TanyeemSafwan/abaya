<script setup>
import { ref, watch, computed } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import UserLayout from './User/Layouts/UserLayout.vue';
import Products from './User/Components/Products.vue';

const props = defineProps({
    query: String,
    products: Object,
});

const searchQuery = ref(props.query || '');
const form = useForm({
    query: searchQuery,
    page: props.products.current_page || 1,
});

const search = () => {
    form.get(route('search'), {
        preserveState: true,
        preserveScroll: true,
        only: ['products'],
    });
};

watch(searchQuery, (newQuery) => {
    form.query = newQuery;
    form.page = 1;
    search();
});

const changePage = (page) => {
    form.page = page;
    search();
};

const paginationRange = computed(() => {
    const range = [];
    for (let i = Math.max(2, form.page - 1); i <= Math.min(props.products.last_page - 1, form.page + 1); i++) {
        range.push(i);
    }
    return range;
});
</script>

<template>
    <Head>
        <title>Search</title>
    </Head>
    <UserLayout>
        <div class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
            <div class="container mx-auto px-4 py-16">
                <h1 class="text-5xl font-extrabold text-gray-900 mb-12 text-center">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-pink-600">
                        Search Results
                    </span>
                </h1>
                
                <div class="max-w-3xl mx-auto mb-12">
                    <div class="relative">
                        <input 
                            v-model="searchQuery"
                            type="text"
                            placeholder="Search products..."
                            class="w-full px-8 py-5 text-lg border-2 border-gray-300 rounded-full focus:outline-none focus:ring-4 focus:ring-purple-300 focus:border-purple-500 transition duration-300 shadow-lg"
                        >
                        <svg class="absolute right-6 top-1/2 transform -translate-y-1/2 h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <div v-if="products.data.length > 0">
                    <Products :products="products.data" />
                </div>
                <div v-else class="text-center text-2xl text-gray-600 mt-16">
                    <p>No results found.</p>
                </div>

                <!-- Pagination -->
                <div v-if="products.last_page > 1" class="flex justify-center items-center space-x-2 mt-16">
                    <button 
                        @click="changePage(products.current_page - 1)"
                        :disabled="products.current_page === 1"
                        class="px-6 py-3 bg-purple-600 text-white rounded-full disabled:opacity-50 disabled:cursor-not-allowed hover:bg-purple-700 transition duration-300 shadow-md"
                    >
                        Previous
                    </button>

                    <button 
                        v-if="products.current_page > 2"
                        @click="changePage(1)"
                        class="px-4 py-2 bg-white text-purple-600 rounded-full hover:bg-purple-100 transition duration-300 shadow-md"
                    >
                        1
                    </button>

                    <span v-if="products.current_page > 3" class="text-gray-500">...</span>

                    <button 
                        v-for="page in paginationRange" 
                        :key="page"
                        @click="changePage(page)"
                        :class="['px-4 py-2 rounded-full transition duration-300 shadow-md', 
                                 page === products.current_page ? 'bg-purple-600 text-white' : 'bg-white text-purple-600 hover:bg-purple-100']"
                    >
                        {{ page }}
                    </button>

                    <span v-if="products.current_page < products.last_page - 2" class="text-gray-500">...</span>

                    <button 
                        v-if="products.current_page < products.last_page - 1"
                        @click="changePage(products.last_page)"
                        class="px-4 py-2 bg-white text-purple-600 rounded-full hover:bg-purple-100 transition duration-300 shadow-md"
                    >
                        {{ products.last_page }}
                    </button>

                    <button 
                        @click="changePage(products.current_page + 1)"
                        :disabled="products.current_page === products.last_page"
                        class="px-6 py-3 bg-purple-600 text-white rounded-full disabled:opacity-50 disabled:cursor-not-allowed hover:bg-purple-700 transition duration-300 shadow-md"
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>
    </UserLayout>
</template>