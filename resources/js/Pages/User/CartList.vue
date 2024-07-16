<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import UserLayout from './Layouts/UserLayout.vue';
import { router } from '@inertiajs/vue3';

const products = computed(() => usePage().props.cart.data.products);
const total = computed(() => usePage().props.cart.data.total);
const carts = computed(() => usePage().props.cart.data.items);
const itemId = (id) => carts.value.findIndex((item) => item.product_id === id);
const update = (product, quantity) =>
    router.patch(route('cart.update', product), {
        quantity,
    });
const remove = (product) => router.delete(route('cart.delete', product));
</script>

<template>
  <UserLayout>
    <section class="text-gray-600 body-font relative">
      <div class="container px-5 py-24 mt-10 mx-auto">
        <div class="flex flex-wrap lg:flex-nowrap">
          <div class="lg:w-2/3 md:w-1/2 w-full rounded-lg p-10 flex flex-col mb-8 lg:mb-0">
            <!-- List of cart items -->
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                  <th scope="col" class="px-16 py-3"><span class="sr-only">Image</span></th>
                  <th scope="col" class="px-6 py-3">Product</th>
                  <th scope="col" class="px-6 py-3">Qty</th>
                  <th scope="col" class="px-6 py-3">Price</th>
                  <th scope="col" class="px-6 py-3">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="product in products" :key="product.id"
                  class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                  <td class="p-4">
                    <img v-if="product.product_images.length" :src="`/${product.product_images[0].image}`"
                      class="w-50 md:w-16 max-w-full max-h-full" :alt="product.title">
                    <img v-else
                      src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTNNLEL-qmmLeFR1nxJuepFOgPYfnwHR56vcw&s"
                      class="w-16 md:w-32 max-w-full max-h-full" :alt="product.title">
                  </td>
                  <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">{{ product.title }}</td>
                  <td class="px-6 py-4">
                    <div class="flex items-center">
                      <button @click.prevent="update(product, carts[itemId(product.id)].quantity - 1)"
                      :disabled="carts[itemId(product.id)].quantity <= 1"
                      :class="[carts[itemId(product.id)].quantity > 1 ? 'cursor-pointer text-purple-600' : 'cursor-not-allowed text-grey-300 dark:text-grey-500', 'mr-2 inline-flex items-center justify-center h-6 w-6 p-1 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700']"
                        type="button">
                        <span class="sr-only">Quantity button</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                          viewBox="0 0 18 2">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h16" />
                        </svg>
                      </button>
                      <div>
                        <input type="number" id="first_product"
                          v-model="carts[itemId(product.id)].quantity"
                          class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                          placeholder="1" required />
                      </div>
                      <button @click.prevent="update(product, carts[itemId(product.id)].quantity + 1)"
                        class="ml-2 inline-flex items-center justify-center h-6 w-6 p-1 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                        type="button">
                        <span class="sr-only">Quantity button</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                          viewBox="0 0 18 18">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 1v16M1 9h16" />
                        </svg>
                      </button>
                    </div>
                  </td>
                  <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">{{ product.price }}</td>
                  <td class="px-6 py-4">
                    <a @click="remove(product)" class="font-medium text-red-600 dark:text-red-500 hover:underline cursor-pointer">Remove</a>
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- End List of cart items -->
          </div>
          <div class="lg:w-1/3 md:w-1/2 w-full bg-white flex flex-col p-10 rounded-lg">
            <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Summary</h2>
            <p class="leading-relaxed mb-5 text-gray-600">Total: {{ total }} Taka</p>
            <div class="relative mb-4">
              <label for="name" class="leading-7 text-sm text-gray-600">Name</label>
              <input type="text" id="name" name="name"
                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            </div>
            <div class="relative mb-4">
              <label for="phone" class="leading-7 text-sm text-gray-600">Phone Number</label>
              <input type="tel" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}"
                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            </div>
            <div class="relative mb-4">
              <label for="address" class="leading-7 text-sm text-gray-600">Address</label>
              <textarea id="address" name="address"
                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
            </div>
            <button type="button"
              class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Checkout</button>
          </div>
        </div>
      </div>
    </section>

  </UserLayout>

</template>