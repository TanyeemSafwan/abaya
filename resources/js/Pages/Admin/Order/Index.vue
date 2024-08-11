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
    <el-dialog v-model="dialogVisible" title="Edit Order" width="30%"
        :before-close="handleClose">


        <form class="max-w-md mx-auto" @submit.prevent="updateOrder()">
            <div class="relative z-0 w-full mb-5 group">
                <input v-model="name" type="text" name="floating_title" id="floating_title"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " required />
                <label for="floating_email"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Name</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input v-model="address_1" type="text" name="floating_title" id="floating_title"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " required />
                <label for="floating_email"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Address</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input v-model="total_price" type="text" name="floating_price" id="floating_price"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " required />
                <label for="floating_price"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Total</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input v-model="phone" type="number" name="quantity" id="floating_quantity"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " required />
                <label for="floating_quantity"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone</label>
            </div>


            <form class="max-w-sm mb-4">
                <label for="categories" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                    Status</label>
                <select id="categories" v-model="status"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option v-for="status in allStatus" :key="status.id" :value="status.name">{{ status.name }}
                    </option>
                </select>
            </form>

            <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                <div class="relative z-0 w-full mb-6 group">
                    <div v-for="product in productsOrdered" :key="product.id">
                        {{ product.name }}: {{ product.quantity }}items -- {{ product.size }} size
                    </div>
                </div>
            </div>

            <div class="flex flex-nowrap mb-8 ">
                    <div v-for="(pimage, index) in product_images" :key="pimage.id" class="relative w-32 h-32 ">
                        <img class="w-24 h-20 rounded" :src="`/${pimage.image}`" alt="">
                        <span
                            class="absolute top-0 right-8 transform -translate-y-1/2 w-3.5 h-3.5 bg-red-400 border-2 border-white dark:border-gray-800 rounded-full">
                            <span @click="deleteImage(pimage, index)"
                                class="text-white text-xs font-bold absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 hover:cursor-pointer">x</span>
                        </span>
                    </div>
            </div>

            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </form>

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
                                        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Pending</button>
                                        <button v-else-if="order.status === 'In Progress'" type="button"
                                        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">In Progress</button>
                                        <button v-else-if="order.status === 'Cancelled'" type="button"
                                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Cancelled</button>
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