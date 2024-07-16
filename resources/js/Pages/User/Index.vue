<script setup>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import { Link } from '@inertiajs/vue3';
import UserLayout from './Layouts/UserLayout.vue'
import Products from './Components/Products.vue';

// initialize components based on data attribute selectors
onMounted(() => {
  initFlowbite();
})

defineProps({
  products: Array
})

</script>

<template>
  <UserLayout>
    <!-- Hero Section-->
    <div class="bg-gradient-to-b from-green-50 to-green-100">


      <section class="py-10 sm:py-16 lg:py-24">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="grid items-center grid-cols-1 gap-12 lg:grid-cols-2">
            <div>
              <h1 class="text-4xl font-bold text-black sm:text-6xl lg:text-7xl">
                Elegance gracefully folded, with classic <br>
                <div class="relative inline-flex">
                  <span class="absolute inset-x-0 bottom-0 border-b-[30px] border-[#4ADE80]"></span>
                  <h1 class="relative text-4xl font-bold text-black sm:text-6xl lg:text-7xl">Abaya.</h1>
                </div>
              </h1>

              <p class="mt-8 text-base text-black sm:text-xl">Amet minim mollit non deserunt ullamco est sit aliqua
                dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat.</p>

              <div class="mt-10 sm:flex sm:items-center sm:space-x-8">
                <a href="#" title=""
                  class="inline-flex items-center justify-center px-10 py-4 text-base font-semibold text-white transition-all duration-200 bg-orange-500 hover:bg-orange-600 focus:bg-orange-600"
                  role="button"> Start exploring </a>

                <a href="#" title=""
                  class="inline-flex items-center mt-6 text-base font-semibold transition-all duration-200 sm:mt-0 hover:opacity-80">
                  <svg class="w-10 h-10 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path fill="#F97316" stroke="#F97316" stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  Watch video
                </a>
              </div>
            </div>

            <div>
              <img class="w-full" src="" alt="" />
            </div>
          </div>
        </div>
      </section>
    </div>
    <!-- Hero Section ends-->
    <div class="bg-white">
      <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">Latest Products List</h2>

        <Products :products="products"/>
        <div class="flex justify-center mt-5">
        <Link :href="route('products.index')" type="button" class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">View All Products</Link>

        </div>
      </div>
    </div>
  </UserLayout>
</template>