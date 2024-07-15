<script setup>
import { inject, onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import { router } from '@inertiajs/vue3';
import UserLayout from './Layouts/UserLayout.vue'

// initialize components based on data attribute selectors
onMounted(() => {
  initFlowbite();
})

defineProps({
  products: Array
})
const $swal = inject('$swal');

const addToCart = (product) => {
  console.log(product);
  router.post(route('cart.store', product), {
    onSuccess: (page) => {
      if (page.props.flash.success) {
        $swal.fire({
          toast: true,
          icon: 'success',
          position: 'top-end',
          showConfirmationButton: false,
          title: page.props.flash.sucess
        })
      }
    }
  })
}
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

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
          <div v-for="product in products" :key="product.id" class="group relative">
            <div
              class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
              <img v-if="product.product_images.length" :src="`/${product.product_images[0].image}`"
                :alt="product.imageAlt" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
              <img v-else
                src="https://t3.ftcdn.net/jpg/04/62/93/66/360_F_462936689_BpEEcxfgMuYPfTaIAOC1tCDurmsno7Sp.jpg"
                :alt="product.imageAlt" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
            </div>
            <div class="mt-4 flex justify-between">
              <div style="max-width: 55%">
                <h3 class="text-sm text-gray-700">
                  <a :href="product.href">
                    <span aria-hidden="true" class=""></span>
                    {{ product.title }}
                  </a>
                </h3>
                <p class="mt-1 text-sm text-gray-500">{{ product.brand.name }}</p>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900 text-center">{{ product.price }} taka</p>
                <button type="button" @click="addToCart(product)"
                  class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 cursor-pointer"
                  style="cursor: pointer;">Add to Cart</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </UserLayout>
</template>