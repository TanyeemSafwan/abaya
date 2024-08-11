<script setup>
import UserLayout from './Layouts/UserLayout.vue'
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  product: Object,
  productImages: Array,
  brand: Object,
  category: Object
});

const activeImage = ref(`/${props.productImages[0].image}`);
</script>

<template>
  <Head>
    <title>{{ 'Product Details | Abaya' }}</title>
</Head>
  <UserLayout>
    <div class="font-sans bg-gradient-to-r from-blue-50 to-indigo-50">
      <div class="p-4 lg:max-w-7xl max-w-4xl mx-auto mb-16">
        <div class="grid items-start grid-cols-1 lg:grid-cols-5 gap-12 bg-white shadow-lg rounded-2xl p-8">
          <div class="lg:col-span-3 w-full lg:sticky top-4 text-center">
            <div class="p-6 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-100 shadow-md relative overflow-hidden group">
              <img :src="activeImage" alt="Product" class="w-4/5 h-auto rounded-lg object-cover mx-auto transition-transform duration-300 group-hover:scale-105" />
              <button type="button" class="absolute top-4 right-4 bg-white p-2 rounded-full shadow-md transition-colors duration-300 hover:bg-red-500 group">
                <svg xmlns="http://www.w3.org/2000/svg" width="20px" fill="currentColor" class="group-hover:text-white" viewBox="0 0 64 64">
                  <path d="M45.5 4A18.53 18.53 0 0 0 32 9.86 18.5 18.5 0 0 0 0 22.5C0 40.92 29.71 59 31 59.71a2 2 0 0 0 2.06 0C34.29 59 64 40.92 64 22.5A18.52 18.52 0 0 0 45.5 4ZM32 55.64C26.83 52.34 4 36.92 4 22.5a14.5 14.5 0 0 1 26.36-8.33 2 2 0 0 0 3.27 0A14.5 14.5 0 0 1 60 22.5c0 14.41-22.83 29.83-28 33.14Z" data-original="#000000"></path>
                </svg>
              </button>
            </div>

            <div class="mt-8 flex flex-wrap justify-center gap-4 mx-auto">
              <div v-for="productImage in productImages" :key="productImage.id" 
                   class="w-20 h-20 flex items-center justify-center rounded-lg p-2 bg-white shadow-md cursor-pointer transition-transform duration-300 hover:scale-110"
                   @click="activeImage = `/${productImage.image}`">
                <img :src="`/${productImage.image}`" alt="Product Thumbnail" class="w-full h-full object-cover rounded-md"/>
              </div>
            </div>
          </div>

          <div class="lg:col-span-2 space-y-8">
            <h2 class="text-3xl font-bold text-gray-800 leading-tight">{{ product.title }}</h2>

            <div class="flex items-center justify-between">
              <p class="text-4xl font-extrabold text-indigo-600">{{ product.price }} Taka</p>
              <span class="px-3 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full">
                {{ !product.inStock ? 'In Stock' : 'Out of Stock' }}
              </span>
            </div>

            <div class="prose prose-indigo">
              <h3 class="text-xl font-semibold text-gray-700">Description</h3>
              <p class="text-gray-600">{{ product.description }}</p>
            </div>

            <button type="button" class="w-full px-6 py-3 text-white bg-indigo-600 rounded-lg text-lg font-semibold transition-colors duration-300 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
              Add to cart
            </button>
          </div>
        </div>

        <div class="mt-16 bg-white shadow-lg rounded-2xl p-8">
          <h3 class="text-2xl font-bold text-gray-800 mb-6">Product Information</h3>
          <ul class="space-y-4 text-gray-700">
            <li class="flex justify-between items-center py-2 border-b border-gray-200">
              <span class="font-medium">Cloth Type</span>
              <span class="text-indigo-600">{{ brand.name }}</span>
            </li>
            <li class="flex justify-between items-center py-2 border-b border-gray-200">
              <span class="font-medium">Category</span>
              <span class="text-indigo-600">{{ category.name }}</span>
            </li>
            <li class="flex justify-between items-center py-2 border-b border-gray-200">
              <span class="font-medium">Price</span>
              <span class="text-indigo-600">{{ product.price }} Taka</span>
            </li>
            <li class="flex justify-between items-center py-2">
              <span class="font-medium">Status</span>
              <span :class="!product.inStock ? 'text-green-600' : 'text-red-600'">
                {{ !product.inStock ? 'In Stock' : 'Out of Stock' }}
              </span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </UserLayout>
</template>