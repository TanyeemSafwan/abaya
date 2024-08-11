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
    <title>{{ 'Product List | Abaya' }}</title>
  </Head>
  <UserLayout>
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50">
      <div>
        <!-- Mobile filter dialog -->
        <TransitionRoot as="template" :show="mobileFiltersOpen">
          <!-- ... (keep existing mobile filter dialog code) ... -->
        </TransitionRoot>

        <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-gray-200 pb-6 pt-24">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900 mb-4 md:mb-0">
              <span class="text-indigo-600">Discover</span> Our Products
            </h1>

            <div class="flex items-center space-x-4">
              <Menu as="div" class="relative inline-block text-left">
                <div>
                  <MenuButton
                    class="group inline-flex items-center justify-center rounded-md bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-100">
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
                    class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <div class="py-1">
                      <MenuItem v-for="option in sortOptions" :key="option.value" v-slot="{ active }">
                        <a @click.prevent="changeSort(option.value)" :href="'#'"
                          :class="[currentSort === option.value ? 'font-medium text-indigo-600' : 'text-gray-500', active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm hover:bg-indigo-50 transition duration-150 ease-in-out']">
                          {{ option.name }}
                        </a>
                      </MenuItem>
                    </div>
                  </MenuItems>
                </transition>
              </Menu>

              <Link type="button"
                :href="route('cart.view')"
                class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                <ShoppingBagIcon class="h-5 w-5 mr-2" aria-hidden="true" />
                View Cart
              </Link>

              <button type="button"
                class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 md:hidden"
                @click="mobileFiltersOpen = true">
                <FunnelIcon class="h-5 w-5 mr-2" aria-hidden="true" />
                Filters
              </button>
            </div>
          </div>

          <section aria-labelledby="products-heading" class="pb-24 pt-6">
            <h2 id="products-heading" class="sr-only">Products</h2>

            <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
              <!-- Filters -->
              <form class="hidden lg:block bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-4 text-gray-900">Filters</h3>
                
                <!-- Price filter -->
                <div class="mb-6">
                  <h4 class="text-sm font-medium text-gray-900 mb-2">Price Range</h4>
                  <div class="flex items-center space-x-4">
                    <div class="flex-1">
                      <input type="number" id="filters-price-from" placeholder="Min" v-model.number="filterPrices.prices[0]"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    </div>
                    <div class="flex-1">
                      <input type="number" id="filters-price-to" placeholder="Max" v-model.number="filterPrices.prices[1]"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    </div>
                  </div>
                </div>

                <!-- Brand filter -->
                <Disclosure as="div" class="mb-6" v-slot="{ open }">
                  <h3 class="-my-3 flow-root">
                    <DisclosureButton
                      class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500">
                      <span class="font-medium text-gray-900">Brands</span>
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
                          class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
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
                          class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                        <label :for="`filter-category-${category.id}`" class="ml-3 text-sm text-gray-600">{{ category.name }}</label>
                      </div>
                    </div>
                  </DisclosurePanel>
                </Disclosure>
              </form>

              <!-- Product grid -->
              <div class="lg:col-span-3">
                <Products :products="products.data" />
                <div class="mt-8 flex justify-center">
                  <nav aria-label="Page navigation">
                    <ul class="inline-flex -space-x-px rounded-md shadow-sm">
                      <li v-for="(link, index) in props.products.meta.links" :key="index">
                        <a :href="link.url"
                          class="px-4 py-2 text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 hover:text-gray-700 focus:z-10 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50 transition ease-in-out duration-150"
                          :class="[
                            link.url ? '' : 'opacity-50 cursor-not-allowed',
                            link.active ? 'bg-indigo-50 text-indigo-600 z-10' : '',
                            index === 0 ? 'rounded-l-md' : '',
                            index === props.products.meta.links.length - 1 ? 'rounded-r-md' : ''
                          ]"
                          v-html="link.label"
                        ></a>
                      </li>
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
          </section>
        </main>
      </div>
    </div>
  </UserLayout>
</template>