<template>
  <div class="min-h-screen flex bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-white">
    <!-- Sidebar -->
    <Sidebar :isOpen="sidebarOpen" @toggle="toggleSidebar" />

    <!-- Main content -->
    <div class="flex flex-col flex-1 w-full">
      <!-- Header -->
      <Header @toggleSidebar="toggleSidebar" />

      <!-- Page Content -->
      <main class="flex-1 p-6 overflow-y-auto">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'

const sidebarOpen = ref(true)

const toggleSidebar = () => {
  sidebarOpen.value = !sidebarOpen.value
}
</script>
