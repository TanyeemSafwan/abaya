<template>
  <Head>
    <title>Order History</title>
  </Head>
  <UserLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <h1 class="text-4xl font-bold text-gray-900 mb-8 text-center">Order History</h1>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
          <h2 class="text-xl font-semibold text-gray-700 mb-2">Total Orders</h2>
          <p class="text-3xl font-bold text-blue-600">{{ totalOrders }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
          <h2 class="text-xl font-semibold text-gray-700 mb-2">Total Spent</h2>
          <p class="text-3xl font-bold text-green-600">{{ totalSpent }} Taka</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500">
          <h2 class="text-xl font-semibold text-gray-700 mb-2">Average Order</h2>
          <p class="text-3xl font-bold text-purple-600">{{ averageOrderValue }} Taka</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
          <canvas id="orderChart"></canvas>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <div class="flex flex-wrap gap-4 mb-4">
          <input 
            v-model="searchTerm"
            type="text"
            placeholder="Search by Order ID or Name"
            class="flex-grow px-4 py-2 rounded-lg border-2 border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          />
          <select 
            v-model="statusFilter"
            class="px-4 py-2 rounded-lg border-2 border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          >
            <option value="All">All Statuses</option>
            <option value="Pending">Pending</option>
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
            <option value="Cancelled">Cancelled</option>
          </select>
          <select 
            v-model="sortBy"
            class="px-4 py-2 rounded-lg border-2 border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          >
            <option value="date">Sort by Date</option>
            <option value="total">Sort by Total</option>
          </select>
          <button 
            @click="toggleSortOrder"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300"
          >
            {{ sortOrder === 'asc' ? '↑' : '↓' }}
          </button>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Price</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                <th class="hidden lg:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">City</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="order in filteredOrders" :key="order.id" class="hover:bg-gray-50 transition duration-300 ease-in-out">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ order.id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ order.total_price }} Taka</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  <span :class="statusClass(order.status)" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                    {{ order.status }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ order.name }}</td>
                <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ order.phone }}</td>
                <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ order.city }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ new Date(order.created_at).toLocaleDateString() }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </UserLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import UserLayout from './Layouts/UserLayout.vue';
import { ref, computed, onMounted } from 'vue';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

const props = defineProps({
  orders: Array
});

const searchTerm = ref('');
const statusFilter = ref('All');
const sortBy = ref('date');
const sortOrder = ref('desc');

const filteredOrders = computed(() => {
  return props.orders
    .filter(order => 
      (order.id.toString().includes(searchTerm.value) ||
      order.name.toLowerCase().includes(searchTerm.value.toLowerCase())) &&
      (statusFilter.value === 'All' || order.status === statusFilter.value)
    )
    .sort((a, b) => {
      const modifier = sortOrder.value === 'asc' ? 1 : -1;
      if (sortBy.value === 'date') {
        return modifier * (new Date(b.created_at) - new Date(a.created_at));
      } else if (sortBy.value === 'total') {
        return modifier * (b.total_price - a.total_price);
      }
      return 0;
    });
});

const totalOrders = computed(() => filteredOrders.value.length);

const totalSpent = computed(() => {
  const sum = filteredOrders.value.reduce((acc, order) => acc + parseFloat(order.total_price || 0), 0);
  return sum.toFixed(2);
});

const averageOrderValue = computed(() => {
  const avg = totalOrders.value ? (totalSpent.value / totalOrders.value) : 0;
  return avg ? avg.toFixed(2) : '0.00';
});

const statusCounts = computed(() => {
  const counts = { Pending: 0, "In Progress": 0, Completed: 0, Cancelled: 0 };
  filteredOrders.value.forEach(order => {
    counts[order.status]++;
  });
  return counts;
});

const statusClass = status => {
  return {
    'bg-yellow-100 text-yellow-800': status === 'Pending',
    'bg-blue-100 text-blue-800': status === 'In Progress',
    'bg-green-100 text-green-800': status === 'Completed',
    'bg-red-100 text-red-800': status === 'Cancelled'
  };
};

const toggleSortOrder = () => {
  sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
};

const initChart = () => {
  const ctx = document.getElementById('orderChart');
  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: Object.keys(statusCounts.value),
      datasets: [{
        data: Object.values(statusCounts.value),
        backgroundColor: ['#FCD34D', '#60A5FA', '#34D399', '#F87171'],
        borderColor: ['#FDE68A', '#BFDBFE', '#6EE7B7', '#FCA5A5'],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom',
        },
        title: {
          display: true,
          text: 'Order Status Distribution'
        }
      }
    }
  });
};

onMounted(() => {
  initChart();
});
</script>

<style scoped>
@media (max-width: 640px) {
  table {
    font-size: 0.75rem;
  }
}
</style>
