<script setup>
import UserLayout from './Layouts/UserLayout.vue';
import { ref, watch } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import {
  Dialog,
  DialogPanel,
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { ShoppingBagIcon, AdjustmentsVerticalIcon } from '@heroicons/vue/24/outline';
import { ChevronDownIcon, FunnelIcon, MinusIcon, PlusIcon, Squares2X2Icon } from '@heroicons/vue/20/solid';
import Products from '../User/Components/Products.vue';
import SecondaryButtonVue from '@/Components/SecondaryButton.vue';
import { router, useForm } from '@inertiajs/vue3';

const props = defineProps({
  products: Array,
  brands: Object,
  categories: Object,
  currentSort: String,
  currentPriceRange: Object,
});

const sortOptions = [
  { name: 'Newest', value: 'newest', current: false },
  { name: 'Oldest', value: 'oldest', current: false },
  { name: 'Price: Low to High', value: 'price_asc', current: false },
  { name: 'Price: High to Low', value: 'price_desc', current: false },
]

const currentSort = ref(props.currentSort || sortOptions[0].value);

// Update sortOptions to reflect the current sort
sortOptions.forEach(option => {
  option.current = option.value === currentSort.value;
});

const filterPrices = useForm({
  prices: props.currentPriceRange ? [props.currentPriceRange.from, props.currentPriceRange.to] : [0, 30000]
});

const priceFilter = () => {
  updateFilteredProducts();
}

const mobileFiltersOpen = ref(false)

const selectedBrands = ref([])
const selectedCategories = ref([])

watch([selectedBrands, selectedCategories, currentSort, filterPrices.prices], () => {
  updateFilteredProducts();
});

const updateFilteredProducts = () => {
  router.get('products', {
    brands: selectedBrands.value,
    categories: selectedCategories.value,
    sort: currentSort.value,
    prices: {
      from: filterPrices.prices[0],
      to: filterPrices.prices[1]
    }
  }, {
    preserveState: true,
    replace: true
  });
}

const changeSort = (newSort) => {
  currentSort.value = newSort;
  updateFilteredProducts();
}
</script>

<template>
  <Head>
    <title>Discover Our Collection</title>
  </Head>
  <UserLayout>
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 min-h-screen">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="py-16 text-center">
          <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
            Discover Our <span class="text-green-600">Elegant Collection</span>
          </h1>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Explore our curated selection of premium abayas, designed for the modern, sophisticated woman.
          </p>
        </div>

        <!-- Main Content -->
        <div class="pb-24">
          <!-- Mobile filter dialog -->
          <TransitionRoot as="template" :show="mobileFiltersOpen">
            <Dialog as="div" class="relative z-40 lg:hidden" @close="mobileFiltersOpen = false">
              <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-black bg-opacity-25" />
              </TransitionChild>

              <div class="fixed inset-0 z-40 flex">
                <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="translate-x-full">
                  <DialogPanel class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl">
                    <div class="flex items-center justify-between px-4">
                      <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                      <button type="button" class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white p-2 text-gray-400" @click="mobileFiltersOpen = false">
                        <span class="sr-only">Close menu</span>
                        <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                      </button>
                    </div>

                    <!-- Filters -->
                    <form class="mt-4 border-t border-gray-200">
                      <!-- Price filter -->
                      <div class="px-4 py-6">
                        <h3 class="text-sm font-medium text-gray-900">Price Range</h3>
                        <div class="mt-2 flex items-center space-x-4">
                          <div class="flex-1">
                            <input type="number" id="mobile-filters-price-from" placeholder="Min" v-model.number="filterPrices.prices[0]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50" />
                          </div>
                          <div class="flex-1">
                            <input type="number" id="mobile-filters-price-to" placeholder="Max" v-model.number="filterPrices.prices[1]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50" />
                          </div>
                        </div>
                      </div>

                      <!-- Brand filter -->
                      <Disclosure as="div" class="border-t border-gray-200 px-4 py-6" v-slot="{ open }">
                        <h3 class="-mx-2 -my-3 flow-root">
                          <DisclosureButton class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                            <span class="font-medium text-gray-900">Brand</span>
                            <span class="ml-6 flex items-center">
                              <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                              <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                            </span>
                          </DisclosureButton>
                        </h3>
                        <DisclosurePanel class="pt-6">
                          <div class="space-y-4">
                            <div v-for="brand in brands" :key="brand.id" class="flex items-center">
                              <input :id="`mobile-filter-brand-${brand.id}`" :value="brand.id" type="checkbox" v-model="selectedBrands" class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500" />
                              <label :for="`mobile-filter-brand-${brand.id}`" class="ml-3 text-sm text-gray-600">{{ brand.name }}</label>
                            </div>
                          </div>
                        </DisclosurePanel>
                      </Disclosure>

                      <!-- Category filter -->
                      <Disclosure as="div" class="border-t border-gray-200 px-4 py-6" v-slot="{ open }">
                        <h3 class="-mx-2 -my-3 flow-root">
                          <DisclosureButton class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                            <span class="font-medium text-gray-900">Categories</span>
                            <span class="ml-6 flex items-center">
                              <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                              <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                            </span>
                          </DisclosureButton>
                        </h3>
                        <DisclosurePanel class="pt-6">
                          <div class="space-y-4">
                            <div v-for="category in categories" :key="category.id" class="flex items-center">
                              <input :id="`mobile-filter-category-${category.id}`" :value="category.id" type="checkbox" v-model="selectedCategories" class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500" />
                              <label :for="`mobile-filter-category-${category.id}`" class="ml-3 text-sm text-gray-600">{{ category.name }}</label>
                            </div>
                          </div>
                        </DisclosurePanel>
                      </Disclosure>
                    </form>
                  </DialogPanel>
                </TransitionChild>
              </div>
            </Dialog>
          </TransitionRoot>

          <!-- Filters and Sort -->
          <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-gray-200 pb-6">
            <button type="button"
              class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 md:hidden mb-4 md:mb-0"
              @click="mobileFiltersOpen = true">
              <FunnelIcon class="h-5 w-5 mr-2" aria-hidden="true" />
              Filters
            </button>

            <div class="flex items-center space-x-4">
              <Menu as="div" class="relative inline-block text-left">
                <div>
                  <MenuButton
                    class="group inline-flex items-center justify-center rounded-md bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-gray-100">
                    <AdjustmentsVerticalIcon class="mr-2 h-5 w-5 text-gray-400" aria-hidden="true" />
                    Sort
                    <ChevronDownIcon class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                      aria-hidden="true" />
                  </MenuButton>
                </div>

                <transition enter-active-class="transition ease-out duration-100"
                  enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                  leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100"
                  leave-to-class="transform opacity-0 scale-95">
                  <MenuItems
                    class="absolute right--2 z-10 mt-2 w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <div class="py-1">
                      <MenuItem v-for="option in sortOptions" :key="option.value" v-slot="{ active }">
                        <a @click.prevent="changeSort(option.value)" :href="'#'"
                          :class="[currentSort === option.value ? 'font-medium text-green-600' : 'text-gray-500', active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm hover:bg-green-50 transition duration-150 ease-in-out']">
                          {{ option.name }}
                        </a>
                      </MenuItem>
                    </div>
                  </MenuItems>
                </transition>
              </Menu>

              <Link :href="route('cart.view')"
                class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition duration-150 ease-in-out">
                <ShoppingBagIcon class="h-5 w-5 mr-2" aria-hidden="true" />
                View Cart
              </Link>
            </div>
          </div>

          <div class="mt-8 grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
            <!-- Desktop Filters -->
            <form class="hidden lg:block bg-white p-6 rounded-lg shadow-md">
              <h3 class="text-lg font-semibold mb-6 text-gray-900 border-b pb-2">Refine Your Search</h3>
              
              <!-- Price filter -->
              <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Price Range</h4>
                <div class="flex items-center space-x-4">
                  <div class="flex-1">
                    <input type="number" id="filters-price-from" placeholder="Min" v-model.number="filterPrices.prices[0]"
                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50" />
                  </div>
                  <div class="flex-1">
                    <input type="number" id="filters-price-to" placeholder="Max" v-model.number="filterPrices.prices[1]"
                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50" />
                  </div>
                </div>
              </div>

              <!-- Brand filter -->
              <Disclosure as="div" class="mb-6" v-slot="{ open }">
                <h3 class="-my-3 flow-root">
                  <DisclosureButton
                    class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500">
                    <span class="font-medium text-gray-900">Fabric Type</span>
                    <span class="ml-6 flex items-center">
                      <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                      <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                    </span>
                  </DisclosureButton>
                </h3>
                <DisclosurePanel class="pt-6">
                  <div class="space-y-4">
                    <div v-for="brand in brands" :key="brand.id" class="flex items-center">
                      <input :id="`filter-brand-${brand.id}`" :value="brand.id" type="checkbox" v-model="selectedBrands"
                        class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500" />
                      <label :for="`filter-brand-${brand.id}`" class="ml-3 text-sm text-gray-600">{{ brand.name }}</label>
                    </div>
                  </div>
                </DisclosurePanel>
              </Disclosure>

              <!-- Category filter -->
              <Disclosure as="div" class="mb-6" v-slot="{ open }">
                <h3 class="-my-3 flow-root">
                  <DisclosureButton
                    class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500">
                    <span class="font-medium text-gray-900">Categories</span>
                    <span class="ml-6 flex items-center">
                      <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                      <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                    </span>
                  </DisclosureButton>
                </h3>
                <DisclosurePanel class="pt-6">
                  <div class="space-y-4">
                    <div v-for="category in categories" :key="category.id" class="flex items-center">
                      <input :id="`filter-category-${category.id}`" :value="category.id" type="checkbox"
                        v-model="selectedCategories"
                        class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500" />
                        <label :for="`filter-category-${category.id}`" class="ml-3 text-sm text-gray-600">{{ category.name }}</label>
                    </div>
                  </div>
                </DisclosurePanel>
              </Disclosure>
            </form>

            <!-- Product grid -->
            <div class="lg:col-span-3">
              <Products :products="products.data" />
              <div class="mt-12 flex justify-center">
                <nav aria-label="Page navigation" class="isolate inline-flex -space-x-px rounded-md shadow-sm">
                  <a v-for="(link, index) in products.meta.links" :key="index" :href="link.url"
                    :class="[
                      'relative inline-flex items-center px-4 py-2 text-sm font-medium',
                      link.url ? 'text-gray-500 hover:bg-gray-50 focus:z-20 focus:outline-offset-0' : 'text-gray-300 cursor-not-allowed',
                      link.active ? 'z-10 bg-green-50 border-green-500 text-green-600' : 'bg-white border-gray-300',
                      index === 0 ? 'rounded-l-md' : '',
                      index === products.meta.links.length - 1 ? 'rounded-r-md' : ''
                    ]"
                    v-html="link.label"
                  ></a>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </UserLayout>
</template>