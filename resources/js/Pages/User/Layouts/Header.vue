<script setup>
import { usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();

const isRoute = (name) => {
  return route().current(name);
}

const canLogin = page.props.canLogin;
const canRegister = page.props.canRegister;
const auth = page.props.auth;
const cart = computed(() => page.props.cart);

const navItems = computed(() => [
  { label: 'Home', route: route('user.home'), routeName: 'user.home' },
  { label: 'All Products', route: route('products.index'), routeName: 'products.index' },
  ...(auth.user ? [{ label: 'Order History', route: '#', routeName: '' }] : []),
  { label: 'About', route: route('user.about'), routeName: 'user.about' },
  { label: 'Contact', route: route('user.contact'), routeName: 'user.contact' },
])

const isMobileMenuOpen = ref(false);

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};
</script>

<template>
  <!--Header-->
  <nav class="bg-gradient-animate border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      <Link :href="route('user.home')" class="flex items-center space-x-4 transition-all duration-300 hover:scale-105">
        <div class="relative">
          <img src="/application_images/abaya_logo.png" class="h-16 w-auto object-contain filter drop-shadow-lg hover:drop-shadow-2xl transition-all duration-300" alt="Abaya Logo" />
          <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-yellow-500 opacity-0 hover:opacity-40 mix-blend-overlay transition-opacity duration-300 rounded-full"></div>
        </div>

        <span class="text-3xl font-bold bg-gradient-to-r from-yellow-300 to-yellow-300 bg-clip-text text-transparent hover:bg-yellow-400 transition duration-300 ease-in-out drop-shadow-lg">
          Abaya
        </span>
      </Link>
      <div v-if="canLogin" class="flex items-center md:order-2 space-x-4 md:space-x-2 rtl:space-x-reverse">
  <!-- Cart Button -->
  <div class="relative group">
    <Link :href="route('cart.view')" 
      class="inline-flex items-center p-2 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
      </svg>
      <span class="sr-only">Cart</span>
      <div class="absolute -top-2 -right-2 inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full shadow-lg group-hover:bg-red-600 transition-colors duration-300">
        {{ cart.data.count }}
      </div>
    </Link>
  </div>

  <!-- User Menu Button (when logged in) -->
  <div v-if="auth.user" class="relative">
    <button type="button"
      class="flex text-sm bg-gradient-to-r from-purple-500 to-pink-500 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-300 ease-in-out transform hover:scale-105"
      id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
      <span class="sr-only">Open user menu</span>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 p-1 text-white">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
      </svg>
    </button>
  </div>

  <!-- Login/Register Buttons (when logged out) -->
  <div v-else class="flex space-x-2">
    <Link :href="route('login')"
      class="text-white bg-gradient-to-r from-cyan-400 to-blue-500 hover:from-cyan-500 hover:to-blue-600 focus:ring-4 focus:outline-none focus:ring-cyan-200 font-medium rounded-full text-sm px-5 py-2.5 text-center transition-all duration-300 ease-in-out transform hover:scale-105">
      Login
    </Link>
    <Link v-if="canRegister" :href="route('register')"
      class="text-white bg-gradient-to-r from-green-400 to-blue-500 hover:from-green-500 hover:to-blue-600 focus:ring-4 focus:outline-none focus:ring-green-200 font-medium rounded-full text-sm px-5 py-2.5 text-center transition-all duration-300 ease-in-out transform hover:scale-105">
      Register
    </Link>
  </div>

  <!-- User Dropdown Menu -->
  <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
    <div class="px-4 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-t-lg">
      <span class="block text-sm font-semibold">Bonnie Green</span>
      <span class="block text-sm opacity-75 truncate">name@flowbite.com</span>
    </div>
    <ul class="py-2" aria-labelledby="user-menu-button">
      <li>
        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white transition-colors duration-200">Dashboard</a>
      </li>
      <li>
        <Link :href="route('logout')" method="post" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white transition-colors duration-200">
          Sign out
        </Link>
      </li>
    </ul>
  </div>

  <!-- Mobile Menu Toggle Button -->
  <button @click="toggleMobileMenu" type="button"
    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 transition-colors duration-200"
    aria-controls="navbar-user" aria-expanded="false">
    <span class="sr-only">Open main menu</span>
    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
    </svg>
  </button>
</div>
      <div :class="{'hidden': !isMobileMenuOpen, 'block': isMobileMenuOpen}" class="items-center justify-between w-full md:flex md:w-auto md:order-1" id="navbar-user">
        <ul class="flex flex-wrap items-center justify-center p-4 md:space-x-8 text-white">
    <li v-for="(item, index) in navItems" :key="index" class="my-2 md:my-0">
      <Link
        :href="item.route"
        :class="[
          'block py-2 px-4 rounded-full transition-all duration-300 ease-in-out',
          'hover:bg-white hover:text-indigo-600 hover:shadow-md',
          'focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50',
          isRoute(item.routeName)
            ? 'bg-white text-indigo-600 font-semibold shadow-md'
            : 'hover:scale-105'
        ]"
        :aria-current="isRoute(item.routeName) ? 'page' : undefined"
      >
        {{ item.label }}
      </Link>
    </li>
  </ul>
      </div>
    </div>
  </nav>
  <!--Header end-->
</template>

<style scoped>
.bg-gradient-animate {
  background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
  background-size: 400% 400%;
  animation: gradient 15s ease infinite;
}

@keyframes gradient {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}
</style>