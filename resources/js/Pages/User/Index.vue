<script setup>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import { Head, Link } from '@inertiajs/vue3';
import UserLayout from './Layouts/UserLayout.vue'
import Products from './Components/Products.vue';

onMounted(() => {
  initFlowbite();
})

defineProps({
  products: Array
})
</script>

<template>
  <Head>
    <title>{{ 'Home | Abaya' }}</title>
</Head>
  <UserLayout>
    <!-- Hero Section -->
    <div class="bg-gradient-to-b from-emerald-50 via-emerald-100 to-white">
      <section class="py-16 sm:py-24 lg:py-32">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="grid items-center grid-cols-1 gap-12 lg:grid-cols-2">
            <div class="space-y-8">
              <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl lg:text-6xl leading-tight">
                Elegance gracefully folded, with classic
                <span class="relative inline-block">
                  <span class="absolute inset-x-0 bottom-0 h-3 bg-emerald-400"></span>
                  <span class="relative">Abaya</span>
                </span>
              </h1>

              <p class="text-lg text-gray-700 sm:text-xl">
                Each stitch reflects timeless tradition, where modesty meets sophistication. The Abaya is more than attire—it's an expression of grace, crafted for the modern woman who values both heritage and style.
              </p>

              <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-6 space-y-4 sm:space-y-0">
                <Link :href="route('products.index')"
                  class="inline-flex items-center justify-center px-8 py-3 text-base font-medium text-white bg-emerald-600 rounded-md shadow-md hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-150 ease-in-out">
                  Start exploring
                </Link>

                <a href="https://www.facebook.com/abayadubaibd" target="_blank"
                  class="inline-flex items-center text-base font-medium text-emerald-600 hover:text-emerald-800 transition duration-150 ease-in-out">
                  <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                  </svg>
                  Visit Our Facebook Page
                </a>
              </div>
            </div>

            <div class="relative">
              <img class="w-full rounded-lg shadow-2xl" src="/application_images/abaya_logo.png" alt="Elegant Abaya" />
              <div class="absolute inset-0 bg-gradient-to-tr from-emerald-500 to-transparent opacity-20 rounded-lg"></div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- Latest Products Section -->
    <div class="bg-white">
      <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 mb-8">Latest Products</h2>

        <Products :products="products" />

        <div class="flex justify-center mt-12">
          <Link :href="route('products.index')"
            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-150 ease-in-out">
            View All Products
          </Link>
        </div>
      </div>
    </div>
  </UserLayout>
</template>

<style scoped>
/* Add any additional styles here */
</style>