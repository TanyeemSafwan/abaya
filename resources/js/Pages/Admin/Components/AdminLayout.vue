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
  <main class="p-4 md:ml-64 h-auto pt-20">
    <slot />
  </main>
</template>