<script setup>
import UserLayout from './Layouts/UserLayout.vue'
import { inject, ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
  product: Object,
  productImages: Array,
  brand: Object,
  category: Object
});


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

const activeImage = ref(`/${props.productImages[0]?.image ? props.productImages[0].image : 'no-image-available.jpg'}`);
</script>

<template>
  <Head>
    <title>{{ `${product.title}` }}</title>
  </Head>
  <UserLayout>
    <div class="font-sans bg-gray-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white shadow-xl rounded-3xl overflow-hidden">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
            <!-- Product Images Section -->
            <div class="p-6 bg-gradient-to-br from-indigo-50 to-blue-50">
              <div class="aspect-w-1 aspect-h-1 mb-6">
                <img :src="activeImage" :alt="product.title" class="w-full h-full object-cover rounded-2xl shadow-lg transition-all duration-300 hover:scale-105" />
              </div>
              <div class="grid grid-cols-4 gap-4">
                <div v-for="productImage in productImages" :key="productImage.id" 
                     class="aspect-w-1 aspect-h-1 cursor-pointer rounded-lg overflow-hidden shadow-md transition-transform duration-300 hover:scale-110"
                     @click="activeImage = `/${productImage.image}`">
                  <img :src="`/${productImage.image}`" :alt="product.title" class="w-full h-full object-cover" />
                </div>
              </div>
            </div>

            <!-- Product Details Section -->
            <div class="p-8 flex flex-col justify-between">
              <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ product.title }}</h1>
                <div class="flex items-center justify-between mb-6">
                  <p class="text-4xl font-extrabold text-indigo-600">{{ product.price }} Taka</p>
                  <span :class="['px-4 py-2 rounded-full text-sm font-semibold', !product.inStock ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800']">
                    {{ !product.inStock ? 'In Stock' : 'Out of Stock' }}
                  </span>
                </div>
                <div class="prose prose-indigo max-w-none mb-8">
                  <h3 class="text-xl font-semibold text-gray-700 mb-2">Description</h3>
                  <p class="text-gray-600">{{ product.description }}</p>
                </div>
              </div>
              <button @click="addToCart(product)" type="button" class="w-full px-6 py-4 bg-indigo-600 text-white rounded-xl text-lg font-semibold transition-colors duration-300 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Add to Cart
              </button>
            </div>
          </div>
        </div>

        <!-- Product Information Section -->
        <div class="mt-12 bg-white shadow-xl rounded-3xl overflow-hidden">
          <div class="p-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Product Information</h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
              <div class="py-3 sm:py-4 border-b border-gray-200 sm:border-b-0 sm:border-r">
                <dt class="text-sm font-medium text-gray-500">Fabric Type</dt>
                <dd class="mt-1 text-lg font-semibold text-indigo-600">{{ brand.name }}</dd>
              </div>
              <div class="py-3 sm:py-4 border-b border-gray-200">
                <dt class="text-sm font-medium text-gray-500">Category</dt>
                <dd class="mt-1 text-lg font-semibold text-indigo-600">{{ category.name }}</dd>
              </div>
              <div class="py-3 sm:py-4 border-b border-gray-200 sm:border-b-0 sm:border-r">
                <dt class="text-sm font-medium text-gray-500">Price</dt>
                <dd class="mt-1 text-lg font-semibold text-indigo-600">{{ product.price }} Taka</dd>
              </div>
              <div class="py-3 sm:py-4">
                <dt class="text-sm font-medium text-gray-500">Status</dt>
                <dd class="mt-1 text-lg font-semibold" :class="!product.inStock ? 'text-green-600' : 'text-red-600'">
                  {{ !product.inStock ? 'In Stock' : 'Out of Stock' }}
                </dd>
              </div>
            </dl>
          </div>
        </div>
      </div>
    </div>
  </UserLayout>
</template>