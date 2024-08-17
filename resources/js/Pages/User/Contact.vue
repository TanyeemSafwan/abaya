<script setup>
import { Head } from '@inertiajs/vue3';
import UserLayout from './Layouts/UserLayout.vue'
import { ref } from 'vue';

const name = ref('');
const email = ref('');
const message = ref('');

const submitForm = () => {
  // Handle form submission logic here
  console.log('Form submitted:', { name: name.value, email: email.value, message: message.value });
};
</script>

<template>
  <Head>
    <title>Contact | Abaya</title>
  </Head>
  <UserLayout>
    <div class="bg-gradient-to-br from-gray-900 to-black min-h-screen py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-extrabold text-white text-center mb-12">Contact Us</h1>
        
        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden">
          <div class="grid grid-cols-1 lg:grid-cols-2">
            <!-- Map and Contact Info Section -->
            <div class="p-8 bg-gradient-to-br from-green-600 to-green-800 text-white">
              <h2 class="text-2xl font-bold mb-6">Our Location</h2>
              <div class="aspect-w-16 aspect-h-9 mb-8">
                <iframe class="rounded-xl shadow-lg" width="100%" height="100%" frameborder="0" style="border:0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2367.834585319296!2d90.43882349875665!3d23.75807859854222!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b94fae9ffe29%3A0x4ce2c6c6e299413!2sDakhin%20Banasree%20Dhaka!5e0!3m2!1sen!2sbd!4v1723262129173!5m2!1sen!2sbd" allowfullscreen></iframe>
              </div>
              <div class="space-y-4">
                <div class="flex items-start">
                  <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                  <p>House no 20, Road no 4, Block C, South Banasree, Dhaka 1219, Bangladesh</p>
                </div>
                <div class="flex items-center">
                  <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                  <a href="mailto:example@email.com" class="hover:underline">example@email.com</a>
                </div>
                <div class="flex items-center">
                  <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                  <p>01300-722027</p>
                </div>
              </div>
            </div>

            <!-- Contact Form Section -->
            <div class="p-8 bg-white">
              <h2 class="text-3xl font-bold text-gray-900 mb-6">Get in Touch</h2>
              <form @submit.prevent="submitForm" class="space-y-6">
                <div>
                  <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                  <input v-model="name" type="text" id="name" name="name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                  <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                  <input v-model="email" type="email" id="email" name="email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                  <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                  <textarea v-model="message" id="message" name="message" rows="4" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"></textarea>
                </div>
                <div>
                  <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                    Send Message
                  </button>
                </div>
              </form>
              <p class="mt-4 text-sm text-gray-500 text-center">Your insights help us create the best shopping experience.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </UserLayout>
</template>