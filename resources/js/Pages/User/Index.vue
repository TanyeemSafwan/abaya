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

const customers = [
  'Mareya Akther',
  'Eva Khondokar',
  'Happy Customter'
];
</script>

<template>
  <Head>
    <title>Home | Abaya</title>
  </Head>
  <UserLayout>
    <!-- Hero Section -->
    <section class="relative bg-gray-900 text-white">
  <div class="absolute inset-0 bg-center bg-cover bg-no-repeat" 
       style="background-image: url('/application_images/abaya-background.jpg');">
  </div>
  <div class="absolute inset-0 bg-black opacity-60"></div>
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 sm:py-48 lg:py-56">
        <h1 class="text-4xl font-extrabold sm:text-5xl lg:text-6xl leading-tight mb-6">
          Elegance Redefined: <br>
          <span class="text-emerald-400">Your Perfect Abaya</span>
        </h1>
        <p class="text-xl max-w-3xl mb-8">
          Discover our collection of exquisite abayas, where timeless tradition meets modern sophistication.
        </p>
        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
          <Link :href="route('products.index')"
            class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 transition duration-150 ease-in-out">
            Shop Now
          </Link>
          <a href="#featured" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-emerald-300 bg-gray-800 hover:bg-gray-700 transition duration-150 ease-in-out">
            Explore Collection
          </a>
        </div>
      </div>
    </section>

    <!-- Featured Categories -->
    <section id="featured" class="bg-gray-100 py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Featured Categories</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="category in ['Classic Abayas', 'Embroidered Designs', 'Modern Cuts']" :key="category" class="relative group overflow-hidden rounded-lg shadow-lg">
            <img :src="`/application_images/${category.toLowerCase().replace(' ', '-')}.jpg`" :alt="category" class="w-full h-64 object-cover transition duration-300 group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-70"></div>
            <div class="absolute bottom-0 left-0 p-6">
              <h3 class="text-xl font-semibold text-white mb-2">{{ category }}</h3>
              <Link :href="route('products.index')" class="text-sm text-emerald-300 group-hover:text-emerald-400 transition duration-150 ease-in-out">
                Shop Now &rarr;
              </Link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Latest Products Section -->
    <section class="bg-white py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Latest Products</h2>
        <Products :products="products" />
        <div class="flex justify-center mt-12">
          <Link :href="route('products.index')"
            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 transition duration-150 ease-in-out">
            View All Products
          </Link>
        </div>
      </div>
    </section>

    <!-- Testimonials -->
    <section class="bg-gray-900 text-white py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold mb-12 text-center">What Our Customers Say</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="(testimonial, index) in ['মাশাল্লাহ আপু খুব সুন্দর বোরকা। এক দম সেম টু সেম। ইন্শাল্লাহ অবারও  নিতে পারি।', 'অনেক অনেক ধন্যবাদ আপু, মাশাল্লাহ! অনেক সুন্দর হয়েছে বোরখা।', 'আলহামদুলিল্লাহ প্রোডাক্ট পেয়েছি। দাম অনুযায়ী কাপড়ের কোয়ালিটি মোটামুটি ভালো। স্যাটিসফাইড। ধন্যবাদ।']" :key="testimonial" class="bg-gray-800 p-6 rounded-lg">
            <p class="text-lg mb-4">{{ testimonial }}</p>
            <div class="flex items-center">
              <img src="/application_images/avatar-placeholder.jpg" alt="Customer" class="w-10 h-10 rounded-full mr-4">
              <div>
                <p class="font-semibold">{{ customers[index] }}</p>
                <p class="text-emerald-400 text-sm">Verified Buyer</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Newsletter -->
    <section class="bg-emerald-600 py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Stay Updated</h2>
        <p class="text-emerald-100 mb-8 max-w-2xl mx-auto">Subscribe to our newsletter for exclusive offers, new arrivals, and styling tips.</p>
        <form class="max-w-md mx-auto flex">
          <input type="email" placeholder="Enter your email" class="flex-grow px-4 py-2 rounded-l-md focus:outline-none focus:ring-2 focus:ring-white">
          <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-r-md hover:bg-gray-800 transition duration-150 ease-in-out">
            Subscribe
          </button>
        </form>
      </div>
    </section>
  </UserLayout>
</template>

<style scoped>
/* Add any additional styles here */
</style>