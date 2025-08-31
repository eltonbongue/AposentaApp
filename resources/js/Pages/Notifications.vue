<!-- resources/js/Pages/Dashboard.vue -->

<template>
  <AppLayout>
    <div class="p-6 bg-white rounded shadow max-w-6xl mx-auto space-y-10">
      <h1 class="text-3xl font-bold text-indigo-700 mb-6">Dashboard Financeira</h1>

      <!-- Painel: Notificações -->
      <NotificationsPanel />
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import NotificationsPanel from '@/Components/NotificationsPanel.vue'
</script>
