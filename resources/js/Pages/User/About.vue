<script setup>
import UserLayout from './Layouts/UserLayout.vue'
import { Head } from '@inertiajs/vue3';
</script>

<template>
  <Head>
    <title>About | Abaya</title>
  </Head>
  <UserLayout>
    <!-- Hero Section -->
    <section class="relative bg-gray-900 text-white">
      <div class="absolute inset-0 bg-center bg-cover opacity-30" style="background-image: url('/application_images/abaya-background.jpg');"></div>
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <h1 class="text-4xl font-extrabold sm:text-5xl lg:text-6xl leading-tight mb-6">
          Our Story of <span class="text-emerald-400">Elegance</span>
        </h1>
        <p class="text-xl max-w-3xl mb-8">
          At Abaya, we blend tradition with modernity to bring you the finest Islamic clothing. Our journey is one of passion, quality, and dedication to preserving cultural heritage.
        </p>
      </div>
    </section>

    <!-- Our Mission -->
    <section class="bg-white py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center">
          <h2 class="text-base text-emerald-600 font-semibold tracking-wide uppercase">Our Mission</h2>
          <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
            Empowering Modesty with Style
          </p>
          <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
            We strive to provide elegant, high-quality abayas that allow women to express their faith and personal style with confidence.
          </p>
        </div>
      </div>
    </section>

    <!-- Why Choose Us -->
    <section class="bg-gray-100 py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8 text-center">Why Choose Abaya?</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="text-emerald-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Premium Quality</h3>
            <p class="text-gray-600">Crafted from the finest Zoom fabric, ensuring unmatched quality and durability.</p>
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="text-emerald-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Elegant Designs</h3>
            <p class="text-gray-600">A perfect blend of tradition and modernity, offering elegance in every piece.</p>
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="text-emerald-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Affordable Luxury</h3>
            <p class="text-gray-600">Experience luxury at prices that won't break the bank. Elegance made accessible.</p>
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="text-emerald-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Customer Satisfaction</h3>
            <p class="text-gray-600">We prioritize your satisfaction with seamless shopping and top-notch service.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Our Process -->
    <section class="bg-white py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8 text-center">Our Process</h2>
        <div class="flex flex-col md:flex-row justify-between items-center space-y-8 md:space-y-0 md:space-x-8">
          <div class="text-center">
            <div class="bg-emerald-100 rounded-full p-6 inline-block mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Design</h3>
            <p class="text-gray-600">Our designers create elegant, modern abayas</p>
          </div>
          <div class="text-center">
            <div class="bg-emerald-100 rounded-full p-6 inline-block mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Source</h3>
            <p class="text-gray-600">We source premium Zoom fabric from Dubai</p>
          </div>
          <div class="text-center">
            <div class="bg-emerald-100 rounded-full p-6 inline-block mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Craft</h3>
            <p class="text-gray-600">Skilled artisans bring our designs to life</p>
          </div>
          <div class="text-center">
            <div class="bg-emerald-100 rounded-full p-6 inline-block mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Deliver</h3>
            <p class="text-gray-600">We ensure timely and safe delivery to you</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Our Commitment -->
    <section class="bg-emerald-700 text-white py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-extrabold mb-4">Our Commitment to You</h2>
        <p class="text-xl mb-8">We're dedicated to providing you with the highest quality abayas, exceptional customer service, and a seamless shopping experience.</p>
        <a href="#" class="inline-block bg-white text-emerald-700 font-bold py-3 px-8 rounded-full hover:bg-gray-100 transition duration-300">
          Shop Now
        </a>
      </div>
    </section>
  </UserLayout>
</template>