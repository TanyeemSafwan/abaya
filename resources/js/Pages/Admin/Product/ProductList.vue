<script setup>
import { ref, computed, onMounted } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { ElMessage, ElMessageBox } from 'element-plus';
import debounce from 'lodash/debounce';

const props = defineProps({
    products: Array,
    brands: Array,
    categories: Array,
});

const page = usePage();
const currentPage = ref(1);
const pageSize = ref(10);
const searchQuery = ref('');
const selectedCategory = ref('');
const selectedBrand = ref('');
const sortBy = ref('title');
const sortOrder = ref('asc');

const isAddProduct = ref(false);
const editMode = ref(false);
const dialogVisible = ref(false);
const dialogImageUrl = ref('');

const id = ref('');
const title = ref('');
const price = ref('');
const quantity = ref('');
const description = ref('');
const product_images = ref([]);
const published = ref(false);
const category_id = ref('');
const brand_id = ref('');
const inStock = ref(true);

const productImages = ref([]);

const filteredProducts = computed(() => {
    let result = props.products;

    if (searchQuery.value) {
        result = result.filter(product => 
            product.title.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    }

    if (selectedCategory.value) {
        result = result.filter(product => product.category_id === selectedCategory.value);
    }

    if (selectedBrand.value) {
        result = result.filter(product => product.brand_id === selectedBrand.value);
    }

    result.sort((a, b) => {
        if (a[sortBy.value] < b[sortBy.value]) return sortOrder.value === 'asc' ? -1 : 1;
        if (a[sortBy.value] > b[sortBy.value]) return sortOrder.value === 'asc' ? 1 : -1;
        return 0;
    });

    return result;
});

const paginatedProducts = computed(() => {
    const start = (currentPage.value - 1) * pageSize.value;
    const end = start + pageSize.value;
    return filteredProducts.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(filteredProducts.value.length / pageSize.value));

const handleSearch = debounce(() => {
    currentPage.value = 1;
}, 300);

const handleSort = (column) => {
    if (sortBy.value === column) {
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortBy.value = column;
        sortOrder.value = 'asc';
    }
};

const handleFileChange = (file) => {
    productImages.value.push(file);
}

const handlePictureCardPreview = (uploadFile) => {
    dialogImageUrl.value = uploadFile.url;
    dialogVisible.value = true;
}

const handleRemove = (uploadFile) => {
    console.log(uploadFile);
}

const openAddModal = () => {
    isAddProduct.value = true;
    dialogVisible.value = true;
    editMode.value = false;
    resetFormData();
}

const openEditModal = (product) => {
    isAddProduct.value = false;
    dialogVisible.value = true;
    editMode.value = true;

    id.value = product.id;
    title.value = product.title;
    price.value = product.price;
    quantity.value = product.quantity;
    description.value = product.description;
    brand_id.value = product.brand_id;
    category_id.value = product.category_id;
    product_images.value = product.product_images;
    published.value = product.published;
    inStock.value = product.inStock;
}

const resetFormData = () => {
    id.value = '';
    title.value = '';
    price.value = '';
    quantity.value = '';
    description.value = '';
    productImages.value = [];
    dialogImageUrl.value = '';
    category_id.value = '';
    brand_id.value = '';
    published.value = false;
    inStock.value = true;
}

const addProduct = async () => {
    const formData = new FormData();
    formData.append('title', title.value);
    formData.append('price', price.value);
    formData.append('quantity', quantity.value);
    formData.append('description', description.value);
    formData.append('brand_id', brand_id.value);
    formData.append('category_id', category_id.value);
    formData.append('published', published.value);
    formData.append('inStock', inStock.value);

    for (const image of productImages.value) {
        formData.append('product_images[]', image.raw);
    }

    try {
        await router.post('/admin/products/store', formData, {
            onSuccess: page => {
                ElMessage({
                    type: 'success',
                    message: page.props.flash.success
                });
                dialogVisible.value = false;
                resetFormData();
            }
        })
    } catch (err) {
        console.log(err)
    }
}

const deleteImage = async (pimage, index) => {
    try {
        await router.delete('/admin/products/image/' + pimage.id, {
            onSuccess: (page) => {
                product_images.value.splice(index, 1);
                ElMessage({
                    type: 'success',
                    message: page.props.flash.success
                });
            }
        })
    } catch(error) {
        console.error(error);
    }
};

const updateProduct = async () => {
    const formData = new FormData();
    formData.append('title', title.value);
    formData.append('price', price.value);
    formData.append('quantity', quantity.value);
    formData.append('description', description.value);
    formData.append('category_id', category_id.value);
    formData.append('brand_id', brand_id.value);
    formData.append('published', published.value);
    formData.append('inStock', inStock.value);
    formData.append('_method', 'PUT');

    for (const image of productImages.value) {
        formData.append('product_images[]', image.raw);
    }

    try {
        await router.post('/admin/products/update/' + id.value, formData, {
            onSuccess: (page) => {
                dialogVisible.value = false;
                resetFormData();
                ElMessage({
                    type: 'success',
                    message: page.props.flash.success
                });
            }
        })
    } catch(err) {
        console.error(err);
    }
};

const deleteProduct = (product) => {
    ElMessageBox.confirm(
        'Are you sure you want to delete this product?',
        'Warning',
        {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            type: 'warning',
        }
    )
        .then(() => {
            router.delete('/admin/products/destroy/' + product.id, {
                onSuccess: (page) => {
                    ElMessage({
                        type: 'success',
                        message: page.props.flash.success
                    });
                }
            });
        })
        .catch(() => {
            ElMessage({
                type: 'info',
                message: 'Deletion canceled'
            });
        });
}

onMounted(() => {
    // Any initialization logic can go here
});
</script>

<template>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Product List</h1>

        <!-- Filters and Search -->
        <div class="mb-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                <input
                    v-model="searchQuery"
                    @input="handleSearch"
                    type="text"
                    placeholder="Search products..."
                    class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-auto"
                />
                <select
                    v-model="selectedCategory"
                    class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-auto"
                >
                    <option value="">All Categories</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
                <select
                    v-model="selectedBrand"
                    class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-auto"
                >
                    <option value="">All Brands</option>
                    <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                        {{ brand.name }}
                    </option>
                </select>
            </div>
            <button
                @click="openAddModal"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300 w-full sm:w-auto mt-4 sm:mt-0"
            >
                Add Product
            </button>
        </div>

        <!-- Product Table -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="w-full table-auto">
                <thead class="bg-gray-200">
                    <tr>
                        <th
                            v-for="column in ['Title', 'Category', 'Brand', 'Quantity', 'Price', 'Stock', 'Published', 'Actions']"
                            :key="column"
                            @click="handleSort(column.toLowerCase())"
                            class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                        >
                            {{ column }}
                            <span v-if="sortBy === column.toLowerCase()">
                                {{ sortOrder === 'asc' ? '▲' : '▼' }}
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="product in paginatedProducts" :key="product.id">
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">{{ product.title }}</td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">{{ product.category.name }}</td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">{{ product.brand.name }}</td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">{{ product.quantity }}</td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">${{ Number(product.price).toFixed(2) }}</td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                            <span
                                :class="[
                                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                    product.inStock ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'
                                ]"
                            >
                                {{ !product.inStock ? 'In Stock' : 'Out of Stock' }}
                            </span>
                        </td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                            <span
                                :class="[
                                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                    product.published ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800'
                                ]"
                            >
                                {{ !product.published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button
                                @click="openEditModal(product)"
                                class="text-indigo-600 hover:text-indigo-900 mr-2"
                            >
                                Edit
                            </button>
                            <button
                                @click="deleteProduct(product)"
                                class="text-red-600 hover:text-red-900"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 flex flex-col sm:flex-row items-center justify-between">
            <div class="mb-4 sm:mb-0">
                <p class="text-sm text-gray-700">
                    Showing {{ (currentPage - 1) * pageSize + 1 }} to {{ Math.min(currentPage * pageSize, filteredProducts.length) }} of {{ filteredProducts.length }} results
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <button
                        @click="currentPage--"
                        :disabled="currentPage === 1"
                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                    >
                        Previous
                    </button>
                    <button
                        v-for="page in totalPages"
                        :key="page"
                        @click="currentPage = page"
                        :class="[
                            'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                            currentPage === page
                                ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
                        ]"
                    >
                        {{ page }}
                    </button>
                    <button
                        @click="currentPage++"
                        :disabled="currentPage === totalPages"
                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                    >
                        Next
                    </button>
                </nav>
            </div>
        </div>

        <!-- Add/Edit Product Modal -->
        <el-dialog v-model="dialogVisible" :title="editMode ? 'Edit Product' : 'Add Product'" width="90%" custom-class="wp-premium-dialog">
            <form @submit.prevent="editMode ? updateProduct() : addProduct()" class="wp-premium-form">
                <div class="wp-premium-form-grid">
                    <div class="wp-premium-form-col">
                        <div class="wp-premium-form-group">
                            <label for="title" class="wp-premium-label">Title</label>
                            <input v-model="title" type="text" id="title" name="title" required class="wp-premium-input">
                        </div>

                        <div class="wp-premium-form-group">
                            <label for="price" class="wp-premium-label">Price</label>
                            <input v-model="price" type="number" step="0.01" id="price" name="price" required class="wp-premium-input">
                        </div>

                        <div class="wp-premium-form-group">
                            <label for="quantity" class="wp-premium-label">Quantity</label>
                            <input v-model="quantity" type="number" id="quantity" name="quantity" required class="wp-premium-input">
                        </div>

                        <div class="wp-premium-form-group">
                            <label for="category" class="wp-premium-label">Category</label>
                            <select v-model="category_id" id="category" name="category" required class="wp-premium-select">
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                            </select>
                        </div>

                        <div class="wp-premium-form-group">
                            <label for="brand" class="wp-premium-label">Brand</label>
                            <select v-model="brand_id" id="brand" name="brand" required class="wp-premium-select">
                                <option v-for="brand in brands" :key="brand.id" :value="brand.id">{{ brand.name }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="wp-premium-form-col">
                        <div class="wp-premium-form-group">
                            <label for="description" class="wp-premium-label">Description</label>
                            <textarea v-model="description" id="description" name="description" rows="5" class="wp-premium-textarea"></textarea>
                        </div>

                        <div class="wp-premium-form-group">
                            <label class="wp-premium-label">Status</label>
                            <div class="wp-premium-checkbox-group">
                                <label class="wp-premium-checkbox">
                                    <input v-model="published" type="checkbox">
                                    <span class="checkmark"></span>
                                    Published
                                </label>
                                <label class="wp-premium-checkbox">
                                    <input v-model="inStock" type="checkbox">
                                    <span class="checkmark"></span>
                                    In Stock
                                </label>
                            </div>
                        </div>

                        <div class="wp-premium-form-group">
                            <label class="wp-premium-label">Product Images</label>
                            <el-upload
                                v-model:file-list="productImages"
                                action="#"
                                list-type="picture-card"
                                :auto-upload="false"
                                :on-change="handleFileChange"
                                class="wp-premium-upload"
                            >
                                <i class="el-icon-plus"></i>
                            </el-upload>
                        </div>

                        <div v-if="editMode" class="wp-premium-form-group">
                            <label class="wp-premium-label">Existing Images</label>
                            <div class="wp-premium-image-grid">
                                <div v-for="(image, index) in product_images" :key="image.id" class="wp-premium-image-item">
                                    <img :src="'/' + image.image" alt="Product image">
                                    <button @click="deleteImage(image, index)" class="wp-premium-delete-btn">
                                        <i class="el-icon-delete"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wp-premium-form-actions">
                    <button type="button" @click="dialogVisible = false" class="wp-premium-btn wp-premium-btn-secondary">Cancel</button>
                    <button type="submit" class="wp-premium-btn wp-premium-btn-primary">{{ editMode ? 'Update' : 'Add' }} Product</button>
                </div>
            </form>
        </el-dialog>
    </div>
</template>

<style scoped>
.wp-premium-dialog {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif;
    box-shadow: 0 5px 15px rgba(0,0,0,0.15);
}

.wp-premium-form {
    padding: 20px;
}

.wp-premium-form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 30px;
}

@media (min-width: 640px) {
    .wp-premium-form-grid {
        grid-template-columns: 1fr 1fr;
    }
}

.wp-premium-form-group {
    margin-bottom: 20px;
}

.wp-premium-label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
    color: #23282d;
}

