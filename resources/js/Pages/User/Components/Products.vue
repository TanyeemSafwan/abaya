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
  <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
    <Link
      v-if="products.length"
      v-for="product in products" 
      :key="product.id" 
      :href="route('products.show', product.id)"
      class="group relative overflow-hidden rounded-xl bg-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 flex flex-col h-[500px]"
    >
      <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-t-xl bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 h-64">
        <img v-if="product.product_images.length" :src="`/${product.product_images[0].image}`" :alt="product.imageAlt" class="h-full w-full object-cover object-center transition-transform duration-300 group-hover:scale-110" />
        <img v-else src="https://t3.ftcdn.net/jpg/04/62/93/66/360_F_462936689_BpEEcxfgMuYPfTaIAOC1tCDurmsno7Sp.jpg" :alt="product.imageAlt" class="h-full w-full object-cover object-center transition-transform duration-300 group-hover:scale-110" />
      </div>
      <div class="p-6 flex flex-col flex-grow">
        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 h-14">
          {{ product.title }}
        </h3>
        <p class="text-sm font-medium text-indigo-500 mb-2">{{ product.brand.name }}</p>
        <div class="flex justify-between items-center mb-4 mt-auto">
          <p class="text-2xl font-extrabold text-gray-900">{{ product.price }} taka</p>
          <span class="px-3 py-1 text-xs font-semibold text-white bg-green-500 rounded-full">In Stock</span>
        </div>
        <button 
          type="button" 
          @click.prevent="addToCart(product)" 
          class="w-full text-white bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 hover:from-blue-600 hover:via-indigo-600 hover:to-purple-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-3 text-center transition-all duration-300 ease-in-out transform hover:scale-105"
        >
          Add to Cart
        </button>
      </div>
    </Link>
    <div v-else>
      <img src="/application_images/product-not-found.jpg" alt="No Product Found!"/>
    </div>
  </div>
</template>