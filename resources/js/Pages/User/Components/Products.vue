<script setup>
import { inject } from 'vue';
import { router } from '@inertiajs/vue3';
defineProps({
  products: Array
})

const $swal = inject('$swal');

const addToCart = (product) => {
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
  <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
    <div v-for="product in products" :key="product.id" class="group relative">
      <div
        class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
        <img v-if="product.product_images.length" :src="`/${product.product_images[0].image}`" :alt="product.imageAlt"
          class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
        <img v-else src="https://t3.ftcdn.net/jpg/04/62/93/66/360_F_462936689_BpEEcxfgMuYPfTaIAOC1tCDurmsno7Sp.jpg"
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
</template>