<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from './Components/AdminLayout.vue';
import { ref, computed } from 'vue';

const props = defineProps({
  messages: Array,
});

const search = ref('');
const selectedMessage = ref(null);

const filteredMessages = computed(() => {
  return props.messages.filter(message => 
    message.name.toLowerCase().includes(search.value.toLowerCase()) ||
    message.email.toLowerCase().includes(search.value.toLowerCase()) ||
    message.message.toLowerCase().includes(search.value.toLowerCase())
  );
});

const showMessage = (message) => {
  selectedMessage.value = message;
};

const closeMessage = () => {
  selectedMessage.value = null;
};

const deleteMessage = (id) => {
  if (confirm('Are you sure you want to delete this message?')) {
    router.delete(route('admin.contact-messages.destroy', id), {
      preserveScroll: true,
      preserveState: true,
    });
  }
};
</script>

<template>
  <Head title="Contact Messages" />

  <AdminLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
          <h1 class="text-2xl font-semibold mb-6">Contact Messages</h1>

          <input v-model="search" type="text" placeholder="Search messages..." class="w-full mb-4 p-2 border rounded">

          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="message in filteredMessages" :key="message.id">
                  <td class="px-6 py-4 whitespace-nowrap">{{ message.name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ message.email }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ new Date(message.created_at).toLocaleDateString() }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <button @click="showMessage(message)" class="text-indigo-600 hover:text-indigo-900 mr-2">View</button>
                    <button @click="deleteMessage(message.id)" class="text-red-600 hover:text-red-900">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal for viewing full message -->
    <div v-if="selectedMessage" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
      <div class="bg-white p-5 rounded-lg shadow-xl max-w-md w-full">
        <h2 class="text-xl font-semibold mb-4">Message from {{ selectedMessage.name }}</h2>
        <p class="mb-2"><strong>Email:</strong> {{ selectedMessage.email }}</p>
        <p class="mb-4"><strong>Date:</strong> {{ new Date(selectedMessage.created_at).toLocaleString() }}</p>
        <p class="mb-4"><strong>Message:</strong></p>
        <p class="whitespace-pre-wrap">{{ selectedMessage.message }}</p>
        <button @click="closeMessage" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
          Close
        </button>
      </div>
    </div>
  </AdminLayout>
</template>