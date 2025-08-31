<script setup>
import Component from '@/Components/Header.vue';
import Card from '@/Components/Sidebar.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

</script>

<template>
  <AdminLayout>
    <div>
      <h1 class="text-2xl font-bold mb-6">Dashboard Principal</h1>

      <!-- Simple stats or cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow text-center">
          <p class="text-sm text-gray-500">Usuários Cadastrados</p>
          <h2 class="text-3xl font-bold">1.245</h2>
        </div>
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow text-center">
          <p class="text-sm text-gray-500">Notificações</p>
          <h2 class="text-3xl font-bold">87</h2>
        </div>
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow text-center">
          <p class="text-sm text-gray-500">Tarefas Pendentes</p>
          <h2 class="text-3xl font-bold">14</h2>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