.wp-premium-input,
.wp-premium-select,
.wp-premium-textarea {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #8c8f94;
    border-radius: 4px;
    font-size: 14px;
}

.wp-premium-textarea {
    resize: vertical;
}

.wp-premium-checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

@media (min-width: 640px) {
    .wp-premium-checkbox-group {
        flex-direction: row;
        gap: 20px;
    }
}

.wp-premium-checkbox {
    display: flex;
    align-items: center;
    cursor: pointer;
}

.wp-premium-checkbox input {
    margin-right: 8px;
}

.wp-premium-upload .el-upload--picture-card {
    border: 2px dashed #8c8f94;
    border-radius: 4px;
}

.wp-premium-image-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    gap: 10px;
}

@media (min-width: 640px) {
    .wp-premium-image-grid {
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    }
}

.wp-premium-image-item {
    position: relative;
}

.wp-premium-image-item img {
    width: 100%;
    height: 80px;
    object-fit: cover;
    border-radius: 4px;
}

@media (min-width: 640px) {
    .wp-premium-image-item img {
        height: 100px;
    }
}
.wp-premium-delete-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background-color: rgba(255,255,255,0.8);
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.wp-premium-form-actions {
    display: flex;
    flex-direction: column;
    justify-content: center;
    margin-top: 30px;
}

