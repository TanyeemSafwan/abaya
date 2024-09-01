<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, reactive, ref } from 'vue';
import UserLayout from './Layouts/UserLayout.vue';
import { router } from '@inertiajs/vue3';

defineProps({
  userAddress: Object,
  cartItems: Object
})

const cities = [
  { name: 'Dhaka', id: 1 },
  { name: 'Chattogram', id: 2 },
  { name: 'Gazipur', id: 3 },
  { name: 'Narayanganj', id: 4 },
  { name: 'Khulna', id: 5 },
  { name: 'Rangpur', id: 6 },
  { name: 'Mymensingh', id: 7 },
  { name: 'Rajshahi', id: 8 },
  { name: 'Sylhet', id: 9 },
  { name: 'Cumilla', id: 10 },
  { name: 'Barisal', id: 11 }
];

const form = reactive({
  address1: null,
  name: null,
  city: null,
  phone: null,
  specialInstructions: null
})

const products = computed(() => usePage().props.cart.data.products);
const total = computed(() => form.city === 'Dhaka' ? usePage().props.cart.data.total + 80 : form.city === null ? usePage().props.cart.data.total : usePage().props.cart.data.total + 120);
const carts = computed(() => usePage().props.cart.data.items);
const itemId = (id) => carts.value.findIndex((item) => item.product_id === id);

const productSizes = ref([]);
const sizeError = ref(false);

const updateSize = (productId, size) => {
  const index = productSizes.value.findIndex(item => item.productId === productId);
  if (index !== -1) {
    productSizes.value[index].size = size;
  } else {
    productSizes.value.push({ productId, size });
  }
  sizeError.value = false;
};

// const formattedSizeList = computed(() => {
//   return productSizes.value.map(item => {
//     const product = products.value.find(p => p.id === item.productId);
//     return `${product.title}: ${item.size}`;
//   }).join('; ');
// });

const allSizesSelected = computed(() => {
  return products.value.every(product => 
    productSizes.value.some(item => item.productId === product.id && item.size)
  );
});

const update = (product, quantity) =>
  router.patch(route('cart.update', product), {
    quantity,
  });

const remove = (product) => router.delete(route('cart.delete', product));

const submit = async() => {
  if (!allSizesSelected.value) {
    sizeError.value = true;
    return;
  }

  if (total.value) {
    try{
      await router.visit(route('checkout.store'), {
      method: 'post',
      data: {
        carts: usePage().props.cart.data.items,
        products: usePage().props.cart.data.products,
        total: total.value,
        address: form,
        productSizes: productSizes.value,
      }
    });
    } catch {

    }
    
  }
};
</script>

