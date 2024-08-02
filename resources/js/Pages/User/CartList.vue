<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, reactive } from 'vue';
import UserLayout from './Layouts/UserLayout.vue';
import { router } from '@inertiajs/vue3';

defineProps({
  userAddress:Object,
  cartItems:Object
})

const cities = [
  {
    name: 'Dhaka',
    id: 1
  },
  {
    name: 'Chattogram',
    id: 2
  },
  {
    name: 'Gazipur',
    id: 3
  },
  {
    name: 'Narayanganj',
    id: 4
  },
  {
    name: 'Khulna',
    id: 5
  },
  {
    name: 'Rangpur',
    id: 6
  },
  {
    name: 'Mymensingh',
    id: 7
  },
  {
    name: 'Rajshahi',
    id: 8
  },
  {
    name: 'Sylhet',
    id: 9
  },
  {
    name: 'Cumilla',
    id: 10
  },
  {
    name: 'Barisal',
    id: 11
  }
];

const form = reactive({
  address1: null,
  name: null,
  city: null,
  phone: null
})

const products = computed(() => usePage().props.cart.data.products);
const total = computed(() => form.city === 'Dhaka' ? usePage().props.cart.data.total + 80 : form.city === null ? usePage().props.cart.data.total : usePage().props.cart.data.total + 120);
const carts = computed(() => usePage().props.cart.data.items);
const itemId = (id) => carts.value.findIndex((item) => item.product_id === id);
const update = (product, quantity) =>
  router.patch(route('cart.update', product), {
    quantity,
  });
const remove = (product) => router.delete(route('cart.delete', product));
const submit = () => {
  if (total.value) {
    router.visit(route('checkout.store'), {
    method: 'post',
    data: {
      carts:usePage().props.cart.data.items,
      products:usePage().props.cart.data.products,
      total:form.city === 'Dhaka' ? usePage().props.cart.data.total + 80 : form.city === null ? usePage().props.cart.data.total : usePage().props.cart.data.total + 120,
      address:form
    }
  })
  }
};
</script>