@media (min-width: 640px) {
    .wp-premium-form-actions {
        flex-direction: row;
        justify-content: flex-end;
    }
}

.wp-premium-btn {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s;
    width: 100%;
    margin-bottom: 10px;
}

@media (min-width: 640px) {
    .wp-premium-btn {
        width: auto;
        margin-bottom: 0;
    }
}

.wp-premium-btn-primary {
    background-color: #2271b1;
    color: white;
}

.wp-premium-btn-primary:hover {
    background-color: #135e96;
}

.wp-premium-btn-secondary {
    background-color: #f6f7f7;
    color: #2c3338;
}

@media (min-width: 640px) {
    .wp-premium-btn-secondary {
        margin-right: 10px;
    }
}

.wp-premium-btn-secondary:hover {
    background-color: #f0f0f1;
}

/* Additional responsive styles */
@media (max-width: 639px) {
    .container {
        padding-left: 16px;
        padding-right: 16px;
    }

    h1 {
        font-size: 24px;
        margin-bottom: 16px;
    }

    .mb-6 {
        margin-bottom: 16px;
    }

    .overflow-x-auto {
        margin-left: -16px;
        margin-right: -16px;
        padding-left: 16px;
        padding-right: 16px;
    }

    table {
        font-size: 14px;
    }

    th, td {
        padding: 8px;
    }

    .wp-premium-dialog {
        padding: 16px;
    }
}
</style>