<template>
  <Head>
    <title>{{ 'Cart List' }}</title>
  </Head>
  <UserLayout>
    <section class="bg-gradient-to-r from-blue-100 to-purple-100 min-h-screen py-12">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">Your Shopping Cart</h1>
        <div class="flex flex-col lg:flex-row gap-8">
          <div class="lg:w-2/3 bg-white rounded-lg shadow-lg p-6 mb-8">
            <!-- List of cart items -->
            <div v-if="carts.length > 0">
              <!-- Desktop view -->
              <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                  <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                      <th scope="col" class="px-4 py-3">Product</th>
                      <th scope="col" class="px-4 py-3">Size</th>
                      <th scope="col" class="px-4 py-3">Qty</th>
                      <th scope="col" class="px-4 py-3">Price</th>
                      <th scope="col" class="px-4 py-3">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="product in products" :key="product.id"
                      class="bg-white border-b hover:bg-gray-50">
                      <td class="px-4 py-4 font-medium text-gray-900">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center">
                          <img v-if="product.product_images.length" :src="`/${product.product_images[0].image}`"
                            class="w-16 h-16 object-cover mb-2 sm:mb-0 sm:mr-4" :alt="product.title">
                          <img v-else
                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTNNLEL-qmmLeFR1nxJuepFOgPYfnwHR56vcw&s"
                            class="w-16 h-16 object-cover mb-2 sm:mb-0 sm:mr-4" :alt="product.title">
                          <span class="mt-2 sm:mt-0">{{ product.title }}</span>
                        </div>
                      </td>
                      <td class="px-4 py-4">
                        <select 
                          @change="updateSize(product.id, $event.target.value)"
                          :class="{'border-red-500': sizeError && !productSizes.find(item => item.productId === product.id && item.size)}"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        >
                          <option value="">Select Size</option>
                          <option v-for="size in [50, 52, 54, 56, 58, 60]" :key="size" :value="size">{{ size }}</option>
                        </select>
                      </td>
                      <td class="px-4 py-4">
                        <div class="flex items-center">
                          <button @click.prevent="update(product, carts[itemId(product.id)].quantity - 1)"
                            :disabled="carts[itemId(product.id)].quantity <= 1"
                            class="text-gray-500 focus:outline-none focus:text-gray-600">
                            <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                              <path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                          </button>
                          <span class="text-gray-700 mx-2">{{ carts[itemId(product.id)].quantity }}</span>
                          <button @click.prevent="update(product, carts[itemId(product.id)].quantity + 1)"
                            class="text-gray-500 focus:outline-none focus:text-gray-600">
                            <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                              <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                          </button>
                        </div>
                      </td>
                      <td class="px-4 py-4 font-semibold text-gray-900">{{ product.price }}</td>
                      <td class="px-4 py-4">
                        <a @click="remove(product)"
                          class="font-medium text-red-600 hover:underline cursor-pointer">Remove</a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              
              <!-- Mobile view -->
              <div class="sm:hidden">
                <div v-for="product in products" :key="product.id" class="bg-white border-b p-4">
                  <div class="flex items-center mb-2">
                    <img v-if="product.product_images.length" :src="`/${product.product_images[0].image}`"
                      class="w-16 h-16 object-cover mr-4" :alt="product.title">
                    <img v-else
                      src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTNNLEL-qmmLeFR1nxJuepFOgPYfnwHR56vcw&s"
                      class="w-16 h-16 object-cover mr-4" :alt="product.title">
                    <div>
                      <h3 class="font-medium text-gray-900">{{ product.title }}</h3>
                      <p class="text-gray-600">Price: {{ product.price }}</p>
                    </div>
                  </div>
                  <div class="mb-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Size:</label>
                    <select 
                      @change="updateSize(product.id, $event.target.value)"
                      :class="{'border-red-500': sizeError && !productSizes.find(item => item.productId === product.id && item.size)}"
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    >
                      <option value="">Select Size</option>
                      <option v-for="size in [50, 52, 54, 56, 58, 60]" :key="size" :value="size">{{ size }}</option>
                    </select>
                  </div>
                  <div class="flex items-center justify-between">
                    <div class="flex items-center">
                      <button @click.prevent="update(product, carts[itemId(product.id)].quantity - 1)"
                        :disabled="carts[itemId(product.id)].quantity <= 1"
                        class="text-gray-500 focus:outline-none focus:text-gray-600">
                        <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                          <path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                      </button>
                      <span class="text-gray-700 mx-2">{{ carts[itemId(product.id)].quantity }}</span>
                      <button @click.prevent="update(product, carts[itemId(product.id)].quantity + 1)"
                        class="text-gray-500 focus:outline-none focus:text-gray-600">
                        <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                          <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                      </button>
                    </div>
                    <a @click="remove(product)"
                      class="font-medium text-red-600 hover:underline cursor-pointer">Remove</a>
                  </div>
                </div>
              </div>
            </div>
            <div v-else class="text-center py-8">
              <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                aria-hidden="true">
                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
              </svg>
              <h3 class="mt-2 text-sm font-medium text-gray-900">No items in cart</h3>
              <p class="mt-1 text-sm text-gray-500">Get started by adding some products to your cart.</p>
              <div class="mt-6">
                <Link :href="route('products.index')"
                  class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  View Products
                </Link>
              </div>
            </div>
          </div>
          <div class="lg:w-1/3 bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Order Summary</h2>
            <div class="space-y-4 mb-6">
              <div class="flex justify-between items-center">
                <span class="text-gray-600">Subtotal</span>
                <span class="font-semibold">{{ usePage().props.cart.data.total }} Taka</span>
              </div>
              <div class="flex justify-between items-center">
                <span class="text-gray-600">Delivery Charge</span>
                <span class="font-semibold">
                  {{ form.city === 'Dhaka' ? '80' : form.city === null ? '0' : '120' }} Taka
                </span>
              </div>
              <div class="border-t border-gray-200 pt-4">
                <div class="flex justify-between items-center">
                  <span class="text-lg font-semibold text-gray-900">Total</span>
                  <span class="text-xl font-bold text-indigo-600">{{ total }} Taka</span>
                </div>
              </div>
            </div>
            <p class="text-sm text-gray-500 mb-6">
              Delivery Charge: 80 taka within Dhaka City, 120 Taka outside Dhaka City
            </p>
            <form @submit.prevent="submit" class="space-y-4">
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input v-model="form.name" required type="text" id="name" name="name"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
              </div>
              <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input v-model="form.phone" required type="tel" id="phone" name="phone" pattern="[0-9]{11}"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
              </div>
              <div>
                <label for="city" class="block text-sm font-medium text-gray-700">Select City</label>
                <select required id="city" v-model="form.city"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                  <option value="">Select a city</option>
                  <option v-for="city in cities" :key="city.id" :value="city.name">{{ city.name }}</option>
                </select>
              </div>
              <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <textarea id="address" required name="address" v-model="form.address1" rows="3"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
              </div>
              <div>
                <label for="specialInstructions" class="block text-sm font-medium text-gray-700">Special Instructions</label>
                <textarea id="specialInstructions" name="specialInstructions" v-model="form.specialInstructions" rows="3"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  placeholder="Add any special instructions for cloth making. Note: Custom sizes may increase the price, and we'll contact you to discuss."></textarea>
              </div>
              <div v-if="sizeError" class="text-red-500 text-sm font-medium">
                Please select a size for all products before proceeding in the cart list.
              </div>
              <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                Proceed to Checkout
              </button>
            </form>
          </div>
        </div>
      </div>
    </section>
  </UserLayout>
</template>