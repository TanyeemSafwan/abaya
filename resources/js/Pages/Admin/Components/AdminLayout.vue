<script setup>
import Navbar from './Navbar.vue'
import Sidebar from './Sidebar.vue'
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})
</script>
<template>
  <Navbar />
  <Sidebar />
  <slot />
</template>