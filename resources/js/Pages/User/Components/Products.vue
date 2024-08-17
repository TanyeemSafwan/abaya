<script setup>
import { Link } from '@inertiajs/vue3';
import { inject } from 'vue';
import { router } from '@inertiajs/vue3';

defineProps({
  products: Array
})

const $swal = inject('$swal');

const addToCart = (product) => {
  router.post(route('cart.store', product), {
    preserveState: true,
    preserveScroll: true,
    onSuccess: (page) => {
      if (page.props.flash.success) {
        $swal.fire({
          toast: true,
          icon: 'success',
          position: 'top-end',
          showConfirmationButton: false,
          title: page.props.flash.success
        })
      }
    }
  })
}
</script>

<template>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    <div
      v-if="products.length"
      v-for="product in products" 
      :key="product.id" 
      class="bg-white rounded-3xl shadow-xl overflow-hidden transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl flex flex-col h-full"
    >
      <Link
        :href="route('products.show', product.id)"
        class="block flex-shrink-0"
      >
        <div class="relative h-64 overflow-hidden">
          <img 
            v-if="product.product_images.length" 
            :src="`/${product.product_images[0].image}`" 
            :alt="product.title" 
            class="w-full h-full object-cover object-center transition-transform duration-300 group-hover:scale-110"
          />
          <img 
            v-else 
            src="https://t3.ftcdn.net/jpg/04/62/93/66/360_F_462936689_BpEEcxfgMuYPfTaIAOC1tCDurmsno7Sp.jpg" 
            :alt="product.title" 
            class="w-full h-full object-cover object-center transition-transform duration-300 group-hover:scale-110"
          />
          <div class="absolute top-0 right-0 m-4">
            <span class="px-3 py-1 text-xs font-semibold text-white bg-green-500 rounded-full shadow-lg">In Stock</span>
          </div>
        </div>
      </Link>
      <div class="p-6 flex flex-col flex-grow">
        <Link
          :href="route('products.show', product.id)"
          class="block mb-2"
        >
          <h3 class="text-xl font-bold text-gray-900 line-clamp-2 h-14 hover:text-purple-600 transition duration-300">
            {{ product.title }}
          </h3>
        </Link>
        <p class="text-sm font-medium text-purple-600 mb-2">{{ product.brand.name }}</p>
        <div class="flex justify-between items-center mt-auto">
          <p class="text-2xl font-extrabold text-gray-900">{{ product.price }} taka</p>
        </div>
      </div>
      <div class="px-6 pb-6 mt-auto">
        <button 
          type="button"
          @click.prevent="addToCart(product)" 
          class="w-full text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-3 text-center transition-all duration-300 ease-in-out transform hover:scale-105 shadow-lg"
        >
          Add to Cart
        </button>
      </div>
    </div>
    <div v-else class="col-span-full text-center">
      <img src="/application_images/product-not-found.jpg" alt="No Product Found!" class="mx-auto max-w-md rounded-lg shadow-lg"/>
    </div>
  </div>
</template>