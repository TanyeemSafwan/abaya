<script setup>
import AdminLayout from '../Components/AdminLayout.vue';
import Paigination from '../../../Components/Paigination.vue';
import { inject, ref } from 'vue';
import { router } from '@inertiajs/vue3';
const props = defineProps({
  orders: Object,
  products: Array,
  orderItems: Array
})

const $swal = inject('$swal');

const id = ref('');
const status = ref('');
const total_price = ref('');
const user_address_id = ref('');
const phone = ref('');
const name = ref('');
const address_1 = ref('');
const size = ref('');
const specialInstructions = ref('');
const dialogVisible = ref(false);


const allStatus = [ 
    {
        id: 1,
        name: 'Pending'
    },
    {
        id: 2,
        name: 'In Progress'
    },
    {
        id: 3,
        name: 'Cancelled'
    },
    {
        id: 4,
        name: 'Delivered'
    }
];

const productsOrdered = ref([]);

const openEditModal = async (order) => {
    dialogVisible.value = true;

    id.value = order.id;
    status.value = order.status;
    total_price.value = order.total_price;
    user_address_id.value = order.user_address_id || null;
    phone.value = order.phone;
    name.value = order.name;
    address_1.value = order.address_1;

    productsOrdered.value = props.orderItems.filter((value) => value.order_id === order.id);
    
}

const resetFormData = () => {
    id.value = '';
    status.value = '';
    total_price.value = '';
    user_address_id.value = '';
    phone.value = '';
    name.value = [];
    address_1.value = '';
}

const updateOrder = async () => {
    const formData = new FormData();
    formData.append('status', status.value);
    formData.append('total_price', total_price.value);
    formData.append('user_address_id', user_address_id.value);
    formData.append('phone', phone.value);
    formData.append('name', name.value);
    formData.append('address_1', address_1.value);
    formData.append('_method', 'PUT');

    try {
        await router.post('orders/update/' + id.value, formData, {
            onSuccess: (page) => {
                dialogVisible.value = false;
                resetFormData();
                $swal.fire({
                    toast: true,
                    icon: "success",
                    position: "top-end",
                    showConfirmButton: false,
                    title: page.props.flash.success
                });
            }
        })
    }catch(err) {

    }

};

const deleteOrder = (order, index) => {
    $swal.fire({
        title: 'Are you Sure',
        text: "This actions cannot undo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'no',
        confirmButtonText: 'yes, delete!'
    }).then((result) => {
        if (result.isConfirmed) {
            try {
                router.delete('orders/delete/' + order.id, {
                    onSuccess: (page) => {
                        $swal.fire({
                            toast: true,
                            icon: "success",
                            position: "top-end",
                            showConfirmButton: false,
                            title: page.props.flash.success
                        });
                    }
                })
            } catch (err) {
                console.log(err)
            }
        }
    })
}
</script>
<template>
  <AdminLayout>
    <el-dialog v-model="dialogVisible" title="" width="50%" :before-close="handleClose">
  <div class="bg-gradient-to-r from-blue-100 to-purple-100 p-6 rounded-lg shadow-xl">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Order Details</h2>
    
    <form class="space-y-6" @submit.prevent="updateOrder()">
      <div class="grid md:grid-cols-2 gap-4">
        <div class="space-y-2">
          <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
          <input v-model="name" type="text" id="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required />
        </div>
        
        <div class="space-y-2">
          <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
          <input v-model="address_1" type="text" id="address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required />
        </div>
        
        <div class="space-y-2">
          <label for="total" class="block text-sm font-medium text-gray-700">Total</label>
          <input v-model="total_price" type="text" id="total" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required />
        </div>
        
        <div class="space-y-2">
          <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
          <input v-model="phone" type="tel" id="phone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required />
        </div>
      </div>
      
      <div class="space-y-2">
        <label for="status" class="block text-sm font-medium text-gray-700">Order Status</label>
        <select v-model="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
          <option v-for="status in allStatus" :key="status.id" :value="status.name">{{ status.name }}</option>
        </select>
      </div>
      
      <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Ordered Products</h3>
        <ul class="space-y-2">
          <li v-for="product in productsOrdered" :key="product.id" class="flex justify-between items-center">
            <span>{{ product.name }}</span>
            <span class="text-sm text-gray-600">{{ product.quantity }} items - {{ product.size }} size</span>
          </li>
        </ul>
      </div>
      
      <div v-if="product_images && product_images.length" class="space-y-2">
        <h3 class="text-lg font-semibold">Product Images</h3>
        <div class="flex flex-wrap gap-4">
          <div v-for="(pimage, index) in product_images" :key="pimage.id" class="relative group">
            <img class="w-24 h-24 object-cover rounded-lg shadow-md" :src="`/${pimage.image}`" alt="Product image">
            <button @click="deleteImage(pimage, index)" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>
      
      <div class="flex justify-end">
        <button type="submit" class="px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 transition">
          Update Order
        </button>
      </div>
    </form>
  </div>
</el-dialog>
    <div v-if="props.orders.data.length">
      <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Oder Id</th>
                                <th scope="col" class="px-4 py-3">Name</th>
                                <th scope="col" class="px-4 py-3">Address</th>
                                <th scope="col" class="px-4 py-3">City</th>
                                <th scope="col" class="px-4 py-3">Phone</th>
                                <th scope="col" class="px-4 py-3">Amount</th>
                                <th scope="col" class="px-4 py-3">Order Date</th>
                                <th scope="col" class="px-4 py-3">Status</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in props.orders.data" :key="order.id" class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">{{ order.id }}</td>
                                <td class="px-4 py-3">{{ order.name }}</td>
                                <td class="px-4 py-3">{{ order.address_1 }}</td>
                                <td class="px-4 py-3">{{ order.city }}</td>
                                <td class="px-4 py-3">{{ order.phone }}</td>
                                <td class="px-4 py-3">{{ order.total_price }}</td>
                                <td class="px-4 py-3">{{ order.created_at }}</td>
                                <td class="px-4 py-3">
                                    <button v-if="order.status === 'Pending'" type="button"
                                        class="focus:outline-none text-white bg-yellow-500 hover:bg-yellow-500 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-yellow-500 dark:hover:bg-yellow-500 dark:focus:ring-green-800">Pending</button>
                                        <button v-else-if="order.status === 'In Progress'" type="button"
                                        class="focus:outline-none text-white bg-blue-500 hover:bg-blue-500 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-500 dark:hover:bg-blue-500 dark:focus:ring-green-800">In Progress</button>
                                        <button v-else-if="order.status === 'Cancelled'" type="button"
                                        class="focus:outline-none text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-500 dark:hover:bg-red-500 dark:focus:ring-red-800">Cancelled</button>
                                        <button v-else type="button"
                                        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Delivered</button>
                                </td>
                                <td class="px-4 py-3 flex items-center justify-end">

                                    <button :id="`${order.id}-button`" :data-dropdown-toggle="`${order.id}`"
                                        class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                        type="button">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                    <div :id="`${order.id}`"
                                        class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                            :aria-labelledby="`${order.id}-button`">

                                            <li>
                                                <a href="#" @click="openEditModal(order)"
                                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                            </li>
                                        </ul>
                                        <div class="py-1">
                                            <a href="#" @click="deleteOrder(order, index)"
                                                class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
      <Paigination :pagination="props.orders.meta"  class="py-4"/>

    </div>
  </AdminLayout>
</template>