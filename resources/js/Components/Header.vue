<template>
  <header class="bg-white dark:bg-gray-800 shadow px-4 py-4 flex items-center justify-between">
    <!-- Toggle sidebar button -->
    <button @click="$emit('toggleSidebar')" class="md:hidden text-gray-500 dark:text-white">
      <i class="fas fa-bars"></i>
    </button>

    <div class="text-lg font-semibold">Bem-vindo, Admin</div>

    <!-- User info -->
    <div class="flex items-center space-x-3">
      <span class="text-sm">admin@admin.com</span>
      <img src="https://i.pravatar.cc/40" class="rounded-full w-10 h-10 border" alt="Avatar" />
    </div>
  </header>
</template>
