<script setup>
import AdminLayout from '../Components/AdminLayout.vue';
import ProductList from './ProductList.vue';
defineProps({
  products: Array,
  brands: Array,
  categories: Array,
})
</script>
<template>
  <AdminLayout>
    <ProductList :products="products" :brands="brands" :categories="categories"/>
  </AdminLayout>
</template>