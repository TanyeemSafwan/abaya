<script setup>
import { usePage, router } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { computed, ref, onMounted, onUnmounted } from 'vue';

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
  { label: 'Products', route: route('products.index'), routeName: 'products.index' },
  { label: 'About', route: route('user.about'), routeName: 'user.about' },
  { label: 'Contact', route: route('contact.index'), routeName: 'contact.index' },
])

const isMobileMenuOpen = ref(false);
const isSearchOpen = ref(false);
const isUserMenuOpen = ref(false);

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const toggleSearch = () => {
  isSearchOpen.value = !isSearchOpen.value;
};

const toggleUserMenu = () => {
  isUserMenuOpen.value = !isUserMenuOpen.value;
};

const closeUserMenu = (event) => {
  if (!event.target.closest('#user-menu-button') && !event.target.closest('#user-menu-dropdown')) {
    isUserMenuOpen.value = false;
  }
};

onMounted(() => {
  document.addEventListener('click', closeUserMenu);
});

onUnmounted(() => {
  document.removeEventListener('click', closeUserMenu);
});

const logout = () => {
  // Implement logout functionality here
  // For example:
  // Inertia.post(route('logout'));
};

const searchQuery = ref('');

const handleSearch = () => {
  if (searchQuery.value.trim()) {
    router.get(route('search'), { query: searchQuery.value.trim() });
  }
};
</script>

<template>
  <header class="bg-white shadow-md relative z-20">
    <!-- Top bar -->

    <!-- Main header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center py-4">
        <div class="flex items-center">
          <Link :href="route('user.home')" class="flex-shrink-0 flex items-center">
            <img src="/application_images/abaya_logo.png" class="h-10 w-auto" alt="Abaya Logo" />
            <span class="ml-2 text-2xl font-bold text-gray-900">Abaya</span>
          </Link>
        </div>

        <!-- Search bar -->
        <div class="hidden md:block flex-grow max-w-xl mx-8">
          <div class="relative">
            <input 
              v-model="searchQuery"
              @keyup.enter="handleSearch"
              type="text" 
              placeholder="Search products..." 
              class="w-full py-2 px-4 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >
            <button @click="handleSearch" class="absolute right-0 top-0 mt-2 mr-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </button>
          </div>
        </div>

        <div class="flex items-center space-x-4">
          <!-- Cart -->
          <Link :href="route('cart.view')" 
            class="relative text-gray-600 hover:text-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
              {{ cart.data.count }}
            </span>
          </Link>

          <!-- User menu -->
          <div class="relative">
            <button @click="toggleUserMenu" type="button" class="flex items-center space-x-2 text-gray-600 hover:text-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              <span class="hidden md:inline">My Account</span>
            </button>
            
            <!-- Dropdown menu -->
            <div v-if="isUserMenuOpen" id="user-menu-dropdown" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
              <template v-if="auth.user">
                <Link :href="route('user.home')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Home</Link>
                <Link :href="route('user.history')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Orders</Link>
                <Link :href="route('profile.edit')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Profile</Link>
                <Link :href="route('logout')" method="post" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Logout</Link>
              </template>
              <template v-else>
                <Link :href="route('login')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Login</Link>
                <Link v-if="canRegister" :href="route('register')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Register</Link>
              </template>
            </div>
          </div>

          <!-- Mobile menu button -->
          <button @click="toggleMobileMenu" type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-controls="mobile-menu" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-gray-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-12">
          <div class="hidden md:block">
            <div class="flex items-baseline space-x-4">
              <Link v-for="item in navItems" :key="item.label"
                :href="item.route"
                :class="[
                  'px-3 py-2 rounded-md text-sm font-medium',
                  isRoute(item.routeName)
                    ? 'bg-gray-900 text-white'
                    : 'text-gray-300 hover:bg-gray-700 hover:text-white'
                ]"
              >
                {{ item.label }}
              </Link>
            </div>
          </div>
          <div class="flex md:hidden">
            <button @click="toggleSearch" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Mobile menu, show/hide based on menu state -->
    <div v-show="isMobileMenuOpen" class="md:hidden" id="mobile-menu">
      <div class="px-2 pt-2 pb-3 space-y-1">
        <Link v-for="item in navItems" :key="item.label"
          :href="item.route"
          :class="[
            'block px-3 py-2 rounded-md text-base font-medium',
            isRoute(item.routeName)
              ? 'bg-gray-900 text-white'
              : 'text-gray-300 hover:bg-gray-700 hover:text-white'
          ]"
        >
          {{ item.label }}
        </Link>
      </div>
      <div v-if="!auth.user" class="pt-4 pb-3 border-t border-gray-700">
        <div class="px-2 space-y-1">
          <Link :href="route('login')" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Login</Link>
          <Link v-if="canRegister" :href="route('register')" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Register</Link>
        </div>
      </div>
    </div>

    <!-- Mobile search, show/hide based on search state -->
    <div v-show="isSearchOpen" class="md:hidden px-2 py-4">
      <div class="relative">
        <input 
          v-model="searchQuery"
          @keyup.enter="handleSearch"
          type="text" 
          placeholder="Search products..." 
          class="w-full py-2 px-4 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
        <button @click="handleSearch" class="absolute right-0 top-0 mt-2 mr-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </button>
      </div>
    </div>
  </header>
</template>