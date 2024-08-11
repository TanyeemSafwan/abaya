<script setup>
import UserLayout from './Layouts/UserLayout.vue';
import { computed, ref } from 'vue';

const props = defineProps({
  orders: Array
});

const searchTerm = ref('');

const filteredOrders = computed(() => {
  return props.orders.filter(order => 
    order.id.toString().includes(searchTerm.value) ||
    order.name.toLowerCase().includes(searchTerm.value.toLowerCase())
  );
});
</script>

<template>
  <UserLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-6 text-center relative">
        <span class="absolute inset-x-0 bottom-0 border-b-4 border-indigo-600 mx-auto w-1/2"></span>
        Order History
      </h2>

      <div class="mb-4">
        <input 
          v-model="searchTerm"
          type="text"
          placeholder="Search by Order ID or Name"
          class="w-full px-4 py-2 rounded-lg border-2 border-indigo-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        >
      </div>

      <div class="overflow-x-auto bg-gradient-to-br from-indigo-50 to-purple-50 p-4 rounded-lg shadow-lg">
        <table class="min-w-full bg-white border border-indigo-200 rounded-lg overflow-hidden">
          <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Order ID</th>
              <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Total Price</th>
              <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
              <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Name</th>
              <th class="hidden md:table-cell px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Phone</th>
              <th class="hidden lg:table-cell px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">City</th>
              <th class="hidden xl:table-cell px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Address</th>
              <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Date</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-indigo-100">
            <tr v-for="order in filteredOrders" :key="order.id" class="hover:bg-indigo-50 transition duration-300 ease-in-out">
              <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-indigo-900">{{ order.id }}</td>
              <td class="px-4 py-4 whitespace-nowrap text-sm text-indigo-900">{{ order.total_price }} Taka</td>
              <td class="px-4 py-4 whitespace-nowrap text-sm">
                <span :class="{
                  'bg-yellow-100 text-yellow-800': order.status === 'Pending',
                  'bg-green-100 text-green-800': order.status === 'Completed',
                  'bg-red-100 text-red-800': order.status === 'Cancelled'
                }" class="inline-flex px-2 py-1 text-xs font-medium rounded-full">
                  {{ order.status }}
                </span>
              </td>
              <td class="px-4 py-4 whitespace-nowrap text-sm text-indigo-900">{{ order.name }}</td>
              <td class="hidden md:table-cell px-4 py-4 whitespace-nowrap text-sm text-indigo-900">{{ order.phone }}</td>
              <td class="hidden lg:table-cell px-4 py-4 whitespace-nowrap text-sm text-indigo-900">{{ order.city }}</td>
              <td class="hidden xl:table-cell px-4 py-4 whitespace-nowrap text-sm text-indigo-900">{{ order.address_1 }}</td>
              <td class="px-4 py-4 whitespace-nowrap text-sm text-indigo-900">{{ new Date(order.created_at).toLocaleDateString() }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </UserLayout>
</template>

<style scoped>
@media (max-width: 640px) {
  table {
    font-size: 0.75rem;
  }
}
</style>