<template>
  <UserLayout>
    <section class="text-gray-600 body-font relative">
      <div class="container px-5 py-24 mt-10 mx-auto">
        <div class="flex flex-wrap lg:flex-nowrap">
          <div class="lg:w-2/3 md:w-1/2 w-full rounded-lg p-10 flex flex-col mb-8 lg:mb-0">
            <!-- List of cart items -->
            <table v-if="carts.length > 0" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
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
                        <input type="number" id="first_product" v-model="carts[itemId(product.id)].quantity"
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
                    <a @click="remove(product)"
                      class="font-medium text-red-600 dark:text-red-500 hover:underline cursor-pointer">Remove</a>
                  </td>
                </tr>
              </tbody>
            </table>
            <section v-else class="bg-white dark:bg-gray-900">
              <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
                <div class="mx-auto max-w-screen-sm text-center">
                  <div class="flex justify-center w-full">
                    <svg fill="#000000" height="100px" width="100px" version="1.1" id="Capa_1"
                      xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                      viewBox="0 0 231.523 231.523" xml:space="preserve">
                      <g>
                        <path d="M107.415,145.798c0.399,3.858,3.656,6.73,7.451,6.73c0.258,0,0.518-0.013,0.78-0.04c4.12-0.426,7.115-4.111,6.689-8.231
		                      l-3.459-33.468c-0.426-4.12-4.113-7.111-8.231-6.689c-4.12,0.426-7.115,4.111-6.689,8.231L107.415,145.798z" />
                        <path d="M154.351,152.488c0.262,0.027,0.522,0.04,0.78,0.04c3.796,0,7.052-2.872,7.451-6.73l3.458-33.468
		                      c0.426-4.121-2.569-7.806-6.689-8.231c-4.123-0.421-7.806,2.57-8.232,6.689l-3.458,33.468
		                      C147.235,148.377,150.23,152.062,154.351,152.488z" />
                        <path d="M96.278,185.088c-12.801,0-23.215,10.414-23.215,23.215c0,12.804,10.414,23.221,23.215,23.221
		                      c12.801,0,23.216-10.417,23.216-23.221C119.494,195.502,109.079,185.088,96.278,185.088z M96.278,216.523
		                      c-4.53,0-8.215-3.688-8.215-8.221c0-4.53,3.685-8.215,8.215-8.215c4.53,0,8.216,3.685,8.216,8.215
		                      C104.494,212.835,100.808,216.523,96.278,216.523z" />
                        <path d="M173.719,185.088c-12.801,0-23.216,10.414-23.216,23.215c0,12.804,10.414,23.221,23.216,23.221
		                      c12.802,0,23.218-10.417,23.218-23.221C196.937,195.502,186.521,185.088,173.719,185.088z M173.719,216.523
		                      c-4.53,0-8.216-3.688-8.216-8.221c0-4.53,3.686-8.215,8.216-8.215c4.531,0,8.218,3.685,8.218,8.215
		                      C181.937,212.835,178.251,216.523,173.719,216.523z" />
                        <path d="M218.58,79.08c-1.42-1.837-3.611-2.913-5.933-2.913H63.152l-6.278-24.141c-0.86-3.305-3.844-5.612-7.259-5.612H18.876
		c-4.142,0-7.5,3.358-7.5,7.5s3.358,7.5,7.5,7.5h24.94l6.227,23.946c0.031,0.134,0.066,0.267,0.104,0.398l23.157,89.046
		c0.86,3.305,3.844,5.612,7.259,5.612h108.874c3.415,0,6.399-2.307,7.259-5.612l23.21-89.25C220.49,83.309,220,80.918,218.58,79.08z
		 M183.638,165.418H86.362l-19.309-74.25h135.895L183.638,165.418z" />
                        <path d="M105.556,52.851c1.464,1.463,3.383,2.195,5.302,2.195c1.92,0,3.84-0.733,5.305-2.198c2.928-2.93,2.927-7.679-0.003-10.607
		L92.573,18.665c-2.93-2.928-7.678-2.927-10.607,0.002c-2.928,2.93-2.927,7.679,0.002,10.607L105.556,52.851z" />
                        <path d="M159.174,55.045c1.92,0,3.841-0.733,5.306-2.199l23.552-23.573c2.928-2.93,2.925-7.679-0.005-10.606
		c-2.93-2.928-7.679-2.925-10.606,0.005l-23.552,23.573c-2.928,2.93-2.925,7.679,0.005,10.607
		C155.338,54.314,157.256,55.045,159.174,55.045z" />
                        <path
                          d="M135.006,48.311c0.001,0,0.001,0,0.002,0c4.141,0,7.499-3.357,7.5-7.498l0.008-33.311c0.001-4.142-3.356-7.501-7.498-7.502
		c-0.001,0-0.001,0-0.001,0c-4.142,0-7.5,3.357-7.501,7.498l-0.008,33.311C127.507,44.951,130.864,48.31,135.006,48.311z" />
                      </g>
                    </svg>
                  </div>
                  <p class="mb-4 text-3xl tracking-tight font-bold text-gray-900 md:text-4xl dark:text-white">
                    Cart Empty!</p>
                  <p class="mb-4 text-lg font-light text-gray-500 dark:text-gray-400">Please add something to the cart to checkout.
                    You'll find lots to explore on the products page. </p>
                  <Link :href="route('products.index')"
                    class="inline-flex text-white bg-blue-600 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-primary-900 my-4">View All Products</Link>
                </div>
              </div>
            </section>
            <!-- End List of cart items -->
          </div>
          <div class="lg:w-1/3 md:w-1/2 w-full bg-white flex flex-col p-10 rounded-lg">
            <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Summary</h2>
            <p class="leading-relaxed mb-5 text-gray-600">Total: {{ total ? total : 0 }} Taka<br> (Additional Delivery Charge of 80 taka within Dhaka City and 120 Taka outside Dhaka City will be added)</p>
            <form @submit.prevent="submit">
            <div class="relative mb-4">
              <label for="name" class="leading-7 text-sm text-gray-600">Name</label>
              <input v-model="form.name" required type="text" id="name" name="name"
                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            </div>
            <div class="relative mb-4">
              <label for="phone" class="leading-7 text-sm text-gray-600">Phone Number</label>
              <input v-model="form.phone" required type="tel" id="phone" name="phone" pattern="[0-9]{11}"
                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            </div>
            <div class="relative mb-4">
              <label for="brands" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                    City</label>
                <select required id="brands" v-model="form.city"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option v-for="city in cities" :key="city.id" :value="city.name">{{ city.name }}</option>
                </select>
            </div>
            <div class="relative mb-4">
              <label for="address" class="leading-7 text-sm text-gray-600">Address</label>
              <textarea id="address" required name="address" v-model="form.address1"
                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
            </div>
            <button type="submit"
              class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Checkout</button>
            </form>
            </div>
        </div>
      </div>
    </section>

  </UserLayout>

</template>